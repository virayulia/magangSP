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

<!-- Tabs Sertifikat -->
<div class="profile-card">
    <ul class="nav nav-tabs profile-tabs mb-4" id="sertifikatTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="sertifikat-tab" data-bs-toggle="tab" data-bs-target="#pelaksanaan" type="button" role="tab">
                Sertifikat Magang
            </button>
        </li>
    </ul>

    <?php if (!empty($penilaian)): ?>
        <?php if ($penilaian['approve_kaunit'] == 1): ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">📋 Detail Penilaian Magang</h5>
                    <?php
                    $totalNilai = $penilaian['nilai_disiplin']
                                + $penilaian['nilai_kerajinan']
                                + $penilaian['nilai_tingkahlaku']
                                + $penilaian['nilai_kerjasama']
                                + $penilaian['nilai_kreativitas']
                                + $penilaian['nilai_kemampuankerja']
                                + $penilaian['nilai_tanggungjawab']
                                + $penilaian['nilai_penyerapan'];

                    $rataRata = round($totalNilai / 8, 2);
                    ?>

                    <ul class="list-group mb-3">
                        <li class="list-group-item">Disiplin: <strong><?= $penilaian['nilai_disiplin'] ?></strong></li>
                        <li class="list-group-item">Kerajinan: <strong><?= $penilaian['nilai_kerajinan'] ?></strong></li>
                        <li class="list-group-item">Tingkah Laku: <strong><?= $penilaian['nilai_tingkahlaku'] ?></strong></li>
                        <li class="list-group-item">Kerja Sama: <strong><?= $penilaian['nilai_kerjasama'] ?></strong></li>
                        <li class="list-group-item">Kreativitas: <strong><?= $penilaian['nilai_kreativitas'] ?></strong></li>
                        <li class="list-group-item">Kemampuan Kerja: <strong><?= $penilaian['nilai_kemampuankerja'] ?></strong></li>
                        <li class="list-group-item">Tanggung Jawab: <strong><?= $penilaian['nilai_tanggungjawab'] ?></strong></li>
                        <li class="list-group-item">Penyerapan: <strong><?= $penilaian['nilai_penyerapan'] ?></strong></li>
                        <li class="list-group-item">Rata-rata Nilai: <strong><?= $rataRata ?></strong></li>
                        <li class="list-group-item text-success">✅ Telah disetujui pada: <strong><?= date('d M Y H:i', strtotime($penilaian['tgl_disetujui'])) ?></strong></li>
                    </ul>

                    <a href="<?= base_url('user/cetak-sertifikat') ?>" target="_blank" class="btn btn-success">
                        <i class="fas fa-file-pdf"></i> Unduh Sertifikat
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                ✅ Penilaian kamu sudah ada, namun masih <strong>menunggu persetujuan</strong> dari pembimbing.
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-warning">
            ⚠️ Kamu belum dinilai oleh pembimbing atau belum menyelesaikan seluruh tahapan magang.
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>
