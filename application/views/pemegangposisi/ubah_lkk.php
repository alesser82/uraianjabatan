            <main role="main" class="col-10 ml-sm-auto">
                <div class="content-title mt-4 pt-3 pb-3 pl-3">
                    <h4>Ubah data</h4>
                    <i class="font-italic">Masukkan lkk pegawai incomben.</i>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('pemegangposisi/ubah') ?>">Ubah pemegang posisi</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="<?= base_url('pemegangposisi/ubah/lkk') ?>">LKK</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><b>Ubah lkk</b></li>
                        </ol>
                    </nav>
                    <?= $this->session->flashdata('message'); ?>
                </div>
                <div class="content mt-3">
                    <form action="<?= base_url('pemegangposisi/prosesubahlkk') ?>" method="post" class="needs-validation" id="lkk-form">
                        <div class="accordion" id="accordionExample">
                            <?php
                            $noid = 1;
                            $nofor = $noid;
                                for ($i=1; $i <= 4; $i++) {
                                    if ($i == 1) {
                                        $number = "One";
                                        $lkktitle = "korporat";
                                        $name = 'kk';
                                        $ny = 1;
                                        $nn = 1;
                                    }elseif ($i == 2) {
                                        $number = "Two";
                                        $lkktitle = "rumpun";
                                        $name = 'kr';
                                        $ny = 1;
                                        $nn = 1;
                                    }elseif ($i == 3) {
                                        $number = "Three";
                                        $lkktitle = "unit";
                                        $name = 'ku';
                                        $ny = 1;
                                        $nn = 1;

                                    }elseif ($i == 4) {
                                        $number = "Four";
                                        $lkktitle = "spesifik";
                                        $name = 'ks';
                                        $ny = 1;
                                        $nn = 1;
                                    }
                                    $konten = 
                                    '<div class="card">
                                        <div class="card-header" id="heading'.$number.'">
                                            <button class="btn btn-link btn-symbol" type="button" data-toggle="collapse" data-target="#collapse'.$number.'" aria-expanded="true" aria-controls="collapse'.$number.'">
                                                <div class="triangle-button" style="">
                                                </div>
                                            </button>
                                            <button class="btn btn-link pt-2 pb-0 btn-text" type="button" data-toggle="collapse" data-target="#collapse'.$number.'" aria-expanded="true" aria-controls="collapse'.$number.'">
                                                <h5 class="text-uppercase">Kompetensi '.$lkktitle.'</h5>
                                            </button>
                                            <i class="fas fa-star-of-life fa-xs text-danger"></i>
                                        </div>
                                        <div id="collapse'.$number.'" class="collapse" aria-labelledby="heading'.$number.'" data-parent="#accordionExample">
                                        <div class="card-body">
                                        ';
                                        foreach ($set_kompetensi as $key => $value) {
                                            switch ($i) {
                                                case 1:
                                                    for ($a=1; $a < 11; $a++) {
                                                        if ($value->{'kk_'.$a} != '') {
                                                            ${'check_ya'.$a} = $value->{'lkk'.$a} == 1 ? 'checked' : '';
                                                            ${'check_tidak'.$a} = $value->{'lkk'.$a} != 1 ? 'checked' : '';
                                                            $konten .= '
                                                            <div class="row">
                                                                <div class="col-9">
                                                                    '.$value->{'kk_'.$a}.'
                                                                </div>
                                                                <div class="col-3 text-right">
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="custom-control custom-radio custom-control-inline">
                                                                            <input type="radio" name="'.$name.$ny++.'" class="custom-control-input" value="1" id="radio'.$noid++.'" '.${'check_ya'.$a}.'>
                                                                            <label class="custom-control-label" for="radio'.$nofor++.'">Ya</label>
                                                                        </div>
                                                                        <div class="custom-control custom-radio custom-control-inline">
                                                                            <input type="radio" name="'.$name.$nn++.'" class="custom-control-input" value="0" id="radio'.$noid++.'" '.${'check_tidak'.$a}.'>
                                                                            <label class="custom-control-label" for="radio'.$nofor++.'">Tidak</label>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            ';
                                                        }else{
                                                            break;
                                                        }
                                                    }
                                                    
                                                    break;
                                                
                                                    case 2:
                                                    for ($a=1; $a < 11; $a++) {
                                                        if ($value->{'kr_'.$a} != '') {
                                                            ${'check_ya'.$a} = $value->{'lkk'.($a+10)} == 1 ? 'checked' : '';
                                                            ${'check_tidak'.$a} = $value->{'lkk'.($a+10)} != 1 ? 'checked' : '';
                                                            $konten .= '
                                                            <div class="row">
                                                                <div class="col-9">
                                                                    '.$value->{'kr_'.$a}.'
                                                                </div>
                                                                <div class="col-3 text-right">
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="custom-control custom-radio custom-control-inline">
                                                                            <input type="radio" name="'.$name.$ny++.'" class="custom-control-input" value="1" id="radio'.$noid++.'" '.${'check_ya'.$a}.'>
                                                                            <label class="custom-control-label" for="radio'.$nofor++.'">Ya</label>
                                                                        </div>
                                                                        <div class="custom-control custom-radio custom-control-inline">
                                                                            <input type="radio" name="'.$name.$nn++.'" class="custom-control-input" value="0" id="radio'.$noid++.'" '.${'check_tidak'.$a}.'>
                                                                            <label class="custom-control-label" for="radio'.$nofor++.'">Tidak</label>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            ';
                                                        }else{
                                                            break;
                                                        }
                                                    }
                                                    
                                                    break;
                                                    case 3:
                                                    for ($a=1; $a < 11; $a++) {
                                                        if ($value->{'ku_'.$a} != '') {
                                                            ${'check_ya'.$a} = $value->{'lkk'.($a+20)} == 1 ? 'checked' : '';
                                                            ${'check_tidak'.$a} = $value->{'lkk'.($a+20)} != 1 ? 'checked' : '';
                                                            $konten .= '
                                                            <div class="row">
                                                                <div class="col-9">
                                                                    '.$value->{'ku_'.$a}.'
                                                                </div>
                                                                <div class="col-3 text-right">
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="custom-control custom-radio custom-control-inline">
                                                                            <input type="radio" name="'.$name.$ny++.'" class="custom-control-input" value="1" id="radio'.$noid++.'" '.${'check_ya'.$a}.'>
                                                                            <label class="custom-control-label" for="radio'.$nofor++.'">Ya</label>
                                                                        </div>
                                                                        <div class="custom-control custom-radio custom-control-inline">
                                                                            <input type="radio" name="'.$name.$nn++.'" class="custom-control-input" value="0" id="radio'.$noid++.'" '.${'check_tidak'.$a}.'>
                                                                            <label class="custom-control-label" for="radio'.$nofor++.'">Tidak</label>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            ';
                                                        }else{
                                                            break;
                                                        }
                                                    }
                                                    
                                                    break;

                                                    case 4:
                                                    for ($a=1; $a < 11; $a++) {
                                                        if ($value->{'ks_'.$a} != '') {
                                                            ${'check_ya'.$a} = $value->{'lkk'.($a+30)} == 1 ? 'checked' : '';
                                                            ${'check_tidak'.$a} = $value->{'lkk'.($a+30)} != 1 ? 'checked' : '';
                                                            $konten .= '
                                                            <div class="row">
                                                                <div class="col-9">
                                                                    '.$value->{'ks_'.$a}.'
                                                                </div>
                                                                <div class="col-3 text-right">
                                                                    <div class="d-flex justify-content-end">
                                                                        <div class="custom-control custom-radio custom-control-inline">
                                                                            <input type="radio" name="'.$name.$ny++.'" class="custom-control-input" value="1" id="radio'.$noid++.'" '.${'check_ya'.$a}.'>
                                                                            <label class="custom-control-label" for="radio'.$nofor++.'">Ya</label>
                                                                        </div>
                                                                        <div class="custom-control custom-radio custom-control-inline">
                                                                            <input type="radio" name="'.$name.$nn++.'" class="custom-control-input" value="0" id="radio'.$noid++.'" '.${'check_tidak'.$a}.'>
                                                                            <label class="custom-control-label" for="radio'.$nofor++.'">Tidak</label>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            ';
                                                        }else{
                                                            break;
                                                        }
                                                    }
                                                    
                                                    break;
                                                    default:
                                                    # code...
                                                    break;
                                            }
                                        }
                                        
                                        $konten .= '
                                        </div>
                                            </div>
                                        </div>
                                        ';
                                        echo $konten;
                                }
                            ?>
                        
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