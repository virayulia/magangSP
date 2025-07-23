<?= $this->extend('user/template'); ?>
<?= $this->section('main-content'); ?>

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

<!-- Tabs Lamaran -->
<div class="profile-card">
    <ul class="nav nav-tabs profile-tabs mb-4" id="lamaranTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="status-lamaran-tab" data-bs-toggle="tab" data-bs-target="#pelaksanaan" type="button" role="tab">
                Pelaksanaan Magang
            </button>
        </li>
    </ul>
    <?php if (!empty($pendaftaran)): ?>
    <div class="tab-content" id="lamaranTabContent">
        <div class="tab-pane fade show active" id="pelaksanaan" role="tabpanel">
            <p class="text-muted">Panduan dan tugas penting yang perlu kamu selesaikan sebelum memulai magang:</p>


            <!-- Surat Pernyataan -->
            <!-- Tombol Buka Surat Pernyataan -->
<div class="card shadow-sm mb-4">
    <div class="card-body ">
        <h5 class="card-title">📝 Surat Pernyataan</h5>
        
        
        <?php if (!empty($pendaftaran['tanggal_setujui_pernyataan'])): ?>
            <div class="alert alert-success p-4 text-center">
                <h5 class="mb-3">✅ Terima Kasih!</h5>
                Anda telah menyetujui <strong>Surat Pernyataan</strong>. <br>
               Persetujuan ini telah tercatat pada: <br>
                <strong><?= format_tanggal_indonesia(date('d M Y', strtotime($pendaftaran['tanggal_setujui_pernyataan']))) ?></strong></p>

                <a href="<?= base_url('magang/surat-pernyataan') ?>" target="_blank" >
                    Lihat Surat Pernyataan
                </a>
            </div>
        <?php else: ?>
            <p>Klik tombol di bawah ini untuk membaca dan menyetujui surat pernyataan.</p>
            <a href="<?= base_url('magang/surat-pernyataan') ?>" class="btn btn-primary">Baca & Setujui Surat Pernyataan</a>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Surat Pernyataan -->
