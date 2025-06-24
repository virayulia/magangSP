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
<!-- END Flash Sukses dn error-->

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
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="dokumen-tab" data-bs-toggle="tab" data-bs-target="#dokumen" type="button" role="tab">
        Dokumen
        </button>
    </li>
    </ul>
    <!-- Tab Content Profil-->
    <div class="tab-content" id="profileTabContent">
    <div class="tab-pane fade show active" id="data-pribadi" role="tabpanel">
        <div class="card p-4">
        <h5 class="fw-bold">Data Pribadi  
            <a href="/data-pribadi" class="text-decoration-none text-muted" title="Edit Data Pribadi">
                <i class="bi bi-pencil-square"></i>
            </a>
        </h5>
        <p class="text-muted">Pastikan data pribadi benar untuk mempermudah proses pendaftaran</p>
        <hr>
        <!-- <p><strong class="d-block">Tentang Saya</strong></p>
        <p class="text-muted">
            Saya adalah mahasiswa tingkat akhir Jurusan Sistem Informasi di Universitas Andalas dengan IPK 3.7. Saya memiliki pemahaman yang kuat dalam teknologi informasi dan pemrograman, khususnya dalam pengembangan web. Selain itu, saya terlatih dalam manajemen data serta pengelolaan database, termasuk SQL. Saya memiliki motivasi tinggi untuk terus tumbuh dan berkembang, serta bertanggung jawab dalam setiap pekerjaan. Saya juga mampu bekerja secara efektif, baik secara mandiri maupun dalam tim.
        </p> -->
        <div class="row">
            <div class="col-md-6">
            <p><strong>Nama Lengkap</strong></p>
            <p class="text-muted"><?= esc($user_data->fullname ?? 'Data belum diisi'); ?></p>
            <p><strong>NISN/NIM</strong> </p>
            <p class="text-muted"><?= esc($user_data->nisn_nim ?? 'Data belum diisi'); ?></p>
            <p><strong>Email</strong> </p>
            <p class="text-muted"><?= esc($user_data->email ?? 'Data belum diisi'); ?></p>
            <!-- <p><strong>Tempat Lahir</strong></p>
            <p class="text-muted"><?= esc($user_data->tempat_lahir ?? 'Data belum diisi'); ?></p>
            <p><strong>Tanggal Lahir</strong></p>
            <p class="text-muted"><?= esc($user_data->tanggal_lahir ?? 'Data belum diisi'); ?></p> -->
            </div>
            <div class="col-md-6">
            <p><strong>Jenis Kelamin</strong> </p>
            <?php if (esc($user_data->jenis_kelamin === 'L')) :?>
            <p class="text-muted">Laki-Laki</p>
            <?php elseif (esc($user_data->jenis_kelamin === 'P')): ?>
            <p class="text-muted">Perempuan</p>
            <?php else: ?>
            <p class="text-muted">Data belum diisi</p>
            <?php endif; ?>
            <p><strong>No Handphone</strong></p>
            <p class="text-muted"><?= esc($user_data->no_hp ?? 'Data belum diisi'); ?></p>
            </div>
        </div>

            <p><strong>Alamat Sesuai KTP</strong><br></p>
            <p class="text-muted">
                <?php
                    $alamat = $user_data->alamat ?? '';
                    $kota   = ($user_data->tipe_kota_ktp ?? '') . ' ' . ($user_data->kota_ktp ?? '');
                    $prov   = $user_data->provinsi_ktp ?? '';

                    $parts = array_filter([$alamat, trim($kota), $prov]);
                    echo esc(implode(', ', $parts)) ?: 'Data belum diisi';
                ?>
            </p>

            <p><strong>Alamat Domisili</strong><br></p>
            <p class="text-muted">
                <?php
                    $alamat = $user_data->domisili ?? '';
                    $kota   = ($user_data->tipe_kota_domisili ?? '') . ' ' . ($user_data->kota_domisili ?? '');
                    $prov   = $user_data->provinsi_domisili ?? '';

                    $parts = array_filter([$alamat, trim($kota), $prov]);
                    echo esc(implode(', ', $parts)) ?: 'Data belum diisi';
                ?>
            </p>



        </div>
    </div>
    </div>

    <!-- Tab Content Akademik-->
    <div class="tab-content" id="profileTabContent">
        <div class="tab-pane fade show non-active" id="data-akademik" role="tabpanel">
            <div class="card p-4">
            <h5 class="fw-bold">Informasi Akademik
                <a href="/data-pribadi" class="text-decoration-none text-muted" title="Edit Data Akademik">
                    <i class="bi bi-pencil-square"></i>
                </a>
            </h5>
            
            <p class="text-muted">Pastikan data akademik benar untuk mempermudah proses pendaftaran</p>
            <hr>
            <div class="row">
                <div class="col-md-6">
                <p><strong>Tingkat Pendidikan</strong></p>
                <p class="text-muted"><?= esc($user_data->pendidikan ?? 'Data belum diisi'); ?></p>
                <p><strong>Sekolah/Perguruan Tinggi</strong></p>
                <p class="text-muted"><?= esc($user_data->nama_instansi ?? 'Data belum diisi'); ?></p>
                <p><strong>Jurusan</strong> </p>
                <p class="text-muted"><?= esc($user_data->nama_jurusan ?? 'Data belum diisi'); ?></p>
                </div>
                <div class="col-md-6">
                <p><strong>Semester</strong></p>
                <p class="text-muted"><?= esc($user_data->semester ?? 'Data belum diisi'); ?></p>
                <p><strong>Nilai rata-rata/IPK</strong></p>
                <p class="text-muted"><?= esc($user_data->nilai_ipk ?? 'Data belum diisi'); ?></p>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="tab-content" id="profileTabContent">
        <div class="tab-pane fade show non-active" id="dokumen" role="tabpanel">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">
                Kelengkapan Dokumen
                </h5>
                <p class="text-muted mb-4">Lengkapi dokumen untuk mempermudah proses pendaftaran magang.
                    <br><small class="text-danger">*Wajib diisi</small>
                </p>

                <!-- Dokumen: CV -->
                <div class="border rounded p-3 mb-3">
                    <h6 class="fw-semibold mb-2">Curriculum Vitae<span class="text-danger">*</span></h6>

                    <div class="d-flex justify-content-between align-items-center">
                        <?php if (!empty($user_data->cv)): ?>
                            <div>
                                <i class="bi bi-file-earmark-text me-2"></i> <?= esc($user_data->cv) ?>
                            </div>
                            <div>
                                <a href="<?= base_url('uploads/cv/' . $user_data->cv) ?>" target="_blank" class="btn btn-sm btn-info me-2">Lihat file</a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirmDeleteCV(<?= $user_data->id ?>)">
                                    Delete
                                </button>                            
                            </div>
                        <?php else: ?>
                            <div class="text-muted">Dokumen belum diupload</div>
                            <div>
                                <!-- Tombol trigger -->
                                <button type="button" class="btn btn-sm btn-primary me-2" onclick="document.getElementById('cvFile').click();">Upload file</button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- File input tersembunyi -->
                    <input type="file" name="cv" id="cvFile" style="display:none;" onchange="uploadCV(this)">
                    
                    <!-- Alert hasil upload -->
                    <div id="uploadMessage" class="mt-2"></div>
                </div>

                <!-- Dokumen: Proposal -->
                <div class="border rounded p-3 mb-3">
                    <h6 class="fw-semibold mb-2">Proposal</h6>

                    <div class="d-flex justify-content-between align-items-center">
                        <?php if (!empty($user_data->proposal)): ?>
                            <div>
                                <i class="bi bi-file-earmark-text me-2"></i> <?= esc($user_data->proposal) ?>
                            </div>
                            <div>
                                <a href="<?= base_url('uploads/proposal/' . $user_data->proposal) ?>" target="_blank" class="btn btn-sm btn-info me-2">Lihat file</a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirmDeleteProposal(<?= $user_data->id ?>)">
                                    Delete
                                </button>                            
                            </div>
                        <?php else: ?>
                            <div class="text-muted">Dokumen belum diupload</div>
                            <div>
                                <!-- Tombol trigger -->
                                <button type="button" class="btn btn-sm btn-primary me-2" onclick="document.getElementById('proposalFile').click();">Upload file</button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- File input tersembunyi -->
                    <input type="file" name="proposal" id="proposalFile" style="display:none;" onchange="uploadProposal(this)">
                    
                    <!-- Alert hasil upload -->
                    <div id="uploadMessageProposal" class="mt-2"></div>
                </div>

                <!-- Dokumen: Surat Permohonan -->
                <div class="border rounded p-3 mb-3">
                    <h6 class="fw-semibold mb-2">Surat Permohonan<span class="text-danger">*</span></h6>

                    <?php if (!empty($user_data->surat_permohonan)): ?>
                        <!-- Bagian atas: file -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <i class="bi bi-file-earmark-text me-2"></i> <?= esc($user_data->surat_permohonan) ?>
                            </div>
                            <div>
                                <a href="<?= base_url('uploads/surat_permohonan/' . $user_data->surat_permohonan) ?>" target="_blank" class="btn btn-sm btn-info me-2">Lihat file</a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirmDeleteSurat(<?= $user_data->id ?>)">
                                    Delete
                                </button>  
                            </div>
                        </div>

                        <!-- Informasi detail -->
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <p class="mb-1"><strong>No. Surat</strong></p>
                                <p class="text-muted"><?= esc($user_data->no_surat) ?></p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1"><strong>Tanggal Surat</strong></p>
                                <p class="text-muted"><?= esc(date('d-m-Y', strtotime($user_data->tanggal_surat))) ?></p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1"><strong>Pimpinan</strong></p>
                                <p class="text-muted"><?= esc($user_data->nama_pimpinan) ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p class="mb-1"><strong>Jabatan</strong></p>
                                <p class="text-muted"><?= esc($user_data->jabatan) ?></p>
                            </div>
                            <div class="col-md-8">
                                <p class="mb-1"><strong>Email</strong></p>
                                <p class="text-muted"><?= esc($user_data->email_instansi) ?></p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">Dokumen belum diupload</div>
                            <div>
                                <button type="button" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#uploadSuratModal">
                                    Upload file
                                </button>                                
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Dokumen: KTP/KK -->
                <div class="border rounded p-3 mb-3">
                    <h6 class="fw-semibold mb-2">KTP/KK</h6>

                    <div class="d-flex justify-content-between align-items-center">
                        <?php if (!empty($user_data->ktp_kk)): ?>
                            <div>
                                <i class="bi bi-file-earmark-text me-2"></i> <?= esc($user_data->ktp_kk) ?>
                            </div>
                            <div>
                                <a href="<?= base_url('uploads/ktp-kk/' . $user_data->ktp_kk) ?>" target="_blank" class="btn btn-sm btn-info me-2">Lihat file</a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirmDeleteKTP(<?= $user_data->id ?>)">
                                    Delete
                                </button>                            
                            </div>
                        <?php else: ?>
                            <div class="text-muted">Dokumen belum diupload</div>
                            <div>
                                <!-- Tombol trigger -->
                                <button type="button" class="btn btn-sm btn-primary me-2" onclick="document.getElementById('ktpFile').click();">Upload file</button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- File input tersembunyi -->
                    <input type="file" name="ktp_kk" id="ktpFile" style="display:none;" onchange="uploadKTPKK(this)">
                    
                    <!-- Alert hasil upload -->
                    <!-- <div id="uploadMessage" class="mt-2"></div> -->
                </div>

                <!-- Dokumen: BPJS Kes -->
                <div class="border rounded p-3 mb-3">
                    <h6 class="fw-semibold mb-2">BPJS Kesehatan</h6>

                    <div class="d-flex justify-content-between align-items-center">
                        <?php if (!empty($user_data->bpjs_kes)): ?>
                            <div>
                                <i class="bi bi-file-earmark-text me-2"></i> <?= esc($user_data->bpjs_kes) ?>
                            </div>
                            <div>
                                <a href="<?= base_url('uploads/bpjs_kes/' . $user_data->bpjs_kes) ?>" target="_blank" class="btn btn-sm btn-info me-2">Lihat file</a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirmDeleteBPJSKes(<?= $user_data->id ?>)">
                                    Delete
                                </button>                            
                            </div>
                        <?php else: ?>
                            <div class="text-muted">Dokumen belum diupload</div>
                            <div>
                                <!-- Tombol trigger -->
                                <button type="button" class="btn btn-sm btn-primary me-2" onclick="document.getElementById('bpjs_kesFile').click();">Upload file</button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- File input tersembunyi -->
                    <input type="file" name="bpjs_kes" id="bpjs_kesFile" style="display:none;" onchange="uploadBPJSKes(this)">
                    
                </div>

                <!-- Dokumen: BPJS TK -->
                <div class="border rounded p-3 mb-3">
                    <h6 class="fw-semibold mb-2">BPJS Ketenagakerjaan</h6>

                    <div class="d-flex justify-content-between align-items-center">
                        <?php if (!empty($user_data->bpjs_tk)): ?>
                            <div>
                                <i class="bi bi-file-earmark-text me-2"></i> <?= esc($user_data->bpjs_tk) ?>
                            </div>
                            <div>
                                <a href="<?= base_url('uploads/bpjs_tk/' . $user_data->bpjs_tk) ?>" target="_blank" class="btn btn-sm btn-info me-2">Lihat file</a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirmDeleteBPJSTK(<?= $user_data->id ?>)">
                                    Delete
                                </button>                            
                            </div>
                        <?php else: ?>
                            <div class="text-muted">Dokumen belum diupload</div>
                            <div>
                                <!-- Tombol trigger -->
                                <button type="button" class="btn btn-sm btn-primary me-2" onclick="document.getElementById('bpjs_tkFile').click();">Upload file</button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- File input tersembunyi -->
                    <input type="file" name="bpjs_tk" id="bpjs_tkFile" style="display:none;" onchange="uploadBPJSTK(this)">
                    
                </div>

                <!-- Dokumen: BUKTI BPJS TK -->
                <div class="border rounded p-3 mb-3">
                    <h6 class="fw-semibold mb-2">Bukti Pembayaran BPJS Ketenagakerjaan</h6>

                    <div class="d-flex justify-content-between align-items-center">
                        <?php if (!empty($user_data->buktibpjs_tk)): ?>
                            <div>
                                <i class="bi bi-file-earmark-text me-2"></i> <?= esc($user_data->buktibpjs_tk) ?>
                            </div>
                            <div>
                                <a href="<?= base_url('uploads/buktibpjs_tk/' . $user_data->buktibpjs_tk) ?>" target="_blank" class="btn btn-sm btn-info me-2">Lihat file</a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirmDeleteBuktiBPJSTK(<?= $user_data->id ?>)">
                                    Delete
                                </button>                            
                            </div>
                        <?php else: ?>
                            <div class="text-muted">Dokumen belum diupload</div>
                            <div>
                                <!-- Tombol trigger -->
                                <button type="button" class="btn btn-sm btn-primary me-2" onclick="document.getElementById('buktibpjs_tkFile').click();">Upload file</button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- File input tersembunyi -->
                    <input type="file" name="buktibpjs_tk" id="buktibpjs_tkFile" style="display:none;" onchange="uploadBuktiBPJSTK(this)">
                    
                </div>

                <!-- Modal Upload Surat Permohonan -->
                <div class="modal fade" id="uploadSuratModal" tabindex="-1" aria-labelledby="uploadSuratModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <form id="uploadSuratForm" enctype="multipart/form-data">
                        <div class="modal-header">
                        <h5 class="modal-title" id="uploadSuratModalLabel">Upload Surat Permohonan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="file_surat" class="form-label">File Surat (PDF)</label>
                                <input type="file" class="form-control" name="file_surat" id="file_surat" accept="application/pdf" required>
                            </div>
                            <div class="mb-3">
                                <label for="no_surat" class="form-label">No. Surat</label>
                                <input type="text" class="form-control" name="no_surat" id="no_surat" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                                <input type="date" class="form-control" name="tanggal_surat" id="tanggal_surat" required>
                            </div>
                            <div class="mb-3">
                                <label for="pimpinan" class="form-label">Nama Pimpinan</label>
                                <input type="text" class="form-control" name="pimpinan" id="pimpinan" required>
                            </div>
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan Pimpinan</label>
                                <input type="text" class="form-control" name="jabatan" id="jabatan" required>
                            </div>
                            <label for="email_instansi" class="form-label">
                                Email Instansi <small class="text-muted">(Alamat email resmi kampus/sekolah untuk pengiriman tembusan surat penerimaan Anda.)</small>
                            </label>

                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>


            </div>
        </div>
    </div>
    <!-- End Tab Content -->
</div>
<!-- End Tab Data Profil -->

<script>
    function uploadCV(input) {
        if (input.files.length === 0) return;

        const file = input.files[0];
        const formData = new FormData();
        formData.append('cv', file);

        fetch('<?= base_url('cv/uploads/' . $user_data->id) ?>', {
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
            text: "Dokumen CV akan dihapus permanen.",
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

        fetch('<?= base_url('proposal/uploads/' . $user_data->id) ?>', {
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

        fetch("<?= base_url('surat-permohonan/uploads/' . $user_data->id) ?>", {
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

        fetch('<?= base_url('ktp-kk/uploads/' . $user_data->id) ?>', {
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

        fetch('<?= base_url('bpjs-kes/uploads/' . $user_data->id) ?>', {
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

        fetch('<?= base_url('bpjs-tk/uploads/' . $user_data->id) ?>', {
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

        fetch('<?= base_url('buktibpjs-tk/uploads/' . $user_data->id) ?>', {
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