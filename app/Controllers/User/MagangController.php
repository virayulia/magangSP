<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\InstansiModel;
use App\Models\MagangModel;
use App\Models\SoalSafetyModel;
use App\Models\JawabanSafetyModel;
use App\Models\PenilaianModel;

class MagangController extends BaseController
{
    
    protected $userModel;
    protected $instansiModel;
    protected $magangModel;
    protected $soalSafetyModel;
    protected $jawabanModel;
    protected $penilaianModel;
    
    public function __construct()
    {
        // Inisialisasi model
        $this->userModel = new UserModel();
        $this->instansiModel = new InstansiModel();
        $this->magangModel = new MagangModel();
        $this->soalSafetyModel = new SoalSafetyModel();
        $this->jawabanModel = new JawabanSafetyModel();
        $this->penilaianModel = new PenilaianModel();

    }

    public function statusLamaran()
    {
        $userId = user_id();

        // Ambil data profil pengguna
        $data['user_data'] = $this->userModel
            ->join('instansi', 'instansi.instansi_id = users.instansi_id', 'left')
            ->join('jurusan', 'jurusan.jurusan_id = users.jurusan_id', 'left')
            ->select('users.*, instansi.nama_instansi, jurusan.nama_jurusan')
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

        return redirect()->to('/lowongan')->with('success', 'Pendaftaran berhasil dikirim. Silakan pantau pendaftaran Anda di Menu Profil - Pendaftaran Magang.');
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

        $magang = $this->magangModel->find($id);

        if (!$magang) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data magang tidak ditemukan.');
        }

        // Ambil data user berdasarkan user_id dari tabel magang
        $user = $this->userModel->join('instansi', 'instansi.instansi_id = users.instansi_id')
                                ->where('users.id', $magang['user_id'])
                                ->select('users.*, instansi.nama_instansi as nama_instansi') // jika kamu butuh nama instansi
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
            ->select('users.*, instansi.nama_instansi, jurusan.nama_jurusan')
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
       

        // Kalau sudah lulus, tampilkan view pelaksanaan normal
        return view('user/pelaksanaan', [
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
            ->select('users.*, instansi.nama_instansi, jurusan.nama_jurusan')
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

        return redirect()->to(base_url('pelaksanaan'))->with('message', 'Surat pernyataan berhasil disetujui.');
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

        // Hitung skor dari jawaban
        $soalSemua = $this->soalSafetyModel->findAll();
        $skor = 0;
        $nilaiPerSoal = 100 / count($soalSemua); // agar total maksimal 100

        foreach ($soalSemua as $soal) {
            $id = $soal['soal_id'];
            $jawabanBenar = strtolower(trim($soal['jawaban_benar']));
            $jawaban = strtolower(trim($jawabanUser[$id] ?? ''));

            if ($jawaban && $jawaban === $jawabanBenar) {
                $skor += $nilaiPerSoal;
            }
        }

        $skor = round($skor); // bulatkan skor

        // Tentukan status kelulusan
        $status = $skor >= 70 ? 'lulus' : 'gagal';

        // Simpan ke database
        $this->jawabanModel->save([
            'magang_id'     => $magangId,
            'nilai'         => $skor,
            'percobaan_ke'  => $percobaanSebelumnya + 1,
            'tanggal_ujian' => date('Y-m-d'),
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/pelaksanaan')->with('success', "Tes selesai. Skor Anda: $skor ($status)");
    }


    public function sertifikatIndex()
    {
        $userId = user_id();

        // Ambil data profil
        $userData = $this->userModel
            ->join('instansi', 'instansi.instansi_id = users.instansi_id', 'left')
            ->join('jurusan', 'jurusan.jurusan_id = users.jurusan_id', 'left')
            ->select('users.*, instansi.nama_instansi, jurusan.nama_jurusan')
            ->where('users.id', $userId)
            ->first();
        
        $penilaian = $this->magangModel
            ->join('penilaian', 'penilaian.magang_id = magang.magang_id')
            ->where('magang.user_id', $userId)
            ->first();
            
         // Kalau sudah lulus, tampilkan view pelaksanaan normal
        return view('user/sertifikat-magang', [
            'user_data' => $userData,
            'penilaian' => $penilaian,
        ]);
    }

    }
