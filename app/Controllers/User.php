<?php

namespace App\Controllers;
use App\Models\MagangModel;
use App\Models\InstansiModel;
use App\Models\JurusanModel;
use App\Models\ProvincesModel;
use App\Models\RegenciesModel;
use Myth\Auth\Models\UserModel;

class User extends BaseController
{
    protected $pendaftaranModel;
    protected $userModel;
    protected $instansiModel;
    protected $magangModel;
    protected $jurusanModel;
    protected $countriesModel;
    protected $provincesModel;
    protected $regenciesModel;

    public function __construct()
    {
        // Inisialisasi model
        $this->userModel = new UserModel();
        $this->instansiModel = new InstansiModel();
        $this->magangModel = new MagangModel();
        $this->jurusanModel = new JurusanModel();
        $this->provincesModel = new ProvincesModel();
        $this->regenciesModel = new RegenciesModel();

    }
    
    public function index(): string
    {
        return view('user/index');
    }
    
    public function pendaftaran(): string
    {
        return view('user/pendaftaran');
    }

    // public function savedaftar()
    // {
    //     $userId = user_id(); // ambil ID user login
    //     $userModel = new UserModel();
    //     $pendaftaranModel = new MagangModel();

    //     // Update data diri ke tabel users
    //     $userModel->update($userId, [
    //         'fullname'              => $this->request->getPost('nama'),
    //         'nim'               => $this->request->getPost('nim'),
    //         'nik'               => $this->request->getPost('nik'),
    //         'no_hp'             => $this->request->getPost('no_hp'),
    //         'jurusan'           => $this->request->getPost('jurusan'),
    //         'fakultas'          => $this->request->getPost('fakultas'),
    //         'universitas'       => $this->request->getPost('universitas'),
    //         'semester'          => $this->request->getPost('semester'),
    //     ]);

    //     // Validasi file upload
    //     $validationRule = [
    //         'cv'                  => 'uploaded[cv]|mime_in[cv,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]|max_size[cv,2048]',
    //         'proposal' => 'uploaded[proposal]|mime_in[proposal,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]|max_size[proposal,2048]',
    //         'surat_permohonanpt' => 'uploaded[surat_permohonanpt]|mime_in[surat_permohonanpt,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]|max_size[surat_permohonanpt,2048]',
    //     ];

    //     if (!$this->validate($validationRule)) {
    //         return redirect()->back()->withInput()->with('error', 'Upload file gagal. Pastikan format pdf/doc/docx dan ukuran maksimal 2MB.');
    //     }

    //     // Upload file cv, proposal, dan surat permohonan
    //     $cv = $this->request->getFile('cv');
    //     $proposal = $this->request->getFile('proposal');
    //     $suratPermohonan = $this->request->getFile('surat_permohonanpt');

    //     $cvName = $cv->getRandomName();
    //     $proposalName = $proposal->getRandomName();
    //     $suratPermohonanName = $suratPermohonan->getRandomName();

    //     $cv->move('uploads/cv', $cvName);
    //     $proposal->move('uploads/proposal', $proposalName);
    //     $suratPermohonan->move('uploads/surat', $suratPermohonanName);

    //     $dataPendaftaran = [
    //         'user_id'             => $userId,
    //         'jenis_program'       => $this->request->getPost('jenis_pengajuan'),
    //         'tanggal_pengajuan'   => $this->request->getPost('tanggal_pengajuan'),
    //         'tanggal_daftar'      => date('Y-m-d H:i:s'),
    //         'lama_pelaksanaan'    => $this->request->getPost('lama_pelaksanaan'),
    //         'cv'                  => $cvName,
    //         'proposal'            => $proposalName,
    //         'surat_permohonanpt'  => $suratPermohonanName,
    //     ];
        
    //     // Simpan dan cek apakah berhasil
    //     if (!$pendaftaranModel->insert($dataPendaftaran)) {
    //         // Kalau GAGAL, tampilkan error
    //         dd($pendaftaranModel->errors());
    //     }
        
    //     // Kalau berhasil, lanjut redirect
    //     return redirect()->to('/')->with('success', 'Pendaftaran berhasil dikirim.');
    // }

