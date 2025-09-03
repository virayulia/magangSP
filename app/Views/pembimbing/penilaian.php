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
                <th>Status Penilaian</th>
                <th>Status Approve</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($peserta)): ?>
                <tr><td colspan="9" class="text-center">Tidak ada peserta magang</td></tr>
            <?php else: ?>
                <?php foreach ($peserta as $i => $item): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($item['fullname']) ?></td>
                        <td><?= esc($item['nisn_nim']) ?></td>
                        <td><?= esc($item['nama_instansi']) ?></td>
                        <td><?= date('d M Y', strtotime($item['tanggal_masuk'])) ?></td>
                        <td><?= date('d M Y', strtotime($item['tanggal_selesai'])) ?></td>
                        <td>
                            <?php if ($item['penilaian_id']): ?>
                                <span class="badge bg-success text-light">Sudah Dinilai</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-light">Belum Dinilai</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($item['approve_kaunit']): ?>
                                <span class="badge bg-success text-light">Sudah Disetujui</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-light">Belum Disetujui</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($item['penilaian_id']): ?>
                                <button type="button" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#modalDetail-<?= $item['magang_id'] ?>">
                                    👁️ Detail
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalNilai-<?= $item['magang_id'] ?>">
                                    📝 Nilai
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>

    <?php if (!empty($peserta)): ?>
        <?php foreach ($peserta as $item): ?>
            
            <!-- Modal Penilaian -->
            <div class="modal fade" id="modalNilai-<?= $item['magang_id'] ?>" tabindex="-1" aria-labelledby="modalNilaiLabel-<?= $item['magang_id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="<?= base_url('pembimbing/penilaian/save') ?>" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="magang_id" value="<?= $item['magang_id'] ?>">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="modalNilaiLabel-<?= $item['magang_id'] ?>">Form Penilaian: <?= esc($item['fullname']) ?></h5>
                                <button type="button" class="close text-white" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <?php
                                $fields = [
                                    'disiplin' => 'Disiplin',
                                    'kerajinan' => 'Kerajinan',
                                    'tingkahlaku' => 'Tingkah Laku',
                                    'kerjasama' => 'Kerja Sama',
                                    'kreativitas' => 'Kreativitas',
                                    'kemampuankerja' => 'Kemampuan Kerja',
                                    'tanggungjawab' => 'Tanggung Jawab',
                                    'penyerapan' => 'Penyerapan'
                                ];
                                foreach ($fields as $name => $label): ?>
                                    <div class="form-group">
                                        <label><?= $label ?></label>
                                        <input type="number" name="<?= $name ?>" class="form-control" min="1" max="100" required>
                                    </div>
                                <?php endforeach; ?>
                                <div class="form-group">
                                    <label>Catatan atau Komentar</label>
                                    <textarea name="catatan" class="form-control" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Simpan Nilai</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Detail Penilaian -->
            <div class="modal fade" id="modalDetail-<?= $item['magang_id'] ?>" tabindex="-1" aria-labelledby="modalDetailLabel-<?= $item['magang_id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="modalDetailLabel-<?= $item['magang_id'] ?>">Detail Penilaian: <?= esc($item['fullname']) ?></h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <?php foreach ($fields as $name => $label): ?>
                                <div class="form-group">
                                    <label><?= $label ?></label>
                                    <input type="number" value="<?= esc($item['nilai_' . $name]) ?>" class="form-control" readonly>
                                </div>
                            <?php endforeach; ?>
                            <div class="form-group">
                                <label>Catatan atau Komentar</label>
                                <textarea class="form-control" rows="3" readonly><?= esc($item['catatan']) ?></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    <?php endif; ?>

</div>

        </div>
    </div>
</div>


<?= $this->endSection() ?>