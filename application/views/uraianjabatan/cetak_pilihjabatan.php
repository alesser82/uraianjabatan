            <main role="main" class="col-10 ml-sm-auto">
                <div class="content-title mt-4 pt-3 pb-3 pl-3">
                    <h4>Cetak Uraian Jabatan</h4>
                    <i class="font-italic">Pilih jabatan</i>
                    <nav aria-label="breadcrumb" class="mr-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('uraianjabatan/cetak') ?>">Pilih format</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><b>Pilih jabatan</b></li>
                        <!-- <li class="breadcrumb-item">Data</li> -->
                    </ol>
                    </nav>
                    <form method="get" id="jobdesc-search-form">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="unitkerja" class="font-weight-bold">Unit Kerja</label>
                                <select class="custom-select" name="unitkerja" id="unitkerja">
                                <option value=''>Pilih Unit Kerja</option>
                                <?php
                                    foreach ($unitkerja as $value) {
                                        echo '<option value="'.md5($value["id_uk"]).'">'.$value["nama_uk"].'</option>';
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
                                <label for="jabatan" class="font-weight-bold">Jabatan</label>
                                <select class="custom-select" name="jabatan" id="jabatan">
                                <option value="">Pilih Unit Kerja Terlebih Dahulu</option>
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