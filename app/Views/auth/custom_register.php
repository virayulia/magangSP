<?= $this->extend('auth/template_plain'); ?>
<?= $this->section('content'); ?>

<style>
  .stepper {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin-bottom: 2rem;
  }
  .stepper::before {
    content: "";
    position: absolute;
    top: 20px;
    left: 15px;
    right: 15px;
    border-top: 2px dashed #ccc;
    z-index: 0;
  }
  .step {
    position: relative;
    z-index: 1;
    text-align: center;
    flex: 1;
  }
  .step .circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid #ccc;
    background-color: #fff;
    margin: 0 auto;
    line-height: 36px;
    font-weight: bold;
    color: #ccc;
    transition: all 0.3s;
  }
  .step.active .circle,
  .step.completed .circle {
    border-color: #dc3545;
    background-color: #dc3545;
    color: #fff;
  }
  .step p {
    margin-top: 8px;
    font-size: 0.9rem;
    color: #333;
  }
  .required-star::after {
    content: " *";
    color: red;
  }
  .password-check {
    font-size: 0.85rem;
    display: flex;
    align-items: center;
  }
  .password-check i {
    margin-right: 5px;
  }
  .password-check.valid i {
    color: green;
  }
  .password-check.invalid i {
    color: red;
  }

  
</style>


