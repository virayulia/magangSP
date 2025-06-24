<?= $this->extend('user/template'); ?>
<?= $this->section('main-content'); ?>
<style>
    .timeline-step {
  position: relative;
  padding-left: 25px;
}

.timeline-step::before {
  content: '';
  position: absolute;
  top: 0;
  left: 8px;
  width: 2px;
  height: 100%;
  background-color: #dee2e6;
}

</style>
<?php if (session()->getFlashdata('success')): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Sukses',
    text: '<?= session()->getFlashdata('success') ?>',
    timer: 2000,
    showConfirmButton: false
});
</script>
<?php elseif (session()->getFlashdata('error')): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '<?= session()->getFlashdata('error') ?>'
});
</script>
<?php endif; ?>
<!-- Tabs Lamaran (New Age Bootstrap style) -->
<div class="profile-card">
<ul class="nav nav-tabs profile-tabs mb-4" id="lamaranTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="status-lamaran-tab" data-bs-toggle="tab" data-bs-target="#status-lamaran" type="button" role="tab">
            Status Lamaran
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="histori-lamaran-tab" data-bs-toggle="tab" data-bs-target="#histori-lamaran" type="button" role="tab">
            Histori Lamaran
        </button>
    </li>
</ul>

<div class="tab-content" id="lamaranTabContent">
    <!-- Status Lamaran Tab -->
    <div class="tab-pane fade show active" id="status-lamaran" role="tabpanel">
    <p class="text-muted">Pantau perkembangan lamaran magang kamu di sini.</p>
    <hr>

    <?php if (empty($pendaftaran)) : ?>
        <div class="alert alert-info text-center">
            Belum ada lamaran.
        </div>
    <?php else : ?>
        <!-- Progress Bar Pendaftaran -->
