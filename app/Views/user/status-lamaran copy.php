<?= $this->extend('user/template'); ?>
<?= $this->section('main-content'); ?>

<!-- Tabs Lamaran -->
<div class="profile-card">
    <ul class="nav nav-tabs profile-tabs mb-4" id="lamaranTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="status-lamaran-tab" data-bs-toggle="tab" data-bs-target="#status-lamaran" type="button" role="tab">
                Status Lamaran
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="histori-lamaran-tab" data-bs-toggle="tab" data-bs-target="#histori-lamaran" type="button" role="tab">
                Histori Lamaran
            </button>
        </li>
    </ul>

    <div class="tab-content" id="lamaranTabContent">
        <!-- TAB STATUS LAMARAN -->
        <div class="tab-pane fade show active" id="status-lamaran" role="tabpanel" aria-labelledby="status-lamaran-tab">
            <div class="card p-4">
                <h5 class="fw-bold">Status Lamaran Magang</h5>
                <p class="text-muted">Pantau perkembangan lamaran magang kamu di sini.</p>
                <hr>

                <?php if (empty($pendaftaran)) : ?>
                    <div class="alert alert-info text-center">
                        Belum ada lamaran.
                    </div>
                <?php else : ?>

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
                                                <h6 class="mb-0">2. Seleksi</h6>
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

        <!-- TAB HISTORI LAMARAN -->
        <div class="tab-pane fade" id="histori-lamaran" role="tabpanel" aria-labelledby="histori-lamaran-tab">
            <div class="card p-4">
                <h5 class="fw-bold">Histori Pendaftaran</h5>
                <p class="text-muted">Riwayat semua lamaran yang pernah diajukan.</p>
                <hr>
                <a href="<?= base_url('histori-pendaftaran'); ?>" class="btn btn-primary">Lihat Histori Pendaftaran</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>