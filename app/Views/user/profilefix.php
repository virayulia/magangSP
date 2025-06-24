<?= $this->extend('templates/index'); ?>
<?= $this->section('content'); ?>
<style>
    body {
      background-color: #f8f9fa;
    }
    .sidebar a {
      border-radius: 0.5rem;
      padding: 0.5rem 0.75rem;
      color: #212529;
      text-decoration: none;
      transition: all 0.2s ease-in-out;
    }

    .sidebar a:hover {
      background-color: #f1f3f5;
    }

    .sidebar a.active {
      background-color: #e9f5ff;
      color: #0d6efd;
      font-weight: 600;
    }
    .profile-card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .progress-bar {
      background-color: #4e73df;
    }
   
    .profile-tabs {
      border-bottom: 2px solid #dee2e6;
    }

    .profile-tabs .nav-link {
      border: none;
      color: #6c757d;
      padding: 12px 20px;
      font-weight: 500;
      transition: all 0.3s ease;
      background-color: transparent;
      border-radius: 0;
    }

    .profile-tabs .nav-link:hover {
      color: #0056b3;
      background-color: rgba(0, 123, 255, 0.1);
    }

    .profile-tabs .nav-link.active {
      color: #0d6efd;
      border-bottom: 3px solid #0d6efd;
      font-weight: 600;
      background-color: transparent;
    }

  </style>

