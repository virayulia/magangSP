<?= $this->extend('admin/templates/index'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <?php $session = \Config\Services::session(); ?>
    <?php if ($session->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $session->getFlashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <h1 class="h3 mb-2 text-gray-800">Data Pendaftaran</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pendaftaran) && is_array($pendaftaran)) : ?>
                            <?php $no = 1; foreach ($pendaftaran as $data) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($data['fullname']); ?></td>
                                    <td><?= esc($data['tanggal_daftar']); ?></td>
                                    <td>
                                        <?php 
                                        if (is_null($data['tanggal_validasi_berkas'])) {
                                            echo "Pendaftaran";
                                        } else {
                                            if ($data['status_validasi_berkas'] === 'Y') {
                                                echo "Berkas Valid";
                                            } else {
                                                echo "Berkas Tidak Valid";
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('detail-pendaftaran/' . $data['magang_id']); ?>" class="btn btn-info btn-sm">Detail</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
