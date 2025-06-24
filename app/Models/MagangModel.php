<?php

namespace App\Models;

use CodeIgniter\Model;

class MagangModel extends Model
{
    protected $table            = 'magang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['unit_id','user_id','durasi','tanggal_pengajuan','status_seleksi','tanggal_seleksi', 'validasi_berkas',
                                    'tgl_validasi_berkas','cttn_validasi_berkas','konfirmasi_pendaftar','tanggal_konfirmasi',
                                    'berkas_lengkap','tgl_berkas_lengkap','pembimbing_id','tanggal_masuk','tanggal_selesai',
                                    'status','created_at'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getSisaKuota()
    {
        $builder = $this->db->query("
            SELECT 
                ku.unit_id,
                uk.unit_kerja,
                ku.tingkat_pendidikan,
                ku.kuota,

                -- Jumlah yang diterima/magang
                IFNULL(jumlah_diterima.jumlah, 0) AS jumlah_diterima_atau_magang,

                -- Jumlah pendaftar
                IFNULL(jumlah_pendaftar.jumlah, 0) AS jumlah_pendaftar,

                -- Sisa kuota = kuota - diterima/magang
                (ku.kuota - IFNULL(jumlah_diterima.jumlah, 0)) AS sisa_kuota

            FROM 
                kuota_unit ku
            JOIN 
                unit_kerja uk ON ku.unit_id = uk.id

            -- Subquery untuk jumlah diterima/magang
            LEFT JOIN (
                SELECT 
                    mg.unit_id,
                    CASE
                        WHEN LOWER(u.pendidikan) = 'sma/smk' THEN 'sma/smk'
                        WHEN LOWER(u.pendidikan) IN ('d3', 'd4/s1', 's2') THEN 'kuliah'
                    END AS tingkat_pendidikan,
                    COUNT(*) AS jumlah
                FROM magang mg
                JOIN users u ON mg.user_id = u.id
                WHERE mg.status IN ('diterima', 'magang','berkas valid','konfirmasi')
                GROUP BY mg.unit_id, tingkat_pendidikan
            ) AS jumlah_diterima ON jumlah_diterima.unit_id = ku.unit_id 
                                AND jumlah_diterima.tingkat_pendidikan = LOWER(ku.tingkat_pendidikan)

            -- Subquery untuk jumlah pendaftar
            LEFT JOIN (
                SELECT 
                    mg.unit_id,
                    CASE
                        WHEN LOWER(u.pendidikan) = 'sma/smk' THEN 'sma/smk'
                        WHEN LOWER(u.pendidikan) IN ('d3', 'd4/s1', 's2') THEN 'kuliah'
                    END AS tingkat_pendidikan,
                    COUNT(*) AS jumlah
                FROM magang mg
                JOIN users u ON mg.user_id = u.id
                WHERE mg.status = 'pendaftar'
                GROUP BY mg.unit_id, tingkat_pendidikan
            ) AS jumlah_pendaftar ON jumlah_pendaftar.unit_id = ku.unit_id 
                                AND jumlah_pendaftar.tingkat_pendidikan = LOWER(ku.tingkat_pendidikan)

            ORDER BY uk.unit_kerja, ku.tingkat_pendidikan;

        ");
        return $builder->getResult();
    }

    public function getSisaKuotaPerUnit($unitId, $pendidikan)
    {
        foreach ($this->getSisaKuota() as $k) {
            if ($k->unit_id == $unitId && strtolower($k->tingkat_pendidikan) == strtolower($pendidikan)) {
                return $k->sisa_kuota;
            }
        }
        return 0;
    }
}
