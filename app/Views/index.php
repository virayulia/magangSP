<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
<style>
    .select2-container--default
    .select2-selection--multiple
    .select2-selection__choice {
    background-color: #dc3545;
    border: none;
    color: white;
    padding: 4px 10px 4px 10px; /* Tambah padding kiri-kanan */
    margin-top: 4px;
    margin-right: 4px;
    border-radius: 6px;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    }

    .select2-container--default
    .select2-selection--multiple
    .select2-selection__choice__remove {
    position: relative;
    margin-right: 6px; /* Jarak X dengan teks */
    left: 0; /* pastikan tidak geser */
    color: rgba(255, 255, 255, 0.8);
    font-weight: bold;
    cursor: pointer;
    }

    .select2-container--default
    .select2-selection--multiple
    .select2-selection__choice__remove:hover {
    color: white;
    }

    .portfolio-img-wrapper {
      position: relative;
      width: 100%;
      padding-top: 100%; /* Rasio 1:1 (square) */
      overflow: hidden;
      border-radius: 8px; /* Kalau mau rounded, boleh dihapus */
    }

    .portfolio-img-wrapper img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease;
    }

    .portfolio-img-wrapper img:hover {
      transform: scale(1.05);
    }

</style>

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

<!-- Tambah AOS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" />

<!-- Masthead -->
<header class="masthead">
  <div class="container px-4 px-lg-5 h-100">
    <div class="row gx-4 gx-lg-5 h-100 align-items-start justify-content-start text-start" style="padding-top: 15rem;">
      <div class="col-lg-8" style="margin-left: -13px;" data-aos="fade-down" data-aos-delay="200">
        <h1 class="text-white font-weight-bold">
          Magang <br>PT Semen Padang
        </h1>
        <a class="btn btn-primary btn-xl mt-2" href="/register" data-aos="zoom-in" data-aos-delay="600">
          Daftar Sekarang
        </a>
      </div>
    </div>
  </div>
</header>

<!-- Program -->
<section class="page-section bg-primary" id="about">
  <div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center" data-aos="fade-up">
      <div class="col-lg-8 text-center">
        <h2 class="text-white mt-0">Program</h2>
        <hr class="divider divider-light" />
      </div>
    </div>
    <div class="row gx-4 gx-lg-5 mt-5 justify-content-center">
      <!-- Card Magang -->
      <div class="col-md-5 mb-4" data-aos="fade-right" data-aos-delay="300">
        <div class="card h-100 text-center shadow-lg rounded-5">
          <div class="card-body p-5">
            <i class="bi bi-briefcase-fill fs-1 text-primary mb-3"></i>
            <h5 class="h4 mb-2">Magang</h5>
            <p class="text-muted mb-4 text-justify">
              Program Magang di PT Semen Padang dirancang sebagai sarana pembelajaran langsung bagi pelajar dan mahasiswa untuk mengaplikasikan pengetahuan yang telah diperoleh selama studi ke dunia kerja nyata.
              <br><br> Melalui program ini, peserta magang akan mendapatkan pengalaman praktis di lingkungan industri, serta pemahaman yang lebih mendalam tentang proses kerja di perusahaan manufaktur terkemuka. 
              <br><br>Program ini juga menjadi jembatan untuk mengembangkan keterampilan profesional serta memperluas wawasan karier peserta.            </p>
            <a href="/register" class="btn btn-primary">Daftar Sekarang</a>
          </div>
        </div>
      </div>
      <!-- Card Penelitian -->
      <div class="col-md-5 mb-4" data-aos="fade-left" data-aos-delay="300">
        <div class="card h-100 text-center shadow-lg rounded-5">
          <div class="card-body p-5">
            <i class="bi bi-journal-bookmark-fill fs-1 text-primary mb-3"></i>
            <h5 class="h4 mb-2">Penelitian</h5>
            <p class="text-muted mb-4 text-justify">
              Program Penelitian PT Semen Padang ditujukan bagi mahasiswa dan dosen yang ingin melakukan penelitian akademik di lingkungan perusahaan.
              <br><br>Program ini mendukung penyusunan karya ilmiah seperti skripsi, tesis, maupun penelitian lainnya yang relevan dengan bidang industri semen dan operasional perusahaan. 
              <br><br>Dengan membuka akses terhadap data dan informasi yang diperlukan, PT Semen Padang memberikan kontribusi nyata dalam mendukung pengembangan ilmu pengetahuan dan teknologi di tingkat perguruan tinggi.            </p>
            <a href="/register" class="btn btn-primary">Daftar Sekarang</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Services -->
