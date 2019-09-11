<?php
    $this->load->library('Pdf');
    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetTitle('Uraian Jabatan');
    $pdf->SetPrintHeader(true);
    $pdf->SetPrintFooter(true);
    $pdf->SetMargins(25, 40, 25);
    $pdf->SetHeaderMargin(15);
    $pdf->setFooterMargin(30);
    $pdf->SetAutoPageBreak(true,20);
    $pdf->SetAuthor('Author');
    $pdf->SetDisplayMode('real', 'default');
    $pdf->AddPage();
    foreach ($uraian_jabatan as $key => $value) {
        $tanggal = $value->tgl_update == 0 ? $value->tgl_input : $value->tgl_update;
        $tujuan = $value->tujuanposisi != '' ? $value->tujuanposisi : 'Belum ada data';
        $kondisi_kerja = $value->kondisi_kerja != '' ? $value->kondisi_kerja : 'N/A';
        $hubungan_internal = [];
        $hubungan_eksternal = [];
        $pengetahuan_dan_keterampilan = [];
        for ($i=1; $i < 6; $i++) { 
            if ($value->{'hubintern'.$i} == '') {
                break;
            }
            $hubungan_internal += 
            [
                $value->{'hubintern'.$i}
            ];
        }
        for ($i=1; $i < 6; $i++) { 
            if ($value->{'hubeks'.$i} == '') {
                break;
            }
            $hubungan_eksternal += 
            [
                $value->{'hubeks'.$i}
            ];
        }

        for ($i=1; $i < 16; $i++) { 
            if ($value->{'pk'.$i} == '') {
                break;
            }
            $pengetahuan_dan_keterampilan += 
            [
                $value->{'pk'.$i}
            ];
        }

        $html = 
        '
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 10px 0px;
            }

            table#identitas {
                border: 1px solid black;
                font-size:12pt;
            }

            td.title {
                text-transform: uppercase;
                border: 1px solid black;
                font-weight: bold;
                padding: 0px;
                font-size:13pt;
            }

            td {
                padding: 7 0;
            }

            .sub-title {
                font-weight: bold;
                text-decoration: underline;
            }

            .wewenang {
                margin: 0px 17px;
            }
            
            .low-width{
                width:10;
            }

            .mid-width{
                width:75;
            }

            .high-width{
                width:100;
            }
        </style>

        <table id="identitas" cellpadding="3">
            <tr>
                <td colspan="7" class="title">1. IDENTITAS PEKERJAAN</td>
            </tr>
            <tr>
                <td class="high-width">Posisi Jabatan</td>
                <td class="low-width">:</td>
                <td style="width:135">'.$value->nama_jbt.'</td>
                <td class="low-width"></td>
                <td class="mid-width">Tanggal</td>
                <td class="low-width">:</td>
                <td class="mid-width">'.$tanggal.'</td>
            </tr>
            <tr>
                <td class="high-width">Kode Jabatan</td>
                <td class="low-width">:</td>
                <td>'.$value->kode_jbt.'</td>
                <td></td>
                <td class="mid-width">Lokasi</td>
                <td class="low-width">:</td>
                <td style="width:100">Graha Sucofindo</td>
            </tr>
            <tr>
                <td class="high-width">Unit Kerja</td>
                <td class="low-width">:</td>
                <td>Human Capital</td>
                <td></td>
                <td class="mid-width">Persetujuan</td>
                <td class="low-width">:</td>
                <td></td>
            </tr>
            <tr>
                <td class="high-width">Pemegang Posisi</td>
                <td class="low-width">:</td>
                <td>Heriyanto</td>
                <td></td>
                <td class="mid-width">Persetujuan</td>
                <td class="low-width">:</td>
                <td></td>
            </tr>
            <tr>
                <td class="high-width">Atasan Langsung</td>
                <td class="low-width">:</td>
                <td colspan="5"></td>
            </tr>
        </table>
        
        <table cellpadding="3">
            <tr><td></td></tr>
            <tr>
                <td colspan="7" class="title">2. TUJUAN POSISI PEKERJAAN</td>
            </tr>
            <tr>
                <td colspan="7">'.$tujuan.'</td>
            </tr>
        </table>
        '
        ;
        $html .=
        '<table cellpadding="3">
            <tr><td colspan="3"></td></tr>
            <tr>
                <td colspan="3" class="title">3. TANGGUNG JAWAB UTAMA</td>
            </tr>
            <tr style="text-align: center">
                <td colspan="2"><b>Uraian</b></td>
                <td colspan="1"><b>Standar Ukuran Kinerja</b></td>
            </tr>
            <tr>
                <td colspan="2"><ol>';
        for ($i=1; $i < 21; $i++) { 
            if ($value->{'tugas'.$i} == '') {
                break;
            }
            $html .= '<li>'.$value->{'tugas'.$i}.'</li>';
        }
        $html .= '
        </ol></td>
        <td colspan="1"><ul>
        ';
        for ($i=1; $i < 21; $i++) { 
            if ($value->{'tj'.$i} == '') {
                break;
            }
            $html .= '<li>'.$value->{'tj'.$i}.'</li>';
        }
        $html .= 
        '</ul></td></tr></table>
        <table cellpadding="3">
            <tr><td></td></tr>
            <tr>
                <td class="title">4. DIMENSI DAN RUANG LINGKUP</td>
            </tr>
            <tr>
                <td class="sub-title">Dimensi</td>
            </tr>';
        for ($i=1; $i < 4; $i++) { 
            if ($value->{'dimensi'.$i} == '') {
                break;
            }
            $html .= '<tr><td>Dimensi '.$i.' : '.$value->{'dimensi'.$i}.'</td></tr>';
        }
        $html .= '
        <tr>
            <td class="sub-title">Ruang Lingkup</td>
        </tr>
        <tr><td>Lingkup Area : '.$value->ruanglingkup.'</td></tr>';
        $html .= '
        </table>
        <table cellpadding="3">
            <tr><td></td></tr>
            <tr>
                <td class="title">5. WEWENANG</td>
            </tr>
            <tr>
                <td>
                    <ul>
        ';
        for ($i=1; $i < 11; $i++) { 
            if ($value->{'wewenang'.$i} == '') {
                break;
            }
            $html .= '<li>'.$value->{'wewenang'.$i}.'</li>';
        }
        $html .= '</ul></td></tr></table>
        <table cellpadding="3">
            <tr><td></td></tr>
            <tr>
                <td class="title">6. HUBUNGAN KERJA</td>
            </tr>
            <tr>
                <td class="sub-title">Internal Perusahaan (Di dalam lingkungan PT Sucofindo)</td>
            </tr>
            <tr>
                <td><ol>
        ';
        if (empty($hubungan_internal)) {
            $html .= 'N/A';
        }else{
            for ($i=1; $i < 6; $i++) { 
                if ($value->{'hubintern'.$i} == '') {
                    break;
                }
                $html .= '<li>'.$value->{'hubintern'.$i}.'</li>';
            }
        }
        $html .= '</ol></td></tr>
        <tr>
            <td class="sub-title">Eksternal Perusahaan (Di luar lingkungan PT Sucofindo)</td>
        </tr>
        <tr><td><ol>';
        if (empty($hubungan_eksternal)) {
            $html .= 'N/A';
        }else{
            for ($i=1; $i < 6; $i++) { 
                if ($value->{'hubeks'.$i} == '') {
                    break;
                }
                $html .= '<li>'.$value->{'hubeks'.$i}.'</li>';
            }
        }
        $html .= '
        </ol></td></tr></table>
        ';

        $html .= '
        <table cellpadding="3">
            <tr><td></td></tr>
            <tr>
                <td class="title">7. KONDISI KERJA</td>
            </tr>
            <tr>
                <td>'.$kondisi_kerja.'</td>
            </tr>
        </table>';

        $html .= '
        <table cellpadding="3">
            <tr><td></td></tr>
            <tr>
                <td class="title">8. PENGETAHUAN DAN KETERAMPILAN</td>
            </tr>
        ';
        if (empty($pengetahuan_dan_keterampilan)) {
            $html .= '<tr><td>N/A</td></tr>';
        }else{
            $html .= '<tr><td><ol>';
            for ($i=1; $i < 16; $i++) { 
                if($value->{'pk'.$i} == ''){
                    break;
                }
                $html .= '<li>'.$value->{'pk'.$i}.'</li>';
            }
        }
        $html .= '</ol></td></tr></table>';

        if (!empty($value->struktur)) {
            $html .= '
            <table cellpadding="3">
                <tr><td></td></tr>
                <tr>
                    <td class="title">9. STRUKTUR ORGANISASI</td>
                </tr>
                <tr>
                    <td><img src="'.base_url('assets/img/struktur_organisasi/'.$value->struktur.'').'" alt="struktur organisasi" style="width:450px"></td>
                </tr>
            </table>
            ';
        }else {
            $html .= '
            <table cellpadding="3">
                <tr><td></td></tr>
                <tr>
                    <td class="title">9. STRUKTUR ORGANISASI</td>
                </tr>
                <tr>
                    <td><img src="" alt="struktur organisasi"></td>
                </tr>
            </table>
            ';
        }
    }
    $ln = true;
    $fill = false;
    $reseth = false;
    $cell = false;
    $align = '';
    $pdf->writeHTML($html, $ln, $fill, $reseth, $cell,$align);
    ob_end_clean();
    foreach ($uraian_jabatan as $key => $value) {
        $nama_jabatan = $value->nama_jbt;
    }
    $pdf->Output($nama_jabatan, 'I');

?>