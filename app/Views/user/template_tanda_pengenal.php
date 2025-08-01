<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ID Card Magang</title>
    <link rel="shortcut icon" href="<?= base_url('assets/img/SP_logo.png'); ?>" type="image/png">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #eaeaea;
            display: block;
            height: auto;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }

        .card {
            width: 5.4cm;
            height: 8.6cm;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            position: relative;
            background: linear-gradient(160deg, #ffffff 0%, #dfe3e8 100%);
            color: #222;
            text-align: center;
        }

        .card::after {
            content: "";
            position: absolute;
            top: 32px;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('<?= base_url("assets/img/SP_logo.png") ?>');
            background-size: 85%;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.05;
            z-index: 0;
        }

        .logo-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 10px;
            background: #fff;
            border-bottom: 1px solid #ccc;
            position: relative;
            z-index: 2;
        }

        .logo {
            width: 32px;
            height: auto;
        }

        .header,
        .foto,
        .info,
        .footer {
            position: relative;
            z-index: 1;
        }

        .header {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 6px 0;
            line-height: 1.3;
            color: #e30613;
            padding-top: 8px;
        }

        .foto {
            width: 75px;
            height: 75px;
            object-fit: cover;
            border-radius: 6px;
            border: 2px solid #e30613;
            margin: 10px auto 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .info {
            font-size: 9.5px;
            padding: 0 15px;
            text-align: center;
        }

        .info p {
            margin: 5px 0;
            line-height: 1.3;
        }

        .info b {
            display: inline-block;
            width: 60px;
            color: #444;
        }

        .footer {
            position: absolute;
            bottom: 6px;
            width: 100%;
            font-size: 8.5px;
            color: #666;
        }

        @media print {
            body {
                background: none;
                margin: 0;
                padding: 0;
            }

            .card {
                box-shadow: none;
                margin: 0;
                page-break-after: always;
            }
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="logo-container">
            <img src="<?= base_url('assets/img/SP_logo.png') ?>" alt="SP Logo" class="logo">
            <img src="<?= base_url('assets/img/sig_logo.png') ?>" alt="SIG Logo" class="logo">
        </div>

        <div class="header">TANDA PENGENAL<br>PKL / PENELITIAN</div>

        <img src="<?= base_url('/uploads/user-image/' . $user->user_image) ?>" alt="Foto" class="foto">

        <!-- <div class="info">
            <p><b>Nama</b>: <?= esc($user->fullname) ?></p>
            <p><b>NIM/NISN</b>: <?= esc($user->nisn_nim) ?></p>
            <p><b>Instansi</b>: <?= esc($user->nama_instansi) ?></p>
            <p><b>Unit Kerja</b>: <?= esc($magang['unit_kerja']) ?></p>
            <p><b>Jadwal</b>: <?= format_tanggal_singkat($magang['tanggal_masuk']) ?> - <?= format_tanggal_singkat($magang['tanggal_selesai']) ?></p>
        </div> -->
        <div class="info">
            <p><?= esc($user->fullname) ?></p>
            <p><?= esc($user->nisn_nim) ?></p>
            <p><?= esc($user->nama_instansi) ?></p>
            <p><?= esc($magang['unit_kerja']) ?></p>
            <p><?= format_tanggal_singkat($magang['tanggal_masuk']) ?> - <?= format_tanggal_singkat($magang['tanggal_selesai']) ?></p>
        </div>

        <div class="footer">© PT. Semen Padang</div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