<!-- Progress Bar Pendaftaran -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title mb-4">Progress Pendaftaran Magang</h5>

        <?php

       $step = 1;

        if (!empty($pendaftaran['berkas_lengkap'])&& !empty($pendaftaran['tgl_berkas_lengkap'])){
            $step = 6;
        }
        elseif (!empty($pendaftaran['validasi_berkas']) && !empty($pendaftaran['tgl_validasi_berkas'])){
            $step = 5;
        }
        elseif (!empty($pendaftaran['konfirmasi_pendaftar']) && !empty($pendaftaran['tanggal_konfirmasi'])) {
            $step = 4;
        } elseif (!empty($pendaftaran['tanggal_seleksi']) && !empty($pendaftaran['status'])) {
            $step = 3;
        } elseif (!empty($pendaftaran['tanggal_pengajuan'])) {
            $step = 2;
        } else {
            $step = 1;
        }


       
        ?>

        <style>
            .timeline-vertical {
                position: relative;
                padding-left: 30px;
                border-left: 3px solid #dee2e6;
            }

            .timeline-vertical .timeline-step {
                position: relative;
                margin-bottom: 40px;
            }

            .timeline-vertical .timeline-step:last-child {
                margin-bottom: 0;
            }

            .timeline-vertical .circle {
                position: absolute;
                left: -14px;
                top: 0;
                width: 20px;
                height: 20px;
                border-radius: 50%;
                background-color: #dee2e6;
                border: 3px solid white;
                z-index: 1;
            }

            .timeline-vertical .circle.active {
                background-color: #0d6efd;
            }

            .timeline-vertical .circle.completed {
                background-color: #198754;
            }

            .timeline-vertical .timeline-content {
                margin-left: 20px;
            }

            .timeline-vertical h6 {
                margin-bottom: 4px;
                font-weight: 600;
            }

            .timeline-vertical small {
                font-size: 0.85rem;
                color: #6c757d;
            }

            /* Card pemberitahuan */
            .info-card {
                margin-top: -30px;
                margin-bottom: 30px;
                padding: 15px 20px;
                border-left: 5px solid #0d6efd;
                background-color: #e7f1ff;
                color: #0d6efd;
                border-radius: 4px;
                font-weight: 500;
            }

            .info-card.error {
                border-left-color: #dc3545;
                background-color: #f8d7da;
                color: #842029;
            }

            .info-card.success {
                border-left-color: #198754;
                background-color: #d1e7dd;
                color: #0f5132;
            }
        </style>

        <div class="timeline-vertical">

            <!-- Step 1: Pendaftaran -->
            <div class="timeline-step">
                <div class="circle <?= $step >= 1 ? ($step > 1 ? 'completed' : 'active') : '' ?>"></div>
                <div class="timeline-content">
                    <h6>Pendaftaran</h6>
                    <?php if($step <= 1): ?>
                        <div class="info-card mt-3">
                            ✅ Pendaftaran berhasil! <br>
                            Kamu telah mendaftar ke unit <strong><?= esc($pendaftaran['unit_kerja']) ?></strong> pada tanggal <strong><?= format_tanggal_indonesia (date('d F Y', strtotime($pendaftaran['tanggal_pengajuan']))) ?></strong>. <br><br>
                            
                            📢 Silakan cek website ini secara berkala untuk melihat status pendaftaranmu. <br>
                            📧 Kamu juga akan menerima pemberitahuan melalui email jika ada informasi terbaru terkait proses seleksi magang.
                        </div>
                    <?php endif;?>
                </div>
            </div>
            <!-- Step 2: Seleksi -->
            <div class="timeline-step">
                <div class="circle <?= $step >= 2 ? ($step > 2 ? 'completed' : 'active') : '' ?>"></div>
                <div class="timeline-content">
                    <h6>Seleksi</h6>
                    <?php if($step <2): ?>
                    <small>Menunggu hasil seleksi dari admin.</small>
                    <?php elseif ($step == 2): ?>
                        <br><br>
                        <div class="info-card">
                            Anda sedang dalam tahap <strong>seleksi</strong>. <br>
                            Silakan cek email secara berkala untuk perkembangan pendaftaran Anda.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Step 3: Konfirmasi Penerimaan -->
            <div class="timeline-step">
                <div class="circle <?= $step >= 3 ? ($step > 3 ? 'completed' : 'active') : '' ?>"></div>
                <div class="timeline-content">
                    <h6>Konfirmasi Penerimaan</h6>
                    <?php if ($step < 3):?>
                    <small>Konfirmasi penerimaan oleh pendaftar.</small>
                    <?php elseif ($step == 3): ?>
                        <?php if ($pendaftaran['status_seleksi'] == 'Ditolak'): ?>
                            <br><br>
                            <div class="info-card error">
                                <strong>Terima kasih telah mendaftar.</strong>
                                Setelah melalui proses seleksi, kami informasikan bahwa Anda <strong>belum berhasil lolos</strong> dalam tahap ini.
                                Kami sangat mengapresiasi minat dan usaha Anda.
                                Jangan berkecil hati—tetap semangat dan terus tingkatkan kemampuan Anda!
                                Semoga sukses untuk kesempatan berikutnya.
                            </div>
                        <?php elseif ($pendaftaran['status_seleksi'] == 'Diterima'): ?>
                            <br><br>
                            <div class="info-card success">
                                <strong>Selamat!</strong> <br>
                                Anda telah diterima sebagai peserta magang. <br>
                                Silakan lakukan konfirmasi penerimaan dalam waktu <strong>maksimal 3 hari</strong> sejak pengumuman ini. <br>   
                                Jika tidak ada konfirmasi hingga batas waktu tersebut, maka kesempatan ini akan dianggap gugur secara otomatis. <br>
                                Kami tunggu konfirmasi Anda, dan selamat bergabung! <br><br>
                                <?php if ($pendaftaran['safety'] == 1): ?>
                                    <div class="alert alert-warning mt-2">
                                        <strong>Perhatian:</strong> Unit kerja Anda mewajibkan kelengkapan alat pelindung diri (APD). <br>
                                        Silakan menyiapkan perlengkapan berikut secara mandiri:
                                        <ul class="mb-0 mt-1">
                                            <li>Rompi safety</li>
                                            <li>Helm safety warna biru</li>
                                            <li>Sepatu safety</li>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#konfirmasiModal">
                                    Konfirmasi Penerimaan
                                </button>
                            </div>

                        <!-- Modal Konfirmasi -->
                        <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content shadow">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Kesediaan Magang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <form action="<?= base_url('magang/konfirmasi') ?>" method="post">
                                        <div class="modal-body">
                                            <p>Dengan ini, saya menyatakan bersedia untuk mengikuti program magang yang akan dimulai pada tanggal <strong><?= date('d M Y', strtotime($pendaftaran['tanggal_masuk'])) ?></strong>.</p>
                                            <p>Saya berkomitmen untuk menjalankan seluruh kegiatan magang dengan penuh tanggung jawab, disiplin, dan sebaik-baiknya sesuai dengan ketentuan yang berlaku.</p>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="setuju" id="setuju" required>
                                                <label class="form-check-label" for="setuju">
                                                    Saya menyetujui pernyataan di atas dan bersedia mengikuti program magang.
                                                </label>
                                            </div>

                                            <!-- Hidden field -->
                                            <input type="hidden" name="magang_id" value="<?= $pendaftaran['magang_id'] ?>">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Konfirmasi</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>      
            <!-- Step 4: Pengumpulan Berkas -->
            <div class="timeline-step">
                <div class="circle <?= $step >= 4 ? ($step > 4 ? 'completed' : 'active') : '' ?>"></div>
                <div class="timeline-content">
                    <h6>Kelengkapan Berkas</h6>

                    <?php if($step < 4) : ?>
                        <small>Melengkapi persyaratan sebelum H-3 magang</small>        

                    <?php elseif ($step == 4): ?>
                        <?php if ($pendaftaran['berkas_lengkap'] === 'N'): ?>
                            <div class="alert alert-warning">
                                ❌ Berkas yang Anda lampirkan sebelumnya <strong>belum lengkap atau tidak sesuai</strong>.<br>
                                Mohon lengkapi dokumen Anda melalui menu <strong><a href="/profile">Profil</a></strong> dan lakukan validasi ulang.<br><br>
                                Jika tidak dilengkapi sebelum <strong><?= format_tanggal_indonesia(date('d M Y', strtotime('-3 days', strtotime($pendaftaran['tanggal_masuk'])))) ?></strong>, maka pendaftaran Anda akan <strong>gugur otomatis</strong>.
                            </div>
                        <?php else: ?>
                            <br><br>
                            <div class="info-card">
                                Mohon lengkapi dokumen persyaratan Anda melalui menu <strong><a href="/profile">Profil</a></strong> selambat-lambatnya pada tanggal <strong><?= format_tanggal_indonesia(date('d M Y', strtotime('-3 days', strtotime($pendaftaran['tanggal_masuk'])))) ?></strong>.<br><br>
                                Dokumen yang wajib dilengkapi:
                                <ul class="mb-2 mt-1">
                                    <li>BPJS Kesehatan</li>
                                    <li>BPJS Ketenagakerjaan</li>
                                    <li>KTP atau Kartu Keluarga</li>
                                </ul>
                                Jika dokumen belum lengkap hingga batas waktu tersebut, maka pendaftaran Anda akan <strong>gugur secara otomatis</strong>.
                            </div>
                        <?php endif; ?>

                        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#validasiBerkasModal">
                            Validasi Berkas Lengkap
                        </button>

                        <!-- Modal Validasi Berkas -->
                        <div class="modal fade" id="validasiBerkasModal" tabindex="-1" aria-labelledby="validasiBerkasModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content shadow">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="validasiBerkasModalLabel">Pernyataan Validasi Berkas</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <form action="<?= base_url('magang/validasi-berkas') ?>" method="post">
                                        <div class="modal-body">
                                            <p>Dengan ini, saya menyatakan bahwa seluruh dokumen yang saya unggah sebagai syarat administrasi magang adalah benar, sah, dan sesuai dengan keadaan sebenarnya.</p>
                                            <p>Apabila di kemudian hari ditemukan ketidaksesuaian atau ketidakbenaran atas dokumen yang saya berikan, saya bersedia menerima segala konsekuensi sesuai ketentuan yang berlaku.</p>

                                            <div class="form-check mt-3">
                                                <input class="form-check-input" type="checkbox" name="setuju_berkas" id="setuju_berkas" required>
                                                <label class="form-check-label" for="setuju_berkas">
                                                    Saya menyetujui pernyataan di atas dan menyatakan bahwa berkas saya telah lengkap.
                                                </label>
                                            </div>

                                            <!-- Hidden field -->
                                            <input type="hidden" name="magang_id" value="<?= $pendaftaran['magang_id'] ?>">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Validasi Sekarang</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Step 5: Validasi Berkas -->
            <div class="timeline-step">
                <div class="circle <?= $step >= 5 ? ($step > 5 ? 'completed' : 'active') : '' ?>"></div>
                <div class="timeline-content">
                    <h6>Validasi Berkas</h6>
                    <?php if ($step == 5): ?>
                        <br><br>
                        <div class="info-card">
                            📁 <strong>Kamu telah mengonfirmasi kelengkapan berkas</strong> pada
                                <strong><?= format_tanggal_indonesia(date('d F Y', strtotime($pendaftaran['tanggal_konfirmasi']))) ?></strong>. <br>
                                ⏳ Saat ini kamu sedang <strong>menunggu verifikasi dokumen oleh admin</strong>. <br>
                                📧 Mohon cek email dan website ini secara berkala untuk mengetahui hasil verifikasi.
                        </div>
                    <?php elseif ($step < 5): ?>
                    <small>Menunggu verifikasi dokumen oleh admin</small>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Step 6: Pelaksanaan -->
            <div class="timeline-step">
                <div class="circle <?= $step >= 6 ? 'completed' : '' ?>"></div>
                <div class="timeline-content">
                    <h6>Pelaksanaan</h6>
                    <?php if($step < 6): ?>
                        <small>Mulai kegiatan magang</small>
                    <?php elseif ($step == 6): ?>
                        <br><br>
                        <div class="info-card">
                            🎉 Selamat! <br>
                            Kamu telah <strong>diterima magang di PT. Semen Padang</strong> pada <strong>Unit <?= esc($pendaftaran['unit_kerja']) ?></strong>. Selamat bergabung dan semangat menjalani pengalaman barumu! <br>
                            Tanggal pelaksanaan magang dimulai dari <strong><?= format_tanggal_indonesia(date('d F Y', strtotime($pendaftaran['tanggal_masuk']))) ?></strong> hingga <strong><?= format_tanggal_indonesia(date('d F Y', strtotime($pendaftaran['tanggal_selesai']))) ?></strong>.
                            <br><br>
                            Pada hari pertama, kamu diharapkan hadir di <strong>Gedung Diklat PT Semen Padang</strong> pada pukul <strong>08.00 WIB</strong> untuk mengikuti pengarahan awal dan registrasi peserta magang.
                            <br><br>
                            Mohon untuk <strong>mencetak tanda pengenal magang</strong> dan <strong>membawanya</strong> saat hari pertama. Kamu bisa mencetaknya melalui tombol berikut:
                            <br><br>
                            <a href="<?= base_url('/cetak-tanda-pengenal/' . $pendaftaran['magang_id']) ?>" target="_blank" class="btn btn-primary">
                                Cetak Tanda Pengenal
                            </a>

                            <?php if ($pendaftaran['safety'] == 1): ?>
                                    <div class="alert alert-warning mt-2">
                                        <strong>Perhatian:</strong> Unit kerja Anda mewajibkan kelengkapan alat pelindung diri (APD). <br>
                                        Silakan menyiapkan perlengkapan berikut secara mandiri:
                                        <ul class="mb-0 mt-1">
                                            <li>Rompi safety</li>
                                            <li>Helm safety warna biru</li>
                                            <li>Sepatu safety</li>
                                        </ul>
                                    </div>
                            <?php endif; ?>

                            <a href="<?= base_url('generateSuratPenerimaan/'.$pendaftaran['magang_id']); ?>" class="btn btn-primary" target="_blank">Cetak Surat Penerimaan</a>

                        </div>
                    <?php endif; ?>
                </div>
            </div>



        </div>
    </div>
</div>

    <?php endif; ?>

    <!-- Histori Lamaran Tab -->
    <div class="tab-pane fade" id="histori-lamaran" role="tabpanel">
    <h4 class="fw-bold mb-3">Histori Pendaftaran</h4>
    <p class="text-muted">Riwayat semua lamaran yang pernah diajukan.</p>
    <a href="#" class="btn btn-outline-primary">Lihat Histori Pendaftaran</a>
    </div>
</div>
</div>
        


<!-- Optional: Include Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<?= $this->endSection(); ?>