<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MagangModel;
use Myth\Auth\Models\UserModel;


class Magang extends BaseController
{
    protected $magangModel;
    protected $userModel;


    public function __construct()
    {
        // Inisialisasi model
        $this->userModel = new UserModel();
        $this->magangModel = new MagangModel();

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

        // Cek apakah user sudah pernah daftar magang di unit manapun dan statusnya belum ditolak
        $existing = $this->magangModel
            ->where('user_id', $userId)
            ->whereIn('status', ['pendaftaran', 'magang', 'diterima']) // status belum ditolak
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Kamu sudah mendaftar magang. Tidak bisa daftar lagi.');
        }

        // Simpan pendaftaran baru
        $this->magangModel->insert([
            'user_id' => $userId,
            'unit_id' => $unitId,
            'durasi' => $durasi,
            'status' => 'pendaftaran',
            'tanggal_pengajuan' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/lowongan')->with('success', 'Pendaftaran berhasil dikirim.');
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
            'konfirmasi_pendaftar' => 'Y',  // Status konfirmasi di-set menjadi 1
            'tanggal_konfirmasi' => date('Y-m-d H:i:s'),  // Tanggal konfirmasi adalah hari ini\
        ];

        // Update data pendaftaran
        if ($this->magangModel->update($id, $data)) {
            // Jika berhasil, redirect dengan pesan sukses
            return redirect()->to('/status-lamaran')->with('success', 'Pendaftaran berhasil dikonfirmasi.');
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
            'validasi_berkas'     => 'Y',
            'tgl_validasi_berkas' => date('Y-m-d H:i:s')
        ];

        // Jika sebelumnya dinyatakan TIDAK lengkap, reset ulang
        if ($pendaftaran['berkas_lengkap'] === 'N') {
            $data['berkas_lengkap']        = null;
            $data['tgl_berkas_lengkap']    = null;
            $data['cttn_validasi_berkas']  = null;
        }

        if ($this->magangModel->update($id, $data)) {
            return redirect()->to('/status-lamaran')->with('success', 'Validasi berhasil. Kami menghargai komitmen Anda dalam melengkapi dokumen dengan benar.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengkonfirmasi pendaftaran.');
        }
    }

    public function cetakTandaPengenal($id)
    {

        $magang = $this->magangModel->find($id);

        if (!$magang) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data magang tidak ditemukan.');
        }

        // Ambil data user berdasarkan user_id dari tabel magang
        $user = $this->userModel->join('instansi', 'instansi.id = users.instansi_id')
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




     



}
