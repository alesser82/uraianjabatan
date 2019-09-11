            <main role="main" class="col-10 ml-sm-auto">
                <div class="content-title mt-4 pt-3 pb-3 pl-3">
                    <h4>Cetak Uraian Jabatan</h4>
                    <i class="font-italic">Pilih pemegang posisi</i>
                    <nav aria-label="breadcrumb" class="mr-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('pemegangposisi/cetak') ?>">Pilih format</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><b>Pilih pemegang posisi</b></li>
                        <!-- <li class="breadcrumb-item">Data</li> -->
                    </ol>
                    </nav>
                    <form method="get" id="jobdesc-search-form">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="atasan" class="font-weight-bold">Pegawai Atasan</label>
                                <select class="custom-select" name="atasan" id="atasan">
                                <option value="">Pilih Pegawai Atasan</option>
                                <?php
                                    foreach ($pegawai as $key => $value) {
                                        echo '<option value="'.md5($value['npp']).'">'.$value['npp'].' - '.$value['namaPegawai'].'</option>';
                                    }
                                ?>
                                </select>
                                <div class="invalid-feedback">Pilih terlebih dahulu</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="incomben" class="font-weight-bold">Pegawai Incomben</label>
                                <select class="custom-select" name="incomben" id="incomben">
                                <option value="">Pilih Pegawai Atasan Terlebih Dahulu</option>
                                </select>
                                <div class="invalid-feedback">Pilih terlebih dahulu</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <button type="submit" class="btn btn-info">Cetak</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="content mt-3">
                    <i class="fa fa-copyright"> 2018</i>
                </div>
            </main>
        </div>
        </div>