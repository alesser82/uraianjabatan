<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?= base_url('assets/img/icon/') ?>apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url('assets/img/icon/') ?>apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url('assets/img/icon/') ?>apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url('assets/img/icon/') ?>apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?= base_url('assets/img/icon/') ?>apple-touch-icon-60x60.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?= base_url('assets/img/icon/') ?>apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?= base_url('assets/img/icon/') ?>apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?= base_url('assets/img/icon/') ?>apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/icon/') ?>favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/icon/') ?>favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/icon/') ?>favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/icon/') ?>favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/icon/') ?>favicon-128.png" sizes="128x128" />
    <meta name="application-name" content="&nbsp;"/>
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="mstile-144x144.png" />
    <meta name="msapplication-square70x70logo" content="mstile-70x70.png" />
    <meta name="msapplication-square150x150logo" content="mstile-150x150.png" />
    <meta name="msapplication-wide310x150logo" content="mstile-310x150.png" />
    <meta name="msapplication-square310x310logo" content="mstile-310x310.png" />
    <title><?= $judul ?></title>
    <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/all.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-select.css');?>">
</head>
<body class="uraian-jabatan">
    <header class="uraian-jabatan">
        <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 text-center" style="background:#96AEBD;">
                <a href="<?= base_url('uraianjabatan/tambah')?>" class="logo-menu"><img src="<?= base_url('assets/img/logo.png') ?>" alt="sucofindo-logo" class="logo-menu-img pt-1 pb-1"></a>
            </div>
            <div class="col-lg-10">
                <nav class="navbar navbar-dark">
                    <a href="sidebar-collapse" role='button' class="sidebar-button navbar-brand" data-toggle="collapse"><img src="<?= base_url('assets/img/menu.png') ?>" alt="menu-icon"></a>
                    <ul class="nav nav-pills justify-content-end">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle mt-0 text-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->session->nama; ?></a>
                        <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= base_url('admin/ubahkatasandibaru') ?>">Ubah kata sandi</a>
                        <a class="dropdown-item" href="<?= base_url('admin/hapusakun') ?>">Hapus akun</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= base_url('uraianjabatan/keluar') ?>">Keluar</a>
                        </div>
                    </li>
                </ul>
                </nav>
            </div>
        </div>
        </div>
    </header>