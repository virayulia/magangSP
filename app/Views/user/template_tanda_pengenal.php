<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tanda Pengenal Magang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 9cm;
            height: 5cm;
            border: 2px solid #000;
            padding: 6px;
            box-sizing: border-box;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 4px;
        }

        .logo {
            width: 40px;
            height: auto;
            margin-right: 8px;
        }

        .judul {
            font-weight: bold;
            font-size: 24px;
            text-transform: uppercase;
            flex: 1;
            text-align: center;
        }

        .content {
            display: flex;
            align-items: flex-start;
        }

        .foto {
            width: 75px;
            height: 90px;
            object-fit: cover;
            border: 1px solid #000;
        }

        .data {
            font-size: 13px;
            margin-left: 10px;
        }

        .data p {
            margin: 2px 0;
            padding: 2px;
        }

        .data b {
            display: inline-block;
            width: 65px;
        }

    </style>
</head>
<body>
    <div class="header">
        <img src="<?= base_url('/assets/img/SP_logo.png') ?>" alt="Logo" class="logo">
        <div class="judul">TANDA PENGENAL PKL / PENELITIAN</div>
    </div>
<hr style="height: 3px; background-color: #000; border: none;">
    <div class="content">
        <img src="<?= base_url('/uploads/user_image/' . $user->user_image) ?>" alt="Foto" class="foto">

        <div class="data"> 
            <p><b>Nama</b>: <?= esc($user->fullname) ?></p>
            <p><b>NIM/NISN</b>: <?= esc($user->nisn_nim) ?></p>
            <p><b>Instansi</b>: <?= esc($user->nama_instansi) ?></p>
            <p><b>Jadwal</b>: <?= format_tanggal_singkat($magang['tanggal_masuk']) ?> - <?= format_tanggal_singkat($magang['tanggal_selesai']) ?></p>
        </div>
    </div>
</body>
<script>
    window.onload = function() {
        window.print();
    };
</script>
</html>
