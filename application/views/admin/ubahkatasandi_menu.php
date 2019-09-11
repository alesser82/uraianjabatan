            <main role="main" class="col-10 ml-sm-auto">
                <div class="content-title mt-4 pt-3 pb-3 pl-3">
                    <h4>Ubah Kata Sandi</h4>
                    <i class="font-italic">Isi formulir</i>
                    <?= $this->session->flashdata('message'); ?>
                </div>
                <div class="content mt-3">
                    <div class="row bg-white mr-0 ml-0 p-5">
                        <div class="col-12">
                            <form action="<?= base_url('admin/prosesubahkatasandibaru') ?>" method="post" id="change-password-form">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group text-center">
                                            <label for="npp">NPP</label>
                                            <input type="number" class="form-control border-top-0 border-left-0 border-right-0" id="npp" placeholder="1234" name="npp">
                                            <div class="invalid-feedback">Isi terlebih dahulu</div>
                                        </div>
                                        <div class="form-group text-center">
                                            <label for="katasandilama">Kata Sandi Lama</label>
                                            <input type="password" class="form-control border-top-0 border-left-0 border-right-0" id="katasandilama" placeholder="*******" name="katasandilama">
                                            <div class="invalid-feedback">Isi terlebih dahulu</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group text-center">
                                            <label for="katasandibaru">Kata Sandi Baru</label>
                                            <input type="password" class="form-control border-top-0 border-left-0 border-right-0" id="katasandibaru" placeholder="*******" name="katasandibaru">
                                            <div class="invalid-feedback">Isi terlebih dahulu</div>
                                        </div>
                                        <div class="form-group text-center">
                                            <label for="katasandibaru2">Ulang Kata Sandi Baru</label>
                                            <input type="password" class="form-control border-top-0 border-left-0 border-right-0" id="katasandibaru2" placeholder="*******" name="katasandibaru2">
                                            <div class="invalid-feedback">Isi terlebih dahulu</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2 mb-2">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-md w-25" id="submit-form">Simpan</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <i class="fa fa-copyright"> 2018</i>
                </div>
            </main>
        </div>
        </div>