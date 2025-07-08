<?php

namespace App\Controllers;
use App\Models\UnitKerjaModel;
use App\Models\MagangModel;
use App\Models\JurusanModel;

class Home extends BaseController
{
    protected $pendaftaranModel;
    protected $userModel;
    protected $instansiModel;
    protected $magangModel;
    protected $jurusanModel;
    protected $unitKerjaModel;

    public function __construct()
    {
        // Inisialisasi model
        $this->magangModel = new MagangModel();
        $this->jurusanModel = new JurusanModel();
        $this->unitKerjaModel = new UnitKerjaModel();

    }

    public function index(): string
    {
        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        // Ambil periode aktif
        $periode = $db->table('periode_magang')
            ->where('tanggal_buka <=', $today)
            ->where('tanggal_tutup >=', $today)
            ->orderBy('tanggal_buka', 'DESC')
            ->get()
            ->getRow();

        // Ambil filter dari GET
        $unitDipilih      = $this->request->getGet('unit_kerja') ?? [];
        $pendidikanDipilih = $this->request->getGet('pendidikan') ?? [];
        $jurusanDipilih   = $this->request->getGet('jurusan') ?? [];

        // Ambil data kuota (query dasar)
        $kuotaData = $this->magangModel->getSisaKuota();

        // Filter manual
        $filteredData = [];

        if (!empty($kuotaData)) {
            foreach ($kuotaData as $item) {
                $match = true;

                // Cek filter unit kerja
                if (!empty($unitDipilih) && !in_array($item->unit_kerja, $unitDipilih)) {
                    $match = false;
                }

                // Cek filter tingkat pendidikan
                if (!empty($pendidikanDipilih) && !in_array($item->tingkat_pendidikan, $pendidikanDipilih)) {
                    $match = false;
                }

                // Cek jurusan di jurusanMap
                $builder = $db->table('jurusan_unit')
                    ->select('jurusan.nama_jurusan')
                    ->join('jurusan', 'jurusan.jurusan_id = jurusan_unit.jurusan_id')
                    ->where('jurusan_unit.kuota_unit_id', $item->unit_id)
                    ->get();

                $jurusanList = array_map(fn($row) => $row->nama_jurusan, $builder->getResult());

                if (!empty($jurusanDipilih)) {
                    // Kalau jurusan tidak ada yang match, skip
                    if (empty(array_intersect($jurusanDipilih, $jurusanList))) {
                        $match = false;
                    }
                }

                if ($match) {
                    // Tambahkan jurusan ke item
                    $item->jurusan = implode(', ', $jurusanList) ?: null;
                    $filteredData[] = $item;
                }
            }
        }

        // Data unit kerja & jurusan untuk select filter
        $list_unitKerja = $this->unitKerjaModel->findAll();
        $jurusan        = $this->jurusanModel->findAll();

        $isProfilComplite = $this->isProfilComplite();

        return view('index', [
            'periode'          => $periode,
            'data_unit'        => $filteredData,
            'isProfilComplite' => $isProfilComplite,
            'list_unit_kerja'  => $list_unitKerja,
            'list_jurusan'     => $jurusan,
            'unitDipilih'      => $unitDipilih,
            'pendidikanDipilih'=> $pendidikanDipilih,
            'jurusanDipilih'   => $jurusanDipilih,
        ]);
    }
    public function tentang_kami(): string
    {
        return view('tentang_kami');
    }
    public function login(): string
    {
        return view('auth/login');
    }
    public function register(): string
    {
        return view('auth/register');
    }

   public function lowongan(): string
    {
        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        // Ambil periode aktif
        $periode = $db->table('periode_magang')
            ->where('tanggal_buka <=', $today)
            ->where('tanggal_tutup >=', $today)
            ->orderBy('tanggal_buka', 'DESC')
            ->get()
            ->getRow();

        // Ambil filter dari GET
        $unitDipilih      = $this->request->getGet('unit_kerja') ?? [];
        $pendidikanDipilih = $this->request->getGet('pendidikan') ?? [];
        $jurusanDipilih   = $this->request->getGet('jurusan') ?? [];

        // Ambil data kuota (query dasar)
        $kuotaData = $this->magangModel->getSisaKuota();

        // Filter manual
        $filteredData = [];

        if (!empty($kuotaData)) {
            foreach ($kuotaData as $item) {
                $match = true;

                // Cek filter unit kerja
                if (!empty($unitDipilih) && !in_array($item->unit_kerja, $unitDipilih)) {
                    $match = false;
                }

                // Cek filter tingkat pendidikan
                if (!empty($pendidikanDipilih) && !in_array($item->tingkat_pendidikan, $pendidikanDipilih)) {
                    $match = false;
                }

                // Cek jurusan di jurusanMap
                $builder = $db->table('jurusan_unit')
                    ->select('jurusan.nama_jurusan')
                    ->join('jurusan', 'jurusan.jurusan_id = jurusan_unit.jurusan_id')
                    ->where('jurusan_unit.kuota_unit_id', $item->unit_id)
                    ->get();

                $jurusanList = array_map(fn($row) => $row->nama_jurusan, $builder->getResult());

                if (!empty($jurusanDipilih)) {
                    // Kalau jurusan tidak ada yang match, skip
                    if (empty(array_intersect($jurusanDipilih, $jurusanList))) {
                        $match = false;
                    }
                }

                if ($match) {
                    // Tambahkan jurusan ke item
                    $item->jurusan = implode(', ', $jurusanList) ?: null;
                    $filteredData[] = $item;
                }
            }
        }

        // Data unit kerja & jurusan untuk select filter
        $list_unitKerja = $this->unitKerjaModel->findAll();
        $jurusan        = $this->jurusanModel->findAll();

        $isProfilComplite = $this->isProfilComplite();

        return view('lowongan', [
            'periode'          => $periode,
            'data_unit'        => $filteredData,
            'isProfilComplite' => $isProfilComplite,
            'list_unit_kerja'  => $list_unitKerja,
            'list_jurusan'     => $jurusan,
            'unitDipilih'      => $unitDipilih,
            'pendidikanDipilih'=> $pendidikanDipilih,
            'jurusanDipilih'   => $jurusanDipilih,
        ]);
    }


    private function isProfilComplite(): bool
    {
        $userId = user_id();
        $db = \Config\Database::connect();

        $user = $db->table('users')->where('id', $userId)->get()->getRow();

        // Cek kelengkapan field, sesuaikan dengan field pada tabel kamu
        if (!$user) return false;

        $requiredFields = ['fullname', 'alamat', 'nisn_nim','no_hp', 'cv', 'surat_permohonan','tingkat_pendidikan','jurusan_id','instansi_id']; // Tambahkan sesuai kebutuhan
        if ($user->tingkat_pendidikan !== 'SMA/SMK') {
            $requiredFields[] = 'proposal';
        }

        foreach ($requiredFields as $field) {
            if (empty($user->$field)) {
                return false;
            }
        }

        return true;
    }
}
