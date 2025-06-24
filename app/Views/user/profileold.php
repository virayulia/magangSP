<?= $this->extend('templates/index'); ?>
<?= $this->section('content'); ?>
<style>
.timeline {
    position: relative;
    margin-left: 20px;
}
.timeline::before {
    content: '';
    position: absolute;
    top: 0;
    left: 8px;
    width: 4px;
    height: 100%;
    background-color: #dee2e6;
}
.timeline-step {
    position: relative;
}
.circle {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background-color: #dee2e6;
    border: 2px solid white;
    position: relative;
    z-index: 1;
}
.bg-success {
    background-color: #28a745 !important;
}
.bg-secondary {
    background-color: #6c757d !important;
}
.alert {
    border-radius: 10px;
}
</style>

<div class="container-fluid" style="padding-top: 90px;">
    <?php $session = \Config\Services::session(); ?>
    <?php if ($session->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $session->getFlashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Sidebar Profile & Menu -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <img src="<?= base_url('img/' . esc($user_data->user_image)); ?>" class="img-fluid rounded-circle mb-3" alt="Profile Picture" style="width: 120px; height: 120px;">
                    <h5 class="font-weight-bold"><?= esc($user_data->fullname); ?></h5>
                    <p class="mb-1"><?= esc($user_data->email); ?></p>
                    <p><?= esc($user_data->universitas); ?></p>
                </div>
            </div>

            <!-- Menu -->
            <div class="card shadow mt-3">
                <div class="list-group list-group-flush" id="menu">
                    <a href="#" class="list-group-item list-group-item-action active" id="menu-profil">Profil</a>
                    <a href="#" class="list-group-item list-group-item-action" id="menu-status">Status Lamaran</a>
                    <a href="#" class="list-group-item list-group-item-action" id="menu-bantuan">Bantuan</a>
                    <a href="<?= base_url('logout')?>" class="list-group-item list-group-item-action" id="menu-keluar">Keluar</a>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-md-8" id="content-area">
            <!-- Profil Content -->
            <div id="profil-content">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Profil</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Profile Image -->
                            <div class="col-md-4 text-center mb-4">
                                <img src="<?= base_url('img/' . esc($user_data->user_image ?? '')); ?>" class="img-fluid rounded-circle" alt="Profile Picture" style="width: 150px; height: 150px;">
                            </div>

                            <!-- Profile Info -->
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" value="<?= esc($user_data->fullname ?? ''); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label>NIM</label>
                                    <input type="text" class="form-control" value="<?= esc($user_data->nim ?? ''); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" class="form-control" value="<?= esc($user_data->nik ?? ''); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" value="<?= esc($user_data->email ?? ''); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label>No. HP</label>
                                    <input type="text" class="form-control" value="<?= esc($user_data->no_hp ?? ''); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Perguruan Tinggi</label>
                                    <input type="text" class="form-control" value="<?= esc($user_data->universitas ?? ''); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Fakultas</label>
                                    <input type="text" class="form-control" value="<?= esc($user_data->fakultas ?? ''); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Jurusan</label>
                                    <input type="text" class="form-control" value="<?= esc($user_data->jurusan ?? ''); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Semester</label>
                                    <input type="text" class="form-control" value="<?= esc($user_data->semester ?? ''); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label>CV</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="<?= esc($pendaftaran['cv'] ?? ''); ?>" readonly>
                                        <?php if (!empty($pendaftaran['cv'])) : ?>
                                            <div class="input-group-append">
                                                <a href="<?= base_url('uploads/cv/' . $pendaftaran['cv']); ?>" target="_blank" class="btn btn-primary">
                                                    Lihat
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Proposal</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="<?= esc($pendaftaran['proposal'] ?? ''); ?>" readonly>
                                        <?php if (!empty($pendaftaran['proposal'])) : ?>
                                            <div class="input-group-append">
                                                <a href="<?= base_url('uploads/proposal/' . $pendaftaran['proposal']); ?>" target="_blank" class="btn btn-primary">
                                                    Lihat
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Surat Permohonan PT</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="<?= esc($pendaftaran['surat_permohonanpt'] ?? ''); ?>" readonly>
                                        <?php if (!empty($pendaftaran['surat_permohonanpt'])) : ?>
                                            <div class="input-group-append">
                                                <a href="<?= base_url('uploads/surat/' . $pendaftaran['surat_permohonanpt']); ?>" target="_blank" class="btn btn-primary">
                                                    Lihat
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Lamaran Content -->
            <div id="status-content" style="display: none;">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Status Lamaran Magang</h6>
                    </div>
                    <div class="card-body">
                        <?php if (empty($pendaftaran)) : ?>
                            <div class="alert alert-info text-center">
                                Belum ada lamaran.
                            </div>
                        <?php else : ?>
                            <div class="text-right mb-3">
                                <a href="<?= base_url('histori-pendaftaran'); ?>" class="btn btn-primary">Lihat Histori Pendaftaran</a>
                            </div>

                            <?php
                            $status = '';
                            if (is_null($pendaftaran['tanggal_approval'])) {
                                $status = 'Sedang Diproses';
                            } elseif (is_null($pendaftaran['tanggal_mulai'])) {
                                $status = 'Ditolak';
                            } else {
                                $status = 'Diterima';
                            }
                            ?>

                            <?php if ($status == 'Sedang Diproses' || $status == 'Ditolak') : ?>
                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">
                                            <?= $status == 'Sedang Diproses' ? 'Lamaran Anda Sedang Diproses' : 'Lamaran Ditolak'; ?>
                                        </h5>

                                        <div class="mb-2"><strong>Jenis Program:</strong> <?= esc($pendaftaran['jenis_program']); ?></div>
                                        <div class="mb-2"><strong>Tanggal Daftar:</strong> <?= date('d M Y', strtotime($pendaftaran['tanggal_daftar'])); ?></div>
                                        <div class="mb-2"><strong>Tanggal Pengajuan:</strong> <?= date('d M Y', strtotime($pendaftaran['tanggal_pengajuan'])); ?></div>

                                        <?php if ($status == 'Ditolak' && !empty($pendaftaran['catatan'])): ?>
                                            <div class="mt-3">
                                                <strong>Catatan Penolakan:</strong>
                                                <div class="alert alert-danger mt-2" role="alert">
                                                    <?= esc($pendaftaran['catatan']); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            <?php else : ?>
                                <!-- Progress Bar Pendaftaran -->
                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">Progress Pendaftaran Magang</h5>

                                        <?php
                                        $step = 1;

                                        // Kalau sudah selesai
                                        if (!empty($pendaftaran['tanggal_selesai'])) {
                                            $step = 4;
                                        }
                                        // Kalau sudah konfirmasi diterima
                                        elseif (!empty($pendaftaran['tanggal_mulai']) && !empty($pendaftaran['konfirmasi_diterima']) && $pendaftaran['konfirmasi_diterima'] == 1) {
                                            $step = 3;
                                        }
                                        // Kalau sudah di-approval
                                        elseif (!empty($pendaftaran['tanggal_approval'])) {
                                            $step = 2;
                                        }
                                        ?>

                                        <div class="timeline">
                                            <!-- STEP 1 -->
                                            <div class="timeline-step mb-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="circle <?= $step >= 1 ? 'bg-success' : 'bg-secondary'; ?>"></div>
                                                    <div class="ml-3">
                                                        <h6 class="mb-0">1. Pendaftaran</h6>
                                                        <small><?= !empty($pendaftaran['tanggal_daftar']) ? date('d M Y', strtotime($pendaftaran['tanggal_daftar'])) : '-'; ?></small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- STEP 2 -->
                                            <div class="timeline-step mb-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="circle <?= $step >= 2 ? 'bg-success' : 'bg-secondary'; ?>"></div>
                                                    <div class="ml-3">
                                                        <h6 class="mb-0">2. Konfirmasi Mahasiswa</h6>
                                                        <small><?= !empty($pendaftaran['tanggal_approval']) ? date('d M Y', strtotime($pendaftaran['tanggal_approval'])) : '-'; ?></small>
                                                    </div>
                                                </div>

                                                <?php if ($step == 2): ?>
                                                    <div class="alert alert-info mt-3">
                                                        <strong>Selamat!</strong> Pendaftaran Anda telah diterima.<br>
                                                        Tanggal magang dimulai pada: <strong><?= date('d M Y', strtotime($pendaftaran['tanggal_mulai'])); ?></strong>
                                                        <br><br>
                                                        <div class="alert alert-warning mt-3">
                                                            <strong>Perhatian:</strong> Anda wajib melakukan konfirmasi paling lambat <strong><?= date('d M Y', strtotime('+3 days', strtotime($pendaftaran['tanggal_approval']))); ?></strong>.
                                                        </div>
                                                        <div class="mt-3">
                                                            <button class="btn btn-success" data-toggle="modal" data-target="#konfirmasiModal">Konfirmasi Penerimaan</button>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- STEP 3 -->
                                            <div class="timeline-step mb-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="circle <?= $step >= 3 ? 'bg-success' : 'bg-secondary'; ?>"></div>
                                                    <div class="ml-3">
                                                        <h6 class="mb-0">3. Pelaksanaan Magang</h6>
                                                        <small><?= !empty($pendaftaran['tanggal_mulai']) ? date('d M Y', strtotime($pendaftaran['tanggal_mulai'])) : '-'; ?></small>
                                                    </div>
                                                </div>

                                                <?php if ($step == 3): ?>
                                                <div class="alert alert-success mt-3">
                                                    <p>Anda telah diterima untuk magang/penelitian.</p>
                                                    <p>Silakan mengumpulkan seluruh persyaratan berikut ke Unit Operasional SDM (Pusdiklat) paling lambat <strong><?= date('d M Y', strtotime('-3 days', strtotime($pendaftaran['tanggal_mulai']))); ?></strong>:</p>
                                                    <ol class="mt-2">
                                                        <li>Surat Permohonan dari Perguruan Tinggi/Sekolah</li>
                                                        <li>Proposal Kerja Praktek/Penelitian</li>
                                                        <li>Curriculum Vitae (Biodata Diri)</li>
                                                        <li>Foto Berwarna/Hitam Putih ukuran 2x3 : 3 lembar</li>
                                                        <li>Fotokopi Asuransi Kesehatan</li>
                                                        <li>Fotokopi BPJS Kecelakaan Kerja/Ketenagakerjaan (Pribadi)</li>
                                                        <li>Fotokopi KTP atau KK</li>
                                                    </ol>

                                                    <div class="mt-3">
                                                        <a href="<?= base_url('generateSuratPenerimaan/'.$pendaftaran['id']); ?>" class="btn btn-primary" target="_blank">Cetak Surat Penerimaan</a>
                                                        <!-- <a href="<?= base_url('generatePersyaratan/'.$pendaftaran['id']); ?>" class="btn btn-secondary" target="_blank">Cetak Persyaratan</a> -->
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- STEP 4 -->
                                            <div class="timeline-step mb-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="circle <?= $step >= 4 ? 'bg-success' : 'bg-secondary'; ?>"></div>
                                                    <div class="ml-3">
                                                        <h6 class="mb-0">4. Selesai</h6>
                                                        <small><?= !empty($pendaftaran['tanggal_selesai']) ? date('d M Y', strtotime($pendaftaran['tanggal_selesai'])) : '-'; ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="konfirmasiModal" tabindex="-1" role="dialog" aria-labelledby="modalKonfirmasiLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <?php $form_action = isset($pendaftaran['id']) ? base_url('manage-pendaftaran/konfirmasi//' . $pendaftaran['id']) : '#'; ?>
  <form action="<?= $form_action; ?>" method="post">        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKonfirmasiLabel">Konfirmasi Penerimaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            Dengan ini saya menyatakan bersedia melaksanakan <strong><?= esc($pendaftaran['jenis_program'] ?? 'Program'); ?></strong>
            pada tanggal yang telah ditentukan dan akan memenuhi semua ketentuan dari perusahaan.
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Setuju</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </form>
  </div>
</div>


<!-- JavaScript untuk switch menu -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script><script>
$(document).ready(function(){
    $('#menu-profil').click(function(e){
        e.preventDefault();
        $('#profil-content').show();
        $('#status-content').hide();
        $('#menu a').removeClass('active');
        $(this).addClass('active');
    });
    $('#menu-status').click(function(e){
        e.preventDefault();
        $('#profil-content').hide();
        $('#status-content').show();
        $('#menu a').removeClass('active');
        $(this).addClass('active');
    });
});
</script>

<?= $this->endSection(); ?>
