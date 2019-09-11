<?php
    $this->load->library('Pdf');
    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetTitle('Uraian Jabatan');
    $pdf->SetPrintHeader(true);
    $pdf->SetPrintFooter(true);
    $pdf->SetMargins(25, 40, 25);
    $pdf->SetHeaderMargin(15);
    $pdf->setFooterMargin(30);
    $pdf->SetAutoPageBreak(true,25);
    $pdf->SetAuthor('Author');
    $pdf->SetDisplayMode('real', 'default');
    $pdf->AddPage();
    foreach ($pemegang_posisi as $key => $value) {
        $nama_jabatan = $value->nama_jbt;
        $kode_jabatan = $value->kode_jbt;
        for ($i=1; $i < 41; $i++) { 
            ${'lkk_'.$i} = $value->{'lkk'.$i};
        }
    }
    foreach ($uraian_jabatan as $key => $value) {
        for ($i=1; $i < 71; $i++) { 
            switch ($i) {
                case 1:
                    $data = 'prasyarat';
                    $number = 0;
                    break;
                
                case 11:
                    $data = 'wewenang';
                    $number = -10;
                    break;
                
                case 21:
                    $data = 'tugas';
                    $number = -20;
                    break;

                case 31:
                    $data = 'kk_';
                    $number = -30;
                    break;
                
                case 41:
                    $data = 'kr_';
                    $number = -40;
                    break;

                case 51:
                    $data = 'ku_';
                    $number = -50;
                    break;

                case 61:
                    $data = 'ks_';
                    $number = -60;
                    break;
                default:
                    # code...
                    break;
            }
            ${$data.'_'.($number + $i)} = $value->{$data.($number + $i)};
        }
        $tujuan = $value->tujuanposisi;
    }


    // Judul
    $html = 
    '
        <style>
            table{
                width:100%;
            }
            .title{
                font-weight:bold;
            }
        </style>
        <h1 align="center">Uraian Jabatan</h1>
    ';

    // Jabatan

    $html .= 
    '
        <table>
        <tr>
            <td style="width:30%">Nama Jabatan</td>
            <td style="width:2%">:</td>
            <td colspan="7">'.$nama_jabatan.'</td>
        </tr>
        <tr>
            <td style="width:30%">Kode Jabatan</td>
            <td style="width:2%">:</td>
            <td colspan="7">'.$kode_jabatan.'</td>
        </tr>
        </table>
    ';

    // Prasyarat
    $html .= 
    '
        <table>
            <tr><td></td></tr>
            <tr>
                <td style="width:30%">PRASYARAT</td>
                <td style="width:10%">:</td>
            </tr>
    ';
    if (empty($uraian_jabatan)) {
        $html .= '<tr><td>Data belum dimasukkan.</td></tr>';
    }else{
        if ($prasyarat_1 == '') {
            $html .= '<tr><td>Data belum dimasukkan.</td></tr>';
        }else{
            for ($i=1; $i < 11; $i++) { 
                if (${'prasyarat_'.$i} == '') {
                    break;
                }
                $html .= 
                '
                    <tr><td>'. $i .'. '. ${'prasyarat_'.$i} .'</td></tr>
                ';
            }
        }
    }
    $html .= '</table>';

    // Tujuan
    $html .= 
    '
        <table>
            <tr><td></td></tr>
            <tr>
                <td style="width:30%">TUJUAN</td>
                <td style="width:2%">:</td>
    ';
    if (empty($uraian_jabatan)) {
        $html .= '<td>Belum ada data.</td>';
    }else{
        if ($tujuan == '') {
            $html .= '<td>Belum ada data.</td>';
        }else{
            $html .= '<td>'. $tujuan .'</td>';
        }
    }
    $html .= '</tr></table>';

    // Tugas
    $html .= 
    '
        <table>
            <tr><td></td></tr>
            <tr>
                <td style="width:30%">TUGAS</td>
                <td style="width:2%">:</td>
            </tr>
    ';
    if (empty($uraian_jabatan)) {
        $html .= '<tr><td>Belum ada data.</td></tr>';
    }else{
        if ($tugas_1 == '') {
            $html .= '<tr><td>Belum ada data.</td></tr>';
        }else{
            for ($i=1; $i < 21; $i++) { 
                if (${'tugas_'.$i} == '') {
                    break;
                }
                $html .= '<tr><td>'.$i.'. '. ${'tugas_'.$i} .'</td></tr>';
            }
        }
    }
    $html .= '</table>';

    // Wewenang
    $html .= 
    '
        <table>
            <tr><td></td></tr>
            <tr>
                <td style="width:30%">WEWENANG</td>
                <td style="width:2%">:</td>
            </tr>
    ';
    if (empty($uraian_jabatan)) {
        $html .= '<tr><td>Belum ada data.</td></tr>';
    }else{
        if ($wewenang_1 == '') {
            $html .= '<tr><td>Belum ada data.</td></tr>';
        }else{
            for ($i=1; $i < 21; $i++) { 
                if (${'wewenang_'.$i} == '') {
                    break;
                }
                $html .= '<tr><td>'.$i.'. '. ${'wewenang_'.$i} .'</td></tr>';
            }
        }
    }
    $html .= '</table>';

    // Set Kompetensi
    $html .=
    '
        <table>
            <tr><td></td></tr>
            <tr>
                <td style="width:30%">SET KOMPETENSI</td>
                <td style="width:2%">:</td>
            </tr>
            <tr>
                <td style="width:6%"></td>
                <td style="width:90%">Korporat</td>
            </tr>
    ';
    if (empty($uraian_jabatan)) {
        $html .= '<tr><td style="width:10%;"></td><td>Belum ada data.</td></tr>';
    }else{
        if ($kk__1 == '') {
            $html .= '<tr><td style="width:10%;"></td><td>Belum ada data.</td></tr>';
        }else{
            for ($i=1; $i < 11; $i++) { 
                if (${'kk__'.$i} == '') {
                    break;
                }
                $html .= '<tr><td style="width:10%;"></td><td>'. $i .'. '. ${'kk__'.$i} .'</td></tr>';
            }
        }
    }

    $html .= '<tr>
                <td style="width:6%"></td>
                <td style="width:90%">Rumpun</td>
            </tr>
    ';
    if (empty($uraian_jabatan)) {
        $html .= '<tr><td style="width:10%;"></td><td>Belum ada data.</td></tr>';
    }else{
        if ($kr__1 == '') {
            $html .= '<tr><td style="width:10%;"></td><td>Belum ada data.</td></tr>';
        }else{
            for ($i=1; $i < 11; $i++) { 
                if (${'kr__'.$i} == '') {
                    break;
                }
                $html .= '<tr><td style="width:10%;"></td><td>'. $i .'. '. ${'kr__'.$i} .'</td></tr>';
            }
        }
    }

    $html .= '<tr>
                <td style="width:6%"></td>
                <td style="width:90%">Unit</td>
            </tr>
    ';
    if (empty($uraian_jabatan)) {
        $html .= '<tr><td style="width:10%;"></td><td>Belum ada data.</td></tr>';
    }else{
        if ($ku__1 == '') {
            $html .= '<tr><td style="width:10%;"></td><td>Belum ada data.</td></tr>';
        }else{
            for ($i=1; $i < 11; $i++) { 
                if (${'ku__'.$i} == '') {
                    break;
                }
                $html .= '<tr><td style="width:10%;"></td><td>'. $i .'. '. ${'ku__'.$i} .'</td></tr>';
            }
        }
    }

    $html .= '<tr>
                <td style="width:6%"></td>
                <td style="width:90%">Spesifik</td>
            </tr>
    ';
    if (empty($uraian_jabatan)) {
        $html .= '<tr><td style="width:10%;"></td><td>Belum ada data.</td></tr>';
    }else{
        if ($ks__1 == '') {
            $html .= '<tr><td style="width:10%;"></td><td>Belum ada data.</td></tr>';
        }else{
            for ($i=1; $i < 11; $i++) { 
                if (${'ks__'.$i} == '') {
                    break;
                }
                $html .= '<tr><td style="width:10%;"></td><td>'. $i .'. '. ${'ks__'.$i} .'</td></tr>';
            }
        }
    }

    $html .= '</table>';
    $pdf->writeHTML($html, $ln, $fill, $reseth, $cell,$align);

    // LKK
    $pdf->addPage();
    $html2 .= 
    '
        <style>
            table{
                width:100%;
            }

            .title{
                font-weight:bold;
                font-size:14pt;
            }

            .kompetensi{
                width: 80%;
            }

            .lkk{
                list-style-type:none;
            }

            .icon-check{
                width: 20px;
                height: 15px;
            }

            .icon-close{
                width: 20px;
                height: 8px;
            }

            .space{
                width: 10%;
            }
        </style>
        <h1 align="center">LKK</h1>
    ';

    // Kompetensi Korporat
    $html2 .= 
    '
        <table>
            <tr><td class="title">Kompetensi Korporat</td></tr>
    ';

    if (empty($uraian_jabatan)) {
        $html2 .= '<tr><td>Belum ada data.</td></tr>';
    }else{
        if ($kk__1 == '') {
            $html2 .= '<tr><td>Belum ada data.</td></tr>';
        }else{
            for ($i=1; $i < 11; $i++) { 
                if (${'kk__'.$i} == '') {
                    break;
                }else{
                    $html2 .= 
                    '
                        <tr>
                            <td class="space"></td>
                            <td class="kompetensi">'. ${'kk__'.$i} .'</td>
                    ';
                    if (${'lkk_'.$i} == '1') {
                        $html2 .= '<td><img src="'. base_url('assets/img/check.svg') .'" class="icon-check"></td></tr>';
                    }else{
                        $html2 .= '<td><img src="'. base_url('assets/img/close.svg') .'" class="icon-close"></td></tr>';
                    }
                    // $html2 .= '</tr>';

                }
            }
        }
    }
    $html2 .= '</table>';

    // Kompetensi Rumpun
    $html2 .= 
    '
        <table>
            <tr><td></td></tr>
            <tr><td class="title">Kompetensi Rumpun</td></tr>
    ';

    if (empty($uraian_jabatan)) {
        $html2 .= '<tr><td>Belum ada data.</td></tr>';
    }else{
        if ($kr__1 == '') {
            $html2 .= '<tr><td>Belum ada data.</td></tr>';
        }else{
            for ($i=1; $i < 11; $i++) { 
                if (${'kr__'.$i} == '') {
                    break;
                }else{
                    $html2 .= 
                    '
                        <tr>
                            <td class="space"></td>
                            <td class="kompetensi">'. ${'kr__'.$i} .'</td>
                    ';
                    if (${'lkk_'.($i + 10)} == '1') {
                        $html2 .= '<td><img src="'. base_url('assets/img/check.svg') .'" class="icon-check"></td></tr>';
                    }else{
                        $html2 .= '<td><img src="'. base_url('assets/img/close.svg') .'" class="icon-close"></td></tr>';
                    }

                }
            }
        }
    }
    $html2 .= '</table>';

    // Kompetensi Unit
    $html2 .= 
    '
        <table>
            <tr><td></td></tr>
            <tr><td class="title">Kompetensi Unit</td></tr>
    ';

    if (empty($uraian_jabatan)) {
        $html2 .= '<tr><td>Belum ada data.</td></tr>';
    }else{
        if ($ku__1 == '') {
            $html2 .= '<tr><td>Belum ada data.</td></tr>';
        }else{
            for ($i=1; $i < 11; $i++) { 
                if (${'ku__'.$i} == '') {
                    break;
                }else{
                    $html2 .= 
                    '
                        <tr>
                            <td class="space"></td>
                            <td class="kompetensi">'. ${'ku__'.$i} .'</td>
                    ';
                    if (${'lkk_'.($i + 10)} == '1') {
                        $html2 .= '<td><img src="'. base_url('assets/img/check.svg') .'" class="icon-check"></td></tr>';
                    }else{
                        $html2 .= '<td><img src="'. base_url('assets/img/close.svg') .'" class="icon-close"></td></tr>';
                    }

                }
            }
        }
    }
    $html2 .= '</table>';

    // Kompetensi Spesifik
    $html2 .= 
    '
        <table>
            <tr><td></td></tr>
            <tr><td class="title">Kompetensi Spesifik</td></tr>
    ';

    if (empty($uraian_jabatan)) {
        $html2 .= '<tr><td>Belum ada data.</td></tr>';
    }else{
        if ($ks__1 == '') {
            $html2 .= '<tr><td>Belum ada data.</td></tr>';
        }else{
            for ($i=1; $i < 11; $i++) { 
                if (${'ks__'.$i} == '') {
                    break;
                }else{
                    $html2 .= 
                    '
                        <tr>
                            <td class="space"></td>
                            <td class="kompetensi">'. ${'ks__'.$i} .'</td>
                    ';
                    if (${'lkk_'.($i + 10)} == '1') {
                        $html2 .= '<td><img src="'. base_url('assets/img/check.svg') .'" class="icon-check"></td></tr>';
                    }else{
                        $html2 .= '<td><img src="'. base_url('assets/img/close.svg') .'" class="icon-close"></td></tr>';
                    }

                }
            }
        }
    }
    $html2 .= '</table>';

    $ln = true;
    $fill = false;
    $reseth = false;
    $cell = false;
    $align = '';
    
    $pdf->writeHTML($html2, $ln, $fill, $reseth, $cell,$align);
    ob_end_clean();
    $pdf->Output('coba', 'I');

?>