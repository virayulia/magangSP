<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KuotaunitModel;
use App\Models\MagangModel;
use App\Models\UnitKerjaModel;
use App\Models\UserModel;

class MagangController extends BaseController
{
    protected $magangModel;
    protected $userModel;
    protected $unitKerjaModel;
    protected $kuotaUnitModel;

    public function __construct()
    {
        $this->magangModel = new MagangModel();
        $this->userModel = new UserModel();
        $this->unitKerjaModel = new UnitKerjaModel();
        $this->kuotaUnitModel = new KuotaunitModel();
    }

    public function index()
    {
        $pendaftaran = $this->magangModel->select('magang.*,unit_kerja.unit_kerja, users.*,jurusan.nama_jurusan, 
                        instansi.nama_instansi, 
                        province_ktp.province AS provinsi_ktp,
                        province_dom.province AS provinsi_domisili, 
                        city_ktp.regency AS kota_ktp, 
                        city_ktp.type AS tipe_kota_ktp,
                        city_dom.regency AS kota_domisili,
                        city_dom.type AS tipe_kota_domisili')
                                        ->join('users', 'users.id = magang.user_id')
                                        ->join('instansi', 'instansi.instansi_id = users.instansi_id', 'left')
                                        ->join('jurusan', 'jurusan.jurusan_id = users.jurusan_id','left')
                                        ->join('provinces AS province_ktp', 'province_ktp.id = users.province_id', 'left')
                                        ->join('provinces AS province_dom', 'province_dom.id = users.provinceDom_id', 'left')
                                        ->join('regencies AS city_ktp', 'city_ktp.id = users.city_id', 'left')
                                        ->join('regencies AS city_dom', 'city_dom.id = users.cityDom_id', 'left')
                                        ->join('unit_kerja', 'magang.unit_id = unit_kerja.unit_id')
                                        ->whereIn('magang.status_akhir', ['proses', 'pendaftaran'])
                                        ->orderBy('magang.tanggal_daftar', 'asc')
                                        ->findAll();
        $unitList = $this->unitKerjaModel->findAll();
        return view('admin/index', ['pendaftaran' => $pendaftaran, 'unitList' => $unitList]);
    }

    public function detail($id)
    {
        $pendaftaran = $this->magangModel
            ->select('magang.*, users.*, instansi.nama_instansi, jurusan.nama_jurusan,province_ktp.province AS provinsi_ktp,
                        province_dom.province AS provinsi_domisili,
                        city_ktp.regency AS kota_ktp, 
                        city_ktp.type AS tipe_kota_ktp,
                        city_dom.regency AS kota_domisili,
                        city_dom.type AS tipe_kota_domisili')
            ->join('users', 'users.id = magang.user_id')
            ->join('instansi', 'instansi.instansi_id = users.instansi_id')
            ->join('jurusan', 'jurusan.jurusan_id = users.jurusan_id')
            ->join('provinces AS province_ktp', 'province_ktp.id = users.province_id', 'left')
            ->join('provinces AS province_dom', 'province_dom.id = users.provinceDom_id', 'left')
            ->join('regencies AS city_ktp', 'city_ktp.id = users.city_id', 'left')
            ->join('regencies AS city_dom', 'city_dom.id = users.cityDom_id', 'left')
            ->where('magang.magang_id', $id)
            ->first();

        if (!$pendaftaran) {
            return redirect()->to('admin/manage-pendaftaran')->with('error', 'Data tidak ditemukan.');
        }
        return view('admin/detail', [
            'pendaftaran' => $pendaftaran
        ]);
    }

    public function seleksi()
    {
        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        // Coba cari periode magang yang sedang berlangsung
        $periode = $db->table('periode_magang')
            ->where('tanggal_buka <=', $today)
            ->where('tanggal_tutup >=', $today)
            ->orderBy('tanggal_buka', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();

        if ($periode) {
            // Ambil semua pendaftar berdasarkan periode yang aktif
            $pendaftar = $db->table('magang')
                ->join('users', 'users.id = magang.user_id')
                ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id')
                ->where('magang.periode_id', $periode->periode_id)
                ->select('magang.*, users.fullname, unit_kerja.unit_kerja')
                ->orderBy('magang.tanggal_daftar', 'DESC')
                ->get()
                ->getResult();
        } else {
            // Jika tidak ada periode aktif, ambil pendaftar berdasarkan tanggal bulan ini
            $firstDay = date('Y-m-01');
            $lastDay  = date('Y-m-t');

            $periode = (object)[
                'tanggal_buka' => $firstDay,
                'tanggal_tutup' => $lastDay,
                'id' => null,
            ];

            $pendaftar = $db->table('magang')
                ->join('users', 'users.id = magang.user_id')
                ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id')
                ->where('magang.tanggal_daftar >=', $firstDay)
                ->where('magang.tanggal_daftar <=', $lastDay)
                ->select('magang.*, users.fullname, unit_kerja.unit_kerja')
                ->orderBy('magang.tanggal_daftar', 'DESC')
                ->get()
                ->getResult();
        }

         // Filter hanya kuota dengan sisa > 0
        $allKuota = $this->magangModel->getSisaKuota();
        $filteredKuota = array_filter($allKuota, fn($k) => $k->sisa_kuota > 0);
        usort($filteredKuota, function ($a, $b) {
            return $b->jumlah_pendaftar <=> $a->jumlah_pendaftar;
        });

        $data['kuota_unit'] = $filteredKuota;
        
        // Kirim data ke view
        $data['pendaftar'] = $pendaftar;
        $data['periode'] = $periode;

        return view('admin/kelola_seleksi', $data);
    }

    public function pendaftar()
    {
        $request = \Config\Services::request();
        $unitId = $request->getGet('unit_id');
        $pendidikan = $request->getGet('pendidikan');

        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        // Ambil periode aktif atau fallback ke bulan ini
        $periode = $db->table('periode_magang')
            ->where('tanggal_buka <=', $today)
            ->where('tanggal_tutup >=', $today)
            ->orderBy('tanggal_buka', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();

        if (!$periode) {
            // Fallback ke periode "bulan ini"
            $periode = (object)[
                'periode_id' => null, // tidak ada ID karena tidak ambil dari tabel
                'tanggal_buka' => date('Y-m-01'),
                'tanggal_tutup' => date('Y-m-t'),
            ];
        }

        // Ambil pendaftar sesuai periode
        $builder = $db->table('magang')
            ->select('magang.magang_id as magang_id, magang.*, users.*, instansi.nama_instansi, jurusan.nama_jurusan as jurusan')
            ->join('users', 'users.id = magang.user_id', 'left')
            ->join('instansi', 'instansi.instansi_id = users.instansi_id', 'left')
            ->join('jurusan', 'jurusan.jurusan_id = users.jurusan_id', 'left')
            ->where('magang.unit_id', $unitId)
            ->where('magang.status_akhir', 'pendaftaran');

        if ($periode->periode_id) {
            $builder->where('magang.periode_id', $periode->periode_id);
        } else {
            // Jika tidak ada periode, filter berdasarkan tanggal bulan ini
            $builder->where('magang.tanggal_daftar >=', $periode->tanggal_buka)
                    ->where('magang.tanggal_daftar <=', $periode->tanggal_tutup);
        }

        $builder->where("
            CASE 
                WHEN users.tingkat_pendidikan = 'SMK' THEN 'SMK'
                WHEN users.tingkat_pendidikan IN ('D3', 'D4/S1', 'S2') THEN 'Perguruan Tinggi'
                ELSE users.tingkat_pendidikan
            END = '$pendidikan'
        ", null, false);

        $builder->orderBy('magang.tanggal_daftar', 'asc');
        $pendaftar = $builder->get()->getResult();

        // Hitung sisa kuota
        $allKuota = $this->magangModel->getSisaKuota();
        $sisa = 0;
        foreach ($allKuota as $k) {
            if ($k->unit_id == $unitId && strtolower($k->tingkat_pendidikan) == strtolower($pendidikan)) {
                $sisa = $k->sisa_kuota;
                break;
            }
        }

        return view('admin/modal_pendaftar', [
            'pendaftar' => $pendaftar,
            'kuota_tersedia' => $sisa,
            'error' => null,
        ]);
    }


    public function terimaBanyak()
    {
        $ids = $this->request->getPost('pendaftar_ids');

        if (!$ids || !is_array($ids)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tidak ada pendaftar yang dipilih.']);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('magang');
        $pdfController = new \App\Controllers\GeneratePDF();
        $email = \Config\Services::email();

        $successCount = 0;
        $failCount = 0;
        $messages = [];

        foreach ($ids as $id) {
            // Ambil data pendaftar
            $pendaftar = $builder
                ->select('magang.*, unit_kerja.unit_kerja')
                ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id', 'left')
                ->where('magang.magang_id', $id)
                ->get()->getRow();

            if (!$pendaftar) {
                $failCount++;
                $messages[] = "ID $id: Pendaftar tidak ditemukan.";
                continue;
            }

           // Ambil tanggal sekarang
            $today = new \DateTime();

            // Ambil tanggal 1 dua bulan ke depan
            $start = new \DateTime($today->format('Y-m-01'));
            $start->modify('+2 month');

            // Jika tanggal masuk adalah Sabtu (6) atau Minggu (7), geser ke hari kerja berikutnya
            while (in_array($start->format('N'), [6, 7])) {
                $start->modify('+1 day');
            }

            // Durasi magang dalam bulan
            $durasi = (int) $pendaftar->durasi;

            // Tanggal selesai = hari terakhir dari bulan ke-(durasi - 1) setelah bulan masuk
            $end = clone $start;
            $end->modify('last day of +' . ($durasi - 1) . ' month');

            // Simpan ke database
            $db->table('magang')->where('magang_id', $id)->update([
                'status_seleksi'   => 'Diterima',
                'tanggal_seleksi' => date('Y-m-d H:i:s'),
                'tanggal_masuk'   => $start->format('Y-m-d'),
                'tanggal_selesai' => $end->format('Y-m-d'),
                'status_akhir'    => 'proses',
            ]);

            // Ambil user
            $user = $db->table('users')->where('id', $pendaftar->user_id)->get()->getRow();
            if (!$user) {
                $failCount++;
                $messages[] = "ID $id: Data user tidak ditemukan.";
                continue;
            }

            $emailPeserta = $user->email;
            $emailInstansi = $user->email_instansi ?? null;

            // Kirim Email
            $email->clear(); // Reset sebelum mengirim email baru
            $email->setTo($emailPeserta);

            $email->setSubject('Penerimaan Magang di PT Semen Padang');
            $email->setMailType('html');
            $email->setMessage(view('emails/penerimaan_magang', [
                'nama'            => $user->fullname ?? $user->username,
                'unit'            => $pendaftar->unit_kerja,
                'tanggal_masuk'   => $start->format('d F Y'),
                'tanggal_selesai' => $end->format('d F Y'),
            ]));


            if ($email->send()) {
                $successCount++;
            } else {
                $failCount++;
                $messages[] = "ID $id: Gagal kirim email.";
            }
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => "$successCount berhasil diterima. $failCount gagal.",
            'details' => $messages
        ]);
    }

    public function tolakBanyak()
    {
        $ids = $this->request->getPost('pendaftar_ids');

        if (!$ids || !is_array($ids)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tidak ada pendaftar yang dipilih.']);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('magang');

        $successCount = 0;
        $failCount = 0;
        $messages = [];

        foreach ($ids as $id) {
            log_message('debug', 'Memproses tolak ID: ' . $id);

            $data = $builder
                ->select('magang.*, users.email, users.email_instansi, users.fullname, users.username, unit_kerja.unit_kerja')
                ->join('users', 'users.id = magang.user_id', 'left')
                ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id', 'left')
                ->where('magang.magang_id', $id)
                ->get()
                ->getRow();

            if (!$data) {
                log_message('error', "Data magang dengan ID $id tidak ditemukan.");
                $failCount++;
                $messages[] = "ID $id: tidak ditemukan.";
                continue;
            }

            $updated = $builder->where('magang_id', $id)->update([
                'status_seleksi'   => 'Ditolak',
                'tanggal_seleksi' => date('Y-m-d H:i:s'),
                'status_akhir' => 'gagal'
            ]);

            if ($updated) {
                log_message('debug', "ID $id: Berhasil ditolak.");
                $successCount++;

                // ===== Kirim Email Penolakan =====
                $email = \Config\Services::email();
                $email->setTo($data->email);

                $email->setSubject('Hasil Seleksi Pendaftaran Magang di PT Semen Padang');
                $email->setMailType('html');
                $email->setMessage(view('emails/penolakan_magang', [
                    'nama' => $data->fullname ?? 'Saudara',
                    'unit' => $data->unit_kerja ?? 'Unit terkait',
                ]));

                if (!$email->send()) {
                    log_message('error', "Gagal kirim email ke ID $id: " . print_r($email->printDebugger(), true));
                }

            } else {
                log_message('error', "ID $id: Gagal update data.");
                $failCount++;
                $messages[] = "ID $id: gagal ditolak.";
            }
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => "$successCount berhasil ditolak. $failCount gagal.",
            'details' => $messages
        ]);
    }

    public function validasi()
    {
        
        $data = $this->magangModel->select('magang.*, users.fullname, users.nisn_nim, users.bpjs_kes, users.bpjs_tk, users.buktibpjs_tk')
                                        ->join('users', 'users.id = magang.user_id')
                                        ->where('magang.status_konfirmasi', 'Y')
                                        ->where('magang.status_akhir', 'proses')
                                        ->orderBy('tanggal_konfirmasi')
                                        ->findAll();

        return view('admin/kelola_validasi', ['data' => $data]);
    }

    public function bulkValidasi()
    {
        $ids     = $this->request->getPost('ids'); 
        $action  = $this->request->getPost('action'); 
        $catatan = $this->request->getPost('catatan_bulk');

        if (empty($ids) || !in_array($action, ['approve', 'reject'])) {
            return redirect()->back()->with('error', 'Tidak ada peserta yang dipilih atau aksi tidak valid.');
        }

        $db      = \Config\Database::connect();
        $email   = \Config\Services::email();
        $tanggal = date('Y-m-d H:i:s');

        $pesertaList = $db->table('magang')
            ->select('magang.*, users.*, unit_kerja.unit_kerja, jurusan.nama_jurusan, instansi.nama_instansi')
            ->join('users', 'users.id = magang.user_id', 'left')
            ->join('jurusan', 'users.jurusan_id = jurusan.jurusan_id', 'left')
            ->join('instansi', 'users.instansi_id = instansi.instansi_id', 'left')
            ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id', 'left')
            ->whereIn('magang.magang_id', $ids)
            ->get()
            ->getResult();

        foreach ($pesertaList as $data) {
            $updateData = [
                'status_validasi_berkas'  => ($action === 'approve') ? 'Y' : 'N',
                'tanggal_validasi_berkas' => $tanggal,
            ];

            if ($action === 'approve') {
                $updateData['status_akhir'] = 'magang';
            }

            $this->magangModel->update($data->magang_id, $updateData);

            // Kirim email
            $toEmail = $data->email;
            $ccEmail = $data->email_instansi;

            if (!empty($toEmail)) {
                $email->clear(true); // reset email sebelum kirim berikutnya
                $email->setTo($toEmail);

                if (!empty($ccEmail) && filter_var($ccEmail, FILTER_VALIDATE_EMAIL)) {
                    $email->setCC($ccEmail);
                }

                $email->setSubject('Hasil Validasi Magang di PT Semen Padang');
                $email->setMailType('html');

                if ($action === 'approve') {
                    $email->setMessage(view('emails/approve', [
                        'nama'            => $data->fullname ?? $data->username,
                        'unit'            => $data->unit_kerja ?? 'Unit terkait',
                        'user_data'       => $data,
                        'tanggal_surat'   => $data->tanggal_surat,
                        'tanggal_masuk'   => $data->tanggal_masuk,
                        'tanggal_selesai' => $data->tanggal_selesai,
                    ]));
                } else {
                    $email->setMessage(view('emails/tidak_approve', [
                        'nama'    => $data->fullname ?? $data->username,
                        'unit'    => $data->unit_kerja ?? 'Unit terkait',
                        'catatan' => $catatan
                    ]));
                }

                if (!$email->send()) {
                    log_message('error', "Gagal kirim email validasi ID {$data->magang_id}: " . print_r($email->printDebugger(), true));
                }
            }
        }

        return redirect()->back()->with('success', 
            $action === 'approve' 
                ? 'Peserta terpilih berhasil divalidasi dan email penerimaan telah dikirim.'
                : 'Peserta terpilih telah ditandai tidak valid dan email penolakan telah dikirim.'
        );
    }


    // public function berkas()
    // {
        
    //     $data = $this->magangModel->select('magang.*, users.fullname, users.nisn_nim, users.bpjs_kes, users.bpjs_tk, users.buktibpjs_tk')
    //                                     ->join('users', 'users.id = magang.user_id')
    //                                     ->where('magang.status_validasi_berkas', 'Y')
    //                                     ->where('magang.status_berkas_lengkap =', null)
    //                                     ->orderBy('tanggal_validasi_berkas')
    //                                     ->findAll();

    //     return view('admin/kelola_kelengkapan', ['data' => $data]);
    // }

    public function berkas($id = null)
    {
        $builder = $this->magangModel->select(
            'magang.*, users.fullname, users.nisn_nim, users.bpjs_kes, users.bpjs_tk, users.buktibpjs_tk'
        )->join('users', 'users.id = magang.user_id')
        ->where('magang.status_validasi_berkas', 'Y')
        ->groupStart()
            ->where('magang.status_berkas_lengkap !=', 'Y')
            ->orWhere('magang.status_berkas_lengkap IS NULL')
        ->groupEnd()
        ->orderBy('tanggal_validasi_berkas');

        if (!empty($id)) {
            // kalau ada id, filter sesuai id
            $builder->where('magang.magang_id', $id);
        }

        $data = $builder->findAll();

        return view('admin/kelola_kelengkapan', ['data' => $data]);
    }


    public function valid($id)
    {
        $catatan = $this->request->getPost('catatan');

        $db = \Config\Database::connect();
        $data = $db->table('magang')
            ->select('magang.*, users.*, unit_kerja.unit_kerja, jurusan.nama_jurusan, instansi.nama_instansi ')
            ->join('users', 'users.id = magang.user_id', 'left')
            ->join('jurusan', 'users.jurusan_id = jurusan.jurusan_id', 'left')
            ->join('instansi', 'users.instansi_id = instansi.instansi_id', 'left')
            ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id', 'left')
            ->where('magang.magang_id', $id)
            ->get()
            ->getRow();

        if (!$data) {
            return redirect()->back()->with('error', 'Data magang tidak ditemukan.');
        }

        // Update data
        $updateData = [
            'status_berkas_lengkap'    => 'Y',
            'tanggal_berkas_lengkap'   => date('Y-m-d H:i:s'),
            'cttn_berkas_lengkap'      => $catatan,
            'status_akhir'             => 'magang'
        ];

        $this->magangModel->update($id, $updateData);

        // Kirim email
        $email = \Config\Services::email();
        $toEmail = $data->email;
        $ccEmail = $data->email_instansi;

        if (!empty($toEmail)) {
            $email->setTo($toEmail);

            if (!empty($ccEmail) && filter_var($ccEmail, FILTER_VALIDATE_EMAIL)) {
                $email->setCC($ccEmail);
            }
        }

        $email->setSubject('Hasil Validasi Berkas Magang di PT Semen Padang');
        $email->setMailType('html');

        $email->setMessage(view('emails/berkas_valid', [
            'nama'            => $data->fullname ?? $data->username,
            'unit'            => $data->unit_kerja ?? 'Unit terkait',
            'user_data'       => $data,
            'tanggal_surat'   => $data->tanggal_surat, 
            'tanggal_masuk'   => $data->tanggal_masuk,
            'tanggal_selesai' => $data->tanggal_selesai,
        ]));

        if (!$email->send()) {
            log_message('error', "Gagal kirim email validasi berkas ID $id: " . print_r($email->printDebugger(), true));
        }

        return redirect()->back()->with('success', 'Validasi berhasil disimpan dan email telah dikirim.');
    }

    public function tidakValid($id)
    {
        $catatan = $this->request->getPost('catatan');

        $db = \Config\Database::connect();
        $data = $db->table('magang')
            ->select('magang.*, users.email, users.email_instansi, users.fullname, users.username, unit_kerja.unit_kerja')
            ->join('users', 'users.id = magang.user_id', 'left')
            ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id', 'left')
            ->where('magang.magang_id', $id)
            ->get()
            ->getRow();

        if (!$data) {
            return redirect()->back()->with('error', 'Data magang tidak ditemukan.');
        }

        // Update data
        $updateData = [
            'status_berkas_lengkap'      => 'N',
            'tanggal_berkas_lengkap'     => date('Y-m-d H:i:s'),
            'cttn_berkas_lengkap'        => $catatan,
        ];

        $this->magangModel->update($id, $updateData);

        // Kirim email
        $email = \Config\Services::email();
        $toEmail = $data->email;
        $ccEmail = $data->email_instansi;

        if (!empty($toEmail)) {
            $email->setTo($toEmail);

            if (!empty($ccEmail) && filter_var($ccEmail, FILTER_VALIDATE_EMAIL)) {
                $email->setCC($ccEmail);
            }
        }

        $email->setSubject('Hasil Validasi Berkas Magang di PT Semen Padang');
        $email->setMailType('html');

        $email->setMessage(view('emails/berkas_tidak_valid', [
            'nama'    => $data->fullname ?? $data->username,
            'unit'    => $data->unit_kerja ?? 'Unit terkait',
            'catatan' => $catatan
        ]));

        if (!$email->send()) {
            log_message('error', "Gagal kirim email validasi berkas ID $id: " . print_r($email->printDebugger(), true));
        }

        return redirect()->back()->with('success', 'Validasi tidak valid berhasil disimpan dan email telah dikirim.');
    }

    public function safety()
    {
        $db = \Config\Database::connect();
        $request = \Config\Services::request();

        $bulan = $request->getGet('bulan');
        $tahun = $request->getGet('tahun');

        if (!$bulan || !$tahun) {
            // Default: bulan dan tahun ini
            $bulan = date('m');
            $tahun = date('Y');
        }

        $hasil = $db->table('jawaban_safety')
            ->select('
                users.fullname,
                users.nisn_nim,
                unit_kerja.unit_kerja,
                jawaban_safety.magang_id,
                MAX(jawaban_safety.nilai) as nilai_maksimal,
                MAX(jawaban_safety.created_at) as tanggal_terakhir,
                MAX(jawaban_safety.percobaan_ke) as percobaan_terakhir,
                (CASE WHEN MAX(jawaban_safety.nilai) >= 70 THEN "Lulus" ELSE "Tidak Lulus" END) as status
            ')
            ->join('magang', 'magang.magang_id = jawaban_safety.magang_id')
            ->join('users', 'users.id = magang.user_id')
            ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id')
            ->where('magang.status_akhir','magang')
            ->where("MONTH(jawaban_safety.created_at)", $bulan)
            ->where("YEAR(jawaban_safety.created_at)", $tahun)
            ->groupBy('jawaban_safety.magang_id')
            ->get()->getResult();

        return view('admin/kelola_safety', [
            'hasil' => $hasil,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    }

    public function pesertaMagang()
    {
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $builder = $this->magangModel->select('
                                    magang.*,
                                    unit_kerja.unit_kerja,
                                    users.*,
                                    jurusan.nama_jurusan,
                                    instansi.nama_instansi,
                                    province_ktp.province AS provinsi_ktp,
                                    province_dom.province AS provinsi_domisili,
                                    city_ktp.regency AS kota_ktp, 
                                    city_ktp.type AS tipe_kota_ktp,
                                    city_dom.regency AS kota_domisili,
                                    city_dom.type AS tipe_kota_domisili,
                                    MAX(jawaban_safety.nilai) as nilai_maksimal,
                                    MAX(jawaban_safety.created_at) as tanggal_terakhir,
                                    MAX(jawaban_safety.percobaan_ke) as percobaan_terakhir,
                                    CASE 
                                        WHEN MAX(jawaban_safety.nilai) IS NULL THEN "Belum Tes"
                                        WHEN MAX(jawaban_safety.nilai) >= 70 THEN "Lulus"
                                        ELSE "Belum Lulus"
                                    END as status_tes
                                ')
                                ->join('users', 'users.id = magang.user_id')
                                ->join('instansi', 'instansi.instansi_id = users.instansi_id')
                                ->join('jurusan', 'jurusan.jurusan_id = users.jurusan_id')
                                ->join('provinces AS province_ktp', 'province_ktp.id = users.province_id', 'left')
                                ->join('provinces AS province_dom', 'province_dom.id = users.provinceDom_id', 'left')
                                ->join('regencies AS city_ktp', 'city_ktp.id = users.city_id', 'left')
                                ->join('regencies AS city_dom', 'city_dom.id = users.cityDom_id', 'left')
                                ->join('unit_kerja', 'magang.unit_id = unit_kerja.unit_id')
                                ->join('jawaban_safety', 'magang.magang_id = jawaban_safety.magang_id', 'left')
                                ->where('magang.status_akhir', 'magang')
                                ->groupBy('magang.magang_id');

        if (!empty($bulan)) {
            $builder->where('MONTH(magang.tanggal_masuk)', $bulan);
        }

        if (!empty($tahun)) {
            $builder->where('YEAR(magang.tanggal_masuk)', $tahun);
        }

        $data = $builder->findAll();
        $unitList = $this->unitKerjaModel->findAll();

        return view('admin/kelola_magang', ['data' => $data, 'unitList' => $unitList]);
    }

    public function updateMagang($id)
    {
        $data = [
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'unit_id' => $this->request->getPost('unit_id'),
        ];

        $this->magangModel->update($id, $data);
        return redirect()->back()->with('success', 'Data magang berhasil diperbarui.');
    }

    public function batalkanMagang()
    {
        $id = $this->request->getPost('id');
        $alasan = $this->request->getPost('alasan');

        if (!$id || !$alasan) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap']);
        }

        $db = \Config\Database::connect();
        $data = $db->table('magang')
            ->select('magang.*, users.email, users.email_instansi, users.fullname, users.username, unit_kerja.unit_kerja')
            ->join('users', 'users.id = magang.user_id', 'left')
            ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id', 'left')
            ->where('magang.magang_id', $id)
            ->get()
            ->getRow();

        if (!$data) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data magang tidak ditemukan']);
        }

        // Update status dan alasan
        $this->magangModel->update($id, [
            'status_akhir' => 'batal',
            'tanggal_selesai' => date('Y-m-d'),
            'alasan_batal' => $alasan,
        ]);

        // Kirim email
        $email = \Config\Services::email();
        $toEmail = $data->email;
        $ccEmail = $data->email_instansi;

        if (!empty($toEmail)) {
            $email->setTo($toEmail);

            if (!empty($ccEmail) && filter_var($ccEmail, FILTER_VALIDATE_EMAIL)) {
                $email->setCC($ccEmail);
            }

            $email->setSubject('Pemberitahuan Pembatalan Magang di PT Semen Padang');
            $email->setMailType('html');

            $email->setMessage(view('emails/batalkan_magang', [
                'nama'   => $data->fullname ?? $data->username,
                'unit'   => $data->unit_kerja ?? 'unit terkait',
                'alasan' => $alasan
            ]));

            if (!$email->send()) {
                log_message('error', "Gagal kirim email pembatalan magang ID $id: " . print_r($email->printDebugger(), true));
            }
        }

        return $this->response->setJSON(['status' => 'success']);
    }






}
