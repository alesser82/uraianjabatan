            <main role="main" class="col-10 ml-sm-auto">
                <div class="content-title mt-4 pt-3 pb-3 pl-3">
                    <h4>Ubah Pemegang Posisi</h4>
                    <i class="font-italic">Pilih Pemegang Posisi.</i>
                    <nav aria-label="breadcrumb" class="mr-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><a href="<?= base_url('pemegangposisi/ubah') ?>">Ubah Pemegang Posisi</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><b>LKK</b></li>
                    </ol>
                    </nav>
                    <?= $this->session->flashdata('message'); ?>
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12">
                                    <form method="get" id="jobdesc-search-form">
                                    <div class="form-group">
                                        <label for="atasan" class="font-weight-bold">Pegawai Atasan</label>
                                        <select class="custom-select custom-select-sm" id="atasan" name="atasan">
                                        <option value="">Pilih Pegawai Atasan</option>
                                        <?php
                                            foreach ($pegawai as $key => $value) {
                                                echo '<option value="'.md5($value->npp).'">'.$value->npp.' - '.$value->namaPegawai.'</option>';
                                            }
                                        ?>
                                        </select>
                                        <div class="invalid-feedback">Pilih terlebih dahulu</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="incomben" class="font-weight-bold">Pegawai Incomben</label>
                                        <select class="custom-select custom-select-sm" id="incomben" name="incomben">
                                        <option value="">Pilih Pegawai Atasan Terlebih Dahulu</option>
                                        </select>
                                        <div class="invalid-feedback">Pilih terlebih dahulu</div>
                                    </div>
                                    <button type="submit" class="btn btn-info">Cari</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content mt-3">
                    <i class="fa fa-copyright"> 2018</i>
                </div>
            </main>
        </div>
        </div>