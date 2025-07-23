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
        $pendaftaran = $this->magangModel->select('magang.*, users.fullname, users.nisn_nim, unit_kerja.unit_kerja')
                                        ->join('users', 'users.id = magang.user_id')
                                        ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id')
                                        ->whereIn('magang.status_akhir', ['proses', 'pendaftaran'])
                                        ->orderBy('magang.tanggal_daftar', 'asc')
                                        ->findAll();

        return view('admin/index', ['pendaftaran' => $pendaftaran]);
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

        // Ambil sisa kuota semua unit (sesuai implementasimu sebelumnya)
        $data['kuota_unit'] = $this->magangModel->getSisaKuota();

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

        // Ambil periode aktif terlebih dahulu
        $periode = $db->table('periode_magang')
            ->where('tanggal_buka <=', $today)
            ->where('tanggal_tutup >=', $today)
            ->orderBy('tanggal_buka', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();

        // Jika tidak ada periode, kembalikan error
        if (!$periode) {
            return view('admin/modal_pendaftar', [
                'pendaftar' => [],
                'kuota_tersedia' => 0,
                'error' => 'Tidak ada periode aktif saat ini.',
            ]);
        }

        // Ambil pendaftar sesuai periode aktif
        $builder = $db->table('magang')
            ->select('magang.magang_id as magang_id, magang.*, users.*, instansi.nama_instansi, jurusan.nama_jurusan as jurusan')
            ->join('users', 'users.id = magang.user_id', 'left')
            ->join('instansi', 'instansi.instansi_id = users.instansi_id', 'left')
            ->join('jurusan', 'jurusan.jurusan_id = users.jurusan_id', 'left')
            ->where('magang.unit_id', $unitId)
            ->where('magang.status_akhir', 'pendaftaran')
            ->where('magang.periode_id', $periode->periode_id)
            ->where("
                CASE 
                    WHEN users.tingkat_pendidikan = 'SMK' THEN 'SMK'
                    WHEN users.tingkat_pendidikan IN ('D3', 'D4/S1', 'S2') THEN 'Perguruan Tinggi'
                    ELSE users.tingkat_pendidikan
                END = '$pendidikan'
            ", null, false)
            ->orderBy('magang.tanggal_daftar', 'asc');

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

            // Hitung tanggal mulai dan selesai
            $today = new \DateTime();
            $start = new \DateTime($today->format('Y-m-01'));
            $start->modify('+2 month');
            while (in_array($start->format('N'), [6, 7])) {
                $start->modify('+1 day');
            }

            $durasi = (int) $pendaftar->durasi;
            $end = clone $start;
            $end->modify("+$durasi month");

            // Update status & tanggal
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
            if ($emailInstansi) {
                $email->setCC($emailInstansi);
            }

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
                if (!empty($data->email_instansi)) {
                    $email->setCC($data->email_instansi);
                }

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

    public function berkas()
    {
        
        $data = $this->magangModel->select('magang.*, users.fullname, users.nisn_nim, users.bpjs_kes, users.bpjs_tk, users.buktibpjs_tk')
                                        ->join('users', 'users.id = magang.user_id')
                                        ->where('magang.status_validasi_berkas', 'Y')
                                        ->where('magang.status_berkas_lengkap =', null)
                                        ->orderBy('tanggal_validasi_berkas')
                                        ->findAll();

        return view('admin/kelola_kelengkapan', ['data' => $data]);
    }

    public function valid($id)
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
            'nama' => $data->fullname ?? $data->username,
            'unit' => $data->unit_kerja ?? 'Unit terkait',
        ]));

        // Generate PDF
        $generatePDF = new \App\Controllers\GeneratePDF();
        $pdfPath = $generatePDF->suratPenerimaan($id, true);

        if ($pdfPath && file_exists($pdfPath)) {
            $email->attach($pdfPath);
        }

        if (!$email->send()) {
            log_message('error', "Gagal kirim email validasi berkas ID $id: " . print_r($email->printDebugger(), true));
        }

        if (!empty($pdfPath) && file_exists($pdfPath)) {
            unlink($pdfPath);
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
            'status_validasi_berkas'     => NULL,
            'tanggal_validasi_berkas'    => NULL
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

        // Ambil data nilai maksimal per peserta (per magang_id)
        $builder = $db->table('jawaban_safety')
            ->select('jawaban_safety.magang_id, MAX(nilai) as nilai_maksimal, MAX(created_at) as tanggal_terakhir, MAX(percobaan_ke) as percobaan_terakhir')
            ->groupBy('magang_id');

        $subquery = $builder->getCompiledSelect();

        // Gabungkan dengan data peserta
       $hasil = $db->table("($subquery) as max_hasil")
            ->join('magang', 'magang.magang_id = max_hasil.magang_id')
            ->join('users', 'users.id = magang.user_id')
            ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id')
            ->select('users.fullname, users.nisn_nim, unit_kerja.unit_kerja, max_hasil.*')
            ->select('(CASE WHEN max_hasil.nilai_maksimal >= 70 THEN "Lulus" ELSE "Tidak Lulus" END) as status', false)
            ->get()->getResult();

        return view('admin/kelola_safety', ['hasil' => $hasil]);
    }


    public function pesertaMagang()
    {
        
        $data = $this->magangModel->select('magang.*,unit_kerja.unit_kerja, users.*,jurusan.nama_jurusan, instansi.nama_instansi,province_ktp.province AS provinsi_ktp,
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
                                        ->join('unit_kerja', 'magang.unit_id = unit_kerja.unit_id')
                                        ->where('magang.status_akhir', 'magang')
                                        ->findAll();
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
