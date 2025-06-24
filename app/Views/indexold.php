<?= $this->extend('templates/index'); ?>
<?= $this->section('content'); ?>
<?php $session = \Config\Services::session(); ?>
<?php if ($session->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $session->getFlashdata('success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<!-- Mashead header-->
<header class="masthead">
    <div class="container px-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-8">
                <br><br><br><br>
                <!-- Mashead text and app badges-->
                <div class="mb-5 mb-lg-0 text-center text-lg-start">
                    <h1 class="display-1 lh-1 mb-3">Magang <br>Semen Padang</h1>
                    <p class="lead fw-normal text-muted mb-5">Daftarkan magang dan penelitianmu di website magang semen padang</p>
                    <?php if (logged_in()) : ?>
                        <!-- Kalau sudah login -->
                        <a href="<?= base_url('/pendaftaran'); ?>" class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0">
                            <span class="d-flex align-items-center">
                                <span class="medium">Daftar Sekarang</span>
                            </span>
                        </a>
                    <?php else : ?>
                        <!-- Kalau belum login -->
                        <a href="javascript:void(0);" class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <span class="d-flex align-items-center">
                                <span class="medium">Daftar Sekarang</span>
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
<!-- Quote/testimonial aside-->
<aside class="text-center bg-gradient-primary-to-secondary">
    <div class="container px-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-xl-8">
                <div class="h2 fs-1 text-white mb-4">"An intuitive solution to a common problem that we all face, wrapped up in a single app!"</div>
                <img src="<?= base_url();?>/img/tnw-logo.svg" alt="..." style="height: 3rem" />
            </div>
        </div>
    </div>
</aside>
<!-- App features section-->
<section id="beranda">
    <div class="container px-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-8 order-lg-1 mb-5 mb-lg-0">
                <div class="container-fluid px-5">
                    <div class="row gx-5">
                        <div class="col-md-6 mb-5">
                            <!-- Feature item-->
                            <div class="text-center">
                                <i class="bi-phone icon-feature text-gradient d-block mb-3"></i>
                                <h3 class="font-alt">Device Mockups</h3>
                                <p class="text-muted mb-0">Ready to use HTML/CSS device mockups, no Photoshop required!</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-5">
                            <!-- Feature item-->
                            <div class="text-center">
                                <i class="bi-camera icon-feature text-gradient d-block mb-3"></i>
                                <h3 class="font-alt">Flexible Use</h3>
                                <p class="text-muted mb-0">Put an image, video, animation, or anything else in the screen!</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-5 mb-md-0">
                            <!-- Feature item-->
                            <div class="text-center">
                                <i class="bi-gift icon-feature text-gradient d-block mb-3"></i>
                                <h3 class="font-alt">Free to Use</h3>
                                <p class="text-muted mb-0">As always, this theme is free to download and use for any purpose!</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Feature item-->
                            <div class="text-center">
                                <i class="bi-patch-check icon-feature text-gradient d-block mb-3"></i>
                                <h3 class="font-alt">Open Source</h3>
                                <p class="text-muted mb-0">Since this theme is MIT licensed, you can use it commercially!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 order-lg-0">
                <!-- Features section device mockup-->
            </div>
        </div>
    </div>
</section>
<?= $this->endSection();?>
       