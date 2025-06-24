<?= $this->extend('admin/templates/index'); ?>
<?= $this->section('content'); ?>

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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Kelengkapan Pendaftar</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableBerkas">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>CV</th>
                            <th>Proposal</th>
                            <th>Surat Permohonan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)): ?>
                            <?php foreach ($data as $item): ?>
                                <tr>
                                    <td><?= esc($item['fullname']) ?></td>
                                    <td><?= esc($item['nisn_nim']) ?></td>
                                    <td><?= $item['cv'] ? '<a href="'.base_url('uploads/cv/'.$item['cv']).'" target="_blank">Lihat</a>' : 'Belum Ada' ?></td>
                                    <td><?= $item['proposal'] ? '<a href="'.base_url('uploads/proposal/'.$item['proposal']).'" target="_blank">Lihat</a>' : 'Belum Ada' ?></td>
                                    <td><?= $item['surat_permohonan'] ? '<a href="'.base_url('uploads/surat/'.$item['surat_permohonan']).'" target="_blank">Lihat</a>' : 'Belum Ada' ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#validasiModal<?= $item['id'] ?>">Validasi</button>
                                    </td>
                                </tr>

                                <!-- Modal Validasi -->
                                <div class="modal fade" id="validasiModal<?= $item['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="validasiModalLabel<?= $item['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="<?= base_url('/manage-kelengkapan-berkas/valid/'.$item['id']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="validasiModalLabel<?= $item['id'] ?>">Validasi Berkas - <?= esc($item['fullname']) ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Status Validasi</label>
                                                        <select name="status_validasi" class="form-control" required>
                                                            <option value="">-- Pilih Status --</option>
                                                            <option value="Y">Valid</option>
                                                            <option value="N">Tidak Valid</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Catatan (Opsional)</label>
                                                        <textarea name="catatan" class="form-control" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-success">Simpan Validasi</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- End Modal -->
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">Belum ada berkas pendaftar yang bisa divalidasi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
