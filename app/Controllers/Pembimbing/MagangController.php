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
            ->select('magang.magang_id, magang.tanggal_masuk, magang.tanggal_selesai,
                    users.fullname, users.nisn_nim, instansi.nama_instansi, 
                    penilaian.penilaian_id, penilaian.nilai_disiplin, penilaian.nilai_kerajinan, penilaian.nilai_tingkahlaku,
                    penilaian.nilai_kerjasama, penilaian.nilai_kreativitas, penilaian.nilai_kemampuankerja, 
                    penilaian.nilai_tanggungjawab, penilaian.nilai_penyerapan, penilaian.catatan, penilaian.tgl_penilaian,
                    penilaian.approve_kaunit, penilaian.tgl_disetujui, penilaian.approve_by')
            ->join('users', 'users.id = magang.user_id')
            ->join('instansi', 'instansi.instansi_id = users.instansi_id')
            ->join('penilaian', 'penilaian.magang_id = magang.magang_id', 'left')
            ->whereIn('magang.unit_id', $unitIds);

        $peserta = $builder->get()->getResultArray();

        return view('pembimbing/penilaian', ['peserta' => $peserta]);
    }


    public function save()
    {
        helper(['form']);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'magang_id'        => 'required|is_natural_no_zero',
            'disiplin'         => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[100]',
            'kerajinan'        => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[100]',
            'tingkahlaku'      => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[100]',
            'kerjasama'        => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[100]',
            'kreativitas'      => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[100]',
            'kemampuankerja'   => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[100]',
            'tanggungjawab'    => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[100]',
            'penyerapan'       => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[100]',
            'catatan'          => 'permit_empty|string|max_length[1000]'
        ]);

        // Jalankan validasi
        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->with('error', implode('<br>', $validation->getErrors()))
                ->withInput();
        }

        // Pastikan pembimbing login
        $pembimbingId = user_id();
        if (! $pembimbingId) {
            return redirect()->back()->with('error', 'Anda belum login sebagai pembimbing.');
        }

        // Ambil data dari form
        $data = [
            'magang_id'            => (int) $this->request->getPost('magang_id'),
            'pembimbing_id'        => $pembimbingId,
            'nilai_disiplin'       => (int) $this->request->getPost('disiplin'),
            'nilai_kerajinan'      => (int) $this->request->getPost('kerajinan'),
            'nilai_tingkahlaku'    => (int) $this->request->getPost('tingkahlaku'),
            'nilai_kerjasama'      => (int) $this->request->getPost('kerjasama'),
            'nilai_kreativitas'    => (int) $this->request->getPost('kreativitas'),
            'nilai_kemampuankerja' => (int) $this->request->getPost('kemampuankerja'),
            'nilai_tanggungjawab'  => (int) $this->request->getPost('tanggungjawab'),
            'nilai_penyerapan'     => (int) $this->request->getPost('penyerapan'),
            'catatan'              => $this->request->getPost('catatan'),
        ];

        $db = \Config\Database::connect();
        $db->transStart();

        // Cek apakah sudah ada penilaian untuk magang ini
        $penilaian = $this->penilaianModel
            ->where('magang_id', $data['magang_id'])
            ->first();

        if ($penilaian) {
            // Update penilaian
            $this->penilaianModel->update($penilaian['penilaian_id'], $data);
        } else {
            // Insert penilaian baru
            $data['tgl_penilaian'] = date('Y-m-d H:i:s');
            $this->penilaianModel->insert($data);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan penilaian.');
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
