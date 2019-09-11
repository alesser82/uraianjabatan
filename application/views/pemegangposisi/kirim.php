            <main role="main" class="col-10 ml-sm-auto">
                <div class="content-title mt-4 pt-3 pb-3 pl-3">
                    <h4>Kirim Data</h4>
                    <i class="font-italic">Masukkan pemegang posisi.</i>
                    <?= $this->session->flashdata('message'); ?>
                </div>
                <div class="content mt-3">
                    <form action="<?= base_url('pemegangposisi/proseskirim') ?>" method="post" class="needs-validation" id="position-form" enctype="multipart/form-data">
                        <div class="accordion" id="accordionExample">
                        <div class="card" id="send-jobdesc">
                            <div class="card-header" id="headingOne">
                                <button class="btn btn-link btn-symbol" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="triangle-button" style="">
                                    </div>
                                </button>
                                <button class="btn btn-link pt-2 pb-0 btn-text" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <h5 class="text-uppercase">Pemegang Posisi </h5>
                                </button>
                                <i class="fas fa-star-of-life fa-xs text-danger"></i>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group text-center" id="incomben-filter">
                                            <label for="atasan" class="font-weight-bold">Pegawai Incomben</label>   
                                            <select class="selectpicker form-control" data-live-search="true" id="incomben" name="incomben[]" data-style="btn-info" multiple title="Pilih Pemegang Posisi">
                                                <option value="">Pilih Pegawai</option>
                                                <?php
                                                    foreach ($pegawai as $key => $value) {
                                                        echo '<option value="'.$value->mail.'" data-tokens="'. $value->namaPegawai .' '. $value->npp .'">'. $value->npp .' - '. $value->namaPegawai .'</option>';
                                                    }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">Pilih terlebih dahulu</div>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="uraianjabatan" name="uraianjabatan[]" accept=".pdf" multiple>
                                            <label class="custom-file-label" for="strukturorganisasi" data-browse="Cari">Pilih Uraian Jabatan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="row mt-2 mb-2">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-md w-50" id="submit-form">Kirim</button>
                            </div>
                        </div>
                    </form>
                    <i class="fa fa-copyright"> 2018</i>
                </div>
            </main>
        </div>
        </div>