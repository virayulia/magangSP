                    <!-- isi data profil -->
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

                                    <!-- PROGRESS BAR-->
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Progress Pendaftaran Magang</h5>

                                    <?php
                                    $step = 1;
                                    if (!empty($pendaftaran['tanggal_mulai'])) {
                                        $step = 3;
                                    }
                                    if (!empty($pendaftaran['tanggal_selesai'])) {
                                        $step = 4;
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
                                                <div class="mt-3">
                                                    <button class="btn btn-success" data-toggle="modal" data-target="#modalKonfirmasi">Konfirmasi Penerimaan</button>
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
                                                Anda telah diterima untuk magang/penelitian.<br>
                                                Harap mengumpulkan seluruh persyaratan ke perusahaan paling lambat <strong><?= date('d M Y', strtotime('-3 days', strtotime($pendaftaran['tanggal_mulai']))); ?></strong>.<br>
                                                <div class="mt-3">
                                                    <a href="<?= base_url('generateSuratPenerimaan/'.$pendaftaran['id']); ?>" class="btn btn-primary" target="_blank">Generate Surat Penerimaan</a>
                                                    <a href="<?= base_url('generatePersyaratan/'.$pendaftaran['id']); ?>" class="btn btn-secondary" target="_blank">Generate Persyaratan</a>
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




<!-- ISI CARD BODY STATUS LAMARAN -->

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
                                    <h5 class="card-title mb-3"><?= $status == 'Sedang Diproses' ? 'Lamaran Anda Sedang Diproses' : 'Lamaran Ditolak' ?></h5>

                                    <div class="mb-2"><strong>Jenis Program:</strong> <?= esc($pendaftaran['jenis_program']); ?></div>
                                    <div class="mb-2"><strong>Tanggal Daftar:</strong> <?= date('d M Y', strtotime($pendaftaran['tanggal_daftar'])); ?></div>
                                    <div class="mb-2"><strong>Tanggal Pengajuan:</strong> <?= date('d M Y', strtotime($pendaftaran['tanggal_pengajuan'])); ?></div>
                                    <div class="mb-2">
                                        <strong>Status:</strong> 
                                        <span class="badge <?= $status == 'Sedang Diproses' ? 'badge-warning' : 'badge-danger'; ?>">
                                            <?= $status; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        <?php else : ?>
                            <!-- Progress Bar Pendaftaran -->
                            
                        <?php endif; ?>
                    <?php endif; ?>



<!-- DATA AKADEMIK -->
     <!-- Tab Content Akademik-->
    <div class="tab-content" id="profileTabContent">
        <div class="tab-pane fade show non-active" id="data-akademik" role="tabpanel">
            <div class="card p-4">
                <p class="text-muted">Pastikan data akademik benar untuk mempermudah proses pendaftaran</p>
                <small class="text-danger">*Wajib diisi</small>
                <hr>
                <form action="<?= base_url('data-akademik/save') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <!-- Pendidikan -->
                        <div class="mb-3">
                            <label for="pendidikan" class="form-label">Pendidikan <span class="text-danger">*</span></label>
                            <select class="form-select" name="pendidikan" id="pendidikan" required>
                                <option value="" disabled selected>Tingkat Pendidikan</option>
                                <option value="SMA/SMK" <?= $user_data->pendidikan == 'SMA/SMK' ? 'selected' : '' ?>>SMA/SMK Sederajat</option>
                                <option value="D3" <?= $user_data->pendidikan == 'D3' ? 'selected' : '' ?>>D3</option>
                                <option value="D4/S1" <?= $user_data->pendidikan == 'D4/S1' ? 'selected' : '' ?>>D4/S1</option>
                                <option value="S2" <?= $user_data->pendidikan == 'S2' ? 'selected' : '' ?>>S2</option>
                            </select>
                        </div>

                        <!-- Instansi (pakai Select2) -->
                        <div class="mb-3">
                            <label for="instansi" class="form-label">Sekolah/Perguruan Tinggi <span class="text-danger">*</span></label>
                            <select class="form-select select2" name="instansi" id="instansi" required>
                                <option value="" disabled selected hidden>Pilih Sekolah/Perguruan Tinggi</option>
                                <?php foreach ($instansi as $item): ?>
                                    <option value="<?= $item['id']; ?>" <?= ($user_data->instansi_id == $item['id']) ? 'selected' : '' ?>>
                                        <?= $item['nama_instansi']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Jurusan -->
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan<span class="text-danger">*</span></label>
                            <select class="form-select select2" name="jurusan" id="jurusan" required>
                                    <option value="" disabled selected hidden>Pilih Jurusan</option>
                                <?php foreach ($jurusan as $item): ?>
                                    <option value="<?= $item['id']; ?>" <?= ($user_data->jurusan == $item['id']) ? 'selected' : '' ?>>
                                        <?= $item['nama_jurusan']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Semester dan IPK -->
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="semester" id="semester" value="<?= esc($user_data->semester) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="nilai_ipk" class="form-label">Nilai/IPK <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="nilai_ipk" id="nilai_ipk" value="<?= number_format($user_data->nilai_ipk, 2, '.', '') ?>" required>
                            <small class="text-muted">Gunakan titik (.) sebagai pemisah desimal, contoh: 3.50</small>
                        </div>

                    </div>

                    <!-- Tombol Simpan -->
                    <div class="d-grid">
                        <button class="btn btn-primary btn-lg" type="submit" name="submit">Simpan Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End Tab Content -->