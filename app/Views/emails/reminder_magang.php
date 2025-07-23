<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pengingat Magang</title>
</head>
<body>
    <p>Yth. Kepala Unit <?= esc($unit); ?>,</p>

    <p>Ini adalah pengingat bahwa peserta magang akan masuk pada tanggal <strong><?= esc(format_tanggal_indonesia($tanggalMasuk)); ?></strong>.</p>

    <p>Berikut detail peserta:</p>
    <ul>
        <li>Nama: <?= esc($nama); ?></li>
        <li>Instansi: <?= esc($instansi); ?></li>
    </ul>

    <p>Terima kasih atas perhatian dan kerjasamanya.</p>

    <p>Salam, <p><strong>Admin Rekrutmen Magang<br>PT Semen Padang</strong></p>
</body>
</html>
