<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-home"></i>           
    </div>
    <div class="sidebar-brand-text mx-3">Admin PTSP</div>
</a>

<?php if(in_groups('admin')): ?>
<div class="sidebar-heading">
    Magang
</div>
<li class="nav-item">
    <a class="nav-link" href="/manage-pendaftaran">
        <i class="fas fa-fw fa-table"></i>
        <span>Data Pendaftar</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/manage-seleksi">
        <i class="fas fa-fw fa-table"></i>
        <span>Seleksi Pendaftar</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/manage-kelengkapan-berkas">
        <i class="fas fa-fw fa-table"></i>
        <span>Kelengkapan Berkas</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/manage-magang">
        <i class="fas fa-fw fa-table"></i>
        <span>Magang</span></a>
</li>
<div class="sidebar-heading">
    Penelitian
</div>
<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="/manage-penelitian">
        <i class="fas fa-fw fa-table"></i>
        <span>Data Pendaftar</span></a>
</li>
<div class="sidebar-heading">
    Kelola
</div>

<li class="nav-item">
    <a class="nav-link" href="/kelola-lowongan">
        <i class="fas fa-fw fa-table"></i>
        <span>Lowongan</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/kuota-unit">
        <i class="fas fa-fw fa-table"></i>
        <span>Kuota Magang</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/jurusan-unit">
        <i class="fas fa-fw fa-table"></i>
        <span>Jurusan Unit</span></a>
</li>
<!-- <li class="nav-item">
    <a class="nav-link collapsed" href="/kelola-unit" data-toggle="collapse" data-target="#collapseThree"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-table"></i>
        <span>Unit dan Kuota</span>
    </a>
    <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="/kelola-kuota-unit">Kuota Unit</a>
            <a class="collapse-item" href="/kelola-kuota">Lihat Kuota Tersedia</a>
        </div>
    </div>
</li> -->
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="/manage-user" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Pengguna</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="/manage-user">Data User</a>
            <a class="collapse-item" href="/manage-user">Data Admin</a>
        </div>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="/kelola-instansi" data-toggle="collapse" data-target="#collapseFour"
        aria-expanded="true" aria-controls="collapseFour">
        <i class="fas fa-fw fa-table"></i>
        <span>Data Master</span>
    </a>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="/kelola-unit">Unit</a>
            <a class="collapse-item" href="/kelola-instansi">Instansi</a>
            <a class="collapse-item" href="/kelola-jurusan">Jurusan</a>
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">
<?php endif;?>

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>