    public function profil()
    {
        $userId = session()->get('user_id'); 
        $data['user_data'] = $this->userModel
            ->join('instansi', 'instansi.id = users.instansi_id','left')
            ->join('jurusan', 'jurusan.id = users.jurusan','left')
            ->join('provinces AS province_ktp', 'province_ktp.id = users.province_id', 'left')
            ->join('provinces AS province_dom', 'province_dom.id = users.provinceDom_id', 'left')
            ->join('regencies AS city_ktp', 'city_ktp.id = users.city_id', 'left')
            ->join('regencies AS city_dom', 'city_dom.id = users.cityDom_id', 'left')
            ->select('users.*, 
                        instansi.nama_instansi, 
                        jurusan.nama_jurusan, 
                        province_ktp.province AS provinsi_ktp,
                        province_dom.province AS provinsi_domisili,
                        city_ktp.regency AS kota_ktp, 
                        city_ktp.type AS tipe_kota_ktp,
                        city_dom.regency AS kota_domisili,
                        city_dom.type AS tipe_kota_domisili')
            ->where('users.id', $userId)
            ->first();
       // dd($data);
        return view('user/profile', $data);
    }

    public function dataPribadi()
    {
        $userId = session()->get('user_id'); 
        $data['user_data'] = $this->userModel
            ->join('instansi', 'instansi.id = users.instansi_id','left')
            ->select('users.*, instansi.nama_instansi')
            ->where('users.id', $userId)
            ->first();
        
        $data['instansi'] =$this->instansiModel->findAll();

        $data['jurusan'] =$this->jurusanModel->findAll();

        $data['listState'] =$this->provincesModel->select('id,province')
                                                ->orderBy('id')
                                                ->findAll();
        $data['listCity'] = $this->regenciesModel->where('province_id', $data['user_data']->province_id)->findAll();
        $data['listCityDom'] = [];

        if (!empty($data['user_data']->provinceDom_id)) {
            $data['listCityDom'] = $this->regenciesModel->where('province_id', $data['user_data']->provinceDom_id)->findAll();
        }
                                               
        return view('user/profile-edit', $data);
    }

    public function getCities()
    {
        $state_id = $this->request->getVar('state_id');
        $searchTerm = $this->request->getVar('searchTerm');

        $query = $this->regenciesModel->select('id, regency')
                                ->where('province_id', $state_id);

        if ($searchTerm) {
            $query->like('regency', $searchTerm);
        }

        $listCities = $query->orderBy('id')->findAll();

        $data = [];
        foreach ($listCities as $value) {
            $data[] = [
                'id' => $value['id'],
                'text' => $value['regency'],
            ];
        }

        return $this->response->setJSON(['data' => $data]);
    }

    public function getCitiesDom()
    {
        $stateDom_id = $this->request->getVar('stateDom_id');
        $searchTerm = $this->request->getVar('searchTerm');

        $query = $this->regenciesModel->select('id, regency')
                                ->where('province_id', $stateDom_id);

        if ($searchTerm) {
            $query->like('regency', $searchTerm);
        }

        $listCities = $query->orderBy('id')->findAll();

        $data = [];
        foreach ($listCities as $value) {
            $data[] = [
                'id' => $value['id'],
                'text' => $value['regency'],
            ];
        }

        return $this->response->setJSON(['data' => $data]);
    }

    public function saveDataPribadi()
{
    $userId = user_id();
    $this->userModel->setValidationRule('email', "required|valid_email|is_unique[users.email,id,{$userId}]");

    $data = [
        'fullname'      => $this->request->getPost('fullname'),
        'nisn_nim'      => $this->request->getPost('nisn_nim'),
        'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
        'email'         => $this->request->getPost('email'),
        'no_hp'         => $this->request->getPost('no_hp'),
        'alamat'        => $this->request->getPost('alamat'),
        'province_id'   => $this->request->getPost('state_id'),
        'city_id'       => $this->request->getPost('city_id'),
        'domisili'      => $this->request->getPost('domisili'),
        'provinceDom_id'=> $this->request->getPost('stateDom_id'),
        'cityDom_id'    => $this->request->getPost('cityDom_id'),
    ];

    // Tangani upload foto
    $foto = $this->request->getFile('foto');
    if ($foto && $foto->isValid() && !$foto->hasMoved()) {
        // Validasi ekstensi dan ukuran
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($foto->getMimeType(), $allowedTypes)) {
            return redirect()->back()->with('error', 'Format gambar tidak valid. Hanya JPG, JPEG, PNG.')->withInput();
        }
        if ($foto->getSize() > 2 * 1024 * 1024) {
            return redirect()->back()->with('error', 'Ukuran gambar maksimal 2MB.')->withInput();
        }

        // Rename nama file
        $fullname = strtolower(preg_replace('/\s+/', '', $this->request->getPost('fullname')));
        $newName = $fullname . '-profile.' . $foto->getExtension();

        // Pindahkan file ke folder uploads/profile/
        $foto->move(ROOTPATH . 'public/uploads/profile', $newName);

        // Masukkan nama file ke dalam array data
        $data['user_image'] = $newName;
    }

    if (!$this->userModel->validate($data)) {
        return redirect()->back()->with('error', implode('<br>', $this->userModel->errors()))->withInput();
    }

    
    $result = $this->userModel->update($userId, $data);

    if (!$result) {
        return redirect()->back()->with('error', 'Gagal memperbarui data.');
    }

    return redirect()->to('/profile')->with('success', 'Data berhasil diperbarui.');
}

