<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Magang PT Semen Padang</title>
        <link rel="icon" type="image/png" href="<?= base_url('img/SP_logo.png') ?>" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,600;1,600&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,300;0,500;0,600;0,700;1,300;1,500;1,600;1,700&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400&amp;display=swap" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="<?= base_url();?>/css/styles.css" rel="stylesheet" />

        <!-- sweet alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

       <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Optional: Select2 Bootstrap 5 Theme (agar matching dengan New Age Bootstrap) -->
        <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
<style>
    .wa-float {
    position: fixed;
    width: 55px;
    height: 55px;
    bottom: 20px;
    right: 20px;
    background-color: #25d366;
    color: #fff;
    border-radius: 50px;
    text-align: center;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.3);
    z-index: 999;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.wa-float img {
    width: 30px;
    height: 30px;
}
.wa-float {
    animation: floatUpDown 2s ease-in-out infinite;
}

@keyframes floatUpDown {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}
</style>

    </head>
    <body id="page-top">
        <!-- Tombol WhatsApp Mengambang -->
        <a href="https://wa.me/628999549000" class="wa-float" target="_blank" title="Hubungi via WhatsApp">
        <img src="https://img.icons8.com/color/48/000000/whatsapp--v1.png" alt="WhatsApp">
        </a>
        <!-- Navigation-->
        <?= $this->include('templates/navbar') ?>
       
        <?= $this->renderSection('content'); ?>
        <!-- Footer-->
        <footer class="bg-light text-dark py-5 border-top">
        <div class="container">
            <div class="row">

            <!-- Kiri: Informasi Perusahaan -->
            <div class="col-md-6 mb-4">
                <img src="<?= base_url('img/sp-black.png') ?>" alt="Logo" style="height: 40px;" class="mb-4">
                <h5 class="fw-bold">PT Semen Padang</h5>
                <p class="mb-1">Jalan Raya Indarung, Padang 25237 Sumatera Barat. Telp. (0751) 815-250 Fax. (0751) 815-590 www.semenpadang.co.id</p>
                <p>Email: <a href="mailto:hrd@namaperusahaan.co.id" class="text-decoration-none">hrd@namaperusahaan.co.id</a></p>
            </div>

            <!-- Tengah: Link Peserta -->
            <div class="col-md-3 mb-3">
                <h5 class="fw-bold">Peserta</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?= base_url('lowongan') ?>" class="text-decoration-none text-dark">Cari Lowongan</a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= base_url('perusahaan') ?>" class="text-decoration-none text-dark">Daftar Perusahaan</a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= base_url('sertifikat') ?>" class="text-decoration-none text-dark">Cek Sertifikat</a>
                    </li>
                </ul>

            </div>

            <!-- Kanan: Tentang -->
            <div class="col-md-3 mb-3">
                <h5 class="fw-bold">Tentang</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?= base_url('panduan') ?>" class="text-decoration-none text-dark">Panduan</a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= base_url('informasi') ?>" class="text-decoration-none text-dark">Pusat Informasi</a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= base_url('tentang') ?>" class="text-decoration-none text-dark">Tentang Kami</a>
                    </li>
                </ul>

            </div>
            </div>

            <!-- Footer bawah -->
            <div class="text-center small text-muted mt-4">
            &copy; <?= date('Y') ?> PT Semen Padang. All rights reserved.
            </div>
        </div>
        </footer>

        <!-- Feedback Modal-->
        <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary-to-secondary p-4">
                        <h5 class="modal-title font-alt text-white" id="feedbackModalLabel">Send feedback</h5>
                        <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body border-0 p-4">
                        <!-- * * * * * * * * * * * * * * *-->
                        <!-- * * SB Forms Contact Form * *-->
                        <!-- * * * * * * * * * * * * * * *-->
                        <!-- This form is pre-integrated with SB Forms.-->
                        <!-- To make this form functional, sign up at-->
                        <!-- https://startbootstrap.com/solution/contact-forms-->
                        <!-- to get an API token!-->
                        <form id="contactForm" data-sb-form-api-token="API_TOKEN">
                            <!-- Name input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="name" type="text" placeholder="Enter your name..." data-sb-validations="required" />
                                <label for="name">Full name</label>
                                <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                            </div>
                            <!-- Email address input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" type="email" placeholder="name@example.com" data-sb-validations="required,email" />
                                <label for="email">Email address</label>
                                <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                                <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                            </div>
                            <!-- Phone number input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="phone" type="tel" placeholder="(123) 456-7890" data-sb-validations="required" />
                                <label for="phone">Phone number</label>
                                <div class="invalid-feedback" data-sb-feedback="phone:required">A phone number is required.</div>
                            </div>
                            <!-- Message input-->
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="message" type="text" placeholder="Enter your message here..." style="height: 10rem" data-sb-validations="required"></textarea>
                                <label for="message">Message</label>
                                <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.</div>
                            </div>
                            <!-- Submit success message-->
                            <!---->
                            <!-- This is what your users will see when the form-->
                            <!-- has successfully submitted-->
                            <div class="d-none" id="submitSuccessMessage">
                                <div class="text-center mb-3">
                                    <div class="fw-bolder">Form submission successful!</div>
                                    To activate this form, sign up at
                                    <br />
                                    <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                                </div>
                            </div>
                            <!-- Submit error message-->
                            <!---->
                            <!-- This is what your users will see when there is-->
                            <!-- an error submitting the form-->
                            <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                            <!-- Submit Button-->
                            <div class="d-grid"><button class="btn btn-primary rounded-pill btn-lg disabled" id="submitButton" type="submit">Submit</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="<?= base_url();?>/js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
        
    </body>
</html>
