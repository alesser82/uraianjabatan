<body class="login">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 align-middle">
                <table>
                    <tbody>
                        <tr>
                            <td class="align-middle">
                                <a href="<?= base_url('') ?>"><img src="<?=base_url('assets/img/logo.png') ?>" alt="sucofindo-logo" class="mx-auto d-block"></a><br>
                                <div class="row justify-content-center">
                                    <div class="col-lg-3">
                                    <?= $this->session->flashdata('message'); ?>
                                    </div>
                                </div>
                                <form class="mx-auto" method="post" action="<?= base_url('admin/prosesubahkatasandilama') ?>" id="form-forgot">
                                    <div class="form-group">
                                        <label for="npp-forgot">Kata sandi baru</label>
                                        <input type="password" name="katasandi1" class="form-control" id="npp-forgot" placeholder="***">
                                        <div class="invalid-feedback">
                                            Isi terlebih dahulu.
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="npp-forgot">Ulangi kata sandi</label>
                                        <input type="password" name="katasandi2" class="form-control" id="npp-forgot" placeholder="***">
                                        <div class="invalid-feedback">
                                            Isi terlebih dahulu.
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    <button type="submit" class="btn btn-primary mx-auto">Ubah</button>
                                    </div>
                                    </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>