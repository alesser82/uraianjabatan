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
    foreach ($uraian_jabatan as $key => $value) {
        $tujuan = $value->tujuanposisi != '' ? $value->tujuanposisi : 'Belum dimasukkan';
        $prasyarat = [];
        $tugas = [];
        $wewenang = [];
        $rumpun = [];
        $unit = [];
        $korporat = [];
        $spesifik = [];
        for ($i=1; $i < 11; $i++) { 
            if ($value->{'prasyarat'.$i} == '') {
                break;
            }
            $prasyarat += [$value->{'prasyarat'.$i}];
        }
        for ($i=1; $i < 21; $i++) { 
            if ($value->{'tugas'.$i} == '') {
                break;
            }
            $tugas += [$value->{'tugas'.$i}];
        }
        for ($i=1; $i < 21; $i++) { 
            if ($value->{'wewenang'.$i} == '') {
                break;
            }
            $wewenang += [$value->{'wewenang'.$i}];
        }
        for ($i=1; $i < 11; $i++) { 
            if ($value->{'kk_'.$i} == '') {
                break;
            }
            $korporat += [$value->{'kk_'.$i}];
        }
        for ($i=1; $i < 11; $i++) { 
            if ($value->{'kr_'.$i} == '') {
                break;
            }
            $rumpun += [$value->{'kr_'.$i}];
        }
        for ($i=1; $i < 11; $i++) { 
            if ($value->{'ku_'.$i} == '') {
                break;
            }
            $unit += [$value->{'ku_'.$i}];
        }
        for ($i=1; $i < 11; $i++) { 
            if ($value->{'ks_'.$i} == '') {
                break;
            }
            $spesifik += [$value->{'ks_'.$i}];
        }
        $html = '
        <style>
            table{
                width:100%;
            }
        </style>
        <h1 align="center">Uraian Jabatan</h1>
        <table>
        <tr>
            <td style="width:30%">Nama Jabatan</td>
            <td style="width:2%">:</td>
            <td colspan="7">'.$value->nama_jbt.'</td>
        </tr>
        <tr>
            <td style="width:30%">Kode Jabatan</td>
            <td style="width:2%">:</td>
            <td colspan="7">'.$value->kode_jbt.'</td>
        </tr>
        </table>

        <table>
            <tr><td></td></tr>
            <tr>
                <td style="width:30%">PRASYARAT</td>
                <td style="width:10%">:</td>
            </tr>
        ';
        if (empty($prasyarat)) {
            $html .= '<tr><td>Belum dimasukkan.</td></tr>';
        }else{
            for ($i=1; $i < 11; $i++) { 
                if ($value->{'prasyarat'.$i} == '') {
                    break;
                }
                $html .= '
                <tr>
                    <td>'.$i.'. '.$value->{'prasyarat'.$i}.'</td>
                </tr>
                ';
            }
        }
        $html .=
        '
        </table>
        <table>
            <tr><td></td></tr>
            <tr>
                <td style="width:30%">TUJUAN</td>
                <td style="width:2%">:</td>
                <td style="width:60%">'.$tujuan.'</td>
            </tr>
        </table>

        <table>
            <tr><td></td></tr>
            <tr>
                <td style="width:30%">TUGAS</td>
                <td style="width:2%">:</td>
            </tr>
        ';
        if (empty($tugas)) {
            $html .= '<tr><td>Belum dimasukkan.</td></tr>';
        }else{
            for ($i=1; $i < 21; $i++) { 
                if ($value->{'tugas'.$i} == '') {
                    break;
                }
                $html .= '
                <tr><td>'.$i.'. '.$value->{'tugas'.$i}.'</td></tr>
                ';
            }
        }
        $html .= '
        </table>
        <table>
            <tr><td></td></tr>
            <tr>
                <td style="width:30%">WEWENANG</td>
                <td style="width:2%">:</td>
            </tr>
        ';
        if (empty($wewenang)) {
            $html .= '<tr><td>Belum dimasukkan.</td></tr>';
        }else{
            for ($i=1; $i < 21; $i++) { 
                if ($value->{'wewenang'.$i} == '') {
                    break;
                }
                $html .= '
                <tr><td>'.$i.'. '.$value->{'wewenang'.$i}.'</td></tr>
                ';
            }
        }
        $html .= '
        </table>
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
        if (empty($korporat)) {
            $html .= '<tr><td style="width:10%;"></td><td style="width:90%;">Belum dimasukkan.</td></tr>';
        }else{
            for ($i=1; $i < 11; $i++) { 
                if ($value->{'kk_'.$i} == '') {
                    break;
                }
                $html .= '<tr><td style="width:15%;"></td><td style="width:90%;">'.$i.'. '.$value->{'kk_'.$i}.'</td></tr>';
            }
        }
        $html .= '
        <tr>
            <td style="width:6%"></td>
            <td style="width:90%">Rumpun</td>
        </tr>';
        if (empty($rumpun)) {
            $html .= '<tr><td style="width:10%;"></td><td style="width:90%;">Belum dimasukkan.</td></tr>';
        }else{
            for ($i=1; $i < 11; $i++) { 
                if ($value->{'kr_'.$i} == '') {
                    break;
                }
                $html .= '<tr><td style="width:15%;"></td><td style="width:90%;">'.$i.'. '.$value->{'kr_'.$i}.'</td></tr>';
            }
        }
        $html .= '
        <tr>
            <td style="width:6%"></td>
            <td style="width:90%">Unit</td>
        </tr>';
        if (empty($unit)) {
            $html .= '<tr><td style="width:10%;"></td><td style="width:90%;">Belum dimasukkan.</td></tr>';
        }else{
            for ($i=1; $i < 11; $i++) { 
                if ($value->{'ku_'.$i} == '') {
                    break;
                }
                $html .= '<tr><td style="width:15%;"></td><td style="width:90%;">'.$i.'. '.$value->{'ku_'.$i}.'</td></tr>';
            }
        }
        $html .= '
        <tr>
            <td style="width:6%"></td>
            <td style="width:90%">Spesifik</td>
        </tr>';
        if (empty($spesifik)) {
            $html .= '<tr><td style="width:10%;"></td><td style="width:90%;">Belum dimasukkan.</td></tr>';
        }else{
            for ($i=1; $i < 11; $i++) { 
                if ($value->{'ks_'.$i} == '') {
                    break;
                }
                $html .= '<tr><td style="width:15%;"></td><td style="width:90%;">'.$i.'. '.$value->{'ks_'.$i}.'</td></tr>';
            }
        }
        $html .= '
        </table>
        <h1 align="center">LKK</h1>
        <table>
            <tr><td><h3>Kompetensi Korporat</h3></td></tr>
        ';
        if (isset($value->npp_incomben)) {
            $html .= '<tr><td>'.$value->npp_incomben.'</td></tr>';
        }else{
            $html .= '<tr><td>LKK belum ditambahkan</td></tr>';
        }
    }
    $ln = true;
    $fill = false;
    $reseth = false;
    $cell = false;
    $align = '';
    $pdf->writeHTML($html, $ln, $fill, $reseth, $cell,$align);
    ob_end_clean();
    $pdf->Output('coba', 'I');

?>