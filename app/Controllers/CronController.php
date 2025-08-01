<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MagangModel;

class CronController extends BaseController
{
    public function remindUnit($token = null)
    {
        // Amankan dengan token
        if ($token !== 'semen123') {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Unauthorized']);
        }

        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        // Ambil pendaftar dengan tanggal masuk 7 hari lagi
        $targetDate = date('Y-m-d', strtotime('+7 days'));

        $pendaftar = $db->table('magang')
            ->select('magang.*, unit_kerja.email as email_unit, unit_kerja.unit_kerja')
            ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id', 'left')
            ->where('magang.tanggal_masuk', $targetDate)
            ->where('magang.status_akhir', 'proses')
            ->get()->getResult();

        $email = \Config\Services::email();
        $count = 0;

        foreach ($pendaftar as $data) {
            if (!$data->email_unit) continue;

            $email->clear();
            $email->setTo($data->email_unit);
            $email->setSubject('Pengingat Penerimaan Peserta Magang');
            $email->setMailType('html');

            $email->setMessage(view('emails/reminder_unit', [
                'unit' => $data->unit_kerja,
                'tanggal_masuk' => date('d F Y', strtotime($data->tanggal_masuk)),
            ]));

            if ($email->send()) $count++;
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => "$count email pengingat dikirim."
        ]);
    }

    public function autoTolakTidakKonfirmasi($token = null)
    {
        // Amankan dengan token
        if ($token !== 'semen123') {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Unauthorized']);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('magang');

        $today = date('Y-m-d');
        $expiredDate = date('Y-m-d', strtotime('-3 days'));

        $dataList = $builder
            ->select('magang.*, users.email, users.email_instansi, users.fullname, users.username, unit_kerja.unit_kerja')
            ->join('users', 'users.id = magang.user_id', 'left')
            ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id', 'left')
            ->where('magang.status_konfirmasi', NULL)
            ->where('magang.status_seleksi', 'Diterima')
            ->where('magang.tanggal_seleksi <=', $expiredDate)
            ->get()
            ->getResult();

        $successCount = 0;
        $failCount = 0;
        $messages = [];

        foreach ($dataList as $data) {
            $update = $builder->where('magang_id', $data->magang_id)->update([
                'status_seleksi'   => 'Ditolak',
                'status_akhir'     => 'gagal',
                'tanggal_seleksi'  => date('Y-m-d H:i:s')
            ]);

            if ($update) {
                $successCount++;

                // Kirim email penolakan
                $email = \Config\Services::email();
                $email->setTo($data->email);

                $email->setSubject('Konfirmasi Seleksi Magang Dibatalkan');
                $email->setMailType('html');
                $email->setMessage(view('emails/penolakan_tidak_konfirmasi', [
                    'nama' => $data->fullname ?? 'Saudara',
                    'unit' => $data->unit_kerja ?? 'Unit terkait',
                ]));

                if (!$email->send()) {
                    log_message('error', "Gagal kirim email ke {$data->email}: " . print_r($email->printDebugger(), true));
                }

            } else {
                $failCount++;
                $messages[] = "ID {$data->magang_id}: gagal update status.";
            }
        }

        return $this->response->setJSON([
            'status' => 'ok',
            'berhasil' => $successCount,
            'gagal' => $failCount,
            'pesan' => $messages
        ]);
    }

    public function autoTolakTidakValidasiBerkas($token = null)
    {
        // Amankan dengan token
        if ($token !== 'semen123') {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Unauthorized']);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('magang');

        $today = date('Y-m-d');
        $deadlineDate = date('Y-m-d', strtotime('-7 days'));

        $dataList = $builder
            ->select('magang.*, users.email, users.email_instansi, users.fullname, unit_kerja.unit_kerja')
            ->join('users', 'users.id = magang.user_id', 'left')
            ->join('unit_kerja', 'unit_kerja.unit_id = magang.unit_id', 'left')
            ->where('status_konfirmasi', 'Y')
            ->where('status_validasi_berkas IS NULL', null, false)
            ->where('tanggal_konfirmasi <=', $deadlineDate)
            ->get()
            ->getResult();

        $successCount = 0;
        $failCount = 0;
        $messages = [];

        foreach ($dataList as $data) {
            $update = $builder->where('magang_id', $data->magang_id)->update([
                'status_validasi_berkas'  => 'N',
                'tanggal_validasi_berkas' => date('Y-m-d'),
                'status_akhir'            => 'gagal',
            ]);

            if ($update) {
                $successCount++;

                // Kirim email pemberitahuan
                $email = \Config\Services::email();
                $email->setTo($data->email); // Hanya ke user
                $email->setSubject('Status Validasi Berkas Magang Dibatalkan');
                $email->setMailType('html');
                $email->setMessage(view('emails/penolakan_validasi_berkas', [
                    'nama' => $data->fullname ?? 'Saudara',
                    'unit' => $data->unit_kerja ?? 'Unit Terkait',
                    'tanggal_konfirmasi' => date('d F Y', strtotime($data->tanggal_konfirmasi))
                ]));

                if (!$email->send()) {
                    log_message('error', "Gagal kirim email ke {$data->email}: " . print_r($email->printDebugger(), true));
                }


            } else {
                $failCount++;
                $messages[] = "ID {$data->magang_id}: gagal update status validasi berkas.";
            }
        }

        return $this->response->setJSON([
            'status' => 'ok',
            'berhasil' => $successCount,
            'gagal' => $failCount,
            'pesan' => $messages
        ]);
    }



}
