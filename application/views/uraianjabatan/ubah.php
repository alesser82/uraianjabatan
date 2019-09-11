            <main role="main" class="col-10 ml-sm-auto">
                <div class="content-title mt-4 pt-3 pb-3 pl-3">
                    <h4>Ubah data</h4>
                    <i class="font-italic">Pilih Jabatan.</i>
                    <?= $this->session->flashdata('message'); ?>
                    <nav aria-label="breadcrumb" class="mr-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"><b>Pilih jabatan</b></li>
                    </ol>
                    </nav>
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12">
                                    <form method="get" id="jobdesc-search-form">
                                    <div class="form-group">
                                        <label for="unitkerja" class="font-weight-bold">Unit Kerja</label>
                                        <select class="custom-select" id="unitkerja" name="unitkerja">
                                        <option value="">Pilih Unit Kerja</option>
                                        <?php
                                            if (empty($unitkerja)) {
                                                echo '';
                                            }else{
                                                foreach ($unitkerja as $key => $value) {
                                                    echo '<option value="'.md5($value["id_uk"]).'">'.$value["nama_uk"].'</option>';
                                                }
                                            }
                                        ?>
                                        </select>
                                        <div class="invalid-feedback">Pilih terlebih dahulu</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="jabatan" class="font-weight-bold">Jabatan</label>
                                        <select class="form-control" id="jabatan" name="jabatan">
                                        <option value="">Pilih Unit Kerja Terlebih Dahulu</option>
                                        </select>
                                        <div class="invalid-feedback">Pilih terlebih dahulu</div>
                                    </div>
                                    <button type="submit" class="btn btn-info">Cari</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12">
                                    <h5><b>Pengolah Terakhir</b></h5>
                                    <p id='pengolah-uraian-jabatan'></p>
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