<section class="page-section" id="services">
  <div class="container px-4 px-lg-5">
    <h2 class="text-center mt-0" data-aos="fade-up">Lowongan</h2>
    <hr class="divider" data-aos="fade-up" />
    <div class="row gx-4 gx-lg-5">
      <!-- Job Filter Section -->

      <form method="GET" action="<?= base_url('/lowongan') ?>">
        <div class="row mb-4">
          <div class="col-md-4 mb-2">
          <select class="form-control select2" data-placeholder="Pilih Unit Kerja" name="unit_kerja[]" multiple>
              <?php foreach ($list_unit_kerja as $unit): ?>
                <option value="<?= $unit['unit_kerja'] ?>"><?= $unit['unit_kerja'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-3 mb-2">
            <select class="form-control select2" data-placeholder="Pilih Jenjang Pendidikan" name="pendidikan[]" multiple>
              <option value="SMA/SMK">SMA/SMK Sederajat</option>
              <option value="D3">D3</option>
              <option value="D4/S1">D4/S1</option>
              <option value="S2">S2</option>
            </select>
          </div>

          <div class="col-md-3 mb-2">
            <select class="form-control select2" data-placeholder="Pilih Jurusan" name="jurusan[]" multiple>
              <?php foreach ($list_jurusan as $jrs): ?>
                <option value="<?= $jrs['nama_jurusan'] ?>"><?= $jrs['nama_jurusan'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-2 mb-2">
            <button type="submit" class="btn btn-primary w-100">Cari</button>
          </div>
        </div>
      </form>

      <?php if ($periode): ?>
    <div class="row">
    <?php if (count($data_unit) > 0): ?>
    <div class="row">
    <?php foreach ($data_unit as $unit): ?>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-2"><?= esc($unit->unit_kerja) ?></h5>
                    <?php if (!is_null($unit->jurusan)): ?>
                    <p class="text-muted mb-2"><?= esc($unit->jurusan) ?></p>
                    <?php else : ?>
                    <p class="text-muted mb-2">Semua Jurusan</p>
                    <?php endif; ?>
                    <p class="text-muted mb-1">Tingkat : <?= esc($unit->tingkat_pendidikan) ?></p>
                    <p><strong><?= $unit->sisa_kuota ?> Posisi</strong></p>
                    <div class="mb-2">
                        <span class="badge <?= $unit->sisa_kuota > 0 ? 'bg-success' : 'bg-secondary' ?>">
                            <?= $unit->sisa_kuota > 0 ? 'Tersedia' : 'Penuh' ?>
                        </span>
                    </div>
                    <hr>

                    <p class="text-danger fw-semibold mb-3">Penutupan: <?= date('d M Y', strtotime($periode->tanggal_tutup)) ?></p>
                      <?php if (logged_in()) : ?>
                          <?php if ($isProfilComplite) : ?>
                            <button
                            class="btn btn-outline-primary w-100 btn-daftar"
                            data-bs-toggle="modal"
                            data-bs-target="#modalPendaftaran"
                            data-unit-id="<?= $unit->unit_id ?>"
                            >
                            Daftar Sekarang <i class="bi bi-arrow-right"></i>
                            </button>
                        <?php else : ?>
                            <button class="btn btn-outline-warning w-100" data-bs-toggle="modal" data-bs-target="#modalLengkapiProfil">
                                Lengkapi Profil <i class="bi bi-exclamation-circle"></i>
                            </button>
                        <?php endif; ?>
                      <?php else : ?>
                            <a href="/pendaftaran" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Daftar Sekarang <i class="bi bi-arrow-right"></i></a>

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
     </div>
  <?php else: ?>
    <div class="alert alert-info text-center">
      <strong>Data Lowongan Tidak Ada</strong>
    </div>
  <?php endif; ?>
<?php else: ?>
<div class="alert alert-warning text-center">
        <strong>Pendaftaran Magang PT Semen Padang Belum Dibuka Saat Ini.</strong><br>
        Silakan cek kembali pada minggu ke-pertama setiap bulannya.
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
    $('.select2').select2({
    
    width: '100%',
    allowClear: true,
    placeholder: function(){
        return $(this).data('placeholder');
    }
    });

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

    </div>
  </div>
</section>

<!-- Portfolio -->
<!-- <div id="portfolio" data-aos="fade-up" data-aos-delay="200">
  <div class="container-fluid p-0">
    <div class="row g-2"> 
      <?php for ($i = 1; $i <= 6; $i++) : ?>
        <div class="col-lg-4 col-md-6 col-12" data-aos="zoom-in" data-aos-delay="<?= 100 * $i ?>">
          <a class="portfolio-box d-block position-relative overflow-hidden" href="assets/img/portfolio/fullsize/<?= $i ?>.jpg" title="Dokumentasi">
            <div class="portfolio-img-wrapper">
              <img class="img-fluid" src="assets/img/portfolio/thumbnails/<?= $i ?>.jpg" alt="..." />
            </div>
          </a>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</div> -->


<!-- FAQ -->
<section class="page-section bg-dark text-white" id="faq">
  <div class="container px-4 px-lg-5">
    <div class="text-center" data-aos="fade-up">
      <h2 class="mb-4">FAQ</h2>
      <hr class="divider divider-light" />
    </div>
    <div class="accordion accordion-flush mt-5" id="faqAccordion">
      <?php
      $faqs = [
        "Siapa saja yang bisa mendaftar program magang di PT Semen Padang?",
        "Apakah program ini terbuka untuk mahasiswa dari luar Sumatera Barat?",
        "Bagaimana cara mendaftar magang atau penelitian di PT Semen Padang?",
        "Apakah peserta magang akan mendapatkan uang saku atau fasilitas lain?",
        "Berapa lama durasi magang di PT Semen Padang?",
        "Apakah bisa memilih unit/divisi tempat magang?",
        "Apakah program penelitian juga membutuhkan proposal?",
        "Apakah akan ada pembimbing selama magang atau penelitian?",
        "Kapan pendaftaran dibuka?",
        "Apakah saya akan mendapat sertifikat setelah menyelesaikan magang?",
      ];
      $i = 1;
      foreach ($faqs as $key => $q) :
      ?>
        <div class="accordion-item bg-dark border-0" data-aos="fade-up" data-aos-delay="<?= 100 * ($key + 1) ?>">
          <h2 class="accordion-header" id="flush-heading<?= $i ?>">
            <button class="accordion-button collapsed bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $i ?>" aria-expanded="false" aria-controls="flush-collapse<?= $i ?>">
              <?= $q ?>
            </button>
          </h2>
          <div id="flush-collapse<?= $i ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $i ?>" data-bs-parent="#faqAccordion">
            <div class="accordion-body text-white-50">
              <!-- Kamu bisa custom jawabannya di sini -->
              Jawaban detail sesuai kebutuhan.
            </div>
          </div>
        </div>
      <?php $i++; endforeach; ?>
    </div>
  </div>
</section>

<!-- Script AOS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
  AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true,
  });
</script>

<?= $this->endSection(); ?>
