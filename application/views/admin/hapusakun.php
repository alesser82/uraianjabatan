            <main role="main" class="col-10 ml-sm-auto">
                <div class="content-title mt-4 pt-3 pb-3 pl-3">
                    <h4>Hapus akun</h4>
                    <i class="font-italic">Isi formulir</i>
                    <?= $this->session->flashdata('message'); ?>
                </div>
                <div class="content mt-3">
                    <div class="row bg-white mr-0 ml-0 p-5">

                        <!-- Formulir Hapus Akun -->
                        <form method="post" action="<?= base_url('admin/proseshapusakun') ?>" class="mx-auto">
                            <div class="col-12">
                                <div class="form-group text-center">
                                    <label for="npp">NPP</label>
                                    <input type="number" class="form-control border-top-0 border-left-0 border-right-0" id="npp" placeholder="1234" name="npp">
                                    <div class="invalid-feedback">Isi terlebih dahulu</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group text-center">
                                    <label for="password">Kata sandi</label>
                                    <input type="password" class="form-control border-top-0 border-left-0 border-right-0" id="password" placeholder="******" name="katasandi">
                                    <div class="invalid-feedback">Isi terlebih dahulu</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-primary btn-md w-100" data-toggle="modal" data-target="#delete-confirmation">Hapus Akun</button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="delete-confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus Akun</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Jika akun dihapus, maka pemilik akun tidak bisa mengelola uraian jabatan.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Lanjutkan</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <i class="fa fa-copyright"> 2018</i>
                </div>
            </main>
        </div>
        </div>