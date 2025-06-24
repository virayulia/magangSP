<?= $this->extend('templates/index'); ?>
<?= $this->section('content'); ?>
<?php
$uri = service('uri');
?>
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
              <img src="<?= esc(base_url('/uploads/profile/'. ($user_data->user_image ?? 'default.svg'))) ?>" alt="Foto Profil" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
            </div>

            <!-- Data di Kanan dan rata tengah secara vertikal -->
            <div class="d-flex flex-column justify-content-center">
              <h5 class="mb-1 fw-bold d-flex align-items-center">
                <?= esc($user_data->fullname ?? 'Data belum diisi'); ?>
                <img src="https://cdn-icons-png.flaticon.com/512/1828/1828640.png" alt="Verified" width="18" class="ms-2" />
              </h5>
              <p class="mb-2 text-muted small"><?= esc($user_data->email ?? 'Data belum diisi'); ?></p>
              <p class="mb-2 text-muted small"><?= esc($user_data->nama_instansi ?? 'Data belum diisi'); ?></p>
              <p class="mb-3 text-muted small"><?= esc($user_data->nama_jurusan ?? 'Data belum diisi'); ?></p>
              <!-- <button class="btn btn-outline-primary btn-sm px-4">Pelaksanaan</button> -->
            </div>
          </div>

          <!-- Sidebar -->
          <div class="card p-3 mt-4 sidebar shadow-sm">
            <a href="/profile" class="nav-link d-flex align-items-center mb-3 <?= ($uri->getSegment(1) === 'profile') ? 'active' : '' ?>">
              <i class="bi bi-file-earmark-text me-2"></i>
              <span><strong>Profil</strong></span>
            </a>
            <!-- <a href="#" class="nav-link d-flex align-items-center mb-3">
              <i class="bi bi-journal-text me-2"></i>
              <span>Logbook</span>
            </a> -->
            <a href="/status-lamaran" class="nav-link d-flex align-items-center mb-3 <?= ($uri->getSegment(1) === 'status-lamaran') ? 'active' : '' ?>">
              <i class="bi bi-list-check me-2"></i>
              <span><strong>Pendaftaran Magang</strong></span>
            </a>
            <a href="/pelaksanaan" class="nav-link d-flex align-items-center mb-3 <?= ($uri->getSegment(1) === 'pelaksanaan') ? 'active' : '' ?>">
              <i class="bi bi-calendar-check me-2"></i>
              <span><strong>Pelaksanaan Magang</strong></span>
            </a>
            <!-- <a href="#" class="nav-link d-flex align-items-center mb-3">
              <i class="bi bi-mortarboard me-2"></i>
              <span>Pelatihan</span>
            </a> -->
            <!-- <a href="#" class="nav-link d-flex align-items-center mb-3">
              <i class="bi bi-cash-coin me-2"></i>
              <span>Riwayat Pembayaran</span>
            </a> -->
            <a href="#" class="nav-link d-flex align-items-center mb-3 <?= ($uri->getSegment(1) === 'sertifikat-magang') ? 'active' : '' ?>">
              <i class="bi bi-award me-2"></i>
              <span><strong>Evaluasi Magang</strong></span>
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
            <a href="#" class="nav-link d-flex align-items-center mb-3 <?= ($uri->getSegment(1) === 'lapor') ? 'active' : '' ?>">
              <i class="bi bi-chat-dots me-2"></i>
              <span><strong>Lapor! (Support)</strong></span>
            </a>
            <a href="#" class="nav-link d-flex align-items-center mb-3 <?= ($uri->getSegment(1) === 'manual-pengguna') ? 'active' : '' ?>">
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
            <?= $this->renderSection('main-content'); ?>
          
        </div>

      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>