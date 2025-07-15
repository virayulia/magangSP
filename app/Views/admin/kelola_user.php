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

<h1 class="h3 mb-4 text-gray-800">Kelola User</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($users as $user): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= esc($user->email) ?></td>
                            <td><?= esc($user->role) ?></td>
                            <td>
                              <?php if ($user->active): ?>
                                <span class="badge badge-success">Aktif</span>
                              <?php else: ?>
                                <span class="badge badge-secondary">Nonaktif</span>
                              <?php endif; ?>
                            </td>
                            <td>
                              <a href="<?= base_url('admin/user/edit/'.$user->id) ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                              </a>
                              <a href="<?= base_url('manage-user/delete/'.$user->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                <i class="fas fa-trash"></i> Hapus
                              </a>
                            </td>
                        </tr>
                        
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

<?= $this->endSection() ?>