<section class="d-flex align-items-center bg-light py-5">
  <div class="container px-4 px-lg-5">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10">
        <div id="formCard" class="card shadow-lg border-0 rounded-4 p-4">
          <h3 class="text-center text-danger fw-bold mb-3">Pendaftaran</h3>
          <?php if (session()->has('errors')): ?>
              <div class="alert alert-danger">
                  <?php foreach (session('errors') as $error): ?>
                      <div><?= esc($error) ?></div>
                  <?php endforeach ?>
              </div>
          <?php endif ?>
          <?php if (session()->getFlashdata('error')): ?>
              <div class="alert alert-danger">
                  <?= session('error') ?>
              </div>
          <?php endif; ?>


          <!-- Stepper -->
          <div class="stepper mb-4">
            <div id="step1" class="step active">
              <div class="circle">1</div>
              <p>Data Akun & Diri</p>
            </div>
            <div id="step2" class="step">
              <div class="circle">2</div>
              <p>Data Akademik</p>
            </div>
            <div id="step3" class="step">
              <div class="circle">3</div>
              <p>Dokumen</p>
            </div>
          </div>

          <form id="regForm" action="<?= site_url('register/process'); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <!-- Step 1 -->
            <div class="form-step" id="form-step-1">
              <div class="mb-2">
                <label class="required-star">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
              </div>
              <div class="mb-2">
                <label class="required-star">Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-2">
                <label class="required-star">Password</label>
                <input type="password" id="password" name="password" class="form-control" required minlength="8">
                <div class="mt-1">
                  <div id="check-length" class="password-check invalid"><i class="bi bi-x-circle"></i> Minimal 8 karakter</div>
                  <div id="check-uppercase" class="password-check invalid"><i class="bi bi-x-circle"></i> Kombinasi huruf kapital dan huruf kecil</div>
                  <div id="check-number" class="password-check invalid"><i class="bi bi-x-circle"></i> Minimal 1 angka atau simbol</div>
                </div>
              </div>
              <div class="mb-2">
                <label class="required-star">Konfirmasi Password</label>
                <input type="password" name="pass_confirm" class="form-control" required minlength="8">
                <div id="confirmError" class="text-danger small mt-1"></div>
              </div>
              <div class="mb-2">
                <label class="required-star">No HP</label>
                <input type="text" name="no_hp" class="form-control" required>
              </div>
              <div class="mb-2">
                <label class="required-star">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select" required>
                  <option value="">Pilih</option>
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
              <div class="mb-2">
                <label class="required-star">NISN/NIM</label>
                <input type="text" name="nisn_nim" class="form-control" required>
              </div>
              <div class="mb-2">
                <label class="required-star">Alamat Lengkap (Sesuai KTP)</label>
                <textarea name="alamat" class="form-control" rows="2" required></textarea>
              </div>
              <div class="mb-2">
                <label class="required-star">Provinsi</label>
                <select name="provinsi" id="provinsi" class="form-select" required>
                    <option value="" disabled selected hidden>Pilih Provinsi</option>
                    <?php foreach ($provinsi as $p) : ?>
                    <option value="<?= $p['id']; ?>"><?= $p['province']; ?></option>
                    <?php endforeach; ?>
                </select>
                <div id="provinsiError" class="text-danger small mt-1"></div>
              </div>

              <div class="mb-3">
                <label class="required-star">Kota/Kabupaten</label>
                <select name="kota" id="kota" class="form-select" required>
                    <option value="" disabled hidden>Pilih Kota/Kabupaten</option>
                </select>
                <div id="kotaError" class="text-danger small mt-1"></div>
              </div>

              <div class="mb-3">
                <label class="required-star">Foto</label>
                <input type="file" name="user_image" class="form-control" accept="image/*" required>
              </div>
              <button type="button" class="btn btn-primary w-100" onclick="nextStep(1)">Lanjut</button>
            </div>

            <!-- Step 2 -->
            <div class="form-step d-none" id="form-step-2">
              <div class="mb-2">
                <label class="required-star">Asal Kampus/Sekolah</label>
                <select name="instansi" id="instansi" class="form-select" required>
                  <option value="" disabled selected hidden>Pilih Instansi</option>
                  <?php foreach($instansi as $item) : ?>
                    <option value="<?= $item['instansi_id']?>"><?= $item['nama_instansi'] ?></option>
                    <?php endforeach; ?>
                </select>
              </div>

              <div class="mb-2">
                <label class="required-star">Jurusan</label>
                <select name="jurusan" id="jurusan" class="form-select" required>
                  <option value="" disabled selected hidden>Pilih Jurusan</option>
                  <?php foreach($jurusan as $item) : ?>
                  <option value="<?= $item['jurusan_id'] ?>"><?= $item['nama_jurusan'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-2">
                <label class="required-star">Jenjang Pendidikan</label>
                <select name="jenjang_pendidikan" id="jenjang-pendidikan" class="form-select" required>
                  <option value="" disabled selected hidden>Pilih</option>
                  <option value="SMA/SMK">SMA/SMK Sederajat</option>
                  <option value="D3">D3</option>
                  <option value="D4/S1">D4/S1</option>
                  <option value="S2">S2</option>
                </select>
              </div>
              <div class="mb-3" id="group-semester">
                <label class="required-star">Semester</label>
                <input type="number" name="semester" class="form-control" min="1">
              </div>
              <div class="mb-3">
                <label class="required-star">Nilai/IPK</label>
                <input type="number" name="nilai_ipk" class="form-control" step="0.01" min="1" required>
                <small class="text-muted" id="help-nilai">Gunakan titik (.) sebagai pemisah desimal, contoh: 3.50</small>
              </div>

              <button type="button" class="btn btn-secondary w-100 mb-2" onclick="prevStep(2)">Kembali</button>
              <button type="button" class="btn btn-primary w-100" onclick="nextStep(2)">Lanjut</button>
            </div>

            <!-- Step 3 -->
            <div class="form-step d-none" id="form-step-3">

              <div class="mb-3">
                  <label class="required-star">CV</label>
                  <input type="file" name="cv" class="form-control" required>
              </div>

              <div class="mb-3">
                  <label>Proposal (wajib jika mahasiswa)</label>
                  <input type="file" name="proposal" class="form-control">
              </div>

              <div class="mb-3">
                  <label class="required-star">Surat Permohonan</label>
                  <input type="file" name="surat_permohonan" class="form-control" required>
              </div>
              <div class="row">
                  <div class="col-md-6 mb-3">
                      <label class="required-star">No Surat</label>
                      <input type="text" name="no_surat" class="form-control" required>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label class="required-star">Tanggal Surat</label>
                      <input type="date" name="tanggal_surat" class="form-control" required>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label class="required-star">Nama Pimpinan</label>
                      <input type="text" name="nama_pimpinan" class="form-control" required>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label class="required-star">Jabatan</label>
                      <input type="text" name="jabatan" class="form-control" required>
                  </div>
                  <div class="col-12 mb-3">
                      <label class="required-star">Email Instansi (untuk balasan)</label>
                      <input type="email" name="email_instansi" class="form-control" required>
                  </div>
              </div>

              <div class="mb-3">
                  <label class="required-star">KTP/KK</label>
                  <input type="file" name="ktp_kk" class="form-control" required>
              </div>

              <div class="mb-3">
                  <label>BPJS Kesehatan (opsional)</label>
                  <input type="file" name="bpjs_kes" class="form-control">
              </div>

              <div class="mb-3">
                  <label>BPJS TK (boleh diisi nanti)</label>
                  <input type="file" name="bpjs_tk" class="form-control">
              </div>

              <div class="mb-3">
                  <label>Bukti Bayar BPJS TK (boleh diisi nanti)</label>
                  <input type="file" name="bukti_bayar_bpjs" class="form-control">
              </div>

              <div class="mb-3">
                  <label>Pilih Program <span class="text-danger">*</span></label>
                  <select name="program" id="program" class="form-select" required>
                      <option value="">Pilih Program</option>
                      <option value="magang">Magang</option>
                      <option value="penelitian">Penelitian</option>
                  </select>
              </div>

              <div id="judulPenelitianDiv" style="display: none;" class="mb-3">
                  <label>Judul Penelitian</label>
                  <input type="text" name="judul_penelitian" class="form-control">
              </div>

              <button type="button" class="btn btn-secondary w-100 mb-2" onclick="prevStep(3)">Kembali</button>
              <button type="submit" class="btn btn-success w-100">Simpan & Daftar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Load jQuery & Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pendidikan = document.getElementById('jenjang-pendidikan');
        const groupSemester = document.getElementById('group-semester');
        const helpNilai = document.getElementById('help-nilai');

        function toggleFields() {
            const isSMA = pendidikan.value === 'SMA/SMK';

            // Sembunyikan/tampilkan semester
            groupSemester.style.display = isSMA ? 'none' : 'block';

            // Ubah label dan helper untuk nilai/IPK
            helpNilai.textContent = isSMA
                ? 'Gunakan titik (.) sebagai pemisah desimal, contoh: 85.00'
                : 'Gunakan titik (.) sebagai pemisah desimal, contoh: 3.50';
        }

        // Inisialisasi saat halaman dimuat
        toggleFields();

        // Event saat pendidikan diubah
        pendidikan.addEventListener('change', toggleFields);
    });
