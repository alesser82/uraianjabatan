<div class="container-fluid">
<div class="row aside-content">
    <div class="col-2 menu-sidebar collapse show" id="sidebar-collapse">
        <div class="sidebar-sticky">
            <div class="pt-3 pb-0 admin-logo border-bottom border-dark">
            <div class="d-flex flex-row bd-highlight mb-2 align-self-center">
                <div class="p-1 bd-highlight"><img src="<?= base_url('assets/img/admin.png') ?>" class="rounded-circle admin-logo" alt="admin-logo"></div>
                <div class="pr-2 mt-2 bd-highlight"><p><?= $this->session->nama_jabatan != '' ? $this->session->nama_jabatan : 'Masukkan Uraian Jabatan Anda' ?></p></div>
            </div>
        </div>
        <div class="sidenav pt-2">
        <button class="dropdown-btn<?= $konten === 'uraian_jabatan' ? ' active' : '' ?>">
            <img src="<?= base_url('assets/img/list.svg') ?>" alt="uraian-jabatan-logo">
            Uraian Jabatan
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container pl-5<?= $konten === 'uraian_jabatan' ? ' active' : '' ?>">
            <a href="<?= base_url('uraianjabatan/tambah') ?>" <?= $fungsi === 'uraian_jabatan-tambah' ? 'class="active"' : '' ?>><img src="<?= base_url('assets/img/oval.svg') ?>" alt="oval-icon"> Tambah</a>
            <a href="<?= base_url('uraianjabatan/ubah') ?>" <?= $fungsi === 'uraian_jabatan-ubah' ? 'class="active"' : '' ?>><img src="<?= base_url('assets/img/oval.svg') ?>" alt="oval-icon"> Ubah</a>
            <a href="<?= base_url('uraianjabatan/cetak') ?>" <?= $fungsi === 'uraian_jabatan-cetak' ? 'class="active"' : '' ?>><img src="<?= base_url('assets/img/oval.svg') ?>" alt="oval-icon"> Cetak</a>
        </div>
        <button class="dropdown-btn">
            <img src="<?= base_url('assets/img/users.svg') ?>" alt="uraian-jabatan-logo">
            Pemegang Posisi
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container pl-5<?= $konten === 'pemegang_posisi' ? ' active' : '' ?>">
            <a href="<?= base_url('pemegangposisi/tambah') ?>" <?= $fungsi === 'pemegang_posisi-tambah' ? 'class="active"' : '' ?>><img src="<?= base_url('assets/img/oval.svg') ?>" alt="oval-icon"> Tambah</a>
            <a href="<?= base_url('pemegangposisi/ubah') ?>" <?= $fungsi === 'pemegang_posisi-ubah' ? 'class="active"' : '' ?>><img src="<?= base_url('assets/img/oval.svg') ?>" alt="oval-icon"> Ubah</a>
            <a href="<?= base_url('pemegangposisi/cetak') ?>" <?= $fungsi === 'pemegang_posisi-cetak' ? 'class="active"' : '' ?>><img src="<?= base_url('assets/img/oval.svg') ?>" alt="oval-icon"> Cetak</a>
        </div>
        </div>
        </div>
        </div>
    </div>