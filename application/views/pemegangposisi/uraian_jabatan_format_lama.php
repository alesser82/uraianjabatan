<?php
    $this->load->library('Pdf');
    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetTitle('Uraian Jabatan');
    $pdf->SetPrintHeader(true);
    $pdf->SetPrintFooter(true);
    $pdf->SetMargins(25, 40, 25);
    $pdf->SetHeaderMargin(15);
    $pdf->setFooterMargin(30);
    $pdf->SetAutoPageBreak(true,30);
    $pdf->SetAuthor('Author');
    $pdf->SetDisplayMode('real', 'default');
    $pdf->AddPage();
    foreach ($pemegang_posisi as $key => $value) {
        $nama_jabatan = $value->nama_jbt;
        if (empty($uraian_jabatan)) {
            $tujuan = 'Belum ada data.';
            $tugas = '';
            $tanggung_jawab = '';
            $dimensi = '';
            $ruang_lingkup = '';
            $wewenang = '';
            $hubungan_internal = '';
            $hubungan_eksternal = '';
            $kondisi_kerja = '';
            $pengetahuan_dan_keterampilan = '';
            $struktur_organisasi = '';
        }else{
            $tugas = [];
            $tanggung_jawab = [];
            $dimensi = [];
            $wewenang = [];
            $hubungan_internal = [];
            $hubungan_eksternal = [];
            $pengetahuan_dan_keterampilan = [];
            foreach ($uraian_jabatan as $key3 => $value3) {
                $tujuan = $value3->tujuanposisi == '' ? 'Belum ada data.' : $value3->tujuanposisi;

                for ($i=1; $i < 21 ; $i++) { 
                    $tugas += ['tugas'.$i.'' => $value3->{'tugas'.$i}];
                    $tanggung_jawab += ['tj'.$i.'' => $value3->{'tj'.$i}];
                }

                for ($i=1; $i < 4; $i++) { 
                    $dimensi += ['dimensi'.$i.'' => $value3->{'dimensi'.$i}];
                }

                $ruang_lingkup = $value3->ruanglingkup;

                for ($i=1; $i < 11; $i++) { 
                    $wewenang += ['wewenang'.$i.'' => $value3->{'wewenang'.$i}]; 
                }

                for ($i=1; $i < 6; $i++) { 
                    $hubungan_internal += ['hubungan_internal'.$i.'' => $value3->{'hubintern'.$i}];
                    $hubungan_eksternal += ['hubungan_eksternal'.$i.'' => $value3->{'hubeks'.$i}];
                }

                $kondisi_kerja = $value3->kondisi_kerja;

                for ($i=1; $i < 16; $i++) { 
                    $pengetahuan_dan_keterampilan += ['pengetahuan_dan_keterampilan_'.$i.'' => $value3->{'pk'.$i}];
                }
                
                $struktur_organisasi = $value3->struktur;
            }
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
                    <td class="low-width">:</td>';
        if (empty($uraian_jabatan)) {
            $html .= '<td class="mid-width">Belum ada data</td>';
        }else{
            foreach ($uraian_jabatan as $key2 => $value2) {
                $html .= '<td class="mid-width">'.$value2->tgl_input.'</td>';
            }
        }
        $html .=
        '
            </tr>
                <tr>
                    <td class="high-width">Kode Jabatan</td>
                    <td class="low-width">:</td>
                    <td>'.$value->kode_jbt.'</td>
                    <td></td>
                    <td class="mid-width">Lokasi</td>
                    <td class="low-width">:</td>
                    <td style="width:100">'.$value->lokasi.'</td>
                </tr>
                <tr>
                    <td class="high-width">Unit Kerja</td>
                    <td class="low-width">:</td>
                    <td>'.$value->nama_uk.'</td>
                    <td></td>
                    <td class="mid-width">Persetujuan</td>
                    <td class="low-width">:</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="high-width">Pemegang Posisi</td>
                    <td class="low-width">:</td>
                    <td>'.$value->nama_pegawai_incomben.'</td>
                    <td></td>
                    <td class="mid-width">Persetujuan</td>
                    <td class="low-width">:</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="high-width">Atasan Langsung</td>
                    <td class="low-width">:</td>
                    <td colspan="5">'.$value->nama_pegawai_atasan.'</td>
                </tr>
            </table>
        ';

        $html .= 
        '
        <table cellpadding="3">
            <tr><td></td></tr>
            <tr>
                <td colspan="7" class="title">2. TUJUAN POSISI PEKERJAAN</td>
            </tr>
            <tr>
                <td colspan="7">'.$tujuan.'</td>
            </tr>
        </table>
        <table cellpadding="3">
            <tr><td colspan="3"></td></tr>
            <tr>
                <td colspan="3" class="title">3. TANGGUNG JAWAB UTAMA</td>
            </tr>
            <tr style="text-align: center">
                <td colspan="2"><b>Uraian</b></td>
                <td colspan="1"><b>Standar Ukuran Kinerja</b></td>
            </tr>
            <tr>
                <td colspan="2"><ol>
        ';
        if (empty($uraian_jabatan)) {
            
                $html .= 
                '
                                <li>Data belum ada</li>
                            </ol>
                        </td>
                        <td colspan="1">
                            <ul>
                                <li>Data belum ada</li>
                            </ul>
                        </td>
                    </tr>
                    </table>
                ';
            
        }else{
            if (empty($tugas['tugas1']) || empty($tanggung_jawab['tj1'])) {
                $html .= 
                    '<li>Data belum ada</li>
                    </ol>
                    </td>
                            <td colspan="1">
                                <ul>
                                    <li>Data belum ada</li>
                                </ul>
                            </td>
                        </tr>
                        </table>
                    ';
            }else{
                for ($i=1; $i < 21; $i++) { 
                    if ($tugas['tugas'.$i] == '') {
                        break;
                    }
                    $html .= '<li>'.$tugas['tugas'.$i].'</li>';
                }
                $html .= 
                '
                    </ol></td>
                    <td colspan="1"><ul>
                ';
                for ($i=1; $i < 21; $i++) { 
                    if ($tanggung_jawab['tj'.$i] == '') {
                        break;
                    }
                    $html .= '<li>'.$tanggung_jawab['tj'.$i].'</li>';
                }
                $html .= 
                    '</ul></td></tr></table>
                ';
            }
        }
        $html .= ' <table cellpadding="3">
            <tr><td></td></tr>
            <tr>
                <td class="title">4. DIMENSI DAN RUANG LINGKUP</td>
            </tr>
            <tr>
                <td class="sub-title">Dimensi</td>
            </tr>';
        if (empty($uraian_jabatan)) {
            
                $html .= 
                '
                    <tr><td>Data belum ada</td></tr>
                ';
            
        }else{
            if (empty($dimensi)) {
                $html .= 
                    '
                        <tr><td>Data belum ada</td></tr>
                    ';
                $html .= 
                '
                    <tr>
                        <td class="sub-title">Ruang Lingkup</td>
                    </tr>
                ';
                if ($ruang_lingkup == '') {
                    $html .= '<tr><td>Lingkup Area : Data belum ada</td></tr>';
                }else{
                    $html .= '<tr><td>Lingkup Area : '.$ruang_lingkup.'</td></tr>';
                }
            }else{
                for ($i=1; $i < 4; $i++) { 
                    if ($dimensi['dimensi'.$i.''] == '') {
                        break;
                    }
                    $html .= '<tr><td>Dimensi '.$i.' : '.$dimensi['dimensi'.$i.''].'</td></tr>';
                }
                if ($ruang_lingkup == '') {
                    $html .= '<tr><td>Lingkup Area : Data belum ada</td></tr>';
                }else{
                    $html .= '<tr><td>Lingkup Area : '.$ruang_lingkup.'</td></tr>';
                }
            }
        }
        $html .= '</table>';

        // Wewenang

        $html .= 
        '
            <table cellpadding="3">
                <tr><td></td></tr>
                <tr>
                    <td class="title">5. WEWENANG</td>
                </tr>
                <tr>
                    <td>
                        <ul>
        ';
        if (empty($uraian_jabatan)) {
            $html .= 
            '   
                <li>Belum ada data</li>
                </ul>
                </td>
                </tr>
            ';
        }else{
            if (empty($wewenang)) {
                $html .= 
                '   
                    <li>Belum ada data</li>
                    </ul>
                    </td>
                    </tr>
                ';
            }else{
                if ($wewenang['wewenang1'] == '') {
                    $html .= 
                    '   
                        <li>Belum ada data.</li>
                        </ul>
                        </td>
                        </tr>
                    ';
                }else{
                    for ($i=1; $i < 11; $i++) { 
                        if ($wewenang['wewenang'.$i.''] == '') {
                            break;
                        }
                        $html .= 
                        '
                            <li>'.$wewenang['wewenang'.$i.''].'</li>
                        ';
                    }
                    $html .= 
                    '
                        </ul></td></tr>
                    ';
                }
            }
        }
        $html .= '</table>';

        // Hubungan Kerja
        $html .= 
        '
            <table cellpadding="3">
                <tr><td></td></tr>
                <tr>
                    <td class="title">6. HUBUNGAN KERJA</td>
                </tr>
                <tr>
                    <td class="sub-title">Internal Perusahaan (Di dalam lingkungan PT Sucofindo)</td>
                </tr>
                <tr>
                    <td>
                        <ol>
        ';
        if (empty($uraian_jabatan)) {
            $html .= 
            '
                <li>Belum ada data</li>
                </ol>
                </td>
                </tr>
            ';
        }else{
            if ($hubungan_internal['hubungan_internal1'] == '') {
                $html .=
                '
                    <li>Belum ada data</li>
                    </ol>
                    </td>
                    </tr>
                ';
            }else{
                for ($i=1; $i < 6; $i++) { 
                    if ($hubungan_internal['hubungan_internal'.$i.''] == '') {
                        break;
                    }
                    $html .= 
                    '
                        <li>'. $hubungan_internal['hubungan_internal'. $i .''] .'</li>
                    ';
                }
                $html .= 
                '
                    </ol>
                    </td>
                    </tr>
                ';
            }
        }

        $html .= 
        '
            <tr>
                <td class="sub-title">Eksternal Perusahaan (Di luar lingkungan PT Sucofindo)</td>
            </tr>
            <tr><td><ol>
        ';
        if (empty($uraian_jabatan)) {
            $html .= 
            '
                <li>Belum ada data.</li></ol></td></tr>
            ';
        }else{
            if ($hubungan_eksternal['hubungan_eksternal1'] == '') {
                $html .= 
                '
                    <li>Belum ada data.</li></ol></td></tr>
                ';
            }else{
                for ($i=1; $i < 6; $i++) { 
                    if ($hubungan_eksternal['hubungan_eksternal'.$i.''] == '') {
                        break;
                    }
                    $html .= 
                    '
                        <li>'. $hubungan_eksternal['hubungan_eksternal'. $i .''] .'</li>
                    ';
                }
                $html .= 
                '
                    </ol>
                    </td>
                    </tr>
                ';
            }
        }

        $html .= '</table>';

        // Kondisi Kerja
        $html .= 
        '
        <table cellpadding="3">
            <tr><td></td></tr>
            <tr>
                <td class="title">7. KONDISI KERJA</td>
            </tr>
            <tr>
        ';
        if (empty($uraian_jabatan)) {
            $html .= '<td>Belum ada data.</td>';
        }else{
            if ($kondisi_kerja == '') {
                $html .= '<td>Belum ada data.</td>';
            }else{
                $html .= '<td>'. $kondisi_kerja .'</td>';
            }
        }
        $html .= '</tr></table>';

        // Pengetahuan dan Keterampilan
        $html .= '
        <table cellpadding="3">
            <tr><td></td></tr>
            <tr>
                <td class="title">8. PENGETAHUAN DAN KETERAMPILAN</td>
            </tr>
        ';

        if (empty($uraian_jabatan)) {
            $html .= '<tr><td>Belum Ada data.</td></tr>';
        }else{
            if ($pengetahuan_dan_keterampilan['pengetahuan_dan_keterampilan_1'] == '') {
                $html .= '<tr><td>Belum Ada data.</td></tr>';
            }else{
                $html .= '<tr><td><ol>';
                for ($i=0; $i < 16; $i++) { 
                    $html .= '<li>'. $pengetahuan_dan_keterampilan['pengetahuan_dan_keterampilan_'.$i.''] .'</li>';
                }
                $html .= '</ol></td></tr>';
            }
        }

        $html .= '</table>';

        // Struktur Organisasi
        $html .= '
        <table cellpadding="3">
            <tr><td></td></tr>
            <tr>
                <td class="title">9. STRUKTUR ORGANISASI</td>
            </tr>
            <tr>
        ';
        if (empty($uraian_jabatan)) {
            $html .= '<td>Belum ada data.</td>';
        }else{
            if ($struktur_organisasi == '') {
                $html .= '<td>Belum ada data.</td>';
            }else{
                $html .= '<td><img src="'.base_url('assets/img/struktur_organisasi/'.$struktur_organisasi.'').'" alt="struktur organisasi" style="width:450px"></td>';
            }
        }
        $html .= '</tr></table>';
    }
    $ln = true;
    $fill = false;
    $reseth = false;
    $cell = false;
    $align = '';
    $pdf->writeHTML($html, $ln, $fill, $reseth, $cell,$align);
    ob_end_clean();

    $pdf->Output($nama_jabatan.'_format_lama', 'I');

?>