<div class="modal fade" id="modalPernyataan" tabindex="-1" aria-labelledby="modalPernyataanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form action="<?= base_url('magang/setuju-surat-pernyataan') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPernyataanLabel">Surat Pernyataan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Yang bertanda tangan di bawah ini:</p>
                    <ul>
                        <li><strong>Nama:</strong> <?= esc(user()->fullname) ?></li>
                        <li><strong>NISN/NIM:</strong> <?= esc(user()->nisn_nim) ?></li>
                        <li><strong>Perguruan Tinggi/Sekolah:</strong> <?= esc($user_data->nama_instansi ?? '-') ?></li>
                        <li><strong>Alamat sesuai KTP:</strong> <?= esc(user()->alamat ?? '-') ?></li>
                    </ul>
                    <p>Dengan ini menyatakan bahwa saya adalah mahasiswa/siswa yang melakukan Kerja Praktek/Penelitian di Unit <?= $pendaftaran['unit_kerja']; ?> 
                    PT Semen Padang sejak Tanggal <?= $pendaftaran['tanggal_masuk'];?> sampai dengan <?= $pendaftaran['tanggal_selesai']; ?></p>
                    <p>Saya menyatakan hal-hal sebagai berikut:</p>
                    <ol>
                        <strong><li>Kepatuhan terhadap Peraturan Perusahaan dan K3</li></strong>
                        <ul>
                            <li>Saya akan mematuhi semua peraturan dan tata tertib yang berlaku di PT Semen Padang, serta menjaga nama baik Perguruan TInggi/Sekolah dan Perusahaan.</li>
                            <li>Selama melaksanakan Kerja Praktek/Penelitian di area kerja PT Semen Padang (Produksi, Pemeliharaan, Tambang, SP Inventory, dan SHE), saya akan memakai sepatu safety, helm warna biru dengan tali pengaman, serta rompi scotlight/safety vest sesuai dengan standar keselamatan kerja.</li>
                        </ul>
                        <strong><li>Tanggung Jawab dan Perawatan Fasilitas Perusahaan</li></strong>
                        <ul>
                            <li>Saya akan melaksanakan tugas dan tanggung jawab yang diberikan dengan penuh tanggung jawab.</li>
                            <li>Saya akan menjaga kondisi barang, peralatan dan fasilitas milik Perusahaan agar tetap dalam keadaan yang baik dan berfungsi dengan optimal.</li>
                        </ul>
                        <strong><li>Kerahasiaan Data dan Informasi</li></strong>
                        <ul>
                            <li>Saya memahami bahwa semua data dan informasi yang diperoleh selama kegiatan Kerja Praktek/Penelitian adalah sepenuhnya milik PT Semen Padang</li>
                            <li>Saya berkomitmen untuk menjaga kerahasiaan data dan informasi milik PT Semen Padang, serta tidak akan memberikan dan/atau menyebarkannya kepada pihak yang tidak berkepentingan atau pihat lain yang dapat memanfaatkan data tersebut untuk kepentingan pribadi/kelompok yang dapat atau berpotensi merugikan PT Semen Padang.</li>
                            <li>Seluruh data dan informasi yang diterima dari PT Semen Padang hanya akan digunakan untuk keperluan penulisan hasil Kerja Praktek/Penelitian dan tidak akan dipublikasikan secara umum atau digunakan untuk kepentingan lain tanpa izin dari PT Semen Padang.</li>
                            <li>Pernyataan mengenai kerahasiaan data dan informasi ini tetap berlaku dan mengikat meskipun periode Kerja Praktek/Penelitian telah berakhir. Untuk penggunaan data dan informasi yang akan dipublikasikan atau digunakan dikemudian hari, saya akan memperoleh persetujuan ulang dari PT Semen Padang.</li>
                        </ul>
                        <strong><li>Sanksi</li></strong>
                        <ul>
                            <li>Saya bersedia dikenakan sanksi sesuai peraturan yang berlaku dan akan bertanggung jawab secara hukum apabila melakukan pelanggaran pada poin 1, 2 dan 3 diatas. Saya siap menanggung biaya kerusakan atau kerugian yang ditimbulkan oleh pelanggaran tersebut.</li>
                        </ul>
                    </ol>
                    <p>Demikian surat pernyataan ini saya buat dengan sebenar-benarnya tanpa adanya tekanan dari pihak manapun.</p>
                    <p><strong>Padang, <?= date('d M Y') ?></strong></p>
                    <p><em>Yang membuat pernyataan</em></p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Setujui & Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>



            <!-- Safety Induction -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">🦺 Safety Induction</h5>
                    <p>Harap mempelajari prosedur keselamatan kerja berikut ini. Anda akan mengikuti tes keselamatan kerja pada hari pertama pelaksanaan magang.</p>

                    <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                        <a href="https://shorturl.at/0y7p7" class="btn btn-outline-info">
                            <i class="bi bi-info-circle"></i> Penjelasan Safety Induction
                        </a>
                   
                        <a href="<?= base_url('safety-tes') ?>" class="btn btn-outline-warning">
                            <i class="bi bi-journal-check"></i> Ikuti Tes Safety Induction
                        </a>
                    </div>

                    <!-- Status Tes -->
                    <?php if (!empty($pendaftaran['tgl_safety_induction'])): ?>
                        <div class="alert alert-success mt-3">
                            ✅ Tes Safety Induction telah diselesaikan pada <strong><?= date('d M Y', strtotime($pendaftaran['tgl_safety_induction'])) ?></strong>.
                        </div>
                    <?php endif; ?>

                    <!-- Riwayat Tes -->
                    <?php if (!empty($riwayat_safety)): ?>
                        <div class="mt-4">
                            <h6>Riwayat Tes Safety Induction:</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Percobaan</th>
                                            <th>Skor</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($riwayat_safety as $i => $r): ?>
                                        <tr>
                                            <td><?= $i + 1 ?></td>
                                            <td><?= date('d M Y, H:i', strtotime($r['created_at'])) ?></td>
                                            <td><?= $r['percobaan_ke'] ?></td>
                                            <td><?= $r['nilai'] ?></td>
                                            <td>
                                                <?= $r['nilai'] >= 70 ? '<span class="badge bg-success">Lulus</span>' : '<span class="badge bg-danger">Tidak Lulus</span>' ?>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-warning">Kamu belum lulus seleksi atau belum melengkapi berkas, sehingga belum bisa mengakses informasi pelaksanaan magang.</div>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>
