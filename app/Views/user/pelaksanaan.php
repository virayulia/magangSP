<?= $this->extend('user/template'); ?>
<?= $this->section('main-content'); ?>

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

<!-- Tabs Lamaran -->
<div class="profile-card">
    <ul class="nav nav-tabs profile-tabs mb-4" id="lamaranTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="status-lamaran-tab" data-bs-toggle="tab" data-bs-target="#pelaksanaan" type="button" role="tab">
                Pelaksanaan Magang
            </button>
        </li>
    </ul>

    <div class="tab-content" id="lamaranTabContent">
        <div class="tab-pane fade show active" id="pelaksanaan" role="tabpanel">
            <p class="text-muted">Panduan dan tugas penting yang perlu kamu selesaikan sebelum memulai magang:</p>

            <!-- Surat Pernyataan -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">📝 Surat Pernyataan</h5>
                    <p>Unduh, isi, dan unggah kembali surat pernyataan berikut sebagai salah satu syarat pelaksanaan magang.</p>

                    <a href="<?= base_url('template/surat-pernyataan.pdf') ?>" class="btn btn-outline-primary mb-3" download>
                        <i class="bi bi-download"></i> Unduh Template Surat Pernyataan
                    </a>

                    <!-- Status Unggah -->
                    <?php if (!empty($pendaftaran['file_pernyataan'])): ?>
                        <div class="alert alert-success p-2">
                            ✅ Surat pernyataan telah diunggah pada <strong><?= date('d M Y', strtotime($pendaftaran['tgl_upload_pernyataan'])) ?></strong>.
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('magang/upload-surat-pernyataan') ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="file_pernyataan" class="form-label">Unggah Surat Pernyataan (PDF)</label>
                            <input class="form-control" type="file" name="file_pernyataan" id="file_pernyataan" accept="application/pdf" required>
                        </div>
                        <button type="submit" class="btn btn-success">Unggah Surat</button>
                    </form>
                </div>
            </div>

            <!-- Safety Induction -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">🦺 Safety Induction</h5>
                    <p>Pelajari prosedur keselamatan kerja dan ikuti tes berikut sebelum memulai magang:</p>

                    <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                        <a href="https://shorturl.at/0y7p7" class="btn btn-outline-info">
                            <i class="bi bi-info-circle"></i> Penjelasan Safety Induction
                        </a>

                        <a href="https://forms.gle/zJRGSo9ZgVNhMFna9" class="btn btn-outline-warning">
                            <i class="bi bi-journal-check"></i> Ikuti Tes Safety Induction
                        </a>
                    </div>

                    <div class="text-center">
                        <img src="<?= base_url('img/safety-induction.jpg') ?>" alt="QR Safety Induction" class="img-fluid" style="max-width: 150px;">
                        <p class="text-muted mt-2"><small>Scan QR untuk mengakses langsung dari perangkat lain</small></p>
                    </div>

                    <!-- Status Tes -->
                    <?php if (!empty($pendaftaran['tgl_safety_induction'])): ?>
                        <div class="alert alert-success mt-3">
                            ✅ Tes Safety Induction telah diselesaikan pada <strong><?= date('d M Y', strtotime($pendaftaran['tgl_safety_induction'])) ?></strong>.
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning mt-3">
                            ⚠️ Tes Safety Induction belum diselesaikan. Silakan selesaikan sebelum tanggal pelaksanaan magang.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
