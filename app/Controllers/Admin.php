<?php

namespace App\Controllers;
use App\Models\MagangModel;
use Myth\Auth\Models\UserModel;

class Admin extends BaseController
{
    protected $magangModel;
    protected $userModel;

    public function __construct()
    {
        $this->magangModel = new MagangModel();
        $this->userModel = new UserModel();
    }

    public function index(): string
    {
        $pendaftaran = $this->magangModel->select('magang.*, users.fullname, users.nisn_nim')
                                        ->join('users', 'users.id = magang.user_id')
                                        ->findAll();

        return view('admin/index', ['pendaftaran' => $pendaftaran]);
    }

    public function detail($id)
    {
        $pendaftaran = $this->magangModel
            ->select('magang.*, users.*, instansi.nama_instansi')
            ->join('users', 'users.id = magang.user_id')
            ->join('instansi', 'instansi.id = users.instansi_id')
            ->where('magang.id', $id)
            ->first();

        if (!$pendaftaran) {
            return redirect()->to('/manage-pendaftaran')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin/detail', [
            'pendaftaran' => $pendaftaran
        ]);
    }

    public function indexKuota(): string
    {
        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        // Ambil periode aktif saat ini
        $periode = $db->table('periode_magang')
            ->where('tanggal_buka <=', $today)
            ->where('tanggal_tutup >=', $today)
            ->orderBy('tanggal_buka', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();

           

        // Jika tidak ada periode aktif, tampilkan periode bulan berjalan
        if (!$periode) {
            $firstDay = date('Y-m-01');
            $lastDay  = date('Y-m-t');
            $periode = (object)[
                'tanggal_buka' => $firstDay,
                'tanggal_tutup' => $lastDay
            ];
        }

        $data['kuota_unit'] = $this->magangModel->getSisaKuota();

        $data['periode'] = $periode;
        // dd($data);
   
        return view('admin/kelola_kuota', $data);
    }

    public function indexSeleksi(): string
    {
        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        // Ambil periode aktif saat ini
        $periode = $db->table('periode_magang')
            ->where('tanggal_buka <=', $today)
            ->where('tanggal_tutup >=', $today)
            ->orderBy('tanggal_buka', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();

           

        // Jika tidak ada periode aktif, tampilkan periode bulan berjalan
        if (!$periode) {
            $firstDay = date('Y-m-01');
            $lastDay  = date('Y-m-t');
            $periode = (object)[
                'tanggal_buka' => $firstDay,
                'tanggal_tutup' => $lastDay
            ];
        }

        $data['kuota_unit'] = $this->magangModel->getSisaKuota();

        $data['periode'] = $periode;
        // dd($data);
   
        return view('admin/kelola_seleksi', $data);
    }
    
    // public function pendaftar()
    // {
    //     $request = \Config\Services::request();
    //     $unitId = $request->getGet('unit_id');
    //     $pendidikan = $request->getGet('pendidikan');

    //     $db = \Config\Database::connect();

    //     // Ambil tanggal tutup terakhir
    //     $lastPeriode = $db->table('periode_magang')
    //         ->orderBy('tanggal_tutup', 'DESC')
    //         ->limit(1)
    //         ->get()
    //         ->getRow();
    //     if (!$lastPeriode) {
    //         return 'Periode tidak ditemukan';
    //     }
    //     $startDate = $lastPeriode->tanggal_buka . ' 00:00:00';
    //     $endDate   = $lastPeriode->tanggal_tutup . ' 23:59:59';

    //     // Mapping manual
    //     if (strtolower($pendidikan) == 'kuliah') {
    //         $pendidikanList = ['d3', 'd4/s1', 's2'];
    //     } else {
    //         $pendidikanList = ['sma/smk sederajat'];
    //     }
    //     // Ambil pendaftar dari periode terbaru
    //    $query = $db->table('magang')
    //         ->select('magang.id as magang_id, magang.*, users.*, instansi.nama_instansi')
    //         ->join('users', 'users.id = magang.user_id', 'left')
    //         ->join('instansi','instansi.id = users.instansi_id','left')
    //         ->where('magang.unit_id', $unitId)
    //         ->whereIn('users.pendidikan', $pendidikanList)
    //         ->where('magang.tanggal_pengajuan >=', $startDate)
    //         ->where('magang.tanggal_pengajuan <=', $endDate)
    //         ->where('magang.status_seleksi', NULL)
    //         ->orderBy('tanggal_pengajuan','asc')
    //         ->get();

    //     $data['pendaftar'] = $query->getResult();
    //     // Hitung kuota yang tersedia
    //     $kuota = $db->table('kuota_unit')
    //         ->where('unit_id', $unitId)
    //         ->where('tingkat_pendidikan', $pendidikan)
    //         ->get()
    //         ->getRow();

    //     $pendaftarCount = $db->table('magang')
    //         ->join('users', 'users.id = magang.user_id')
    //         ->where('magang.unit_id', $unitId)
    //         ->where('users.pendidikan', $pendidikan)
    //         ->where('magang.status_seleksi !=', 'ditolak')
    //         ->where('magang.tanggal_selesai >', date('Y-m-d'))
    //         ->countAllResults();

    //     $data['kuota_tersedia'] = $kuota ? ($kuota->kuota - $pendaftarCount) : 0;
        
    //     return view('admin/modal_pendaftar', $data);
    // }

public function pendaftar()
{
    $request = \Config\Services::request();
    $unitId = $request->getGet('unit_id');
    $pendidikan = $request->getGet('pendidikan');

    $db = \Config\Database::connect();

    // Ambil periode aktif terakhir
    $lastPeriode = $db->table('periode_magang')
        ->orderBy('tanggal_tutup', 'DESC')
        ->limit(1)
        ->get()
        ->getRow();

    if (!$lastPeriode) {
        return 'Periode tidak ditemukan';
    }

    $startDate = $lastPeriode->tanggal_buka . ' 00:00:00';
    $endDate   = $lastPeriode->tanggal_tutup . ' 23:59:59';

    // Mapping jenjang user (untuk filter pendaftar)
    $pendidikanList = strtolower($pendidikan) === 'kuliah'
        ? ['d3', 'd4/s1', 's2']
        : ['sma/smk', 'sma/smk sederajat'];

    // Ambil data pendaftar untuk periode aktif
    $query = $db->table('magang')
        ->select('magang.id as magang_id, magang.*, users.*, instansi.nama_instansi')
        ->join('users', 'users.id = magang.user_id', 'left')
        ->join('instansi','instansi.id = users.instansi_id','left')
        ->where('magang.unit_id', $unitId)
        ->whereIn('LOWER(users.pendidikan)', array_map('strtolower', $pendidikanList))
        ->where('magang.status', 'pendaftar') // status pendaftar
        ->where('magang.tanggal_pengajuan >=', $startDate)
        ->where('magang.tanggal_pengajuan <=', $endDate)
        ->orderBy('magang.tanggal_pengajuan', 'asc')
        ->get();

    $data['pendaftar'] = $query->getResult();

    // Hitung sisa kuota berdasarkan hasil model getSisaKuota()
    $allKuota = $this->magangModel->getSisaKuota();     // Mengambil seluruh kombinasi kuota

    $sisa = 0;
    foreach ($allKuota as $k) {
        if ($k->unit_id == $unitId && strtolower($k->tingkat_pendidikan) == strtolower($pendidikan)) {
            $sisa = $k->sisa_kuota;
            break;
        }
    }

    $data['kuota_tersedia'] = $sisa;

    return view('admin/modal_pendaftar', $data);
}



    // public function terimaPendaftar($id = null)
    // {
    //     if (!$id) {
    //         return $this->response->setJSON(['status' => 'error', 'message' => 'ID tidak ditemukan.']);
    //     }

    //     $db = \Config\Database::connect();
    //     $builder = $db->table('magang');

    //     // Ambil data pendaftar
    //     $pendaftar = $builder->where('id', $id)->get()->getRow();

    //     if (!$pendaftar) {
    //         return $this->response->setJSON(['status' => 'error', 'message' => 'Data pendaftar tidak ditemukan.']);
    //     }

    //     $user_id = $pendaftar->user_id;

    //     // 1. Hitung tanggal mulai: tanggal 1 bulan depan
    //     $today = new \DateTime();
    //     $start = new \DateTime($today->format('Y-m-01'));
    //     $start->modify('+1 month');

    //     // 2. Geser jika bukan hari kerja (Senin–Jumat)
    //     while (in_array($start->format('N'), [6, 7])) {
    //         $start->modify('+1 day');
    //     }

    //     // 3. Hitung tanggal selesai dari durasi (dalam bulan)
    //     $durasi = (int) $pendaftar->durasi;
    //     $end = clone $start;
    //     $end->modify("+$durasi month");

    //     // Update data
    //     $builder->where('id', $id)->update([
    //         'status_seleksi'   => 'Diterima',
    //         'tanggal_seleksi' => date('Y-m-d H:i:s'),
    //         'tanggal_masuk'   => $start->format('Y-m-d'),
    //         'tanggal_selesai' => $end->format('Y-m-d'),
    //     ]);

    //     // ===== Ambil email peserta dan instansi =====
    //     $userBuilder = $db->table('user');
    //     $user = $userBuilder->where('id', $pendaftar->user_id)->get()->getRow();
    //     if (!$user) {
    //         return $this->response->setJSON(['status' => 'error', 'message' => 'Data user tidak ditemukan.']);
    //     }

    //     $emailPeserta = $user->email;
    //     $emailInstansi = $user->email_instansi ?? null;

    //     // ===== Generate Surat Penerimaan (PDF) =====
    //     helper('url');
    //     $pdfController = new \App\Controllers\GeneratePDF();
    //     $pdfPath = $pdfController->suratPenerimaan($id); // pastikan ini mengembalikan path file PDF

    //     // ===== Kirim Email =====
    //     $email = \Config\Services::email();
    //     $email->setTo($emailPeserta);
    //     if ($emailInstansi) {
    //         $email->setCC($emailInstansi);
    //     }

    //     $email->setSubject('Penerimaan Magang di PT Semen Padang');
    //     $email->setMessage(view('emails/penerimaan_magang', [
    //         'nama' => $user->nama,
    //         'unit' => $pendaftar->unit,
    //         'tanggal_masuk' => $start->format('d F Y'),
    //         'tanggal_selesai' => $end->format('d F Y'),
    //     ]));

    //     if (file_exists($pdfPath)) {
    //         $email->attach($pdfPath);
    //     }

    //     if ($email->send()) {
    //         return $this->response->setJSON(['status' => 'success', 'message' => 'Pendaftaran berhasil diterima dan email dikirim.']);
    //     } else {
    //         return $this->response->setJSON(['status' => 'warning', 'message' => 'Diterima, tapi gagal mengirim email.', 'debug' => $email->printDebugger()]);
    //     }
    // }

public function terimaPendaftar($id = null)
{
    if (!$id) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'ID tidak ditemukan.']);
    }

    $db = \Config\Database::connect();

    // Ambil data pendaftar + join unit kerja
    $builder = $db->table('magang');
    $builder->select('magang.*, unit_kerja.unit_kerja');
    $builder->join('unit_kerja', 'unit_kerja.id = magang.unit_id', 'left');
    $pendaftar = $builder->where('magang.id', $id)->get()->getRow();

    if (!$pendaftar) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Data pendaftar tidak ditemukan.']);
    }

    // Hitung tanggal mulai dan selesai magang
    $today = new \DateTime();
    $start = new \DateTime($today->format('Y-m-01'));
    $start->modify('+2 month');
    while (in_array($start->format('N'), [6, 7])) {
        $start->modify('+1 day');
    }

    $durasi = (int) $pendaftar->durasi;
    $end = clone $start;
    $end->modify("+$durasi month");

    // Update status dan tanggal
    $db->table('magang')->where('id', $id)->update([
        'status_seleksi'   => 'Diterima',
        'tanggal_seleksi' => date('Y-m-d H:i:s'),
        'tanggal_masuk'   => $start->format('Y-m-d'),
        'tanggal_selesai' => $end->format('Y-m-d'),
        'status'          => 'Diterima',
    ]);

    // Ambil data user
    $user = $db->table('users')->where('id', $pendaftar->user_id)->get()->getRow();
    if (!$user) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Data user tidak ditemukan.']);
    }

    $emailPeserta = $user->email;
    $emailInstansi = $user->email_instansi ?? null;

    // ===== Kirim Email =====
    $email = \Config\Services::email();
    $email->setTo($emailPeserta);
    if ($emailInstansi) {
        $email->setCC($emailInstansi);
    }

    $email->setSubject('Penerimaan Magang di PT Semen Padang');
    $email->setMessage(view('emails/penerimaan_magang', [
        'nama'            => $user->fullname ?? $user->username,
        'unit'            => $pendaftar->unit_kerja,
        'tanggal_masuk'   => $start->format('d F Y'),
        'tanggal_selesai' => $end->format('d F Y'),
    ]));

    if ($email->send()) {
        return $this->response->setJSON(['status' => 'success', 'message' => 'Pendaftaran berhasil diterima dan email dikirim.']);
    } else {
        return $this->response->setJSON(['status' => 'warning', 'message' => 'Diterima, tapi gagal mengirim email.', 'debug' => $email->printDebugger()]);
    }
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
            ->join('unit_kerja', 'unit_kerja.id = magang.unit_id', 'left')
            ->where('magang.id', $id)
            ->get()->getRow();

        if (!$pendaftar) {
            $failCount++;
            $messages[] = "ID $id: Pendaftar tidak ditemukan.";
            continue;
        }

        // Hitung tanggal mulai dan selesai
        $today = new \DateTime();
        $start = new \DateTime($today->format('Y-m-01'));
        $start->modify('+1 month');
        while (in_array($start->format('N'), [6, 7])) {
            $start->modify('+1 day');
        }

        $durasi = (int) $pendaftar->durasi;
        $end = clone $start;
        $end->modify("+$durasi month");

        // Update status & tanggal
        $db->table('magang')->where('id', $id)->update([
            'status_seleksi'   => 'Diterima',
            'tanggal_seleksi' => date('Y-m-d H:i:s'),
            'tanggal_masuk'   => $start->format('Y-m-d'),
            'tanggal_selesai' => $end->format('Y-m-d'),
            'status'          => 'Diterima',
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


    public function tolakPendaftar($id = null)
    {
        log_message('debug', 'Masuk ke tolakPendaftar() dengan ID: ' . $id);

        if (!$id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID tidak ditemukan.']);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('magang');

        $data = $builder->where('id', $id)->get()->getRow();
        if (!$data) {
            log_message('error', 'Data magang dengan ID ' . $id . ' tidak ditemukan.');
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
        }

        $builder->where('id', $id)->update([
            'status' => 'Ditolak',
            'tanggal_seleksi' => date('Y-m-d H:i:s')
        ]);

        log_message('debug', 'Pendaftaran dengan ID ' . $id . ' berhasil ditolak.');

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Pendaftaran berhasil ditolak.'
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
                ->join('unit_kerja', 'unit_kerja.id = magang.unit_id', 'left')
                ->where('magang.id', $id)
                ->get()
                ->getRow();

            if (!$data) {
                log_message('error', "Data magang dengan ID $id tidak ditemukan.");
                $failCount++;
                $messages[] = "ID $id: tidak ditemukan.";
                continue;
            }

            $updated = $builder->where('id', $id)->update([
                'status'   => 'Ditolak',
                'tanggal_seleksi' => date('Y-m-d H:i:s')
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
                $email->setMessage(view('emails/penolakan_magang', [
                    'nama' => $data->fullname ?? $data->username,
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


    public function indexBerkas(): string
    {
        
        $data = $this->magangModel->select('magang.*, users.fullname, users.nisn_nim, users.cv, users.proposal, users.surat_permohonan')
                                        ->join('users', 'users.id = magang.user_id')
                                        ->where('magang.validasi_berkas', 'Y')
                                        ->where('magang.status !=', 'magang')
                                        ->orderBy('tgl_validasi_berkas')
                                        ->findAll();

        return view('admin/kelola_kelengkapan', ['data' => $data]);
    }

    public function validasiBerkas($id)
    {
        $status  = $this->request->getPost('status_validasi');
        $catatan = $this->request->getPost('catatan');

        // Ambil data user dan magang
        $db = \Config\Database::connect();
        $data = $db->table('magang')
            ->select('magang.*, users.email, users.email_instansi, users.fullname, users.username, unit_kerja.unit_kerja')
            ->join('users', 'users.id = magang.user_id', 'left')
            ->join('unit_kerja', 'unit_kerja.id = magang.unit_id', 'left')
            ->where('magang.id', $id)
            ->get()
            ->getRow();

        if (!$data) {
            return redirect()->back()->with('error', 'Data magang tidak ditemukan.');
        }

        // Siapkan data untuk update
        $updateData = [
            'berkas_lengkap'       => $status,
            'tgl_berkas_lengkap'   => date('Y-m-d H:i:s'),
            'cttn_validasi_berkas' => $catatan
        ];

        // Penyesuaian jika status valid
        if ($status !== 'N') {
            $updateData['status'] = 'magang';
        } else {
            $updateData['validasi_berkas'] = NULL;
            $updateData['tgl_validasi_berkas'] = NULL;
        }

        // Lakukan update data
        $this->magangModel->update($id, $updateData);

        // ===================== Kirim Email ===================== //
        $email = \Config\Services::email();
        // Kirim ke dua email: user dan instansi
        $toEmail = $data->email;
        $ccEmail = $data->email_instansi;

        // Pastikan ada email tujuan
        if (!empty($toEmail)) {
            $email->setTo($toEmail);

            if (!empty($ccEmail) && filter_var($ccEmail, FILTER_VALIDATE_EMAIL)) {
                $email->setCC($ccEmail);
            }
        }

        $email->setSubject('Hasil Validasi Berkas Magang di PT Semen Padang');

        if ($status === 'N') {
            // Jika berkas tidak valid
            $email->setMessage(view('emails/berkas_tidak_valid', [
                'nama'    => $data->fullname ?? $data->username,
                'unit'    => $data->unit_kerja ?? 'Unit terkait',
                'catatan' => $catatan
            ]));
        } else {
            // Jika berkas valid
            $email->setMessage(view('emails/berkas_valid', [
                'nama' => $data->fullname ?? $data->username,
                'unit' => $data->unit_kerja ?? 'Unit terkait',
            ]));

            // Generate dan lampirkan surat penerimaan
            $generatePDF = new \App\Controllers\GeneratePDF();
            $pdfPath = $generatePDF->suratPenerimaan($id, true);

            if ($pdfPath && file_exists($pdfPath)) {
                $email->attach($pdfPath);
            }
        }

        // Kirim email
        if (!$email->send()) {
            log_message('error', "Gagal kirim email validasi berkas ID $id: " . print_r($email->printDebugger(), true));
        }

        // Hapus file PDF sementara (jika ada dan valid)
        if (!empty($pdfPath) && file_exists($pdfPath)) {
            unlink($pdfPath);
        }

        return redirect()->back()->with('success', 'Validasi berhasil disimpan dan email telah dikirim.');
    }



    public function indexMagang(): string
    {
        
        $data = $this->magangModel->select('magang.*,unit_kerja.unit_kerja, users.*')
                                        ->join('users', 'users.id = magang.user_id')
                                        ->join('unit_kerja', 'magang.unit_id = unit_kerja.id')
                                        ->where('magang.berkas_lengkap', 'v')
                                        ->findAll();

        return view('admin/kelola_magang', ['data' => $data]);
    }





    // Menyetujui pendaftaran
    // public function approve($id)
    // {

    //     $this->pendaftaranModel->update($id, [
    //         'validasi_berkas' => 'Y',
    //         'tgl_validasi_berkas' => date('Y-m-d H:i:s')
    //     ]);

    //     return redirect()->to('/manage-pendaftaran')->with('success', 'Pendaftaran telah disetujui.');
    // }

    // Menolak pendaftaran
    // public function reject($id)
    // {
    //     $alasan = $this->request->getPost('alasan');

    //     if (!$alasan) {
    //         return redirect()->back()->with('error', 'Alasan penolakan harus diisi.');
    //     }

    //     $this->pendaftaranModel->update($id, [
    //         'tanggal_approval' => date('Y-m-d H:i:s'),
    //         'catatan' => $alasan,
    //     ]);

    //     return redirect()->to('/manage-pendaftaran')->with('success', 'Pendaftaran telah ditolak.');
    // }

}
