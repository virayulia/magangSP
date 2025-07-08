<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-home"></i>           
    </div>
    <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider">
<?php if(in_groups('user')): ?>
<!-- Heading -->
<div class="sidebar-heading">
    User Profil
</div>

<!-- Nav Item - Charts -->
<li class="nav-item">
    <a class="nav-link" href="/manage-user">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>User</span></a>
</li>

<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="/manage-pendaftaran">
        <i class="fas fa-fw fa-table"></i>
        <span>Pendaftaran</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">
<?php endif;?>

<?php if(in_groups('admin')): ?>
<div class="sidebar-heading">
    User
</div>
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="/manage-user" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Kelola Pengguna</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="/manage-user">Data Pendaftar</a>
            <a class="collapse-item" href="/manage-user">Data Admin</a>
        </div>
    </div>
</li>
<div class="sidebar-heading">
    Pendaftaran
</div>
<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="/kelola-unit">
        <i class="fas fa-fw fa-table"></i>
        <span>Kelola Unit</span></a>
</li>
<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="/kelola-kuota-unit">
        <i class="fas fa-fw fa-table"></i>
        <span>Kelola Kuota Unit</span></a>
</li>
<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="/kelola-kuota">
        <i class="fas fa-fw fa-table"></i>
        <span>Kelola Kuota</span></a>
</li>
<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="/kelola-lowongan">
        <i class="fas fa-fw fa-table"></i>
        <span>Kelola Lowongan</span></a>
</li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="/manage-pendaftaran" data-toggle="collapse" data-target="#collapseTwoP"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Kelola Pendaftaran</span>
    </a>
    <div id="collapseTwoP" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="/manage-pendaftaran">Data Pendaftaran</a>
            <a class="collapse-item" href="/manage-seleksi">Seleksi Pendaftaran</a>
            <a class="collapse-item" href="/manage-kelengkapan-berkas">Cek Kelengkapan Berkas</a>
        </div>
    </div>
</li>
<div class="sidebar-heading">
    Magang
</div>
<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="/manage-magang">
        <i class="fas fa-fw fa-table"></i>
        <span>Magang</span></a>
</li>
<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">
<?php endif;?>

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>