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
        <a class="btn btn-danger btn-xl mt-2" href="#program" data-aos="zoom-in" data-aos-delay="600">
          Daftar Program
        </a>
      </div>
    </div>
  </div>
</header>

<!-- Program -->
<section class="page-section bg-primary" id="program">
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
      <p class="text-muted text-justify mb-2">
        Program Magang di PT Semen Padang dirancang sebagai sarana pembelajaran langsung bagi pelajar dan mahasiswa untuk mengaplikasikan pengetahuan yang telah diperoleh selama studi ke dunia kerja nyata.
        <br><br>Melalui program ini, peserta magang akan mendapatkan pengalaman praktis di lingkungan industri, serta pemahaman yang lebih mendalam tentang proses kerja di perusahaan manufaktur terkemuka. 
        <br><br>Program ini juga menjadi jembatan untuk mengembangkan keterampilan profesional serta memperluas wawasan karier peserta.
      </p>
      <div class="text-start text-muted small mb-3">
        <strong>Berkas yang perlu disiapkan:</strong>
        <ul class="mb-0">
          <li><strong>SMK:</strong> Surat permohonan dari sekolah, KTP/KK</li>
          <li><strong>Perguruan Tinggi:</strong> CV, Proposal, Surat permohonan kampus (minimal ttd Kaprodi), KTP/KK</li>
        </ul>
      </div>
      <a href="/magang" class="btn btn-danger w-100 btn-daftar">Daftar Magang</a>
    </div>
  </div>
</div>

<!-- Card Penelitian -->
<div class="col-md-5 mb-4" data-aos="fade-left" data-aos-delay="300">
  <div class="card h-100 text-center shadow-lg rounded-5">
    <div class="card-body p-5">
      <i class="bi bi-journal-bookmark-fill fs-1 text-primary mb-3"></i>
      <h5 class="h4 mb-2">Penelitian</h5>
      <p class="text-muted text-justify mb-2">
        Program Penelitian PT Semen Padang ditujukan bagi mahasiswa dan dosen yang ingin melakukan penelitian akademik di lingkungan perusahaan.
        <br><br>Program ini mendukung penyusunan karya ilmiah seperti skripsi, tesis, maupun penelitian lainnya yang relevan dengan bidang industri semen dan operasional perusahaan. 
        <br><br>Dengan membuka akses terhadap data dan informasi yang diperlukan, PT Semen Padang memberikan kontribusi nyata dalam mendukung pengembangan ilmu pengetahuan dan teknologi di tingkat perguruan tinggi.
      </p>
      <div class="text-start text-muted small mb-3"> <br>
        <strong>Berkas yang perlu disiapkan:</strong>
        <ul class="mb-0">
          <li>CV</li>
          <li>Proposal</li>
          <li>Surat permohonan kampus (minimal ttd Kaprodi)</li>
          <li>KTP/KK</li>
        </ul>
      </div>

      <?php if (logged_in()) : ?>
        <button class="btn btn-danger w-100 btn-daftar" data-bs-toggle="modal" data-bs-target="#modalPendaftaranPenelitian">
          Daftar Penelitian
        </button>
      <?php else : ?>
        <a href="/register" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Daftar Penelitian</a>
      <?php endif; ?>
    </div>
  </div>
</div>

    </div>
  </div>
</section>
<!-- modal login -->
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
          <a href="<?= base_url('/login'); ?>" class="btn btn-danger rounded-pill px-4">Login</a>
      </div>
      </div>
  </div>
</div>
<!-- modal pendaftaran penelitian -->
<div class="modal fade" id="modalPendaftaranPenelitian" tabindex="-1" aria-labelledby="modalPenelitianLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPenelitianLabel">Pendaftaran Penelitian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <form action="/penelitian/daftar" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="judul" class="form-label">Judul Penelitian</label>
            <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul penelitian" required>
          </div>
          <div class="mb-3">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai Penelitian</label>
            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
          </div>
          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Tuliskan ringkasan topik atau metode penelitian"></textarea>
          </div>
          <div class="mb-3">
            <label for="dosen_pembimbing" class="form-label">Nama Dosen Pembimbing</label>
            <input type="text" class="form-control" id="dosen_pembimbing" name="dosen_pembimbing" placeholder="Opsional">
          </div>
          <div class="mb-3">
            <label for="bidang" class="form-label">Bidang Penelitian</label>
            <input type="text" class="form-control" id="bidang" name="bidang" placeholder="Contoh: Teknologi Semen, Lingkungan, dll">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary w-100">Kirim Pendaftaran</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Services -->
