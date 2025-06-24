<?= $this->extend('templates/index'); ?>
<?= $this->section('content'); ?>
<style>
    .hero-section {
      background: linear-gradient(to right, #f0f4ff, #ffffff);
      padding: 80px 0;
    }
    .job-card {
      border: 1px solid #dee2e6;
      border-radius: 12px;
      padding: 20px;
      background-color: #fff;
      margin-bottom: 20px;
    }
    .footer {
      background-color: #f8f9fa;
      padding: 40px 0;
    }
    .faq-section {
      background: #f8f9fc;
      padding: 60px 0;
    }
</style>

  <!-- Hero Section -->
<header class="masthead hero-section">
    <div class="container px-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-8">
                <br><br><br><br>
                <!-- Mashead text and app badges-->
                <div class="mb-5 mb-lg-0 text-center text-lg-start">
                    <br><br>
                    <h1 class="display-1 lh-1 mb-3">Magang <br>PT Semen Padang</h1>
                    <p class="lead fw-normal text-muted mb-5">Daftarkan magang dan penelitianmu di website magang <br> PT Semen Padang</p>
                    <?php if (logged_in()) : ?>
                        <!-- Kalau sudah login -->
                        <a href="<?= base_url('/lowongan'); ?>" class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0">
                            <span class="d-flex align-items-center">
                                <span class="medium">Daftar Sekarang </span>
                            </span>
                        </a>
                    <?php else : ?>
                        <!-- Kalau belum login -->
                        <a href="javascript:void(0);" class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <span class="d-flex align-items-center">
                                <span class="medium">Daftar Sekarang </span>
                            </span>
                        </a>

                        <!-- Modal -->
                        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-3">
                            <div class="modal-header">
                                <h5 class="modal-title" id="loginModalLabel">Peringatan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p>Anda harus login terlebih dahulu untuk mendaftar.</p>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <a href="<?= base_url('/login'); ?>" class="btn btn-primary rounded-pill px-4">Login</a>
                            </div>
                            </div>
                        </div>
                        </div>
                    <?php endif; ?>

                </div>
                <br><br><br>
            </div>
            <div class="col-lg-4">
                <!-- bisa di isi gambar dll -->
            </div>
        </div>
    </div>
</header>
  <section class="hero-section">
    <div class="container text-center">
      <h1 class="mb-4">Temukan kesempatan magang di berbagai unit di perusahaan <span class="text-primary">PT Semen Padang</span></h1>
      <p class="lead">Bergabung dengan PT Semen Padang Hari Ini dan Temukan Pengalaman yang Paling Sesuai untuk Anda</p>
    </div>
  </section>

  <!-- Job Filter Section -->
  <section class="container py-5">
    <div class="row mb-4">
      <div class="col-md-3 mb-2"><input type="text" class="form-control" placeholder="Posisi"></div>
      <div class="col-md-3 mb-2"><input type="text" class="form-control" placeholder="Perusahaan"></div>
      <div class="col-md-2 mb-2"><input type="text" class="form-control" placeholder="Lokasi"></div>
      <div class="col-md-2 mb-2"><input type="text" class="form-control" placeholder="Jurusan"></div>
      <div class="col-md-2 mb-2">
        <button class="btn btn-primary w-100">Cari</button>
      </div>
    </div>
<?php if ($periode): ?>
    <div class="row">
    <?php foreach ($data_unit as $unit): ?>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <!-- <img src="/img/sp-black.png" alt="Logo Semen Padang" style="height: 50px;"> -->
                    </div>
                    <!-- <h6 class="text-muted mb-1">PT Semen Padang</h6> -->
                    <h5 class="fw-bold mb-2"><?= esc($unit['unit_kerja']) ?></h5>
                    <?php if(!is_null($unit['jurusan'])): ?>
                    <p class="text-muted mb-2"><?= esc($unit['jurusan']) ?></p>
                    <?php else : ?>
                    <p class="text-muted mb-2">Semua Jurusan</p>
                    <?php endif; ?>
                    <p class="text-muted mb-1">Tingkat : <?= esc($unit['tingkat_pendidikan']) ?></p>
                    <p><strong><?= $unit['tersedia'] ?> Posisi</strong></p>
                    <div class="mb-2">
                        <span class="badge <?= $unit['tersedia'] > 0 ? 'bg-success' : 'bg-secondary' ?>">
                            <?= $unit['tersedia'] > 0 ? 'Tersedia' : 'Penuh' ?>
                        </span>
                        <!-- <span class="badge bg-light text-dark">Onsite</span> -->
                    </div>
                    <hr>

                    <p class="text-danger fw-semibold mb-3">Penutupan: <?= date('d M Y', strtotime($periode->tanggal_tutup)) ?></p>
                      <?php if (logged_in()) : ?>
                          <?php if ($isProfilComplite) : ?>
                            <button
                            class="btn btn-outline-primary w-100 btn-daftar"
                            data-bs-toggle="modal"
                            data-bs-target="#modalPendaftaran"
                            data-unit-id="<?= $unit['id'] ?>"
                            >
                            Daftar Sekarang <i class="bi bi-arrow-right"></i>
                            </button>
                        <?php else : ?>
                            <button class="btn btn-outline-warning w-100" data-bs-toggle="modal" data-bs-target="#modalLengkapiProfil">
                                Lengkapi Profil <i class="bi bi-exclamation-circle"></i>
                            </button>
                        <?php endif; ?>

                      <?php else : ?>
                            <!-- Kalau belum login -->
                            <a href="/pendaftaran" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Daftar Sekarang <i class="bi bi-arrow-right"></i></a>

                            <!-- Modal -->
                            <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-3">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="loginModalLabel">Peringatan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <p>Anda harus login terlebih dahulu untuk mendaftar.</p>
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <a href="<?= base_url('/login'); ?>" class="btn btn-primary rounded-pill px-4">Login</a>
                                </div>
                                </div>
                            </div>
                            </div>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
<div class="alert alert-warning text-center">
        <strong>Pendaftaran Magang PT Semen Padang Belum Dibuka Saat Ini.</strong><br>
        Silakan cek kembali pada minggu ke-dua setiap bulannya.
    </div>
<?php endif; ?>
    </div>

<?php if (logged_in()) : ?>
<!-- Modal Pendaftaran -->
<div class="modal fade" id="modalPendaftaran" tabindex="-1" aria-labelledby="modalPendaftaranLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-4">
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title fw-bold" id="modalPendaftaranLabel">Konfirmasi Pendaftaran</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p class="mb-4">Silakan periksa kembali dokumen Anda sebelum mendaftar.</p>

        <form id="formPendaftaran">
          <div class="mb-3">
            <label class="form-label fw-semibold">CV <span class="text-danger">*</span></label>
            <input type="text" class="form-control" value="<?= esc(user()->cv ?? '-') ?>" disabled>
          </div>
          <?php if (user()->pendidikan !== 'SMA/SMK') : ?>
          <div class="mb-3">
            <label class="form-label fw-semibold">Proposal <span class="text-danger">*</span></label>
            <input type="text" class="form-control" value="<?= esc(user()->proposal ?? '-') ?>" disabled>
          </div>
          <?php endif; ?>
          <div class="mb-3">
            <label class="form-label fw-semibold">Surat Permohonan Kampus <span class="text-danger">*</span></label>
            <input type="text" class="form-control" value="<?= esc(user()->surat_permohonan ?? '-') ?>" disabled>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Durasi Magang <span class="text-danger">*</span></label>
            <select class="form-select" name="durasi" id="durasiSelect" required>
            <option value="">-- Pilih Durasi --</option>
            <?php for ($i = 1; $i <= 6; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?> bulan</option>
            <?php endfor; ?>
            </select>
            </div>
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Kembali</button>
        <button type="button" class="btn btn-primary rounded-pill" id="btnKonfirmasiDaftar">Daftar Sekarang</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Final -->
<div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-labelledby="modalKonfirmasiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-sm rounded-4">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Konfirmasi Pendaftaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-4">Apakah Anda yakin ingin mendaftar di unit ini?</p>
        <div class="d-flex justify-content-center gap-2">
          <form method="post" action="<?= base_url('magang/daftar') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="durasi" id="durasiHidden">
            <input type="hidden" name="unit_id" id="unitIdHidden">
            <button type="submit" class="btn btn-success rounded-pill px-4">Ya, Daftar</button>
          </form>
          <button class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Lengkapi Profil -->
<div class="modal fade" id="modalLengkapiProfil" tabindex="-1" aria-labelledby="modalLengkapiProfilLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header bg-warning text-dark rounded-top-4">
        <h5 class="modal-title fw-bold">Lengkapi Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p>Anda perlu melengkapi profil terlebih dahulu untuk dapat mendaftar.</p>
      </div>
      <div class="modal-footer justify-content-center">
        <a href="<?= base_url('/profile') ?>" class="btn btn-warning rounded-pill px-4">Lengkapi Sekarang</a>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
<script>
let selectedUnitId = null;

document.querySelectorAll('.btn-daftar').forEach(button => {
  button.addEventListener('click', function () {
    selectedUnitId = this.getAttribute('data-unit-id');
  });
});

document.getElementById('btnKonfirmasiDaftar').addEventListener('click', function () {
  const durasi = document.getElementById('durasiSelect').value;
  if (!durasi) {
    alert('Silakan pilih durasi magang.');
    return;
  }

  document.getElementById('durasiHidden').value = durasi;
  document.getElementById('unitIdHidden').value = selectedUnitId;

  const modalPendaftaran = bootstrap.Modal.getInstance(document.getElementById('modalPendaftaran'));
  modalPendaftaran.hide();

  const modalKonfirmasi = new bootstrap.Modal(document.getElementById('modalKonfirmasi'));
  modalKonfirmasi.show();
});
</script>


  </section>

  <!-- FAQ Section -->
  <section class="faq-section">
    <div class="container">
      <h2 class="text-center mb-4">Pertanyaan yang Sering Ditanyakan</h2>
      <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">Apakah saya bisa mendaftar lebih dari satu lowongan?</button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse show">
            <div class="accordion-body">Ya, Anda bisa mendaftar lebih dari satu lowongan.</div>
          </div>
        </div>
        <!-- Tambah pertanyaan lainnya sesuai gambar -->
      </div>
    </div>
  </section>

<?= $this->endSection();?>