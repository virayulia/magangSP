<?php

namespace App\Controllers\Pembimbing;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MagangModel;
use App\Models\UserModel;
use App\Models\PenilaianModel;

class MagangController extends BaseController
{
    protected $magangModel;
    protected $userModel;
    protected $penilaianModel;

    public function __construct()
    {
        $this->magangModel = new MagangModel();
        $this->userModel = new UserModel();
        $this->penilaianModel = new PenilaianModel();
    }

    public function penilaian()
    {   
        $db = \Config\Database::connect();

        // Ambil semua unit yang dipegang oleh pembimbing yang login
        $userId = user_id();
        $unitPembimbing = $db->table('unit_user')
            ->select('unit_id')
            ->where('user_id', $userId)
            ->get()
            ->getResultArray();

        $unitIds = array_column($unitPembimbing, 'unit_id');

        // Jika tidak ada unit, tampilkan kosong
        if (empty($unitIds)) {
            return view('pembimbing/penilaian', ['peserta' => []]);
        }

        // Ambil peserta magang dari semua unit tersebut
        $builder = $db->table('magang')
            ->select('magang.*, users.fullname, users.nisn_nim, instansi.nama_instansi, penilaian.*')
            ->join('users', 'users.id = magang.user_id')
            ->join('instansi', 'instansi.instansi_id = users.instansi_id')
            ->join('penilaian', 'penilaian.magang_id = magang.magang_id', 'left')
            ->whereIn('magang.unit_id', $unitIds);

        $peserta = $builder->get()->getResultArray();

        return view('pembimbing/penilaian', ['peserta' => $peserta]);
    }


    public function save()
    {
        $data = [
            'magang_id' => $this->request->getPost('magang_id'),
            'pembimbing_id' => user_id(),
            'nilai_disiplin' => $this->request->getPost('disiplin'),
            'nilai_kerajinan' => $this->request->getPost('kerajinan'),
            'nilai_tingkahlaku' => $this->request->getPost('tingkahlaku'),
            'nilai_kerjasama' => $this->request->getPost('kerjasama'),
            'nilai_kreativitas' => $this->request->getPost('kreativitas'),
            'nilai_kemampuankerja' => $this->request->getPost('kemampuankerja'),
            'nilai_tanggungjawab' => $this->request->getPost('tanggungjawab'),
            'nilai_penyerapan' => $this->request->getPost('penyerapan'),
            'catatan' => $this->request->getPost('catatan'),
        ];

        // Jika sudah ada nilai sebelumnya, update
        $penilaian = $this->penilaianModel
            ->where('magang_id', $data['magang_id'])
            ->first();

        if ($penilaian) {
            $this->penilaianModel->update($penilaian['penilaian_id'], $data);
        } else {
            $data['tgl_penilaian'] = date('Y-m-d H:i:s');
            $this->penilaianModel->insert($data);
        }

        return redirect()->back()->with('success', 'Penilaian berhasil disimpan.');
    }

    public function approve()
    {
        $db = \Config\Database::connect();

        // Ambil semua unit yang dipegang oleh pembimbing yang login
        $userId = user_id();
        $unitPembimbing = $db->table('unit_user')
            ->select('unit_id')
            ->where('user_id', $userId)
            ->get()
            ->getResultArray();

        $unitIds = array_column($unitPembimbing, 'unit_id');

        // Jika tidak ada unit, tampilkan kosong
        if (empty($unitIds)) {
            return view('pembimbing/approve_nilai', ['peserta' => []]);
        }

        // Ambil peserta magang dari semua unit tersebut yang sudah dinilai, tapi belum approve
        $builder = $db->table('magang')
            ->select('magang.*, users.fullname, users.nisn_nim, instansi.nama_instansi, penilaian.*')
            ->join('users', 'users.id = magang.user_id')
            ->join('instansi', 'instansi.instansi_id = users.instansi_id')
            ->join('penilaian', 'penilaian.magang_id = magang.magang_id')
            ->whereIn('magang.unit_id', $unitIds)
            ->where('penilaian.approve_kaunit !=', 1); // Belum di-approve

        $peserta = $builder->get()->getResultArray();

        return view('pembimbing/approve', ['peserta' => $peserta]);
    }

    public function saveApprove()
    {
        $db = \Config\Database::connect();
        $magangId = $this->request->getPost('magang_id');
        $userId = user_id();

        // Update status approve di tabel penilaian
        $db->table('penilaian')
        ->where('magang_id', $magangId)
        ->update([
            'approve_kaunit'    => 1,
            'tgl_disetujui' => date('Y-m-d H:i:s'),
            'approve_by' => $userId
        ]);

        return redirect()->back()->with('success', 'Penilaian berhasil disetujui.');
    }


}
