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

<h1 class="h3 mb-4 text-gray-800">Kelola Kuota Magang</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Unit dan Kuota</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Unit Kerja</th>
                        <th>Tingkat Pendidikan</th>
                        <th>Total Kuota</th>
                        <th>Jumlah Terisi</th>
                        <th>Kuota Tersedia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($kuota_unit as $kuota): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= esc($kuota->unit_kerja); ?></td>
                            <td><?= esc($kuota->tingkat_pendidikan); ?></td>
                            <td><?= $kuota->kuota; ?></td>
                            <td><?= $kuota->jumlah_diterima_atau_magang; ?></td>
                            <td><?= $kuota->sisa_kuota; ?></td>
                        </tr>


                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

<?= $this->endSection() ?>