<div class="container-fluid" style="padding-top: 65px;">
  <div class="row">
    <!-- Main content -->
    <div class="col-md-12 py-4">
      <div class="row g-4">

        <!-- Profile Card -->
        <div class="col-md-4 ">
          <div class="profile-card d-flex align-items-center p-3 border rounded shadow-sm">
            <!-- Foto Profil di Kiri -->
            <div class="me-3">
              <img src="<?= base_url();?>/img/default.svg" alt="Foto Profil" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
            </div>

            <!-- Data di Kanan dan rata tengah secara vertikal -->
            <div class="d-flex flex-column justify-content-center">
              <h5 class="mb-1 fw-bold d-flex align-items-center">
                Vira Yulia
                <img src="https://cdn-icons-png.flaticon.com/512/1828/1828640.png" alt="Verified" width="18" class="ms-2" />
              </h5>
              <p class="mb-2 text-muted small">virayulia1234@gmail.com</p>
              <p class="mb-2 text-muted small">PT Semen Padang</p>
              <p class="mb-3 text-muted small">Sistem Informasi</p>
              <button class="btn btn-outline-primary btn-sm px-4">Pelaksanaan</button>
            </div>
          </div>

          <!-- Sidebar -->
          <div class="card p-3 mt-4 sidebar shadow-sm">
            <a href="#" class="nav-link d-flex align-items-center mb-3 active">
              <i class="bi bi-file-earmark-text me-2"></i>
              <span><strong>Curriculum Vitae</strong></span>
            </a>
            <!-- <a href="#" class="nav-link d-flex align-items-center mb-3">
              <i class="bi bi-journal-text me-2"></i>
              <span>Logbook</span>
            </a> -->
            <a href="#" class="nav-link d-flex align-items-center mb-3">
              <i class="bi bi-list-check me-2"></i>
              <span><strong>Status Lamaran</strong></span>
            </a>
            <a href="#" class="nav-link d-flex align-items-center mb-3">
              <i class="bi bi-calendar-check me-2"></i>
              <span><strong>Kehadiran</strong></span>
            </a>
            <!-- <a href="#" class="nav-link d-flex align-items-center mb-3">
              <i class="bi bi-mortarboard me-2"></i>
              <span>Pelatihan</span>
            </a> -->
            <!-- <a href="#" class="nav-link d-flex align-items-center mb-3">
              <i class="bi bi-cash-coin me-2"></i>
              <span>Riwayat Pembayaran</span>
            </a> -->
            <a href="#" class="nav-link d-flex align-items-center mb-3">
              <i class="bi bi-award me-2"></i>
              <span><strong>Sertifikat Magang</strong></span>
            </a>
            <!-- <a href="#" class="nav-link d-flex align-items-center mb-3">
              <i class="bi bi-sliders2 me-2"></i>
              <span>Preferensi Magang</span>
            </a> -->
            <!-- <a href="#" class="nav-link d-flex align-items-center mb-3">
              <i class="bi bi-calendar-event me-2"></i>
              <span>Event</span>
            </a>
            <a href="#" class="nav-link d-flex align-items-center mb-3">
              <i class="bi bi-wallet2 me-2"></i>
              <span>Riwayat Uang Saku</span>
            </a> -->
            <!-- <a href="#" class="nav-link d-flex align-items-center mb-3">
              <i class="bi bi-shield-lock me-2"></i>
              <span>Pengaturan Keamanan</span>
            </a> -->
            <a href="#" class="nav-link d-flex align-items-center mb-3">
              <i class="bi bi-chat-dots me-2"></i>
              <span><strong>Lapor! (Support)</strong></span>
            </a>
            <a href="#" class="nav-link d-flex align-items-center mb-3">
              <i class="bi bi-book me-2"></i>
              <span><strong>Manual Pengguna</strong></span>
            </a>

            <hr>
            <a href="#" class="nav-link d-flex align-items-center text-danger fw-semibold">
              <i class="bi bi-box-arrow-right me-2"></i>
              <span><strong>Keluar</strong></span>
            </a>
          </div>

        </div>

        <div class="col-md-8">
          <!-- Tab Data Profil -->
          <div class="profile-card">
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
                       <a href="#" class="text-decoration-none text-muted" title="Edit Data Pribadi">
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
                        <p class="text-muted">Vira Yulia</p>
                        <p><strong>NISN/NIM</strong> </p>
                        <p class="text-muted">1472025307010062</p>
                        <p><strong>Tempat Lahir</strong></p>
                        <p class="text-muted">Kota Pariaman</p>
                        <p><strong>Tanggal Lahir</strong></p>
                        <p class="text-muted"> 13 July 2001</p>
                      </div>
                      <div class="col-md-6">
                        <p><strong>Jenis Kelamin</strong> </p>
                        <p class="text-muted">Perempuan</p>
                        <p><strong>Email</strong> </p>
                        <p class="text-muted">virayukia1234@gmail.com</p>
                        <p><strong>No Handphone</strong></p>
                        <p class="text-muted">+6289995490000</p>
                      </div>
                    </div>

                    <p?><strong>Alamat Tempat Tinggal</strong><br></p>
                    <p class="text-muted">
                      Jl. Sisingamangaraja Gg. Mulia, RT 010 RW 000, Teluk Binjai, Dumai Timur, Kota Dumai, Riau
                    </p>
                    <p><strong>Alamat Domisili</strong><br> </p>
                    <p class="text-muted">
                      Jl. Bandes Binuang RT 02/RW 02 Kel. Binuang Kampung Dalam Kec. Pauh Kota Padang Sumbar, Kota Padang, Sumatera Barat
                    </p>
                  </div>
                </div>
              </div>

              <!-- Tab Content Akademik-->
               <div class="tab-content" id="profileTabContent">
                <div class="tab-pane fade show non-active" id="data-akademik" role="tabpanel">
                  <div class="card p-4">
                    <h5 class="fw-bold">Data Akademik</h5>
                    <p class="text-muted">Pastikan data akademik benar untuk mempermudah proses pendaftaran</p>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        <p><strong>Sekolah/Perguruan Tinggi</strong></p>
                        <p class="text-muted">Universitas Andalas</p>
                        <p><strong>Jurusan</strong> </p>
                        <p class="text-muted">Sistem Informasi</p>
                      </div>
                      <div class="col-md-6">
                        <p><strong>Semester</strong></p>
                        <p class="text-muted">7</p>
                        <p><strong>Nilai rata-rata/IPK</strong></p>
                        <p class="text-muted">3.45</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Tab Content Dokumen-->
               <div class="tab-content" id="profileTabContent">
                <div class="tab-pane fade show non-active" id="dokumen" role="tabpanel">
                  <div class="card p-4">
                    <h5 class="fw-bold">Dokumen</h5>
                    <p class="text-muted">Pastikan dokumen benar untuk mempermudah proses pendaftaran</p>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        <p><strong>Sekolah/Perguruan Tinggi</strong></p>
                        <p class="text-muted">Universitas Andalas</p>
                        <p><strong>Jurusan</strong> </p>
                        <p class="text-muted">Sistem Informasi</p>
                      </div>
                      <div class="col-md-6">
                        <p><strong>Semester</strong></p>
                        <p class="text-muted">7</p>
                        <p><strong>Nilai rata-rata/IPK</strong></p>
                        <p class="text-muted">3.45</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Tab Content -->
          </div>
          <!-- End Tab Data Profil -->

        </div>
      </div>
    </div>
  </div>
</div>


<?= $this->endSection(); ?>