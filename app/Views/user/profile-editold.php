<?= $this->extend('user/template'); ?>
<?= $this->section('main-content'); ?>
<!-- Tab Data Profil -->
<div class="profile-card">
    <?php if (session()->get('error')): ?>
    <div class="alert alert-danger"><?= esc(session()->get('error')) ?></div>
<?php endif; ?>
    <!-- Tabs -->
    <ul class="nav nav-tabs profile-tabs mb-4" id="profileTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="data-pribadi-tab" data-bs-toggle="tab" data-bs-target="#data-pribadi" type="button" role="tab">
        Data Pribadi
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="data-akademik-tab" data-bs-toggle="tab" data-bs-target="#data-akademik" type="button" role="tab">
        Data Akademik
        </button>
    </li>
    </ul>
    <!-- Tab Content Profil-->
    <div class="tab-content" id="profileTabContent">
    <div class="tab-pane fade show active" id="data-pribadi" role="tabpanel">
        <div class="card p-4">
        <!-- <h5 class="fw-bold">Data Pribadi  
            <a href="/data-pribadi" class="text-decoration-none text-muted" title="Edit Data Pribadi">
                <i class="bi bi-pencil-square"></i>
            </a>
        </h5> -->
        <p class="text-muted">Pastikan data pribadi benar untuk mempermudah proses pendaftaran</p>
        <small class="text-danger">*Wajib diisi</small>
        <hr>
        <form action="<?= base_url('data-pribadi/save') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-floating mb-3 position-relative">
                <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Nama Lengkap" value="<?= esc($user_data->fullname) ?>" required>
                <label for="fullname">
                    Nama Lengkap <span class="text-danger">*</span>
                </label>
            </div>

            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="nisn_nim" id="nisn_nim" placeholder="NISN/NIM" value="<?= esc($user_data->nisn_nim) ?>" required>
                        <label for="nisn_nim">NISN/NIM <span class="text-danger">*</span></label>
                    </div>

                    
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?= esc($user_data->email) ?>" required>
                        <label for="email">Email <span class="text-danger">*</span></label>
                    </div>

                    <!-- <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" placeholder="Tempat Lahir" value="<?= esc($user_data->tempat_lahir) ?>" required>
                        <label for="tempat_lahir">Tempat Lahir</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="<?= esc($user_data->tanggal_lahir) ?>" required>
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                    </div> -->
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" <?= ($user_data->jenis_kelamin == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= ($user_data->jenis_kelamin == 'P') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                        <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No Handphone" value="<?= esc($user_data->no_hp) ?>" required>
                        <label for="no_hp">No Handphone/WhatsApp<span class="text-danger">*</span></label>
                    </div>
                </div>
            </div>

            <!-- Alamat -->
            <div class="form-floating mb-3">
                <textarea class="form-control" name="alamat" id="alamat" placeholder="Alamat Tempat Tinggal" style="height: 100px" required><?= esc($user_data->alamat) ?></textarea>
                <label for="alamat">Alamat Sesuai KTP</label>
            </div>

            <div class="form-floating mb-3">
                <textarea class="form-control" name="domisili" id="domisili" placeholder="Alamat Domisili" style="height: 100px" required><?= esc($user_data->domisili) ?></textarea>
                <label for="domisili">Alamat Domisili</label>
            </div>

            <!-- Tombol Simpan -->
            <div class="d-grid">
                <button class="btn btn-primary btn-lg" type="submit" name="submit">Simpan Data</button>
            </div>
        </form>

    </div>
    </div>

    <!-- Tab Content Akademik-->
    <div class="tab-content" id="profileTabContent">
        <div class="tab-pane fade show non-active" id="data-akademik" role="tabpanel">
            <div class="card p-4">
                <p class="text-muted">Pastikan data akademik benar untuk mempermudah proses pendaftaran</p>
                <hr>
                <form action="<?= base_url('data-akademik/save') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="pendidikan" id="pendidikan" required>
                                    <option value="">Tingkat Pendidikan</option>
                                    <option value="SMA/SMK" <?= $user_data->pendidikan == 'SMA/SMK' ? 'selected' : '' ?>>SMA/SMK Sederajat</option>
                                    <option value="D3" <?= $user_data->pendidikan == 'D3' ? 'selected' : '' ?>>D3</option>
                                    <option value="D4/S1" <?= $user_data->pendidikan == 'D4/S1' ? 'selected' : '' ?>>D4/S1</option>
                                    <option value="S2" <?= $user_data->pendidikan == 'S2' ? 'selected' : '' ?>>S2</option>
                                </select>

                                <label for="pendidikan">Pendidikan<span class="text-danger">*</span></label>
                            </div>
                            <!-- <div class="form-floating mb-3">
                                <select class="form-select" name="instansi" id="instansi" required>
                                    <option value="">Pilih Sekolah/Perguruan Tinggi</option>
                                    <?php foreach ($instansi as $item): ?>
                                        <option value="<?= $item['id']; ?>" <?= ($user_data->instansi_id == $item['id']) ? 'selected' : '' ?>>
                                            <?= $item['nama_instansi']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="instansi">Sekolah/Perguruan Tinggi<span class="text-danger">*</span></label>
                            </div> -->
                            <div class="mb-3">
                                <label for="instansi" class="form-label">Sekolah/Perguruan Tinggi<span class="text-danger">*</span></label>
                                <select class="form-select select2" name="instansi" id="instansi" required>
                                    <option value="" disabled selected hidden>Pilih Sekolah/Perguruan Tinggi</option>
                                    <?php foreach ($instansi as $item): ?>
                                        <option value="<?= $item['id']; ?>" <?= ($user_data->instansi_id == $item['id']) ? 'selected' : '' ?>>
                                            <?= $item['nama_instansi']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-floating mb-3">
                                <select class="form-select" name="jurusan" id="jurusan" required>
                                    <option value="">Pilih Jurusan</option>
                                    <?php foreach ($jurusan as $item): ?>
                                        <option value="<?= $item['id']; ?>" <?= ($user_data->jurusan == $item['id']) ? 'selected' : '' ?>>
                                            <?= $item['nama_jurusan']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="jurusan">Jurusan<span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" name="semester" id="semester" placeholder="Semester" value="<?= esc($user_data->semester) ?>" required>
                                <label for="semester">Semester<span class="text-danger">*</span></label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" name="nilai_ipk" id="nilai_ipk" step="0.01" placeholder="Nilai/IPK" value="<?= number_format($user_data->nilai_ipk, 2, '.', '') ?>" required>
                                <label for="semester">Nilai/IPK<span class="text-danger">*</span></label>
                                <small class="text-muted">Gunakan titik (.) sebagai pemisah desimal, contoh: 3.50</small>
                            </div>
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
</div>
<!-- End Tab Data Profil -->
<!-- jQuery (required for Select2) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
    $('#instansi').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: $('#instansi').data('placeholder'),
        allowClear: true
    });
});

</script>
<?= $this->endSection(); ?>