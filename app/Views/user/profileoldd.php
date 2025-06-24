<?= $this->extend('templates/index'); ?>
<?= $this->section('content'); ?>
<style>
    body {
      background-color: #f5f7fa;
    }
    .sidebar {
      height: 100vh;
      background-color: white;
      padding: 1.5rem;
      border-right: 1px solid #dee2e6;
    }
    .sidebar a {
      display: flex;
      margin: 0.75rem 0;
      color: #333;
      text-decoration: none;
    }
    .sidebar a:hover {
      color: #0d6efd;
    }
    .profile-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1rem;
    }
    .profile-card {
      background: white;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    .progress-bar {
      background-color: #0d6efd;
    }
    .tab-content .card {
      background-color: #ffffff;
      padding: 1rem;
      border: none;
    }
  </style>

  <div class="container-fluid" style="padding-top: 90px;">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 py-4 sidebar">
      <div class="text-center mb-4">
        <img src="https://via.placeholder.com/80" class="rounded-circle mb-2" alt="Profile">
        <h5>Vira Yulia <i class="fa fa-check-circle text-primary"></i></h5>
        <small>virayulia1234@gmail.com</small><br>
        <small>PT Semen Padang</small><br>
        <small>Sistem Informasi</small>
        <div class="mt-2">
          <button class="btn btn-primary btn-sm">Pelaksanaan</button>
        </div>
      </div>
      <a href="#">Curriculum Vitae</a>
      <a href="#">Status Lamaran</a>
      <a href="#">Kehadiran</a>
      <a href="#">Sertifikat Magang</a>
      <a href="#">Manual Pengguna</a>
      <a href="#" class="text-danger">Keluar</a>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 py-4">
      <!-- Tab Data Profil -->
      <div class="profile-card">
        <ul class="nav nav-tabs mb-3" id="profileTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="data-pribadi-tab" data-bs-toggle="tab" data-bs-target="#data-pribadi" type="button" role="tab">Data Pribadi</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="data-akademik-tab" data-bs-toggle="tab" data-bs-target="#data-akademik" type="button" role="tab">Data Akademik</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="data-keluarga-tab" data-bs-toggle="tab" data-bs-target="#data-keluarga" type="button" role="tab">Data Keluarga</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="dokumen-tab" data-bs-toggle="tab" data-bs-target="#dokumen" type="button" role="tab">Dokumen</button>
          </li>
        </ul>

        <div class="tab-content" id="profileTabContent">
          <div class="tab-pane fade show active" id="data-pribadi" role="tabpanel">
            <div class="card">
              <h6>Biodata</h6>
              <p><strong>Tentang Saya</strong><br>Saya adalah mahasiswa tingkat akhir Jurusan Sistem Informasi di Universitas Andalas dengan IPK 3.7...</p>
              <p><strong>Nama Lengkap:</strong> Vira Yulia</p>
              <p><strong>NIK:</strong> 1470225037001062</p>
              <p><strong>Jenis Kelamin:</strong> Perempuan</p>
              <p><strong>Tempat Lahir:</strong> Kota Pariaman</p>
              <p><strong>Tanggal Lahir:</strong> 13 Juli 2001</p>
              <p><strong>Email:</strong> virayulia1234@gmail.com</p>
              <p><strong>No Handphone:</strong> +6289995490000</p>
              <p><strong>Nama Bank:</strong> -</p>
              <p><strong>No Rekening:</strong> -</p>
              <p><strong>Alamat Tinggal:</strong> Dumai, Riau</p>
              <p><strong>Alamat Domisili:</strong> Padang, Sumbar</p>
            </div>
          </div>
          <!-- Tab lainnya bisa ditambahkan dengan struktur serupa -->
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>
