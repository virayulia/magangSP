<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Magang</title>
    <style>
        body {
            font-family: 'times';
            margin: 0;
            padding: 0;
        }

        .container {
            padding-top: 80px; /* Naikkan untuk mengatur posisi vertikal seluruh isi */
            width: 80%;
            margin: 0 auto;
        }

        .judul {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 40px;
            text-align: center;
        }

        .nama {
            font-size: 14px;
            margin: 10px 0;
            text-align: left;
        }

        .konten {
            font-size: 16px;
            margin-top: 30px;
            text-align: center;
            font-style: italic;
        }
        .footer {
            margin-top: 100px;
            font-size: 14px;
            text-align: right;
            margin-right: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="judul">SERTIFIKAT</div>

        <div class="konten">Diberikan Kepada:</div>
        <div class="nama"><strong>NAMA:</strong> <?= esc($user->fullname ?? "Data tidak ada") ?></div>
        <div class="nama"><strong>No. NISN/BP:</strong> <?= esc($user->nisn_nim ?? "Data tidak ada") ?></div>
        <div class="nama"><strong>JURUSAN:</strong> <?= esc($user->jurusan ?? "Data tidak ada") ?></div>
        <div class="nama"><strong>PERGURUAN TINGGI:</strong> <?= esc($user->asal_sekolah ?? "Data tidak ada") ?></div>

        <div class="konten">
            Telah selesai melakukan Kerja Praktek di PT Semen Padang<br>
            dari tanggal <strong><?= date('d M Y', strtotime($magang['tanggal_masuk'])) ?></strong> s/d <strong><?= date('d M Y', strtotime($magang['tanggal_selesai'])) ?></strong><br>
            dengan hasil:<br><br><strong>BAIK SEKALI</strong>
        </div>

        <div class="footer">
            Padang, <br><br><br>
            Pembimbing Magang<br><br><br>
            ( ................................................... )
        </div>
    </div>
</body>
</html>
