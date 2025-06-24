<?php

namespace App\Controllers;
use App\Models\UnitKerjaModel;
use App\Models\MagangModel;
use App\Models\JurusanModel;

class Landingpage extends BaseController
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

        // Ambil data kuota dan jurusan per unit kerja yang masih memiliki sisa kuota
        $kuotaQuery = $db->query("
            SELECT 
                kuota_unit.id AS kuota_id,
                unit_kerja.unit_kerja,
                kuota_unit.tingkat_pendidikan,
                kuota_unit.kuota,
                (kuota_unit.kuota - COUNT(magang.id)) AS tersedia,
                unit_kerja.id
            FROM kuota_unit
            JOIN unit_kerja ON kuota_unit.unit_id = unit_kerja.id
            LEFT JOIN magang ON magang.unit_id = kuota_unit.unit_id 
                AND magang.tanggal_selesai > CURDATE()
                AND EXISTS (
                    SELECT 1 FROM users 
                    WHERE users.id = magang.user_id 
                    AND users.pendidikan = kuota_unit.tingkat_pendidikan
                )
            GROUP BY kuota_unit.id, unit_kerja.unit_kerja, kuota_unit.tingkat_pendidikan, kuota_unit.kuota
            HAVING tersedia > 0
            ORDER BY unit_kerja.unit_kerja ASC
        ");

        $kuotaData = $kuotaQuery->getResultArray();

        // Ambil jurusan per kuota_unit.id (pakai mapping)
        $kuotaIds = array_column($kuotaData, 'kuota_id');

        $jurusanMap = [];
        if (!empty($kuotaIds)) {
            $builder = $db->table('jurusan_unit')
                ->select('jurusan_unit.kuota_unit_id, jurusan.nama_jurusan')
                ->join('jurusan', 'jurusan.id = jurusan_unit.jurusan_id')
                ->whereIn('jurusan_unit.kuota_unit_id', $kuotaIds)
                ->get();

            foreach ($builder->getResult() as $row) {
                $jurusanMap[$row->kuota_unit_id][] = $row->nama_jurusan;
            }
        }

        // Gabungkan jurusan ke dalam data unit
        $units = [];
        foreach ($kuotaData as $unit) {
            $unit['jurusan'] = isset($jurusanMap[$unit['kuota_id']]) ? implode(', ', $jurusanMap[$unit['kuota_id']]) : null;
            $units[] = $unit;
        }

        $isProfilComplite = $this->isProfilComplite();

        return view('index', [
            'periode' => $periode,
            'data_unit' => $units,
            'isProfilComplite' => $isProfilComplite
        ]);
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

        // Ambil data kuota dan jurusan per unit kerja yang masih memiliki sisa kuota
        $kuotaQuery = $db->query("
            SELECT 
                kuota_unit.id AS kuota_id,
                unit_kerja.unit_kerja,
                kuota_unit.tingkat_pendidikan,
                kuota_unit.kuota,
                (kuota_unit.kuota - COUNT(magang.id)) AS tersedia,
                unit_kerja.id
            FROM kuota_unit
            JOIN unit_kerja ON kuota_unit.unit_id = unit_kerja.id
            LEFT JOIN magang ON magang.unit_id = kuota_unit.unit_id 
                AND magang.tanggal_selesai > CURDATE()
                AND EXISTS (
                    SELECT 1 FROM users 
                    WHERE users.id = magang.user_id 
                    AND users.pendidikan = kuota_unit.tingkat_pendidikan
                )
            GROUP BY kuota_unit.id, unit_kerja.unit_kerja, kuota_unit.tingkat_pendidikan, kuota_unit.kuota
            HAVING tersedia > 0
            ORDER BY unit_kerja.unit_kerja ASC
        ");

        $kuotaData = $kuotaQuery->getResultArray();

        // Ambil jurusan per kuota_unit.id (pakai mapping)
        $kuotaIds = array_column($kuotaData, 'kuota_id');

        $jurusanMap = [];
        if (!empty($kuotaIds)) {
            $builder = $db->table('jurusan_unit')
                ->select('jurusan_unit.kuota_unit_id, jurusan.nama_jurusan')
                ->join('jurusan', 'jurusan.id = jurusan_unit.jurusan_id')
                ->whereIn('jurusan_unit.kuota_unit_id', $kuotaIds)
                ->get();

            foreach ($builder->getResult() as $row) {
                $jurusanMap[$row->kuota_unit_id][] = $row->nama_jurusan;
            }
        }

        // Gabungkan jurusan ke dalam data unit
        $units = [];
        foreach ($kuotaData as $unit) {
            $unit['jurusan'] = isset($jurusanMap[$unit['kuota_id']]) ? implode(', ', $jurusanMap[$unit['kuota_id']]) : null;
            $units[] = $unit;
        }

        $isProfilComplite = $this->isProfilComplite();

        $list_unitKerja = $this->unitKerjaModel->findAll();
        $jurusan = $this->jurusanModel->findAll();

        return view('lowongan', [
            'periode' => $periode,
            'data_unit' => $units,
            'isProfilComplite' => $isProfilComplite,
            'list_unit_kerja' => $list_unitKerja,
            'list_jurusan'   => $jurusan

        ]);
    }

    private function isProfilComplite(): bool
    {
        $userId = user_id();
        $db = \Config\Database::connect();

        $user = $db->table('users')->where('id', $userId)->get()->getRow();

        // Cek kelengkapan field, sesuaikan dengan field pada tabel kamu
        if (!$user) return false;

        $requiredFields = ['fullname', 'alamat', 'nisn_nim','no_hp', 'cv', 'surat_permohonan','pendidikan','jurusan','instansi_id']; // Tambahkan sesuai kebutuhan
        if ($user->pendidikan !== 'SMA/SMK') {
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
