<?= $this->extend('user/template'); ?>
<?= $this->section('main-content'); ?>
<?php if (session()->getFlashdata('success')): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Sukses',
    text: '<?= session()->getFlashdata('success') ?>',
    timer: 2000,
    showConfirmButton: false
});
</script>
<?php elseif (session()->getFlashdata('error')): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '<?= session()->getFlashdata('error') ?>'
});
</script>
<?php endif; ?>

<!-- Flash Sukses dn error-->
<div class="profile-card">

    <!-- Flash message -->
    <?php if (session()->getFlashdata('message')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('message') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Tabs -->
    <ul class="nav nav-tabs profile-tabs mb-4" id="profileTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="data-pribadi-tab" data-bs-toggle="tab" data-bs-target="#data-pribadi" type="button" role="tab">Data Pribadi</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="data-akademik-tab" data-bs-toggle="tab" data-bs-target="#data-akademik" type="button" role="tab">Data Akademik</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="dokumen-tab" data-bs-toggle="tab" data-bs-target="#dokumen" type="button" role="tab">Dokumen</button>
        </li>
    </ul>

    <div class="tab-content" id="profileTabContent">

        <!-- Data Pribadi -->
        <div class="tab-pane fade show active" id="data-pribadi" role="tabpanel">
            <div class="card p-4 shadow-sm rounded-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Data Pribadi</h5>
                    <a href="/data-pribadi" class="text-muted" title="Edit"><i class="bi bi-pencil-square fs-5"></i></a>
                </div>
                <p class="text-muted mb-4">Pastikan data pribadi benar untuk mempermudah proses pendaftaran.</p>

                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="mb-1 fw-semibold">Nama Lengkap</p>
                        <p class="text-muted"><?= esc($user_data->fullname ?? 'Data belum diisi'); ?></p>
                        <p class="mb-1 fw-semibold">NISN/NIM</p>
                        <p class="text-muted"><?= esc($user_data->nisn_nim ?? 'Data belum diisi'); ?></p>
                        <p class="mb-1 fw-semibold">Email</p>
                        <p class="text-muted"><?= esc($user_data->email ?? 'Data belum diisi'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 fw-semibold">Jenis Kelamin</p>
                        <p class="text-muted">
                            <?php if ($user_data->jenis_kelamin === 'L') : ?>
                                Laki-Laki
                            <?php elseif ($user_data->jenis_kelamin === 'P') : ?>
                                Perempuan
                            <?php else : ?>
                                Data belum diisi
                            <?php endif; ?>
                        </p>
                        <p class="mb-1 fw-semibold">No Handphone</p>
                        <p class="text-muted"><?= esc($user_data->no_hp ?? 'Data belum diisi'); ?></p>
                    </div>
                </div>

                <p class="mb-1 fw-semibold">Alamat Sesuai KTP</p>
                <p class="text-muted">
                    <?php
                        $alamat = $user_data->alamat ?? '';
                        $kota = trim(($user_data->tipe_kota_ktp ?? '') . ' ' . ($user_data->kota_ktp ?? ''));
                        $prov = $user_data->provinsi_ktp ?? '';
                        $parts = array_filter([$alamat, $kota, $prov]);
                        echo esc(implode(', ', $parts)) ?: 'Data belum diisi';
                    ?>
                </p>

                <p class="mb-1 fw-semibold">Alamat Domisili</p>
                <p class="text-muted">
                    <?php
                        $alamat = $user_data->domisili ?? '';
                        $kota = trim(($user_data->tipe_kota_domisili ?? '') . ' ' . ($user_data->kota_domisili ?? ''));
                        $prov = $user_data->provinsi_domisili ?? '';
                        $parts = array_filter([$alamat, $kota, $prov]);
                        echo esc(implode(', ', $parts)) ?: 'Data belum diisi';
                    ?>
                </p>
            </div>
        </div>

        <!-- Data Akademik -->
        <div class="tab-pane fade" id="data-akademik" role="tabpanel">
            <div class="card p-4 shadow-sm rounded-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Informasi Akademik</h5>
                    <a href="/data-pribadi" class="text-muted" title="Edit"><i class="bi bi-pencil-square fs-5"></i></a>
                </div>
                <p class="text-muted mb-4">Pastikan data akademik benar untuk mempermudah proses pendaftaran.</p>

                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="mb-1 fw-semibold">Tingkat Pendidikan</p>
                        <p class="text-muted"><?= esc($user_data->tingkat_pendidikan ?? 'Data belum diisi'); ?></p>
                        <p class="mb-1 fw-semibold">Sekolah/Perguruan Tinggi</p>
                        <p class="text-muted"><?= esc($user_data->nama_instansi ?? 'Data belum diisi'); ?></p>
                        <p class="mb-1 fw-semibold">Jurusan</p>
                        <p class="text-muted"><?= esc($user_data->nama_jurusan ?? 'Data belum diisi'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 fw-semibold">Semester</p>
                        <p class="text-muted"><?= esc($user_data->semester ?? 'Data belum diisi'); ?></p>
                        <p class="mb-1 fw-semibold">Nilai rata-rata/IPK</p>
                        <p class="text-muted"><?= esc($user_data->nilai_ipk ?? 'Data belum diisi'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dokumen -->
        <div class="tab-pane fade" id="dokumen" role="tabpanel">
            <div class="card p-4 shadow-sm rounded-4">
                <h5 class="fw-bold mb-3">Kelengkapan Dokumen</h5>
                <p class="text-muted mb-4">Lengkapi dokumen untuk mempermudah proses pendaftaran magang. <br><small class="text-danger">*Wajib diisi</small></p>

                <?php 
                $docs = [
                    ['cv', 'Curriculum Vitae', true],
                    ['proposal', 'Proposal', false],
                    ['surat_permohonan', 'Surat Permohonan', true],
                    ['ktp_kk', 'KTP/KK', false],
                    ['bpjs_kes', 'BPJS Kesehatan', false],
                    ['bpjs_tk', 'BPJS Ketenagakerjaan', false],
                    ['buktibpjs_tk', 'Bukti Pembayaran BPJS TK', false],
                ];
                foreach ($docs as [$field, $label, $wajib]) :
                    $is_uploaded = !empty($user_data->$field);
                    $uploadId = ucfirst($field) . "File";
                ?>
                <div class="border rounded p-3 mb-3 bg-light">
                    <h6 class="fw-semibold mb-2"><?= $label ?><?= $wajib ? '<span class="text-danger">*</span>' : '' ?></h6>
                    <?php if ($is_uploaded): ?>
                        <div class="d-flex justify-content-between align-items-center">
                            <div><i class="bi bi-file-earmark-text me-2"></i><?= esc($user_data->$field) ?></div>
                            <div>
                                <a href="<?= base_url('uploads/' . $field . '/' . $user_data->$field) ?>" target="_blank" class="btn btn-sm btn-outline-info">Lihat</a>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete<?= ucfirst($field) ?>(<?= $user_data->id ?>)">Delete</button>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-muted">Dokumen belum diupload</div>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="document.getElementById('<?= $uploadId ?>').click();">Upload file</button>
                        <input type="file" name="<?= $field ?>" id="<?= $uploadId ?>" style="display:none;" onchange="upload<?= ucfirst($field) ?>(this)">
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>

<!-- End Tab Data Profil -->

<script>
    function uploadCV(input) {
        if (input.files.length === 0) return;

        const file = input.files[0];
        const formData = new FormData();
        formData.append('cv', file);

        fetch("<?= base_url('cv/uploads/') . ($user_data->id ?? 'null') ?>", {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Upload gagal. Silakan coba lagi.'
            });
            console.error('Upload error:', error);
        });
    }

    function confirmDeleteCV(userId) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Dok umen CV akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
            
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke URL delete
                window.location.href = "<?= base_url('cv/delete') ?>/" + userId;
            }
        });
    }

    function uploadProposal(input) {
        if (input.files.length === 0) return;

        const file = input.files[0];
        const formData = new FormData();
        formData.append('proposal', file);

        fetch('<?= base_url('proposal/uploads/') . ($user_data->id ?? 'null') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Upload gagal. Silakan coba lagi.'
            });
            console.error('Upload error:', error);
        });
    }

    function confirmDeleteProposal(userId) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Dokumen Proposal akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
            
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke URL delete
                window.location.href = "<?= base_url('proposal/delete') ?>/" + userId;
            }
        });
    }

    document.getElementById('uploadSuratForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch("<?= base_url('surat-permohonan/uploads/') . ($user_data->id ?? 'null') ?>", {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message
                });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat upload.'
            });
        });
    });

    function confirmDeleteSurat(userId) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Dokumen Surat Permohonan akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
            
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke URL delete
                window.location.href = "<?= base_url('surat-permohonan/delete') ?>/" + userId;
            }
        });
    }

    function uploadKTPKK(input) {
        if (input.files.length === 0) return;

        const file = input.files[0];
        const formData = new FormData();
        formData.append('ktp', file);

        fetch('<?= base_url('ktp-kk/uploads/') . ($user_data->id ?? 'null') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Upload gagal. Silakan coba lagi.'
            });
            console.error('Upload error:', error);
        });
    }

    function confirmDeleteKTP(userId) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Dokumen akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
            
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke URL delete
                window.location.href = "<?= base_url('ktp/delete') ?>/" + userId;
            }
        });
    }

    function uploadBPJSKes(input) {
        if (input.files.length === 0) return;

        const file = input.files[0];
        const formData = new FormData();
        formData.append('bpjs_kes', file);

        fetch('<?= base_url('bpjs-kes/uploads/') . ($user_data->id?? 'null') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Upload gagal. Silakan coba lagi.'
            });
            console.error('Upload error:', error);
        });
    }

    function confirmDeleteBPJSKes(userId) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Dokumen BPJS Kesehatan akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
            
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke URL delete
                window.location.href = "<?= base_url('bpjs-kes/delete') ?>/" + userId;
            }
        });
    }

    function uploadBPJSTK(input) {
        if (input.files.length === 0) return;

        const file = input.files[0];
        const formData = new FormData();
        formData.append('bpjs_tk', file);

        fetch('<?= base_url('bpjs-tk/uploads/') . ($user_data->id ?? 'null') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Upload gagal. Silakan coba lagi.'
            });
            console.error('Upload error:', error);
        });
    }

    function confirmDeleteBPJSTK(userId) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Dokumen BPJS Ketenagakerjaan akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
            
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke URL delete
                window.location.href = "<?= base_url('bpjs-tk/delete') ?>/" + userId;
            }
        });
    }

    function uploadBuktiBPJSTK(input) {
        if (input.files.length === 0) return;

        const file = input.files[0];
        const formData = new FormData();
        formData.append('buktibpjs_tk', file);

        fetch('<?= base_url('buktibpjs-tk/uploads/') . ($user_data->id ?? 'null') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Upload gagal. Silakan coba lagi.'
            });
            console.error('Upload error:', error);
        });
    }

    function confirmDeleteBuktiBPJSTK(userId) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Dokumen Bukti Pembayaran BPJS Ketenagakerjaan akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
            
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke URL delete
                window.location.href = "<?= base_url('buktibpjs-tk/delete') ?>/" + userId;
            }
        });
    }


</script>

<?= $this->endSection(); ?>