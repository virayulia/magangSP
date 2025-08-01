<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\MY_TCPDF as TCPDF;
use App\Models\UserModel;
use App\Models\InstansiModel;
use App\Models\MagangModel;
use App\Models\SoalSafetyModel;
use App\Models\JawabanSafetyModel;
use App\Models\PenilaianModel;
use App\Models\DetailJawabanSafetyModel;



class MagangController extends BaseController
{
    
    protected $userModel;
    protected $instansiModel;
    protected $magangModel;
    protected $soalSafetyModel;
    protected $jawabanModel;
    protected $penilaianModel;
    protected $detailJawabanModel;

    
    public function __construct()
    {
        // Inisialisasi model
        $this->userModel = new UserModel();
        $this->instansiModel = new InstansiModel();
        $this->magangModel = new MagangModel();
        $this->soalSafetyModel = new SoalSafetyModel();
        $this->jawabanModel = new JawabanSafetyModel();
        $this->penilaianModel = new PenilaianModel();
        $this->detailJawabanModel = new DetailJawabanSafetyModel();


    }

    public function statusLamaran()
    {
        $userId = user_id();

        // Ambil data profil pengguna
        $data['user_data'] = $this->userModel
            ->join('instansi', 'instansi.instansi_id = users.instansi_id', 'left')
            ->join('jurusan', 'jurusan.jurusan_id = users.jurusan_id', 'left')
            ->select('users.fullname, users.email,users.user_image,users.nisn_nim, users.no_hp, users.jenis_kelamin, users.alamat,
            users.province_id, users.city_id, users.domisili, users.provinceDom_id, users.cityDom_id,
            users.tingkat_pendidikan, users.instansi_id, users.jurusan_id, users.semester, 
            users.nilai_ipk, users.rfid_no, users.cv, users.proposal, users.surat_permohonan, users.tanggal_surat,
            users.no_surat, users.nama_pimpinan, users.jabatan, users.email_instansi,users.bpjs_kes, users.bpjs_tk, 
            users.buktibpjs_tk, users.ktp_kk, users.status, instansi.nama_instansi, jurusan.nama_jurusan')
            ->where('users.id', $userId)
            ->first();

        // Ambil satu pendaftaran yang masih berjalan
        $data['pendaftaran'] = $this->magangModel
            ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id')
            ->select('magang.magang_id as magang_id, magang.*, unit_kerja.*')
            ->where('user_id', $userId)
            ->whereIn('status_akhir', ['pendaftaran', 'proses', 'magang'])
            ->orderBy('tanggal_daftar', 'DESC')
            ->first();

        // Ambil semua riwayat pendaftaran (untuk ditampilkan sebagai histori)
        $data['histori'] = $this->magangModel
            ->where('user_id', $userId)
            ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id')
            ->select('magang.*, unit_kerja.unit_kerja')
            ->whereNotIn('magang.status_akhir', ['pendaftaran', 'proses', 'magang'])
            ->orderBy('magang.tanggal_daftar', 'DESC')
            ->findAll();

        // Ambil periode aktif
        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        $periode = $db->table('periode_magang')
            ->where('tanggal_buka <=', $today)
            ->orderBy('tanggal_buka', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();
       
        return view('user/status-lamaran', [
            'periode'             => $periode,
            'pendaftaran'         => $data['pendaftaran'],        
            'histori' => $data['histori'],
            'user_data'           => $data['user_data'],
        ]);
    }

    public function daftar()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $userId = user()->id;
        $unitId = $this->request->getPost('unit_id');
        $durasi = $this->request->getPost('durasi');

        if (!$durasi || !is_numeric($durasi)) {
            return redirect()->back()->with('error', 'Durasi magang tidak valid.');
        }

        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        // Cek periode aktif
        $periode = $db->table('periode_magang')
            ->where('tanggal_buka <=', $today)
            ->where('tanggal_tutup >=', $today)
            ->orderBy('tanggal_buka', 'DESC')
            ->get()
            ->getRow();
        $periode_id = $periode->periode_id ?? null;

        // Cek apakah user sudah pernah daftar magang (status belum ditolak)
        $existingMagang = $this->magangModel
            ->where('user_id', $userId)
            ->whereIn('status_akhir', ['pendaftaran', 'proses', 'magang']) // status belum ditolak
            ->first();

        // Cek apakah user sedang daftar penelitian (status belum ditolak)
        $existingPenelitian = $db->table('penelitian')
            ->where('user_id', $userId)
            ->whereIn('status_akhir', ['pendaftaran', 'proses', 'penelitian']) // status belum ditolak
            ->get()
            ->getRow();

        if ($existingMagang || $existingPenelitian) {
            return redirect()->back()->with('error', 'Anda telah melakukan pendaftaran magang atau penelitian. Anda tidak dapat mendaftar lagi saat ini.');
        }

        // Simpan pendaftaran baru
        $this->magangModel->insert([
            'user_id'       => $userId,
            'unit_id'       => $unitId,
            'durasi'        => $durasi,
            'periode_id'    => $periode_id,
            'status_akhir'  => 'pendaftaran',
            'tanggal_daftar'=> date('Y-m-d H:i:s'),
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/magang')->with('success', 'Pendaftaran berhasil dikirim. Silakan pantau pendaftaran Anda di Menu Profil - Pendaftaran Magang.');
    }

    public function konfirmasi()
    {
        // Ambil data pendaftaran berdasarkan id
        $request = service('request');
        $id = $request->getPost('magang_id');
        $pendaftaran = $this->magangModel->find($id);

        // Cek jika data pendaftaran ditemukan
        if (!$pendaftaran) {
            // Jika tidak ditemukan, tampilkan error atau redirect
            return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        // Update status konfirmasi dan tanggal konfirmasi
        $data = [
            'status_konfirmasi' => 'Y',  // Status konfirmasi di-set menjadi 1
            'tanggal_konfirmasi' => date('Y-m-d H:i:s'),  // Tanggal konfirmasi adalah hari ini\
        ];

        // Update data pendaftaran
        if ($this->magangModel->update($id, $data)) {
            // Jika berhasil, redirect dengan pesan sukses
            return redirect()->to('/status-lamaran')->with('success', 'Pendaftaran berhasil dikonfirmasi! Selanjutnya, mohon lengkapi berkas Anda dan lakukan validasi untuk melanjutkan proses.');
        } else {
            // Jika gagal, tampilkan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengkonfirmasi pendaftaran.');
        }
 
    }

    public function validasiBerkas()
    {
        $request = service('request');
        $id = $request->getPost('magang_id');

        // Ambil data pendaftaran
        $pendaftaran = $this->magangModel->find($id);

        if (!$pendaftaran) {
            return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $data = [
            'status_validasi_berkas'     => 'Y',
            'tanggal_validasi_berkas' => date('Y-m-d H:i:s')
        ];

        // Jika sebelumnya dinyatakan TIDAK lengkap, reset ulang
        if ($pendaftaran['status_berkas_lengkap'] === 'N') {
            $data['status_berkas_lengkap']        = null;
            $data['tanggal_berkas_lengkap']    = null;
            $data['cttn_berkas_lengkap']  = null;
        }

        if ($this->magangModel->update($id, $data)) {
            return redirect()->to('/status-lamaran')->with('success', 'Validasi berhasil. Kami menghargai komitmen Anda dalam melengkapi dokumen dengan benar. Selanjutnya, silahkan cek email dan website ini secara berkala untuk info validasi berkas Anda.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memvalidasi berkas.');
        }
    }

    public function cetakTandaPengenal($id)
    {

        $magang = $this->magangModel->join('unit_kerja','unit_kerja.unit_id = magang.unit_id')
                                    ->find($id);

        if (!$magang) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data magang tidak ditemukan.');
        }

        // Ambil data user berdasarkan user_id dari tabel magang
        $user = $this->userModel->join('instansi', 'instansi.instansi_id = users.instansi_id')
                                ->where('users.id', $magang['user_id'])
                                ->select('users.fullname, users.email,users.user_image,users.nisn_nim, users.no_hp, users.jenis_kelamin, users.alamat,
            users.province_id, users.city_id, users.domisili, users.provinceDom_id, users.cityDom_id,
            users.tingkat_pendidikan, users.instansi_id, users.jurusan_id,  users.semester, 
            users.nilai_ipk, users.rfid_no, users.cv, users.proposal, users.surat_permohonan, users.tanggal_surat,
            users.no_surat, users.nama_pimpinan, users.jabatan, users.email_instansi,users.bpjs_kes, users.bpjs_tk, 
            users.buktibpjs_tk, users.ktp_kk, users.status, instansi.nama_instansi as nama_instansi') // jika kamu butuh nama instansi
                                ->first();

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data pengguna tidak ditemukan.');
        }
        return view('user/template_tanda_pengenal', [
            'magang' => $magang,
            'user' => $user,
        ]);
    }

    public function pelaksanaan()
    {
        $userId = user_id();

        // Ambil data profil
        $userData = $this->userModel
            ->join('instansi', 'instansi.instansi_id = users.instansi_id', 'left')
            ->join('jurusan', 'jurusan.jurusan_id = users.jurusan_id', 'left')
            ->select('users.fullname, users.email,users.user_image,users.nisn_nim, users.no_hp, users.jenis_kelamin, users.alamat,
            users.province_id, users.city_id, users.domisili, users.provinceDom_id, users.cityDom_id,
            users.tingkat_pendidikan, users.instansi_id, users.jurusan_id, users.semester, 
            users.nilai_ipk, users.rfid_no, users.cv, users.proposal, users.surat_permohonan, users.tanggal_surat,
            users.no_surat, users.nama_pimpinan, users.jabatan, users.email_instansi,users.bpjs_kes, users.bpjs_tk, 
            users.buktibpjs_tk, users.ktp_kk, users.status, instansi.nama_instansi, jurusan.nama_jurusan')
            ->where('users.id', $userId)
            ->first();

        // Ambil data pendaftaran user (pastikan sesuai nama tabel kamu)
        $pendaftaran = $this->magangModel
            ->where('user_id', $userId)
            ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id')
            ->whereIn('status_akhir', ['pendaftaran', 'proses', 'magang'])
            ->orderBy('tanggal_daftar', 'desc')
            ->first();

    
        $riwayatSafety = $this->jawabanModel
            ->join('magang', 'magang.magang_id = jawaban_safety.magang_id')
            ->where('magang.user_id', $userId)
            ->orderBy('tanggal_ujian', 'desc')
            ->findAll();
        
        // Ambil periode aktif
        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        $periode = $db->table('periode_magang')
            ->where('tanggal_buka <=', $today)
            ->orderBy('tanggal_buka', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();
       

        // Kalau sudah lulus, tampilkan view pelaksanaan normal
        return view('user/pelaksanaan', [
            'periode'   => $periode,
            'user_data' => $userData,
            'pendaftaran' => $pendaftaran,
            'riwayat_safety' => $riwayatSafety
        ]);
    }

    public function suratPernyataan()
    {
        $userId = user_id();

        // Ambil data profil
        $userData = $this->userModel
            ->join('instansi', 'instansi.instansi_id = users.instansi_id', 'left')
            ->join('jurusan', 'jurusan.jurusan_id = users.jurusan_id', 'left')
            ->select('users.fullname,users.email, users.user_image,users.nisn_nim, users.no_hp, users.jenis_kelamin, users.alamat,
            users.province_id, users.city_id, users.domisili, users.provinceDom_id, users.cityDom_id,
            users.tingkat_pendidikan, users.instansi_id, users.jurusan_id, users.semester, 
            users.nilai_ipk, users.rfid_no, users.cv, users.proposal, users.surat_permohonan, users.tanggal_surat,
            users.no_surat, users.nama_pimpinan, users.jabatan, users.email_instansi,users.bpjs_kes, users.bpjs_tk, 
            users.buktibpjs_tk, users.ktp_kk, users.status, instansi.nama_instansi, jurusan.nama_jurusan')
            ->where('users.id', $userId)
            ->first();

        // Ambil data pendaftaran user (pastikan sesuai nama tabel kamu)
        $pendaftaran = $this->magangModel
            ->where('user_id', $userId)
            ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id')
            ->orderBy('tanggal_daftar', 'desc')
            ->first();

        // Kalau sudah lulus, tampilkan view pelaksanaan normal
        return view('user/surat_pernyataan', [
            'user_data' => $userData,
            'pendaftaran' => $pendaftaran
        ]);
    }

    public function setujuiPernyataan()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('magang');

        $userId = user()->id; // Pastikan sesuai field user kamu
        $tanggal = date('Y-m-d');

        // Update data pendaftaran
        $builder->where('user_id', $userId)
            ->update([
                'tanggal_setujui_pernyataan' => $tanggal
            ]);

        return redirect()->to(base_url('pelaksanaan'))->with('success', 'Surat pernyataan berhasil disetujui.');
    }

    public function safetyTes()
    {
        $data['soal'] = $this->soalSafetyModel->findAll();

        return view('user/tes-safety', $data);
    }

    public function submitTes()
    {
        $userId = user_id(); 
        $jawabanUser = $this->request->getPost('jawaban');

        // Ambil data magang aktif user
        $magang = $this->magangModel
            ->where('user_id', $userId)
            ->where('status_akhir', 'magang')
            ->first();

        if (!$magang) {
            return redirect()->to('/pelaksanaan')->with('error', '❌ Data magang tidak ditemukan.');
        }

        $magangId = $magang['magang_id'];

        // Hitung jumlah percobaan sebelumnya
        $percobaanSebelumnya = $this->jawabanModel
            ->where('magang_id', $magangId)
            ->countAllResults();

        if ($percobaanSebelumnya >= 3) {
            return redirect()->to('/pelaksanaan')->with('error', '❌ Anda telah melebihi batas 3 percobaan.');
        }

        $soalSemua = $this->soalSafetyModel->findAll();
        $nilaiPerSoal = 100 / count($soalSemua);
        $skor = 0;

        // Mulai transaksi database
        $db = \Config\Database::connect();
        $db->transStart();

        // Simpan jawaban utama dulu
        $this->jawabanModel->insert([
            'magang_id'     => $magangId,
            'nilai'         => 0, // sementara 0, diupdate nanti
            'percobaan_ke'  => $percobaanSebelumnya + 1,
            'tanggal_ujian' => date('Y-m-d'),
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        $jawabanId = $this->jawabanModel->getInsertID(); // ID jawaban baru
        
        // Simpan detail jawaban per soal
        foreach ($soalSemua as $soal) {
            $soalId = $soal['soal_id'];
            $jawabanBenar = strtolower(trim($soal['jawaban_benar']));
            $jawaban = strtolower(trim($jawabanUser[$soalId] ?? ''));

            $benar = $jawaban === $jawabanBenar;

            if ($benar) {
                $skor += $nilaiPerSoal;
            }

            // Simpan ke detail_jawaban_safety
            $this->detailJawabanModel->insert([
                'jawaban_safety_id' => $jawabanId,
                'soal_safety_id'    => $soalId,
                'jawaban_user'      => $jawaban,
                'benar'             => $benar ? 1 : 0,
                'created_at'        => date('Y-m-d H:i:s'),
            ]);
        }

        // Bulatkan skor & update jawaban utama
        $skor = round($skor);
        $this->jawabanModel->update($jawabanId, ['nilai' => $skor]);

        $db->transComplete();

        $status = $skor >= 70 ? 'lulus' : 'gagal';
        return redirect()->to('/pelaksanaan')->with('success', "Tes selesai. Skor Anda: $skor ($status)");
    }



    public function sertifikatIndex()
    {
        $userId = user_id();

        // Ambil data profil
        $userData = $this->userModel
            ->join('instansi', 'instansi.instansi_id = users.instansi_id', 'left')
            ->join('jurusan', 'jurusan.jurusan_id = users.jurusan_id', 'left')
            ->select('users.fullname,users.email, users.user_image,users.nisn_nim, users.no_hp, users.jenis_kelamin, users.alamat,
            users.province_id, users.city_id, users.domisili, users.provinceDom_id, users.cityDom_id,
            users.tingkat_pendidikan, users.instansi_id, users.jurusan_id,  users.semester, 
            users.nilai_ipk, users.rfid_no, users.cv, users.proposal, users.surat_permohonan, users.tanggal_surat,
            users.no_surat, users.nama_pimpinan, users.jabatan, users.email_instansi,users.bpjs_kes, users.bpjs_tk, 
            users.buktibpjs_tk, users.ktp_kk, users.status, instansi.nama_instansi, jurusan.nama_jurusan')
            ->where('users.id', $userId)
            ->first();
        
        $penilaian = $this->magangModel
            ->join('penilaian', 'penilaian.magang_id = magang.magang_id')
            ->where('magang.user_id', $userId)
            ->first();

        $pendaftaran = $this->magangModel
            ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id')
            ->select('magang.magang_id as magang_id, magang.*, unit_kerja.*')
            ->where('user_id', $userId)
            ->whereIn('status_akhir', ['pendaftaran', 'proses', 'magang'])
            ->orderBy('tanggal_daftar', 'DESC')
            ->first();
        
        // Ambil periode aktif
        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        $periode = $db->table('periode_magang')
            ->where('tanggal_buka <=', $today)
            ->orderBy('tanggal_buka', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();
            
        // Kalau sudah lulus, tampilkan view pelaksanaan normal
        return view('user/sertifikat-magang', [
            'periode'   => $periode,
            'user_data' => $userData,
            'penilaian' => $penilaian,
            'pendaftaran' => $pendaftaran,  
        ]);
    }


    public function cetakSertifikat($saveToFile = false)
    {
        $userId = user_id();

        // Ambil data user & penilaian
        $user = $this->userModel->find($userId);
        $magang = $this->magangModel->where('user_id', $userId)->first();
        $penilaian = $this->penilaianModel->where('magang_id', $magang['magang_id'])->first();


        if (!$penilaian || $penilaian['approve_kaunit'] != 1) {
            return redirect()->back()->with('error', 'Sertifikat belum bisa diunduh.');
        }

        // Hitung nilai
        $totalNilai = $penilaian['nilai_disiplin']
            + $penilaian['nilai_kerajinan']
            + $penilaian['nilai_tingkahlaku']
            + $penilaian['nilai_kerjasama']
            + $penilaian['nilai_kreativitas']
            + $penilaian['nilai_kemampuankerja']
            + $penilaian['nilai_tanggungjawab']
            + $penilaian['nilai_penyerapan'];

        $rataRata = round($totalNilai / 8, 2);

        // Inisialisasi PDF
        $pdf = new \TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('PT. Semen Padang');
        $pdf->SetTitle('Sertifikat Magang');
        $pdf->SetSubject('Sertifikat Magang');
        $pdf->SetKeywords('TCPDF, PDF, sertifikat, semenpadang.online');

        $pdf->SetHeaderData('', '', '', '');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetMargins(20, 25, 20);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetFont('times', '', 12);
        $pdf->AddPage();

        // Data yang dikirim ke view
        $data = [
            'user' => $user,
            'penilaian' => $penilaian,
            'magang' => $magang,
            'rataRata' => $rataRata,
        ];

        // Buat view HTML sertifikat
        $html = view('user/sertifikat-pdf', $data);
        $pdf->writeHTML($html);

        $fileName = 'sertifikat-magang-' . url_title($user->fullname ?? $user->nama, '-', true) . '-' . date('YmdHis') . '.pdf';

        if ($saveToFile) {
            $filePath = WRITEPATH . 'uploads/' . $fileName;
            $pdf->Output($filePath, 'F');
            return $filePath;
        } else {
            $this->response->setContentType('application/pdf');
            $pdf->Output($fileName, 'I');
            exit;
        }
    }



}
