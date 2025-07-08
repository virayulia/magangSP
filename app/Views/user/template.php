<?php $this->setVar('force_scrolled', true); ?>
<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>
<?php
$uri = service('uri');
?>
<style>
  body {
    background-color: #f6f8fb;
    font-family: 'Inter', sans-serif;
  }

  .profile-card {
    background: #ffffff;
    border-radius: 1rem;
    padding: 24px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
  }
  .profile-card:hover {
    /* transform: translateY(-4px); */
    box-shadow: 0 15px 40px rgba(0,0,0,0.07);
  }
  .sidebar {
    background: #ffffff;
    border-radius: 1rem;
    padding: 1rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
  }
  .sidebar a {
    display: flex;
    align-items: center;
    border-radius: 0.75rem;
    padding: 0.6rem 1rem;
    color: #495057;
    font-weight: 500;
    transition: all 0.25s ease;
  }
  .sidebar a:hover {
    background-color: rgba(13, 110, 253, 0.08);
    color: #dc3545;
  }
  .sidebar a.active {
    background-color: #eaf4ff;
    color: #dc3545;
    font-weight: 600;
  }
  .profile-tabs {
    border-bottom: none;
  }
  .profile-tabs .nav-link {
    border: none;
    color: #6c757d;
    padding: 12px 20px;
    font-weight: 500;
    transition: all 0.3s ease;
    border-radius: 0.75rem 0.75rem 0 0;
  }
  .profile-tabs .nav-link:hover {
    color: #dc3545;
    background-color: rgba(13, 110, 253, 0.1);
  }
  .profile-tabs .nav-link.active {
    color: #dc3545;
    background-color: #ffffff;
    font-weight: 600;
    box-shadow: 0 -2px 0 #dc3545 inset;
  }
</style>

<div class="container-fluid" style="padding-top: 75px;">
  <div class="row">
    <div class="col-md-12 py-4">
      <div class="row g-4">

        <!-- Profile Card -->
        <div class="col-md-4">
          <div class="profile-card d-flex align-items-center">
            <!-- Foto Profil -->
            <div class="me-3">
              <img src="<?= esc(base_url('/uploads/user_image/'. ($user_data->user_image ?? 'default.svg'))) ?>" alt="Foto Profil" class="rounded-circle shadow-sm" style="width: 100px; height: 100px; object-fit: cover;">
            </div>

            <!-- Info -->
            <div>
              <h5 class="mb-1 fw-bold d-flex align-items-center">
                <?= esc($user_data->fullname ?? 'Data belum diisi'); ?>
                <img src="https://cdn-icons-png.flaticon.com/512/1828/1828640.png" alt="Verified" width="18" class="ms-2" />
              </h5>
              <p class="mb-1 text-muted small"><?= esc($user_data->email ?? 'Data belum diisi'); ?></p>
              <p class="mb-1 text-muted small"><?= esc($user_data->nama_instansi ?? 'Data belum diisi'); ?></p>
              <p class="mb-0 text-muted small"><?= esc($user_data->nama_jurusan ?? 'Data belum diisi'); ?></p>
            </div>
          </div>

          <!-- Sidebar -->
          <div class="sidebar mt-4">
            <a href="/profile" class="<?= ($uri->getSegment(1) === 'profile') ? 'active' : '' ?>">
              <i class="bi bi-file-earmark-text me-2"></i>
              <span>Profil</span>
            </a>
            <a href="/status-lamaran" class="<?= ($uri->getSegment(1) === 'status-lamaran') ? 'active' : '' ?>">
              <i class="bi bi-list-check me-2"></i>
              <span>Pendaftaran Magang</span>
            </a>
            <a href="/pelaksanaan" class="<?= ($uri->getSegment(1) === 'pelaksanaan') ? 'active' : '' ?>">
              <i class="bi bi-calendar-check me-2"></i>
              <span>Pelaksanaan Magang</span>
            </a>
            <a href="#" class="<?= ($uri->getSegment(1) === 'sertifikat-magang') ? 'active' : '' ?>">
              <i class="bi bi-award me-2"></i>
              <span>Evaluasi Magang</span>
            </a>
            <a href="#" class="<?= ($uri->getSegment(1) === 'lapor') ? 'active' : '' ?>">
              <i class="bi bi-chat-dots me-2"></i>
              <span>Lapor! (Support)</span>
            </a>
            <a href="#" class="<?= ($uri->getSegment(1) === 'manual-pengguna') ? 'active' : '' ?>">
              <i class="bi bi-book me-2"></i>
              <span>Manual Pengguna</span>
            </a>
            <hr>
            <a href="#" class="text-danger fw-semibold">
              <i class="bi bi-box-arrow-right me-2"></i>
              <span>Keluar</span>
            </a>
          </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-8">
          <?= $this->renderSection('main-content'); ?>
        </div>

      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>
