            <main role="main" class="col-10 ml-sm-auto">
                <div class="content-title mt-4 pt-3 pb-3 pl-3">
                    <h4>Tambah data</h4>
                    <i class="font-italic">Masukkan pemegang posisi.</i>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><b>Tambah pemegang posisi</b></li>
                        </ol>
                    </nav>
                    <?= $this->session->flashdata('message'); ?>
                </div>
                <div class="content mt-3">
                    <form action="<?= base_url('pemegangposisi/prosestambah') ?>" method="post" class="needs-validation" id="position-form">
                        <div class="accordion" id="accordionExample">
                        <div class="card">
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
                                <div class="col-6">
                                    <div class="form-group text-center">
                                        <label for="unitkerja" class="font-weight-bold">Unit Kerja</label>
                                        <select class="form-control" id="unitkerja" name="unitkerja">
                                            <option>Pilih Unit Kerja</option>
                                            <?php
                                                foreach ($unit_kerja as $key => $value) {
                                                    echo '<option value="'.md5($value->id_uk).'">'.$value->nama_uk.'</option>';
                                                }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">Pilih terlebih dahulu</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group text-center">
                                        <label for="jabatan" class="font-weight-bold">Jabatan</label>
                                        <select class="form-control" id="jabatan" name="jabatan">
                                        <option value="">Pilih Unit Kerja Terlebih Dahulu</option>
                                        </select>
                                        <div class="invalid-feedback">Pilih terlebih dahulu</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group text-center">
                                        <label for="atasan" class="font-weight-bold">Pegawai Atasan</label>
                                        <select class="form-control" id="atasan" name="atasan">
                                        <option value=''>Pilih Pegawai Atasan</option>
                                        <?php
                                            foreach ($pegawai as $key => $value) {
                                                echo '<option value="'.md5($value->npp).'">'.$value->npp.' - '.$value->namaPegawai.'</option>';
                                            }
                                        ?>
                                        </select>
                                        <div class="invalid-feedback">Pilih terlebih dahulu</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group text-center">
                                        <label for="incomben" class="font-weight-bold">Pegawai Incomben</label>
                                        <select class="form-control" id="incomben" name="incomben">
                                        <option value=''>Pilih Pegawai Incomben</option>
                                        <?php
                                            foreach ($pegawai as $key => $value) {
                                                echo '<option value="'.md5($value->npp).'">'.$value->npp.' - '.$value->namaPegawai.'</option>';
                                            }
                                        ?>
                                        </select>
                                        <div class="invalid-feedback">Pilih terlebih dahulu</div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="row mt-2 mb-2">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-md w-50" id="submit-form">Selanjutnya</button>
                            </div>
                        </div>
                    </form>
                    <i class="fa fa-copyright"> 2018</i>
                </div>
            </main>
        </div>
        </div>