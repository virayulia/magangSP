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

    <h1 class="h3 mb-2 text-gray-800">Daftar Peserta Tes Safety Induction</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>NIM/NISN</th>
                            <th>Unit Magang</th>
                            <th>Nilai Maksimal</th>
                            <th>Status</th>
                            <th>Jumlah Percobaan</th>
                            <th>Tanggal Tes Terakhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($hasil)): ?>
                            <?php $no = 1; foreach ($hasil as $i => $row): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($row->fullname) ?></td>
                                    <td><?= esc($row->nisn_nim) ?></td>
                                    <td><?= esc($row->unit_kerja) ?></td>
                                    <td><?= esc($row->nilai_maksimal) ?></td>
                                    <td>
                                        <span class="badge <?= $row->status === 'Lulus' ? 'bg-success' : 'bg-danger' ?>">
                                            <?= $row->status ?>
                                        </span>
                                    </td>
                                    <td><?= esc($row->percobaan_terakhir) ?></td>
                                    <td><?= format_tanggal_indonesia_dengan_jam(date('d M Y, H:i', strtotime($row->tanggal_terakhir))) ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Belum ada peserta yang mengikuti tes.</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