</script>
<script>
function nextStep(current) {
  let currentStep = document.getElementById('form-step-' + current);
  let inputs = currentStep.querySelectorAll("input, select");

  // Reset error messages
  document.getElementById('confirmError').innerText = '';
  document.getElementById('provinsiError').innerText = '';
  document.getElementById('kotaError').innerText = '';

  if (parseInt(current) === 1) {
    const pass = document.querySelector("input[name='password']").value;
    const confirmInput = document.querySelector("input[name='pass_confirm']");
    const confirm = confirmInput.value;

    if (pass !== confirm) {
      document.getElementById('confirmError').innerText = "Password dan konfirmasi password tidak sama!";
      confirmInput.focus();
      return;
    }

    // Validasi manual provinsi
    const provinsiVal = $('#provinsi').val();
    const kotaVal = $('#kota').val();
    let hasError = false;

    if (!provinsiVal) {
      document.getElementById('provinsiError').innerText = "Silakan pilih provinsi.";
      hasError = true;
    }

    if (!kotaVal) {
      document.getElementById('kotaError').innerText = "Silakan pilih kota/kabupaten.";
      hasError = true;
    }

    if (hasError) {
      return;
    }
  }

  // Validasi HTML native (selain provinsi & kota)
  for (let i = 0; i < inputs.length; i++) {
    if (inputs[i].name !== 'provinsi' && inputs[i].name !== 'kota' && !inputs[i].checkValidity()) {
      inputs[i].reportValidity();
      return;
    }
  }

  // Lanjut ke step berikutnya
  currentStep.classList.add('d-none');
  document.getElementById('form-step-' + (parseInt(current) + 1)).classList.remove('d-none');

  document.getElementById('step' + current).classList.remove('active');
  document.getElementById('step' + current).classList.add('completed');
  document.getElementById('step' + (parseInt(current) + 1)).classList.add('active');

  document.getElementById('formCard').scrollIntoView({ behavior: 'smooth', block: 'start' });
}


  function prevStep(current) {
    document.getElementById('form-step-' + current).classList.add('d-none');
    document.getElementById('form-step-' + (current - 1)).classList.remove('d-none');

    document.getElementById('step' + current).classList.remove('active');
    document.getElementById('step' + (current - 1)).classList.add('active');
    document.getElementById('step' + (current - 1)).classList.remove('completed');

    document.getElementById('formCard').scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
  
  const passwordInput = document.getElementById('password');

  passwordInput.addEventListener('input', function() {
    const val = passwordInput.value;
    let validLength = val.length >= 8;
    let validUpper = /[A-Z]/.test(val) && /[a-z]/.test(val);
    let validNumber = /\d|[^a-zA-Z]/.test(val);

    updateCheck('check-length', validLength);
    updateCheck('check-uppercase', validUpper);
    updateCheck('check-number', validNumber);
  });

  function updateCheck(id, valid) {
    const item = document.getElementById(id);
    if (valid) {
      item.classList.remove('invalid');
      item.classList.add('valid');
      item.querySelector('i').className = 'bi bi-check-circle';
    } else {
      item.classList.remove('valid');
      item.classList.add('invalid');
      item.querySelector('i').className = 'bi bi-x-circle';
    }
  }

  $(document).ready(function() {
    $('#provinsi, #instansi, #jurusan').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: function(){
            $(this).data('placeholder');
        },
        allowClear: true
    });
    $('#provinsi').on('change', function () {
        $('#kota').val(null).trigger('change');
    });
    $('#kota').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: 'Pilih Kota',
        allowClear: true,
        ajax: {
            url: '<?= base_url(); ?>/api/kota',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    provinsi: $('#provinsi').val(), // ini sudah benar
                    searchTerm: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.data
                };
            },
            cache: true
        }
    });
  });

  $('#program').on('change', function() {
    if ($(this).val() === 'penelitian') {
        $('#judulPenelitianDiv').show();
    } else {
        $('#judulPenelitianDiv').hide();
    }
  });
</script>

<?= $this->endSection(); ?>
