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
        
        <hr>
        <form action="<?= base_url('data-pribadi/save') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <!-- Input Gambar Profil -->
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Profil <span class="text-danger">*</span></label>

                <?php if (!empty($user_data->user_image)): ?>
                    <div class="mb-2">
                        <img src="<?= base_url('uploads/profile/' . $user_data->user_image) ?>" alt="Foto Profil" width="120" class="rounded shadow">
                    </div>
                <?php endif; ?>

                <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                <small class="text-muted">Format: JPG, JPEG, atau PNG. Maks. ukuran 2MB.</small>
            </div>
            <!-- Nama Lengkap -->
            <div class="mb-3">
                <label for="fullname" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="fullname" id="fullname" value="<?= esc($user_data->fullname) ?>" required>
            </div>

            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nisn_nim" class="form-label">NISN/NIM <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nisn_nim" id="nisn_nim" value="<?= esc($user_data->nisn_nim) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" value="<?= esc($user_data->email) ?>" required>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" <?= ($user_data->jenis_kelamin == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= ($user_data->jenis_kelamin == 'P') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No Handphone/WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_hp" id="no_hp" value="<?= esc($user_data->no_hp) ?>" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <!-- Provinsi -->
                    <div class="mb-3">
                        <label for="state_id" class="form-label">Provinsi sesuai KTP<span class="text-danger">*</span></label>
                        <select id="state_id" name="state_id" class="form-select select2" required>
                            <option value="" disabled hidden>Pilih Provinsi</option>
                            <?php foreach ($listState as $item): ?>
                                <option value="<?= $item['id'] ?>" <?= $item['id'] == $user_data->province_id ? 'selected' : '' ?>>
                                    <?= $item['province'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Kota -->
                    <div class="mb-3">
                        <label for="city_id" class="form-label">Kota/Kabupaten Sesuai KTP<span class="text-danger">*</span></label>
                        <select id="city_id" name="city_id" class="form-select select2" required>
                            <option value="" disabled hidden>Pilih Kota</option>
                            <?php if (!empty($listCity)): ?>
                                <?php foreach ($listCity as $city): ?>
                                    <option value="<?= $city['id'] ?>" <?= $city['id'] == $user_data->city_id ? 'selected' : '' ?>>
                                        <?= $city['regency'] ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Alamat KTP-->
            <div class="mb-3">
                <label for="alamat" class="form-label">Detail Alamat Sesuai KTP<span class="text-danger">*</span></label>
                <textarea class="form-control" name="alamat" id="alamat" style="height: 90px" required><?= esc($user_data->alamat) ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Pilih Provinsi Domisili -->
                    <div class="mb-3">
                        <label for="stateDom_id" class="form-label">Provinsi Domisili</label>
                        <select id="stateDom_id" name="stateDom_id" class="form-select select2">
                            <option value="" disabled selected hidden>Pilih Provinsi</option>
                            <?php foreach ($listState as $item): ?>
                                <option value="<?= $item['id'] ?>" <?= $item['id'] == $user_data->provinceDom_id ? 'selected' : '' ?>>
                                    <?= $item['province'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Pilih Kota Domisili -->
                    <div class="mb-3">
                        <label for="cityDom_id" class="form-label">Kota/Kabupaten Domisili</label>
                        <select id="cityDom_id" name="cityDom_id" class="form-select select2">
                            <option value="" disabled selected hidden>Pilih Kota</option>
                            <?php if (!empty($listCityDom)): ?>
                                <?php foreach ($listCityDom as $city): ?>
                                    <option value="<?= $city['id'] ?>" <?= $city['id'] == $user_data->cityDom_id ? 'selected' : '' ?>>
                                        <?= $city['regency'] ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Alamat Domisili -->
            <div class="mb-3">
                <label for="domisili" class="form-label">Detail Alamat Domisili</label>
                <textarea class="form-control" name="domisili" id="domisili" style="height: 90px"><?= esc($user_data->domisili) ?></textarea>
            </div>
            <!-- Tombol Simpan -->
            <div class="d-grid">
                <button class="btn btn-primary btn-lg" type="submit" name="submit">Simpan Data</button>
            </div>
        </form>

    </div>
    </div>
    <!-- Tab Content Akademik -->
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

                    <!-- Instansi (Select2) -->
                    <div class="mb-3">
                        <label for="instansi" class="form-label" id="label-instansi">Perguruan Tinggi <span class="text-danger">*</span></label>
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
                        <label for="jurusan" class="form-label">Jurusan <span class="text-danger">*</span></label>
                        <select class="form-select select2" name="jurusan" id="jurusan" required>
                            <option value="" disabled selected hidden>Pilih Jurusan</option>
                            <?php foreach ($jurusan as $item): ?>
                                <option value="<?= $item['id']; ?>" <?= ($user_data->jurusan == $item['id']) ? 'selected' : '' ?>>
                                    <?= $item['nama_jurusan']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Semester -->
                    <div class="mb-3" id="group-semester">
                        <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="semester" id="semester" value="<?= esc($user_data->semester) ?>">
                    </div>

                    <!-- Nilai/IPK -->
                    <div class="mb-3">
                        <label for="nilai_ipk" class="form-label" id="label-nilai">Nilai/IPK <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" name="nilai_ipk" id="nilai_ipk" value="<?= number_format($user_data->nilai_ipk, 2, '.', '') ?>" required>
                        <small class="text-muted" id="help-nilai">Gunakan titik (.) sebagai pemisah desimal, contoh: 3.50</small>
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

<!-- Script Dinamis -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pendidikan = document.getElementById('pendidikan');
        const labelInstansi = document.getElementById('label-instansi');
        const groupSemester = document.getElementById('group-semester');
        const labelNilai = document.getElementById('label-nilai');
        const helpNilai = document.getElementById('help-nilai');

        function toggleFields() {
            const isSMA = pendidikan.value === 'SMA/SMK';

            // Ganti label instansi
            labelInstansi.innerHTML = isSMA ? 'Sekolah <span class="text-danger">*</span>' : 'Perguruan Tinggi <span class="text-danger">*</span>';

            // Sembunyikan/tampilkan semester
            groupSemester.style.display = isSMA ? 'none' : 'block';

            // Ubah label dan helper untuk nilai/IPK
            labelNilai.innerHTML = isSMA ? 'Nilai <span class="text-danger">*</span>' : 'Nilai/IPK <span class="text-danger">*</span>';
            helpNilai.textContent = isSMA
                ? 'Gunakan titik (.) sebagai pemisah desimal, contoh: 85.00'
                : 'Gunakan titik (.) sebagai pemisah desimal, contoh: 3.50';
        }

        // Inisialisasi saat halaman dimuat
        toggleFields();

        // Event saat pendidikan diubah
        pendidikan.addEventListener('change', toggleFields);
    });
