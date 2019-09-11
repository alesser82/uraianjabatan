<body class="login">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 align-middle">
                <table>
                    <tbody>
                        <tr>
                            <td class="align-middle">
                                <a href="<?= base_url('') ?>"><img src="<?=base_url('assets/img/logo.png') ?>" alt="sucofindo-logo" class="mx-auto d-block"></a><br>
                                <form class="mx-auto" method="post" action="<?= base_url('Admin/prosesdaftar') ?>" id="form-register">
                                    <!-- <div class="form-group">
                                        <label for="name-register">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control" id="name-register" placeholder="Aldi Rahman" required>
                                        <small id="namaHelp" class="form-text text-muted">Nama sesuai dengan kartu pengenal.</small>
                                        <div class="invalid-feedback">
                                            Isi terlebih dahulu.
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="npp-register">NPP</label>
                                        <input type="number" name="npp" class="form-control" id="npp-register" placeholder="123456" required>
                                        <div class="invalid-feedback">
                                            Isi terlebih dahulu.
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="atasan-register">Nama Atasan</label>
                                        <input type="text" name="atasan" class="form-control" id="atasan-register" placeholder="Seno Setiawan" required>
                                        <small id="atasanHelp" class="form-text text-muted">Nama sesuai dengan kartu pengenal.</small>
                                        <div class="invalid-feedback">
                                            Isi terlebih dahulu.
                                        </div>
                                    </div> -->
                                    <!-- <div class="form-group">
                                        <label for="email-register">Email</label>
                                        <input type="email" name="email" class="form-control" id="email-register" placeholder="admin@admin.com" required>
                                        <div class="invalid-feedback">
                                            Isi terlebih dahulu.
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                    <button type="submit" class="btn btn-primary mx-auto">Daftar</button>
                                    </div>
                                    </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>