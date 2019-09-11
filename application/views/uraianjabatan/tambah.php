            <main role="main" class="col-10 ml-sm-auto">
                <div class="content-title mt-4 pt-3 pb-3 pl-3">
                    <h4>Tambah data</h4>
                    <i class="font-italic">Masukkan data uraian jabatan.</i>
                    <?= $this->session->flashdata('message'); ?>
                </div>
                <div class="content mt-3">
                    <form action="<?= base_url('uraianjabatan/prosesTambah') ?>" method="post" class="needs-validation" id="jobdesc-form" enctype="multipart/form-data">
                        <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                            <!-- <h2 class="mb-0"> -->
                                <button class="btn btn-link btn-symbol" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="triangle-button" style="">
                                    </div>
                                </button>
                                <button class="btn btn-link pt-2 pb-0 btn-text" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <h5 class="text-uppercase">Identitas Posisi Pekerjaan </h5>
                                </button>
                                <i class="fas fa-star-of-life fa-xs text-danger"></i>
                            </div>
                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                    <div class="form-group text-center">
                                        <label for="unitkerja" class="font-weight-bold">Unit Kerja</label>
                                        <select class="form-control" id="unitkerja" name="unitkerja">
                                            <option value="">Pilih Unit Kerja</option>
                                            <?php

                                                foreach ($list_unitkerja as $unitkerja) {
                                                    echo '<option value="'.md5($unitkerja->id_uk).'">'.$unitkerja->nama_uk.'</option>';
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
                                        <label for="lokasi" class="font-weight-bold">Lokasi</label>
                                        <select class="form-control" id="lokasi" name="lokasi">
                                        <option value="">Pilih Lokasi Jabatan</option>
                                        <?php

                                            foreach ($list_lokasi as $lokasi) {
                                                echo '<option value="'.md5($lokasi->id_lokasi).'">'.$lokasi->lokasi.'</option>';
                                            }
                                        ?>
                                        </select>
                                        <div class="invalid-feedback">Pilih terlebih dahulu</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group text-center">
                                        <label for="alamat" class="col-form-label font-weight-bold">Alamat</label>
                                        <input type="text" name="alamat" readonly class="form-control-plaintext text-center" id="alamat" value="Pilih lokasi">
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingTwo">
                            <!-- <h2 class="mb-0"> -->
                                <button class="btn btn-link btn-symbol" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    <div class="triangle-button" style="">
                                    </div>
                                </button>
                                <button class="btn btn-link pt-2 pb-0 btn-text" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    <h5 class="text-uppercase">Tujuan Posisi Pekerjaan</h5>
                                </button>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="form-group">
                                    <textarea class="form-control" id="tujuan" rows="5" name="tujuan"><?= set_value('tujuan') ?></textarea>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <button class="btn btn-link btn-symbol" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    <div class="triangle-button" style="">
                                    </div>
                                </button>
                                <button class="btn btn-link pt-2 pb-0 btn-text" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    <h5 class="text-uppercase">Tanggung Jawab (Tugas)</h5>
                                </button>
                                <i class="fas fa-equals fa-xs text-danger"></i>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row">
                                <div class="col-12">
                                    
                                    <?php
                                        for ($i=1; $i <= 20; $i++) { 
                                            echo '<div class="form-group"><input type="text" class="form-control border-top-0 border-left-0 border-right-0" id="tugas'. $i .'" placeholder="Tugas '. $i .'" name="tugas'.$i.'" value="'.set_value("tugas".$i."").'"><div class="invalid-feedback">Isi terlebih dahulu</div></div>';
                                        }
                                    ?>
                                    
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingFour">
                            <!-- <h2 class="mb-0"> -->
                                <button class="btn btn-link btn-symbol" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                    <div class="triangle-button" style="">
                                    </div>
                                </button>
                                <button class="btn btn-link pt-2 pb-0 btn-text" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                    <h5 class="text-uppercase">Tanggung Jawab (Standar Ukuran Kinerja)</h5>
                                </button>
                                <i class="fas fa-equals fa-xs text-danger"></i>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                            <div class="card-body">
                                    <?php
                                        for ($i=1; $i <= 20; $i++) { 
                                            echo '<div class="form-group"><input type="text" class="form-control border-top-0 border-left-0 border-right-0" id="tanggungjawab'. $i .'" placeholder="Tanggung Jawab '. $i .'" name="tanggungjawab'.$i.'" value="'.set_value("tanggungjawab".$i."").'"><div class="invalid-feedback">Isi terlebih dahulu</div></div>';
                                        }
                                    ?>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingFive">
                            <!-- <h2 class="mb-0"> -->
                                <button class="btn btn-link btn-symbol" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                    <div class="triangle-button" style="">
                                    </div>
                                </button>
                                <button class="btn btn-link pt-2 pb-0 btn-text" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                    <h5 class="text-uppercase">Dimensi dan ruang lingkup</h5>
                                </button>
                            </div>
                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="form-group text-center">
                                <label for="dimensi" class="font-weight-bold">Dimensi</label>
                                    <?php

                                        for ($i=1; $i <= 3; $i++) {
                                            echo '<input type="text" class="form-control" id="dimensi'.$i.'" placeholder="Dimensi '.$i.'" name="dimensi'.$i.'" value="'.set_value("dimensi".$i."").'">';
                                        } 

                                    ?>
                                
                                </div>
                                <div class="form-group text-center">
                                    <label for="ruanglingkup" class="font-weight-bold">Ruang Lingkup</label>
                                    <input type="text" class="form-control" id="ruanglingkup" placeholder="Ruang Lingkup" name="ruanglingkup" value="<?= set_value("ruanglingkup") ?>">                                
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingSix">
                                <button class="btn btn-link btn-symbol" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                    <div class="triangle-button" style="">
                                    </div>
                                </button>
                                <button class="btn btn-link pt-2 pb-0 btn-text" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                    <h5 class="text-uppercase">Wewenang</h5>
                                </button>
                            </div>
                            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="form-group text-center">
                                    <?php

                                        for ($i=1; $i <= 10; $i++) {
                                            echo '<input type="text" class="form-control" id="wewenang'.$i.'" placeholder="Wewenang '.$i.'" name="wewenang'.$i.'" value="'.set_value("wewenang".$i."").'">';
                                        } 

                                    ?>
                                
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingSeven">
                            <!-- <h2 class="mb-0"> -->
                                <button class="btn btn-link btn-symbol" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                                    <div class="triangle-button" style="">
                                    </div>
                                </button>
                                <button class="btn btn-link pt-2 pb-0 btn-text" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                                    <h5 class="text-uppercase">hubungan kerja</h5>
                                </button>
                            </div>
                            <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6 text-center">
                                        <label for="hubunganinternal" class="font-weight-bold">Hubungan Internal</label>
                                        <?php
                                        
                                            for($i=1;$i <= 5;$i++){
                                                echo '<input type="text" class="form-control" id="hubintern'.$i.'" placeholder="Hubungan Internal '.$i.'" name="hubintern'.$i.'" value="'.set_value("hubintern".$i."").'">';
                                            }

                                        ?>
                                        
                                    </div>
                                    <div class="form-group col-md-6 text-center">
                                        <label for="hubunganeksternal" class="font-weight-bold">Hubungan Eksternal</label>
                                        <?php
                                        
                                            for($i=1;$i <= 5;$i++){
                                                echo '<input type="text" class="form-control" id="hubeks'.$i.'" placeholder="Hubungan Eksternal '.$i.'" name="hubeks'.$i.'" value="'.set_value("hubeks".$i."").'">';
                                            }

                                        ?>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwelve">
                                <button class="btn btn-link btn-symbol" type="button" data-toggle="collapse" data-target="#collapseTwelve" aria-expanded="true" aria-controls="collapseTwelve">
                                    <div class="triangle-button" style="">
                                    </div>
                                </button>
                                <button class="btn btn-link pt-2 pb-0 btn-text" type="button" data-toggle="collapse" data-target="#collapseTwelve" aria-expanded="true" aria-controls="collapseTwelve">
                                    <h5 class="text-uppercase">Prasyarat Jabatan</h5>
                                </button>
                            </div>
                            <div id="collapseTwelve" class="collapse" aria-labelledby="headingTwelve" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="form-group text-center">
                                    <?php

                                        for ($i=1; $i <= 10; $i++) {
                                            echo '<input type="text" class="form-control" id="prasyarat'.$i.'" placeholder="Prasyarat '.$i.'" name="prasyarat'.$i.'" value="'.set_value("prasyarat".$i."").'">';
                                        } 

                                    ?>
                                
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingEight">
                                <button class="btn btn-link btn-symbol" type="button" data-toggle="collapse" data-target="#collapseEight" aria-expanded="true" aria-controls="collapseEight">
                                    <div class="triangle-button" style="">
                                    </div>
                                </button>
                                <button class="btn btn-link pt-2 pb-0 btn-text" type="button" data-toggle="collapse" data-target="#collapseEight" aria-expanded="true" aria-controls="collapseEight">
                                    <h5 class="text-uppercase">Kondisi Kerja</h5>
                                </button>
                            </div>
                            <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordionExample">
                            <div class="card-body">
                                <input type="text" class="form-control" id="kondisi" placeholder="Kondisi kerja" name="kondisi">
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingNine">
                            <!-- <h2 class="mb-0"> -->
                                <button class="btn btn-link btn-symbol" type="button" data-toggle="collapse" data-target="#collapseNine" aria-expanded="true" aria-controls="collapseNine">
                                    <div class="triangle-button" style="">
                                    </div>
                                </button>
                                <button class="btn btn-link pt-2 pb-0 btn-text" type="button" data-toggle="collapse" data-target="#collapseNine" aria-expanded="true" aria-controls="collapseNine">
                                    <h5 class="text-uppercase">pengetahuan dan keterampilan</h5>
                                </button>
                            </div>
                            <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordionExample">
                            <div class="card-body">
                                <?php

                                    for ($i=1; $i <= 15; $i++) {
                                        echo '<input type="text" class="form-control" id="pengetahuanketerampilan'.$i.'" placeholder="Pengetahuan dan Keterampilan '.$i.'" name="pengetahuanketerampilan'.$i.'">';
                                    } 
                                ?>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTen">
                                <button class="btn btn-link btn-symbol" type="button" data-toggle="collapse" data-target="#collapseTen" aria-expanded="true" aria-controls="collapseTen">
                                    <div class="triangle-button" style="">
                                    </div>
                                </button>
                                <button class="btn btn-link pt-2 pb-0 btn-text" type="button" data-toggle="collapse" data-target="#collapseTen" aria-expanded="true" aria-controls="collapseTen">
                                    <h5 class="text-uppercase">set kompetensi</h5>
                                </button>
                            </div>
                            <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="form-group text-center">
                                    <label for="kompetensiKorporat" class="font-weight-bold">Kompetensi Korporat</label>
                                    <?php
                                    
                                        for($i=1;$i <= 10;$i++){
                                            echo '<input type="text" class="form-control" id="kompetensikorporat'.$i.'" placeholder="Kompetensi Korporat '.$i.'" name="kompetensikorporat'.$i.'">';
                                        }
                                    
                                    ?>
                                </div>
                                <div class="form-group text-center">
                                    <label for="kompetensirumpun" class="font-weight-bold">Kompetensi Rumpun</label>
                                    <?php
                                    
                                        for($i=1;$i <= 10;$i++){
                                            echo '<input type="text" class="form-control" id="kompetensirumpun'.$i.'" placeholder="Kompetensi Rumpun '.$i.'" name="kompetensirumpun'.$i.'">';
                                        }
                                    
                                    ?>
                                </div>
                                <div class="form-group text-center">
                                    <label for="kompetensiunit" class="font-weight-bold">Kompetensi Unit</label>
                                    <?php
                                    
                                        for($i=1;$i <= 10;$i++){
                                            echo '<input type="text" class="form-control" id="kompetensiunit'.$i.'" placeholder="Kompetensi Unit '.$i.'" name="kompetensiunit'.$i.'">';
                                        }
                                    
                                    ?>
                                </div>
                                <div class="form-group text-center">
                                    <label for="kompetensispesifik" class="font-weight-bold">Kompetensi Spesifik</label>
                                    <?php
                                    
                                        for($i=1;$i <= 10;$i++){
                                            echo '<input type="text" class="form-control" id="kompetensispesifik'.$i.'" placeholder="Kompetensi Spesifik '.$i.'" name="kompetensispesifik'.$i.'">';
                                        }
                                    
                                    ?>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingEleven">
                            <!-- <h2 class="mb-0"> -->
                                <button class="btn btn-link btn-symbol" type="button" data-toggle="collapse" data-target="#collapseEleven" aria-expanded="true" aria-controls="collapseEleven">
                                    <div class="triangle-button" style="">
                                    </div>
                                </button>
                                <button class="btn btn-link pt-2 pb-0 btn-text" type="button" data-toggle="collapse" data-target="#collapseEleven" aria-expanded="true" aria-controls="collapseEleven">
                                    <h5 class="text-uppercase">struktur organisasi</h5>
                                </button>
                            </div>
                            <div id="collapseEleven" class="collapse" aria-labelledby="headingEleven" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="strukturorganisasi" name="strukturorganisasi" accept=".png,.jpeg,.jpg">
                                    <label class="custom-file-label" for="strukturorganisasi" data-browse="Cari">Pilih gambar</label>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="row mt-2 mb-2">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-md w-50" id="submit-form">Simpan</button>
                            </div>
                        </div>
                    </form>
                    <i class="fa fa-copyright"> 2018</i>
                </div>
            </main>
        </div>
        </div>