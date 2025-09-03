<?= $this->extend('admin/templates/index');?>
<?= $this->section('content');?>
<div class="container-fluid">
    <?php $session = \Config\Services::session(); ?>
    <?php if ($session->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $session->getFlashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <?php if ($session->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $session->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <h1 class="h3 mb-4 text-gray-800">Penilaian</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIM/NISN</th>
            <th>Instansi</th>
            <th>Tgl Mulai</th>
            <th>Tgl Selesai</th>
            <th>Status Approve</th>
            <th>Detail Nilai</th>
            <th>Catatan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($peserta)): ?>
            <tr>
                <td colspan="10" class="text-center">Tidak ada peserta yang sudah dinilai</td>
            </tr>
        <?php else: ?>
            <?php foreach ($peserta as $i => $item): ?>
                <?php if ($item['penilaian_id']): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($item['fullname']) ?></td>
                        <td><?= esc($item['nisn_nim']) ?></td>
                        <td><?= esc($item['nama_instansi']) ?></td>
                        <td><?= date('d M Y', strtotime($item['tanggal_masuk'])) ?></td>
                        <td><?= date('d M Y', strtotime($item['tanggal_selesai'])) ?></td>
                        <td>
                            <?php if ($item['approve_kaunit']): ?>
                                <span class="badge bg-primary text-white">Sudah Disetujui</span>
                            <?php else: ?>
                                <span class="badge bg-secondary text-white">Belum Disetujui</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div>
                                Disiplin: <?= $item['nilai_disiplin'] ?><br>
                                Kerajinan: <?= $item['nilai_kerajinan'] ?><br>
                                Tingkah Laku: <?= $item['nilai_tingkahlaku'] ?><br>
                                Kerja Sama: <?= $item['nilai_kerjasama'] ?><br>
                                Kreativitas: <?= $item['nilai_kreativitas'] ?><br>
                                Kemampuan Kerja: <?= $item['nilai_kemampuankerja'] ?><br>
                                Tanggung Jawab: <?= $item['nilai_tanggungjawab'] ?><br>
                                Penyerapan: <?= $item['nilai_penyerapan'] ?><br>
                            </div>
                            <?php 
                                $total = $item['nilai_disiplin'] + $item['nilai_kerajinan'] + $item['nilai_tingkahlaku'] +
                                        $item['nilai_kerjasama'] + $item['nilai_kreativitas'] + $item['nilai_kemampuankerja'] +
                                        $item['nilai_tanggungjawab'] + $item['nilai_penyerapan'];
                                $rata = round($total / 8, 2);
                            ?>
                            <strong>Rata-rata: <?= $rata ?></strong>
                        </td>

                        <td><?= esc($item['catatan']) ?></td>
                        <td>
                            <?php if (!$item['approve_kaunit']): ?>
                                <form action="<?= base_url('pembimbing/approve/save') ?>" method="post" style="display:inline;">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="magang_id" value="<?= $item['magang_id'] ?>">
                                    <button type="submit" 
                                            class="btn btn-sm btn-primary"
                                            onclick="return confirm('Yakin ingin menyetujui penilaian ini?')">
                                        ✔️ Approve
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted">Sudah diapprove</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>


            </div>

        </div>
    </div>
</div>


<?= $this->endSection() ?>