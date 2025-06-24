<?= $this->extend('templates/index'); ?>
<?= $this->section('content'); ?>
<section class="hero-section" style="padding-top: 140px;">
    <div class="container text-center">
        <h1 class="mb-4">Temukan kesempatan magang di berbagai unit di perusahaan <span class="text-primary">Semen Padang</span></h1>
        <p class="lead">Bergabung dengan Semen Padang Hari Ini dan Temukan Pengalaman yang Paling Sesuai untuk Anda</p>
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

<div class="container my-5">
  <div class="row">
    <!-- Left Column: Job Cards -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
          <div class="mb-3">
            <img src="/img/sp-black.png" alt="Logo Semen Padang" style="height: 50px;">
          </div>
          <h6 class="text-muted mb-1">PT Semen Padang</h6>
          <h5 class="fw-bold mb-2">Unit Sumber Daya Manusia</h5>
          <p class="text-muted mb-2">Kantor Pusat</p>
          <p><strong>1 Posisi</strong></p>
          <div class="mb-2">
            <span class="badge bg-success">Umum</span>
            <span class="badge bg-light text-dark">3 bulan</span>
            <span class="badge bg-light text-dark">Onsite</span>
          </div>
          <hr>
          <p class="text-danger fw-semibold mb-3">Penutupan: 19 Mei 2025</p>
          <a href="#" class="btn btn-outline-primary w-100">Lihat Detail <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

      <!-- Tambahkan kartu lain sesuai kebutuhan -->
    </div>

    <!-- Right Column: Job Detail -->
    <div class="col-md-8">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <img src="/img/sp-black.png" alt="Logo PT Berdikari" style="height: 50px;" class="mb-2">
              <h4 class="fw-bold mb-1">Unit Sumber Daya Manusia</h4>
              <p class="mb-1 text-muted">PT Semen Padang · Kantor Pusat · <span class="badge bg-light text-dark">Onsite</span></p>
            </div>
            <div>
              <a href="#" class="btn btn-primary">Daftar Sekarang</a>
            </div>
          </div>

          <div class="mt-3">
            <span class="badge bg-success">Umum</span>
            <span class="badge bg-light text-dark">6 bulan</span>
          </div>

          <hr>

          <h5 class="fw-semibold">Pendidikan</h5>
          <ul class="mb-3">
            <li>Jenjang pendidikan: S1</li>
            <li>Jurusan: Semua Jurusan</li>
            <li>IPK minimal: 3.1</li>
          </ul>

          <h5 class="fw-semibold">Persyaratan Dokumen</h5>
          <div class="row mb-3">
            <div class="col-6">
              <ul>
                <li>Pakta Integritas</li>
                <li>CV</li>
                <li>Transkrip Nilai</li>
                <li>KTP</li>
              </ul>
            </div>
            <div class="col-6">
              <ul>
                <li>KTM</li>
                <li>Portfolio</li>
                <li>Sertifikat</li>
                <li>Ijazah/Surat Keterangan Lulus</li>
              </ul>
            </div>
          </div>

          <h5 class="fw-semibold">Tanggal Penting</h5>
          <ul class="mb-3">
            <li>Durasi: 6 bulan</li>
            <li>Penutupan lamaran: 20 Mei 2025</li>
            <li>Pengumuman lolos seleksi: 1 Juni 2025</li>
          </ul>

          <h5 class="fw-semibold">Job Summary</h5>
          <p>Tax intern PT Berdikari akan mendukung tim pajak dalam menyiapkan dan melaporkan dokumen perpajakan, melakukan riset, serta membantu kepatuhan dan pelaporan pajak. Posisi ini memberikan pengalaman langsung dalam analisis keuangan, kepatuhan, dan regulasi pajak.</p>

          <h5 class="fw-semibold">Key Responsibilities</h5>
          <ol class="mb-3">
            <li>
              <strong>Tax Preparation & Filing</strong>
              <ul>
                <li>Membantu penyusunan SPT individu dan perusahaan.</li>
                <li>Mengorganisir data keuangan untuk pelaporan pajak.</li>
              </ul>
            </li>
            <li>
              <strong>Research & Compliance</strong>
              <ul>
                <li>Riset kebijakan dan regulasi pajak.</li>
                <li>Pastikan kepatuhan perusahaan terhadap regulasi.</li>
              </ul>
            </li>
            <li>
              <strong>Data Analysis & Reporting</strong>
              <ul>
                <li>Analisis laporan keuangan dan potensi efisiensi pajak.</li>
              </ul>
            </li>
            <li>
              <strong>Process Improvement</strong>
              <ul>
                <li>Identifikasi efisiensi proses dan otomasi tugas pajak.</li>
              </ul>
            </li>
            <li>
              <strong>Administrative Support</strong>
              <ul>
                <li>Kelola catatan pajak dan komunikasi dokumen.</li>
              </ul>
            </li>
          </ol>

          <h5 class="fw-semibold">Requirements</h5>
          <ul>
            <li>Lulusan atau mahasiswa akhir jurusan Akuntansi/Keuangan/Pajak.</li>
            <li>Kuasai prinsip akuntansi dan perpajakan.</li>
            <li>Mahir Excel, SAP, QuickBooks, dsb.</li>
            <li>Kemampuan analitis & detail tinggi.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>


</section>
<?= $this->endSection();?>