</script>



</div>
<!-- End Tab Data Profil -->
<!-- jQuery (required for Select2) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#instansi, #jurusan, #state_id, #stateDom_id').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: function(){
            $(this).data('placeholder');
        },
        allowClear: true
    });

    // Reset kota ketika provinsi sesuai KTP diubah
    $('#state_id').on('change', function () {
        $('#city_id').val(null).trigger('change');
    });

    // Reset kota ketika provinsi domisili diubah
    $('#stateDom_id').on('change', function () {
        $('#cityDom_id').val(null).trigger('change');
    });

    // Untuk kota sesuai KTP
    $('#city_id').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: 'Pilih Kota',
        allowClear: true,
        ajax: {
            url: '<?= base_url(); ?>/api/kota',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    state_id: $('#state_id').val(), // ini sudah benar
                    searchTerm: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.data
                };
            },
            cache: true
        }
    });

    // Untuk kota domisili
    $('#cityDom_id').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: 'Pilih Kota',
        allowClear: true,
        ajax: {
            url: '<?= base_url(); ?>/api/kotaDom',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    stateDom_id: $('#stateDom_id').val(), // pastikan ini sesuai
                    searchTerm: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.data
                };
            },
            cache: true
        }
    });


});
</script>



<?= $this->endSection(); ?>