<section class="page-section" id="services">
  <div class="container px-4 px-lg-5">
    <h2 class="text-center mt-0" data-aos="fade-up">Magang</h2>
    <hr class="divider" data-aos="fade-up" />
    <div class="row gx-4 gx-lg-5">
      <!-- Job Filter Section -->
      <form method="GET" action="<?= base_url('/magang') ?>">
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
              <option value="SMK">SMK</option>
              <option value="Perguruan Tinggi">Perguruan Tinggi</option>
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
            <button type="submit" class="btn btn-danger w-100">Cari</button>
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
                        <p><strong><?= $unit->sisa_kuota ?> Posisi</strong> <small class="text-muted"><?= $unit->jumlah_pendaftar?> pendaftar</small></p>
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
                                class="btn btn-outline-danger w-100 btn-daftar"
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
                                <a href="/pendaftar an" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Daftar Sekarang <i class="bi bi-arrow-right"></i></a>

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
                                        <a href="<?= base_url('/login'); ?>" class="btn btn-danger rounded-pill px-4">Login</a>
                                    </div>
                                    </div>
                                </div>
                                </div>
                          <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- paginatoin -->
        <?php if ($totalPages > 1): ?>
            <nav class="d-flex justify-content-center">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?><?= !empty($_SERVER['QUERY_STRING']) ? '&' . http_build_query(array_diff_key($_GET, ['page' => ''])) : '' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
        <!-- end pagination -->
        </div>
      <?php else: ?>
        <div class="alert alert-info text-center">
            <?php if ($filterByUserJurusan): ?>
                <strong>Tidak ada posisi magang yang sesuai jurusan Anda saat ini.</strong>
            <?php else: ?>
                <strong>Data Posisi Magang Tidak Ada</strong>
            <?php endif; ?>
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
        [
          "question" => "Siapa saja yang bisa mendaftar program magang di PT Semen Padang?",
          "answer" => "Program magang terbuka untuk <strong>pelajar tingkat SMK</strong>, serta <strong>mahasiswa aktif</strong> dari perguruan tinggi negeri maupun swasta yang sedang menjalani masa studi."
        ],
        [
          "question" => "Apakah program ini terbuka untuk mahasiswa dari luar Sumatera Barat?",
          "answer" => "Ya, program magang dan penelitian ini terbuka untuk peserta dari <strong>seluruh Indonesia</strong>, selama memenuhi persyaratan dan dapat hadir secara langsung di lokasi kerja."
        ],
        [
          "question" => "Bagaimana cara mendaftar magang atau penelitian di PT Semen Padang?",
          "answer" => "Pendaftaran dilakukan melalui website ini dengan mengisi formulir pendaftaran dan melampirkan dokumen yang diminta, seperti:<br>• Surat pengantar dari institusi<br>• CV<br>• KTP<br>• Proposal (untuk program penelitian)"
        ],
        [
          "question" => "Apakah peserta magang akan mendapatkan uang saku atau fasilitas lain?",
          "answer" => "Saat ini, program magang bersifat <strong>non-paid (tidak berbayar)</strong>. Namun, peserta akan mendapatkan <strong>pengalaman kerja langsung</strong>, <strong>sertifikat magang</strong>, serta <strong>bimbingan dari mentor profesional</strong>."
        ],
        [
          "question" => "Berapa lama durasi magang di PT Semen Padang?",
          "answer" => "Durasi magang bervariasi tergantung kebutuhan peserta dan persetujuan dari pihak PT Semen Padang, biasanya berkisar antara <strong>1 hingga 6 bulan</strong>."
        ],
        [
          "question" => "Apakah bisa memilih unit/divisi tempat magang?",
          "answer" => "Ya, peserta dapat memilih unit/divisi . Namun, penempatan akhir akan <strong>disesuaikan dengan kebutuhan perusahaan</strong> dan latar belakang pendidikan peserta."
        ],
        [
          "question" => "Apakah program penelitian juga membutuhkan proposal?",
          "answer" => "Ya, untuk mengikuti program penelitian, peserta wajib mengirimkan <strong>proposal penelitian</strong> yang menjelaskan <strong>topik, tujuan, dan metode</strong>, agar dapat ditinjau oleh tim terkait."
        ],
        [
          "question" => "Apakah akan ada pembimbing selama magang atau penelitian?",
          "answer" => "Tentu. Setiap peserta akan ditempatkan di bawah <strong>bimbingan mentor</strong> dari PT Semen Padang yang akan mendampingi selama masa magang atau pelaksanaan penelitian."
        ],
        [
          "question" => "Kapan pendaftaran dibuka?",
          "answer" => "Pendaftaran dibuka secara <strong>berkala pada awal bulan</strong>. Silakan cek halaman Beranda website ini atau Media Sosial PT Semen Padang untuk informasi periode pendaftaran terbaru."
        ],
        [
          "question" => "Apakah saya akan mendapat sertifikat setelah menyelesaikan magang?",
          "answer" => "Ya, peserta yang menyelesaikan program dengan baik akan mendapatkan <strong>sertifikat resmi</strong> dari PT Semen Padang sebagai bukti partisipasi."
        ]
      ];


      $i = 1;
      foreach ($faqs as $key => $faq) :
      ?>
        <div class="accordion-item bg-dark border-0" data-aos="fade-up" data-aos-delay="<?= 100 * ($key + 1) ?>">
          <h2 class="accordion-header" id="flush-heading<?= $i ?>">
            <button class="accordion-button collapsed bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $i ?>" aria-expanded="false" aria-controls="flush-collapse<?= $i ?>">
              <?= $faq["question"] ?>
            </button>
          </h2>
          <div id="flush-collapse<?= $i ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $i ?>" data-bs-parent="#faqAccordion">
            <div class="accordion-body text-white-50">
              <?= $faq["answer"] ?>
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
