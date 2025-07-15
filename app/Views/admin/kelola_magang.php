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

<!-- Card Tabel -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Unit Kerja</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada data peserta magang saat ini.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data as $item): ?>
                        <tr>
                            <td><?= esc($item['fullname']) ?></td>
                            <td><?= esc($item['nisn_nim']) ?></td>
                            <td><?= esc($item['unit_kerja']) ?></td>
                            <td><?= esc($item['tanggal_masuk']) ?></td>
                            <td><?= esc($item['tanggal_selesai']) ?></td>                                                 
                            <td>
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#detailModal<?= $item['id'] ?>">Detail</button>
                            </td>                          
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<?php foreach ($data as $item): ?>
<div class="modal fade" id="detailModal<?= $item['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel<?= $item['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="detailModalLabel<?= $item['id'] ?>">Detail Peserta - <?= esc($item['fullname']) ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr><th>Nama Lengkap</th><td><?= esc($item['fullname']) ?></td></tr>
                <tr><th>NIM/NISN</th><td><?= esc($item['nisn_nim']) ?></td></tr>
                <tr><th>Tanggal Mulai</th><td><?= esc($item['tanggal_masuk']) ?></td></tr>
                <tr><th>Tanggal Selesai</th><td><?= esc($item['tanggal_selesai']) ?></td></tr>
                <tr><th>CV</th>
                    <td><?= $item['cv'] ? '<a href="'.base_url('uploads/cv/'.$item['cv']).'" target="_blank">Lihat CV</a>' : 'Belum Ada' ?></td></tr>
                <tr><th>Proposal</th>
                    <td><?= $item['proposal'] ? '<a href="'.base_url('uploads/proposal/'.$item['proposal']).'" target="_blank">Lihat Proposal</a>' : 'Belum Ada' ?></td></tr>
                <tr><th>Surat Permohonan</th>
                    <td><?= $item['surat_permohonan'] ? '<a href="'.base_url('uploads/surat/'.$item['surat_permohonan']).'" target="_blank">Lihat Surat</a>' : 'Belum Ada' ?></td></tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

</div>

<?= $this->endSection() ?>
