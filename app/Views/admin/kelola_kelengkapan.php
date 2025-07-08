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
                            <th>BPJS Kes</th>
                            <th>BPJS TK</th>
                            <th>Pembayaran BPJS TK</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)): ?>
                            <?php foreach ($data as $item): ?>
                                <tr>
                                    <td><?= esc($item['fullname']) ?></td>
                                    <td><?= esc($item['nisn_nim']) ?></td>
                                    <td><?= $item['bpjs_kes'] ? '<a href="'.base_url('uploads/bpjs_kes/'.$item['bpjs_kes']).'" target="_blank">Lihat</a>' : 'Belum Ada' ?></td>
                                    <td><?= $item['bpjs_tk'] ? '<a href="'.base_url('uploads/bpjs_tk/'.$item['bpjs_tk']).'" target="_blank">Lihat</a>' : 'Belum Ada' ?></td>
                                    <td><?= $item['buktibpjs_tk'] ? '<a href="'.base_url('uploads/buktibpjs_tk/'.$item['buktibpjs_tk']).'" target="_blank">Lihat</a>' : 'Belum Ada' ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#validasiModal<?= $item['magang_id'] ?>">Validasi</button>
                                    </td>
                                </tr>

                                <!-- Modal Validasi -->
                                <div class="modal fade" id="validasiModal<?= $item['magang_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="validasiModalLabel<?= $item['magang_id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="<?= base_url('/manage-kelengkapan-berkas/valid/'.$item['magang_id']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="validasiModalLabel<?= $item['magang_id'] ?>">Validasi Berkas - <?= esc($item['fullname']) ?></h5>
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
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
