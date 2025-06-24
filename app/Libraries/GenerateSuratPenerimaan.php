<?php

namespace App\Libraries;

use TCPDF;

class GenerateSuratPenerimaan extends TCPDF
{
    public function generate($user_data, $pendaftaran)
    {
        // Buat objek TCPDF
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nama Perusahaan');
        $pdf->SetTitle('Surat Penerimaan Magang');
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->AddPage();

         // ISI PDF KAMU
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->Write(0, 'Ini contoh surat penerimaan magang.');

        // Tambahkan header PDF
        header('Content-Type: application/pdf');

        // Logo Kiri dan Kanan
        $logoKiri = FCPATH . 'public/img/SIG_logo.svg'; // Pastikan file ada
        $logoKanan = FCPATH . 'public/img/SP_logo.png'; // Misal sama

        $pdf->Image($logoKiri, 10, 10, 30);
        $pdf->Image($logoKanan, 170, 10, 30);

        // Spasi di bawah logo
        $pdf->Ln(20);

        // Tulis judul
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'SURAT PENERIMAAN MAGANG', 0, 1, 'C');
        $pdf->Ln(10);

        // Tulis isi surat
        $tanggal_mulai = date('d M Y', strtotime($pendaftaran['tanggal_mulai']));
        $tanggal_selesai = date('d M Y', strtotime("+{$pendaftaran['lama_pelaksanaan']} days", strtotime($pendaftaran['tanggal_mulai'])));
        $tanggal_lapor = date('d M Y', strtotime("-3 days", strtotime($pendaftaran['tanggal_mulai'])));

        $html = '
        <p>Nomor: --<br>
        Hal: Penerimaan Mahasiswa Kerja Praktek<br>
        Lamp: -</p>

        <p>Kepada Yth.<br>
        Dekan '.$user_data->fakultas.'<br>
        '.$user_data->universitas.'</p>

        <p>Dengan hormat,<br>
        Sehubungan dengan surat permohonan Bapak, diberitahukan bahwa kami dapat menerima mahasiswa Bapak tersebut untuk kerja praktek di perusahaan kami:</p>

        <p>Nama: '.$user_data->fullname.'<br>
        NIM: '.$user_data->nim.'<br>
        Jurusan/Universitas: '.$user_data->jurusan.' / '.$user_data->universitas.'</p>

        <p>Kerja praktek akan dilaksanakan dari <b>'.$tanggal_mulai.'</b> s/d <b>'.$tanggal_selesai.'</b>.</p>

        <p>Persyaratan:</p>
        <ol>
            <li>Melapor paling lambat <b>'.$tanggal_lapor.'</b>.</li>
            <li>Hadir tanggal '.$tanggal_mulai.' pukul 08.00 WIB.</li>
            <li>Mematuhi semua ketentuan perusahaan.</li>
            <li>Melengkapi perlengkapan safety.</li>
            <li>Menyerahkan asuransi kecelakaan.</li>
        </ol>

        <p>Demikian disampaikan, terima kasih.</p>

        <br><br><br>

        <p>Hormat Kami,<br><br><br>
        <b>Training & KM</b><br>
        Ika Nopikasari<br>
        Kepala</p>
        ';

        // Tulis HTML ke PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output PDF ke browser
        $pdf->Output('Surat_Penerimaan.pdf', 'D'); // 'I' = Inline (langsung buka di browser)
    }
}
