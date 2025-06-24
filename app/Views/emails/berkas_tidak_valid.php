<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Validasi Berkas Magang</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <p>Yth. <?= esc($nama); ?>,</p>

    <p>Dengan hormat,</p>

    <p>Bersama ini kami sampaikan bahwa berkas pendaftaran magang Anda <strong>belum memenuhi kelengkapan atau validitas yang disyaratkan</strong>.</p>

    <p><strong>Catatan dari tim validasi:</strong><br>
    <?= nl2br(esc($catatan)); ?></p>

    <p>Mohon untuk segera melakukan perbaikan dan melengkapi berkas Anda agar dapat melanjutkan proses pendaftaran. Jika ada pertanyaan lebih lanjut, silakan hubungi kami melalui kontak yang tersedia.</p>

    <br>
    <p>Terima kasih atas perhatian dan kerja samanya.</p>

    <p>Hormat kami,</p>
    <p><strong>Tim Rekrutmen Magang<br>PT Semen Padang</strong></p>
</body>
</html>
