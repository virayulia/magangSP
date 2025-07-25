<?= $this->extend('admin/templates/index');?>

<?= $this->section('content');?>

<div class="container-fluid">
<?php $session = \Config\Services::session(); ?>
<?php if ($session->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $session->getFlashdata('success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if ($session->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $session->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<h1 class="h3 mb-2 text-gray-800">Daftar Peserta Magang</h1>
<!-- Card Tabel -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0" id="dataTable">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Unit Kerja</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada data peserta magang saat ini.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data as $item): ?>
                        <tr>
                            <td><?= esc($item['fullname']) ?></td>
                            <td><?= esc($item['nisn_nim']) ?></td>
                            <td><?= esc($item['unit_kerja']) ?></td>
                            <td><?= format_tanggal_indonesia($item['tanggal_masuk']) ?></td>
                            <td><?= format_tanggal_indonesia($item['tanggal_selesai']) ?></td>                                                 
                            <td>
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#detailModal<?= $item['magang_id'] ?>">Detail</button>
                            </td>                          
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<?php foreach ($data as $item): ?>
<div class="modal fade" id="detailModal<?= $item['magang_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel<?= $item['magang_id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="detailModalLabel<?= $item['magang_id'] ?>">Detail Peserta - <?= esc($item['fullname']) ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <h6 class="text-primary">📌 Informasi Mahasiswa</h6>
            <table class="table table-sm table-bordered">
                <tr><th>Nama Lengkap</th><td><?= esc($item['fullname']) ?></td></tr>
                <tr><th>NIM/NISN</th><td><?= esc($item['nisn_nim']) ?></td></tr>
                <tr><th>Email</th><td><?= esc($item['email']) ?></td></tr>
                <tr><th>No HP</th><td><?= esc($item['no_hp']) ?></td></tr>
                <tr><th>Jenis Kelamin</th><?php if($item['jenis_kelamin'] === 'L'):?>
                                            <td>Laki-Laki</td>
                                          <?php elseif($item['jenis_kelamin'] === 'P'):?>
                                            <td>Perempuan</td>
                                        <?php endif;?>
                                          </tr>
                <tr><th>Alamat</th><td><?php
                        $alamat = $item['alamat'] ?? '';
                        $kota = trim(($item['tipe_kota_ktp'] ?? '') . ' ' . ($item['kota_ktp'] ?? ''));
                        $prov = $item['provinsi_ktp'] ?? '';
                        $parts = array_filter([$alamat, $kota, $prov]);
                        echo esc(implode(', ', $parts)) ?: 'Data belum diisi';
                    ?></td></tr>
                <tr><th>Domisili</th><td><?php
                          $alamat = $item['domisili'] ?? '';
                          $kota = trim(($item['tipe_kota_domisili'] ?? '') . ' ' . ($item['kota_domisili'] ?? ''));
                          $prov = $item['provinsi_domisili'] ?? '';
                          $parts = array_filter([$alamat, $kota, $prov]);
                          echo esc(implode(', ', $parts)) ?: 'Data belum diisi';
                      ?></td></tr>
            </table>

            <h6 class="text-primary mt-4">🎓 Pendidikan</h6>
            <table class="table table-sm table-bordered">
                <tr><th>Tingkat</th><td><?= esc($item['tingkat_pendidikan']) ?></td></tr>
                <tr><th>Instansi</th><td><?= esc($item['nama_instansi']) ?></td></tr>
                <tr><th>Jurusan</th><td><?= esc($item['nama_jurusan']) ?></td></tr>
                <?php if($item['tingkat_pendidikan'] === 'SMK'):?>
                <tr><th>Kelas</th><td>Kelas <?= esc($item['semester']) ?></td></tr>
                <?php else:?>
                <tr><th>Semester</th><td>Semester <?= esc($item['semester']) ?></td></tr>
                <tr><th>IPK</th><td><?= esc($item['nilai_ipk']) ?></td></tr>
                <?php endif;?>
                
            </table>

            <h6 class="text-primary mt-4">🗂️ Dokumen</h6>
            <table class="table table-sm table-bordered">
                <?php if($item['tingkat_pendidikan'] === 'SMK'):?>
                    <tr><th>Surat Permohonan</th><td><?= $item['surat_permohonan'] ? '<a href="'.base_url('uploads/surat-permohonan/'.$item['surat_permohonan']).'" target="_blank">Lihat Surat</a>' : 'Belum Ada' ?></td></tr>
                    <tr><th>KTP/KK</th><td><?= $item['ktp_kk'] ? '<a href="'.base_url('uploads/ktp-kk/'.$item['ktp_kk']).'" target="_blank">Lihat KTP/KK</a>' : 'Belum Ada' ?></td></tr>
                    <tr><th>BPJS TK</th><td><?= $item['bpjs_tk'] ? '<a href="'.base_url('uploads/bpjs-tk/'.$item['bpjs_tk']).'" target="_blank">Lihat BPJS TK</a>' : 'Belum Ada' ?></td></tr>
                    <tr><th>Bukti BPJS TK</th><td><?= $item['buktibpjs_tk'] ? '<a href="'.base_url('uploads/buktibpjs-tk/'.$item['buktibpjs_tk']).'" target="_blank">Lihat Bukti</a>' : 'Belum Ada' ?></td></tr>
                <?php else:?>
                    <tr><th>CV</th><td><?= $item['cv'] ? '<a href="'.base_url('uploads/cv/'.$item['cv']).'" target="_blank">Lihat CV</a>' : 'Belum Ada' ?></td></tr>
                    <tr><th>Proposal</th><td><?= $item['proposal'] ? '<a href="'.base_url('uploads/proposal/'.$item['proposal']).'" target="_blank">Lihat Proposal</a>' : 'Belum Ada' ?></td></tr>
                    <tr><th>Surat Permohonan</th><td><?= $item['surat_permohonan'] ? '<a href="'.base_url('uploads/surat-permohonan/'.$item['surat_permohonan']).'" target="_blank">Lihat Surat</a>' : 'Belum Ada' ?></td></tr>
                    <tr><th>KTP/KK</th><td><?= $item['ktp_kk'] ? '<a href="'.base_url('uploads/ktp-kk/'.$item['ktp_kk']).'" target="_blank">Lihat KTP/KK</a>' : 'Belum Ada' ?></td></tr>
                    <tr><th>BPJS TK</th><td><?= $item['bpjs_tk'] ? '<a href="'.base_url('uploads/bpjs-tk/'.$item['bpjs_tk']).'" target="_blank">Lihat BPJS TK</a>' : 'Belum Ada' ?></td></tr>
                    <tr><th>Bukti BPJS TK</th><td><?= $item['buktibpjs_tk'] ? '<a href="'.base_url('uploads/buktibpjs-tk/'.$item['buktibpjs_tk']).'" target="_blank">Lihat Bukti</a>' : 'Belum Ada' ?></td></tr>
                <?php endif;?>
            </table>

            <h6 class="text-primary mt-4">📆 Status Magang</h6>
            <table class="table table-sm table-bordered">
                <tr><th>Unit Kerja</th><td><?= esc($item['unit_kerja']) ?></td></tr>
                <tr><th>Tanggal Masuk</th><td><?= esc(format_tanggal_indonesia($item['tanggal_masuk'])) ?></td></tr>
                <tr><th>Tanggal Selesai</th><td><?= esc(format_tanggal_indonesia($item['tanggal_selesai'])) ?></td></tr>
                <tr><th>Status Akhir</th><td><span class="badge badge-info"><?= esc($item['status_akhir']) ?></span></td></tr>
            </table>
        </div>
        <div class="modal-footer">
            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal<?= $item['magang_id'] ?>">Edit</button>
            <button class="btn btn-sm btn-danger" onclick="batalkanMagang(<?= $item['magang_id'] ?>, 'detailModal<?= $item['magang_id'] ?>')">Batalkan</button>
            <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Modal Edit -->
 <?php foreach ($data as $item): ?>
<div class="modal fade" id="editModal<?= $item['magang_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $item['magang_id'] ?>" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('admin/updateMagang/'.$item['magang_id']) ?>" method="post">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Magang - <?= esc($item['fullname']) ?></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" class="form-control" value="<?= $item['tanggal_masuk'] ?>">
                </div>
                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="<?= $item['tanggal_selesai'] ?>">
                </div>
                <div class="form-group">
                    <label>Unit Kerja</label>
                    <select name="unit_id" class="form-control">
                        <?php foreach ($unitList as $unit): ?>
                            <option value="<?= $unit['unit_id'] ?>" <?= $unit['unit_id'] == $item['unit_id'] ? 'selected' : '' ?>>
                                <?= esc($unit['unit_kerja']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </form>
  </div>
</div>
<?php endforeach; ?>

<script>
    function batalkanMagang(id, modalId) {
    // Tutup modal Bootstrap dulu
    $('#' + modalId).modal('hide');

    // Delay agar modal benar-benar tertutup sebelum SweetAlert muncul
    setTimeout(function() {
        Swal.fire({
            title: 'Batalkan Magang?',
            input: 'textarea',
            inputLabel: 'Alasan Pembatalan',
            inputPlaceholder: 'Tulis alasan pembatalan di sini...',
            inputAttributes: {
                'aria-label': 'Tulis alasan pembatalan'
            },
            showCancelButton: true,
            confirmButtonText: 'Batalkan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            preConfirm: (alasan) => {
                if (!alasan) {
                    Swal.showValidationMessage('Alasan pembatalan wajib diisi.');
                }
                return alasan;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= base_url('admin/batalkanMagang') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'id': id,
                        'alasan': result.value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire('Berhasil', 'Peserta magang telah dibatalkan.', 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Gagal', 'Terjadi kesalahan.', 'error');
                    }
                });
            }
        });
    }, 300); 
}
</script>


</div>

<?= $this->endSection() ?>
