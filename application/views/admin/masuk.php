<body class="login">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 align-middle">
                <table>
                    <tbody>
                        <tr>
                            <td class="align-middle">
                                <img src="<?=base_url('assets/img/logo.png') ?>" alt="sucofindo-logo" class="mx-auto d-block"><br>
                                <div class="row justify-content-center">
                                    <div class="col-lg-3">
                                    <?= $this->session->flashdata('message'); ?>
                                    </div>
                                </div>
                                <form class="mx-auto" method="post" action="<?= base_url('admin/prosesmasuk') ?>" id="form-login">
                                
                                    <div class="form-group">
                                        <label for="npp-login">NPP</label>
                                        <input type="number" name="npp" class="form-control" id="npp-login" placeholder="123456">
                                        <div class="invalid-feedback">
                                            Isi terlebih dahulu.
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sandi-login">Kata Sandi</label>
                                        <input type="password" name="katasandi" class="form-control" id="sandi-login" placeholder="***">
                                        <div class="invalid-feedback">
                                            Isi terlebih dahulu.
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <a href="<?= base_url('admin/lupakatasandi') ?>">Lupa kata sandi ?</a>
                                    </div>
                                    <div class="form-group">
                                    <button type="submit" class="btn btn-primary mx-auto">Masuk</button>
                                    </div>
                                    <p>Belum punya akun ? Buat <a href="<?= base_url('admin/daftar') ?>">disini.</a></p>
                                    </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>