    public function saveDataAkademik()
    {
        $userId = user_id();

        $pendidikan = $this->request->getPost('pendidikan');
        $isSMA = $pendidikan === 'SMA/SMK';

        $data = [
            'pendidikan'    => $pendidikan,
            'instansi_id'   => $this->request->getPost('instansi'),
            'jurusan'       => $this->request->getPost('jurusan'),
            'nilai_ipk'     => $this->request->getPost('nilai_ipk'),
        ];

        // Jika bukan SMA, tambahkan semester
        if (!$isSMA) {
            $data['semester'] = $this->request->getPost('semester');
        } else {
            $data['semester'] = null;
        }

        // Validasi manual tambahan jika dibutuhkan
        if (!is_numeric($data['nilai_ipk']) || $data['nilai_ipk'] < 0) {
            return redirect()->back()->with('error', 'Nilai/IPK harus berupa angka positif.')->withInput();
        }

        if (!$this->userModel->validate($data)) {
            return redirect()->back()->with('error', implode('<br>', $this->userModel->errors()))->withInput();
        }

        $result = $this->userModel->update($userId, $data);

        if (!$result) {
            return redirect()->back()->with('error', 'Gagal memperbarui data.');
        }

        return redirect()->to('/profile')->with('success', 'Data berhasil diperbarui.');
    }



    // public function konfirmasi()
    // {
    //     // Ambil data pendaftaran berdasarkan id
    //     $request = service('request');
    //     $id = $request->getPost('magang_id');
    //     $pendaftaran = $this->magangModel->find($id);

    //     // Cek jika data pendaftaran ditemukan
    //     if (!$pendaftaran) {
    //         // Jika tidak ditemukan, tampilkan error atau redirect
    //         return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan.');
    //     }

    //     // Update status konfirmasi dan tanggal konfirmasi
    //     $data = [
    //         'konfirmasi_pendaftar' => 'Y',  // Status konfirmasi di-set menjadi 1
    //         'tanggal_konfirmasi' => date('Y-m-d H:i:s'),  // Tanggal konfirmasi adalah hari ini\
    //     ];

    //     // Update data pendaftaran
    //     if ($this->magangModel->update($id, $data)) {
    //         // Jika berhasil, redirect dengan pesan sukses
    //         return redirect()->to('/status-lamaran')->with('success', 'Pendaftaran berhasil dikonfirmasi.');
    //     } else {
    //         // Jika gagal, tampilkan pesan error
    //         return redirect()->back()->with('error', 'Terjadi kesalahan saat mengkonfirmasi pendaftaran.');
    //     }
 
    // }

    public function statusLamaran()
    {
        $userId = session()->get('user_id'); // Ambil ID pengguna dari session

        // Ambil data profil pengguna
         $data['user_data'] = $this->userModel
            ->join('instansi', 'instansi.id = users.instansi_id','left')
            ->join('jurusan', 'jurusan.id = users.jurusan','left')
            ->select('users.*, instansi.nama_instansi, jurusan.nama_jurusan')
            ->where('users.id', $userId)
            ->first();

        // Ambil data pendaftaran terkait pengguna
        $data['pendaftaran'] = $this->magangModel->where('user_id', $userId)
                                                ->join('unit_kerja','unit_kerja.id = magang.unit_id')
                                                ->select('magang.id as magang_id, magang.*, unit_kerja.*')
                                                ->first();

        // Muat tampilan profil
        $db = \Config\Database::connect();
        $today = date('Y-m-d');
//  dd($data);
        // Ambil periode aktif
        $periode = $db->table('periode_magang')
            ->where('tanggal_buka <=', $today) // sudah dibuka
            ->orderBy('tanggal_buka', 'DESC')  // paling baru
            ->limit(1)
            ->get()
            ->getRow();

            return view('user/status-lamaran', [
            'periode' => $periode,
            'pendaftaran' => $data['pendaftaran'],
            'user_data' => $data['user_data'], 
            
        ]);
    }

public function pelaksanaan()
    {
        $userId = session()->get('user_id'); // Ambil ID pengguna dari session

        // Ambil data profil pengguna
         $data['user_data'] = $this->userModel
            ->join('instansi', 'instansi.id = users.instansi_id','left')
            ->join('jurusan', 'jurusan.id = users.jurusan','left')
            ->select('users.*, instansi.nama_instansi, jurusan.nama_jurusan')
            ->where('users.id', $userId)
            ->first();

            return view('user/pelaksanaan', [
            'user_data' => $data['user_data'], 
            
        ]);
    }
   

}
