<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav">
    <div class="container px-5">
            <a class="navbar-brand" href="#page-top">
                <img src="<?= base_url('img/sp-black.png') ?>" alt="Logo Semen Padang" style="height: 40px;">
            </a>        
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="bi-list"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                <li class="nav-item"><a class="nav-link me-lg-3" href="/">Beranda</a></li>
                <li class="nav-item"><a class="nav-link me-lg-3" href="/lowongan">Lowongan</a></li>
                <li class="nav-item"><a class="nav-link me-lg-3" href="/tentangkami">Tentang Kami</a></li>
            </ul>
            <?php if (!logged_in()) : ?>
                <!-- Belum login -->
                <a href="<?= base_url('/login'); ?>" class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0">
                    <span class="d-flex align-items-center">
                        <i class="bi-person-fill"></i>
                        <span class="small ms-2">Sign In</span>
                    </span>
                </a>
            <?php else : ?>
                <!-- Sudah login -->
                <div class="dropdown">
                    <a class="btn btn-light rounded-pill px-3 mb-2 mb-lg-0 dropdown-toggle d-flex align-items-center" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= base_url('uploads/profile/' . (user()->user_image ?? 'default.svg')); ?>" alt="Profile" class="rounded-circle" width="30" height="30">
                        <span class="small ms-2"><?= esc(user()->username); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="<?= base_url('/profile'); ?>">Lihat Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= base_url('/logout'); ?>">Logout</a></li>
                    </ul>
                </div>
            <?php endif; ?>

        </div>
    </div>
</nav>