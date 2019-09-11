<?php

class PemegangPosisi extends Jabatan_Controller
{
    use Pegawai_Controller;

    public function __construct() {
        parent::__construct();
        $id_uraian_jabatan = [
                'id_jabatan',
                'id_tugas',
                'id_prasyarat',
                'id_tujuan',
                'id_tanggung_jawab',
                'id_dimensi',
                'id_ruang_lingkup',
                'id_wewenang',
                'id_hubungan_internal',
                'id_hubungan_eksternal',
                'id_kondisi',
                'id_pengetahuan_keterampilan',
                'id_set_kompetensi',
                'id_struktur_organisasi',
                'format'
            ];
        $this->session->unset_userdata($id_uraian_jabatan);
        $this->load->model('Pemegangposisi_model');
        !$this->session->has_userdata('masuk_admin') ? redirect('') : true;
        $this->synchronization();
    }

    public function synchronization()
    {
        $this->load->model('UraianJabatan_model');
        $this->load->model('Admin_model');
        $data_pemegang_posisi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->UraianJabatan_model,$this->Admin_model);
        $data_uraian_jabatan = $this->UraianJabatan_model->tampilUraianJabatan($this->Admin_model, $this->Pemegangposisi_model);
        if (!empty($data_uraian_jabatan) && !empty($data_pemegang_posisi)) {
            foreach ($data_pemegang_posisi as $key => $value) {
                foreach ($data_uraian_jabatan as $key2 => $value2) {
                    if (($value->id_jd == 0) && ($value->id_jbt == $value2->id_jbt)) {
                        $data_update = [
                            'id_pemegang_posisi' => $value->id_pemegang_posisi,
                            'id_jbt' => $value->id_jbt,
                            'id_jd' => $value2->id_jd,
                            'id_lkk' => $value->id_lkk,
                            'npp_incomben' => $value->npp_incomben,
                            'npp_atasan' => $value->npp_atasan,
                            'tgl_input_pgw' => $value->tgl_input_pgw
                        ];
                        $this->db->replace('tbl_jd_org',$data_update);
                    }
                }
            }
        }
    }

    private function unique_multidim_array($array, $key) { 
        $temp_array = array(); 
        $i = 0; 
        $key_array = array(); 
        
        foreach($array as $val) { 
            if (!in_array($val[$key], $key_array)) { 
                $key_array[$i] = $val[$key]; 
                $temp_array[$i] = $val; 
            } 
            $i++; 
        } 
        return $temp_array; 
    } 

    public function daftarJabatan()
    {
        $id_unitkerja = $this->input->post('id_unitkerja');
        $unit_kerja = $this->tampilUnitKerja();
        $this->load->model('UraianJabatan_model','uraianjabatan');
        $this->load->model('Admin_model','admin');
        $pemegang_posisi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan,$this->admin);
        $filter_unit_kerja = array_filter($unit_kerja,function($v) use ($id_unitkerja)
        {
            return md5($v->id_uk) == $id_unitkerja;
        });
        $jabatan = $this->tampilJabatan();
        $filter_jabatan = array_filter($jabatan, function($v) use ($filter_unit_kerja,$pemegang_posisi)
        {
            foreach ($filter_unit_kerja as $key => $value) {
                return $v->org_id == $value->org_id;
            }
        });
        
        $list = '<option>Pilih Jabatan</option>';
        foreach ($filter_jabatan as $data) {
            $list .= "<option value='".md5($data->id_jbt)."'>".$data->nama_jbt."</option>";
        }
        $callback = array('list_jabatan'=>$list);
        echo json_encode($callback);
    }

    public function saringPegawai()
    {
        $npp = $this->input->post('npp');
        $jenis = $this->input->post('pegawai');
        if (isset($npp) && isset($jenis)) {
            $this->load->model('UraianJabatan_model','uraianjabatan');
            $this->load->model('Admin_model','admin');
            $pemegang_posisi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan,$this->admin);
            $pegawai = $this->tampilPegawai();
            $pegawai = array_filter($pegawai,function($value) use($npp)
            {
                return md5($value->npp) != $npp;
            });

            if (($jenis == 'incomben') && (!empty($pemegang_posisi))) {
                $pegawai = array_filter($pegawai,function ($v) use($pemegang_posisi)
                {
                    foreach ($pemegang_posisi as $key => $value) {
                        return $v->npp != $value->npp_incomben;
                    }
                });
            }else if (($jenis == 'ubah_incomben') && (!empty($pemegang_posisi))) {
                foreach ($pegawai as $key => $value) {
                    foreach ($pemegang_posisi as $key2 => $value2) {
                        if ($value->npp == $value2->npp_incomben) {
                            $hasil[] = 
                            [
                                'npp' => $value->npp,
                                'namaPegawai' => $value->namaPegawai,
                                'npp_atasan' => $value2->npp_atasan,
                                'id_jd' => $value2->id_jd
                            ];
                        }
                    }
                }
                $hasil = array_filter($hasil, function ($v) use ($npp)
                {
                    return md5($v['npp_atasan']) == $npp;
                });
                $pegawai = $hasil;
            }else if (($jenis == 'ubah_incomben_lkk') && (!empty($pemegang_posisi))){
                $hasil = [];
                foreach ($pegawai as $key => $value) {
                    foreach ($pemegang_posisi as $key2 => $value2) {
                        if ($value->npp == $value2->npp_incomben) {
                            $hasil[] = 
                            [
                                'npp' => $value->npp,
                                'namaPegawai' => $value->namaPegawai,
                                'npp_atasan' => $value2->npp_atasan,
                                'id_jd' => $value2->id_jd
                            ];
                        }
                    }
                }
                $pegawai = $hasil;
                $pegawai = array_filter($pegawai, function ($v) use ($npp)
                {
                    return md5($v['npp_atasan']) == $npp;
                });
                $pegawai = array_filter($pegawai, function ($v)
                {
                    return $v['id_jd'] != 0;
                });
            }
            $list = '<option value="">Pilih Pegawai Incomben</option>';
            if (($jenis == 'ubah_incomben_lkk') || ($jenis == 'ubah_incomben')) {
                usort($pegawai, function($a, $b) {
                    return $a['namaPegawai'] <=> $b['namaPegawai'];
                });
                foreach ($pegawai as $data) {
                    $list .= "<option value='".md5($data['npp'])."'>".$data['npp']." - ".$data['namaPegawai']."</option>";
                }
            }else{
                usort($pegawai, function($a, $b) {
                    return $a->namaPegawai <=> $b->namaPegawai;
                });
                foreach ($pegawai as $data) {
                    $list .= "<option value='".md5($data->npp)."'>".$data->npp." - ".$data->namaPegawai."</option>";
                }
            }
            $callback = array('list_pegawai'=>$list);
            echo json_encode($callback);
        }else{
            redirect('pemegangposisi/tambah');
        }
    }

    private function unsetSession()
    {
        $pemegang_posisi = [
            'id_pemegang_posisi',
            'npp_incomben',
            'format'
        ];
        $this->session->unset_userdata($pemegang_posisi);
    }

    public function tambah($id = '')
    {
        if ($id != '') {
            $this->load->model('UraianJabatan_model','uraianjabatan');
            $this->load->model('Admin_model','admin');
            $pemegang_posisi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan, $this->admin);
            $pemegang_posisi = array_filter($pemegang_posisi, function($val) use ($id)
            {
                return md5($val->id_pemegang_posisi) == $id;
            });
            if (empty($pemegang_posisi)) {
                redirect('pemegangposisi/tambah');
            }else{
                $id_pemegang_posisi = ['id_pemegang_posisi' => $id];
                foreach ($pemegang_posisi as $key => $value) {
                    $id_jd = $value->id_jd;
                }
                if ($id_jd > 0) {
                    $this->session->set_userdata($id_pemegang_posisi);
                    $this->load->model('UraianJabatan_model','uraianjabatan');
                    $status = 'lkk';
                    $this->load->model('Admin_model','admin');
                    $data['pemegang_posisi'] = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan,$this->admin, $status);
                    $data['pemegang_posisi'] = array_filter($data['pemegang_posisi'],function ($v)
                    {
                        return md5($v->id_pemegang_posisi) == $this->session->id_pemegang_posisi;
                    });
                    $data['judul'] = 'Company | Pemegang Posisi - tambah';
                    $data['konten'] = 'pemegang_posisi';
                    $data['fungsi'] = 'pemegang_posisi-tambah';
                    $this->load->view('header',$data);
                    $this->load->view('sidebar',$data);
                    $this->load->view('pemegangposisi/tambah_lkk',$data);
                    $this->load->view('footer',$data);
                }else{
                    $this->session->set_flashdata(
                    'message','<div class="alert alert-info alert-dismissible fade show mr-3" role="alert"><strong>Berhasil menambah data.</strong><br><small>Pemegang posisi yang dipilih berhasil dimasukkan.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>'
                    );
                    redirect('pemegangposisi/tambah');
                }
            }
        }else{
            $this->unsetSession();
            $this->load->model('UraianJabatan_model','uraianjabatan');
            $this->load->model('Admin_model','admin');
            $pemegang_posisi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan,$this->admin);
            $data['unit_kerja'] = $this->tampilUnitKerja();
            $data['pegawai'] = $this->tampilPegawai();
            if (!empty($pemegang_posisi)) {
                $data['pegawai_incomben'] = array_filter($data['pegawai'], function ($v) use ($pemegang_posisi)
                {
                    foreach ($pemegang_posisi as $key => $value) {
                        return $v->npp != $value->npp_incomben; 
                    }
                });
            }else {
                $data['pegawai_incomben'] = $data['pegawai'];
            }
            usort($data['pegawai'], function($a, $b) {
                return $a->namaPegawai <=> $b->namaPegawai;
            });
            usort($data['pegawai_incomben'], function($a, $b) {
                return $a->namaPegawai <=> $b->namaPegawai;
            });
            $data['judul'] = 'Company | Pemegang Posisi - tambah';
            $data['konten'] = 'pemegang_posisi';
            $data['fungsi'] = 'pemegang_posisi-tambah';
            $this->load->view('header',$data);
            $this->load->view('sidebar',$data);
            $this->load->view('pemegangposisi/tambah',$data);
            $this->load->view('footer',$data);
        }
    }

    public function prosesTambah()
    {
        $id_jabatan = html_escape($this->input->post('jabatan'));
        $npp_pegawai_atasan = html_escape($this->input->post('atasan'));
        $npp_pegawai_incomben = html_escape($this->input->post('incomben'));
        $jabatan = $this->tampilJabatan();
        $pegawai = $this->tampilPegawai();
        $this->load->model('UraianJabatan_model','uraianjabatan');
        $this->load->model('Admin_model','admin');
        $pemegang_posisi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan,$this->admin);
        $id_jabatan = array_filter($jabatan,function ($value) use($id_jabatan)
        {
            return md5($value->id_jbt) == $id_jabatan;
        });
        foreach ($id_jabatan as $key => $value) {
            $id_jabatan = $value->id_jbt;
        }
        $npp_pegawai_atasan = array_filter($pegawai,function ($value) use($npp_pegawai_atasan)
        {
            return md5($value->npp) == $npp_pegawai_atasan;
        });
        foreach ($npp_pegawai_atasan as $key => $value) {
            $npp_pegawai_atasan = $value->npp;
        }
        
        $npp_pegawai_incomben = array_filter($pegawai,function ($value) use($npp_pegawai_incomben)
        {
            return md5($value->npp) == $npp_pegawai_incomben;
        });
        foreach ($npp_pegawai_incomben as $key => $value) {
            $npp_pegawai_incomben = $value->npp;
        }
        $data_pegawai_incomben = array_filter($pemegang_posisi, function($v) use ($npp_pegawai_incomben)
        {
            return $v->npp_incomben == $npp_pegawai_incomben;
        });

        if (empty($data_pegawai_incomben)) {
            $jumlah_pemegang_posisi = count($pemegang_posisi);
            $id_lkk = $jumlah_pemegang_posisi == 0 ? 1 : $jumlah_pemegang_posisi + 1;
            $this->load->model('UraianJabatan_model');
            $this->load->model('Admin_model');
            $data = [
                'id_jbt' => $id_jabatan,
                'id_jd' => '',
                'id_lkk' => $id_lkk,
                'npp_incomben' => $npp_pegawai_incomben,
                'npp_atasan' => $npp_pegawai_atasan,
                'tgl_input_pgw' => date('Y-m-d')
            ];
            $result = $this->Pemegangposisi_model->tambahPemegangPosisi($this->UraianJabatan_model,$this->Admin_model,$data);
            if ($result > 0) {
                redirect('pemegangposisi/tambah/'.md5($result).'');
            }elseif ($result == 'no_jobdesc') {
                $this->session->set_flashdata(
                'message','<div class="alert alert-info alert-dismissible fade show mr-3" role="alert"><strong>Berhasil memasukkan data.</strong><br><small>Pemegang posisi berhasil dimasukkan sesuai formulir.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button></div>'
                );
                redirect('pemegangposisi/tambah');
            }else{
                $this->session->set_flashdata(
                'message','<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert"><strong>Gagal memasukkan data.</strong><br><small>Ada kesalahan dalam proses memasukkan data pemegang posisi.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button></div>'
                );
                redirect('pemegangposisi/tambah');
            }
        }else{
            $this->session->set_flashdata(
            'message','<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert"><strong>Gagal memasukkan data.</strong><br><small>Ada kesalahan dalam proses memasukkan data pemegang posisi.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>'
            );
            redirect('pemegangposisi/tambah');
        }

    }

    public function prosesTambahLkk()
    {
        $id_pemegang_posisi = $this->session->id_pemegang_posisi;
        $this->load->model('UraianJabatan_model','uraianjabatan');
        $this->load->model('Admin_model','admin');
        $pemegang_posisi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan, $this->admin);
        $pemegang_posisi = array_filter($pemegang_posisi, function ($v) use($id_pemegang_posisi)
        {
            return md5($v->id_pemegang_posisi) == $id_pemegang_posisi;
        });
        
        foreach ($pemegang_posisi as $key => $value) {
            $id_lkk = $value->id_lkk;
        }

        for ($i=1; $i < 11; $i++) { 
            ${'kk_'.$i} = $this->input->post('kk'.$i.'');
            if (${'kk_'.$i} > 1) {
                $this->session->set_flashdata(
                    'message','<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert"><strong>Gagal memasukkan data.</strong><br><small>Ada kesalahan dalam proses memasukkan data lkk.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>'
                );
                redirect('pemegangposisi/tambah/'.$this->session->id_pemegang_posisi.'');
            }
        }
        for ($i=1; $i < 11; $i++) { 
            ${'kr_'.$i} = $this->input->post('kr'.$i.'');
            if (${'kr_'.$i} > 1) {
                $this->session->set_flashdata(
                    'message','<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert"><strong>Gagal memasukkan data.</strong><br><small>Ada kesalahan dalam proses memasukkan data lkk.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>'
                );
                redirect('pemegangposisi/tambah/'.$this->session->id_pemegang_posisi.'');
            }
        }
        for ($i=1; $i < 11; $i++) { 
            ${'ku_'.$i} = $this->input->post('ku'.$i.'');
            if (${'ku_'.$i} > 1) {
                $this->session->set_flashdata(
                    'message','<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert"><strong>Gagal memasukkan data.</strong><br><small>Ada kesalahan dalam proses memasukkan data lkk.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>'
                );
                redirect('pemegangposisi/tambah/'.$this->session->id_pemegang_posisi.'');
            }
        }
        for ($i=1; $i < 11; $i++) { 
            ${'ks_'.$i} = $this->input->post('ks'.$i.'');
            if (${'ks_'.$i} > 1) {
                $this->session->set_flashdata(
                    'message','<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert"><strong>Gagal memasukkan data.</strong><br><small>Ada kesalahan dalam proses memasukkan data lkk.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>'
                );
                redirect('pemegangposisi/tambah/'.$this->session->id_pemegang_posisi.'');
            }
        }
        $data = ['id_lkk' => $id_lkk];
        $a = 1;
        for ($i=1; $i < 41; $i++) { 
            if ($a == 11) {
                $a = 1;
            }
            switch ($i) {
                case $i < 11:
                    $data += ['lkk'.$i.'' => ${'kk_'.$a++}];
                    break;
                case $i < 21:
                    $data += ['lkk'.$i.'' => ${'kr_'.$a++}];
                    break;
                case $i < 31:
                    $data += ['lkk'.$i.'' => ${'ku_'.$a++}];
                    break;
                case $i < 41:
                    $data += ['lkk'.$i.'' => ${'ks_'.$a++}];
                    break;
                default:
                    $this->session->set_flashdata(
                        'message','<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert"><strong>Gagal memasukkan data.</strong><br><small>Ada kesalahan dalam proses memasukkan data lkk.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button></div>'
                    );
                    redirect('pemegangposisi/tambah/'.$this->session->id_pemegang_posisi.'');
                    break;
            }
        }
        $status = 'lkk';
        $result = $this->Pemegangposisi_model->ubahPemegangPosisi($this->uraianjabatan, $this->admin, $data, $status);
        if ($result > 0) {
            $this->session->set_flashdata(
            'message','<div class="alert alert-info alert-dismissible fade show mr-3" role="alert"><strong>Berhasil menambah data.</strong><br><small>Pemegang posisi beserta lkk berhasil dimasukkan.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>'
            );
            redirect('pemegangposisi/tambah');
        }else{
            $this->session->set_flashdata(
            'message','<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert"><strong>Gagal memasukkan data.</strong><br><small>Ada kesalahan dalam proses memasukkan data lkk.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>'
            );
            redirect('pemegangposisi/tambah/'.$this->session->id_pemegang_posisi.'');
        }
    }

    public function ubah($sub = '')
    {
        $this->load->model('UraianJabatan_model','uraianjabatan');
        $this->load->model('Admin_model','admin');
        if ($sub == 'lkk') {
            $pemegang_posisi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan, $this->admin);
            $npp_incomben = $this->input->get('incomben');
            $pemegang_posisi = array_filter($pemegang_posisi, function ($v) use ($npp_incomben)
            {
                return md5($v->npp_incomben) == $npp_incomben;
            });
            if (!empty($pemegang_posisi)) {
                foreach ($pemegang_posisi as $key => $value) {
                    $this->session->set_userdata('npp_incomben', $value->npp_incomben);
                }
                $set_kompetensi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan, $this->admin, 'lkk');
                $data['set_kompetensi'] = array_filter($set_kompetensi, function ($v) use ($npp_incomben)
                {
                    return md5($v->npp_incomben) == $npp_incomben;
                });
                $data['judul'] = 'Company | Pemegang Posisi - ubah';
                $data['konten'] = 'pemegang_posisi';
                $data['fungsi'] = 'pemegang_posisi-ubah';
                $this->load->view('header',$data);
                $this->load->view('sidebar',$data);
                $this->load->view('pemegangposisi/ubah_lkk',$data);
                $this->load->view('footer',$data);
                // echo 'tes';
            }else {
                $this->unsetSession();
                $data['judul'] = 'Company | Pemegang Posisi - ubah';
                $data['konten'] = 'pemegang_posisi';
                $data['fungsi'] = 'pemegang_posisi-ubah';
                $pemegang_posisi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan, $this->admin);
                $pegawai = $this->tampilPegawai();
                $data['pegawai'] = array_filter($pegawai, function ($v) use ($pemegang_posisi)
                {
                    foreach ($pemegang_posisi as $key => $value) {
                        return $v->npp == $value->npp_atasan;
                    }
                });
                $this->load->view('header',$data);
                $this->load->view('sidebar',$data);
                $this->load->view('pemegangposisi/ubah_pilihjabatan',$data);
                $this->load->view('footer',$data);
            }
        }else{
            $this->unsetSession();
            $data['judul'] = 'Company | Pemegang Posisi - ubah';
            $data['konten'] = 'pemegang_posisi';
            $data['fungsi'] = 'pemegang_posisi-ubah';
            $data['unit_kerja'] = $this->tampilUnitKerja();
            $pegawai = $this->tampilPegawai();
            $data['pegawai'] = $pegawai;
            $pemegang_posisi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan, $this->admin);
    
            if (!empty($pemegang_posisi)) {
                foreach ($pegawai as $key => $value) {
                    foreach ($pemegang_posisi as $key2 => $value2) {
                        if ($value->npp == $value2->npp_incomben) {
                            $pegawai_incomben[] = 
                            [
                                'npp' => $value->npp,
                                'namaPegawai' => $value->namaPegawai,                
                            ];
                        }
                    }
                }
                $data['pegawai_incomben'] = $pegawai_incomben;
                usort($data['pegawai_incomben'], function($a, $b) {
                    return $a['namaPegawai'] <=> $b['namaPegawai'];
                });

                usort($data['pegawai'], function($a, $b) {
                    return $a->namaPegawai <=> $b->namaPegawai;
                });    
            }else {
                $data['pegawai_incomben'] = [];
                $data['pegawai'] = [];
            }
            
            $this->load->view('header',$data);
            $this->load->view('sidebar',$data);
            $this->load->view('pemegangposisi/ubah',$data);
            $this->load->view('footer',$data);
        }
    }

    public function prosesUbah()
    {
        $id_jabatan = html_escape($this->input->post('jabatan'));
        $npp_pegawai_atasan = html_escape($this->input->post('atasan'));
        $npp_pegawai_incomben = html_escape($this->input->post('incomben'));
        $jabatan = $this->tampilJabatan();
        $pegawai = $this->tampilPegawai();
        $this->load->model('UraianJabatan_model','uraianjabatan');
        $this->load->model('Admin_model','admin');
        $pemegang_posisi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan,$this->admin);
        $id_jabatan = array_filter($jabatan,function ($value) use($id_jabatan)
        {
            return md5($value->id_jbt) == $id_jabatan;
        });
        
        $npp_pegawai_atasan = array_filter($pegawai,function ($value) use($npp_pegawai_atasan)
        {
            return md5($value->npp) == $npp_pegawai_atasan;
        });
        
        $npp_pegawai_incomben = array_filter($pegawai,function ($value) use($npp_pegawai_incomben)
        {
            return md5($value->npp) == $npp_pegawai_incomben;
        });
        if ((empty($id_jabatan)) || (empty($npp_pegawai_atasan)) || (empty($npp_pegawai_incomben))) {
            $this->session->set_flashdata(
            'message','<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert"><strong>Gagal mengubah data.</strong><br><small>Ada kesalahan dalam proses mengubah data pemegang posisi.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>'
            );
            redirect('pemegangposisi/ubah');
        }else{
            foreach ($npp_pegawai_incomben as $key => $value) {
                $npp_pegawai_incomben = $value->npp;
            }
            foreach ($id_jabatan as $key => $value) {
                $id_jabatan = $value->id_jbt;
            }
            foreach ($npp_pegawai_atasan as $key => $value) {
                $npp_pegawai_atasan = $value->npp;
            }
            $data_pegawai_incomben = array_filter($pemegang_posisi, function($v) use ($npp_pegawai_incomben)
            {
                return $v->npp_incomben == $npp_pegawai_incomben;
            });

            $data = [
                'id_jbt' => $id_jabatan,
                'id_jd' => '',
                'npp_incomben' => $npp_pegawai_incomben,
                'npp_atasan' => $npp_pegawai_atasan,
                'tgl_ubah_pemegang_posisi' => date('Y-m-d')
            ];

            $result = $this->Pemegangposisi_model->ubahPemegangPosisi($this->uraianjabatan, $this->admin, $data);

            if ($result > 0) {
                $this->session->set_flashdata(
                'message','<div class="alert alert-info alert-dismissible fade show mr-3" role="alert"><strong>Berhasil mengubah data.</strong><br><small>Pemegang posisi berhasil diubah sesuai isi formulir.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button></div>'
                );
                redirect('pemegangposisi/ubah');
            }else{
                $this->session->set_flashdata(
                'message','<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert"><strong>Gagal mengubah data.</strong><br><small>Ada kesalahan dalam proses mengubah data pemegang posisi.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button></div>'
                );
                redirect('pemegangposisi/ubah');
            }
        }
        
    }

    public function prosesUbahLkk()
    {
        $data = [];
        $this->load->model('UraianJabatan_model','uraianjabatan');
        $this->load->model('Admin_model','admin');
        $pemegang_posisi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan, $this->admin);
        $pemegang_posisi = array_filter($pemegang_posisi, function ($v)
        {
            return $v->npp_incomben == $this->session->npp_incomben;
        });
        foreach ($pemegang_posisi as $key => $value) {
            $data['id_lkk'] = $value->id_lkk;
        }
        $a = 1;
        for ($i=1; $i < 41; $i++) { 
            switch ($i) {
                case 1:
                    $input = 'kk';
                    $a = 1;
                    break;
                case 11:
                    $input = 'kr';
                    $a = 1;
                    break;
                case 21:
                    $input = 'ku';
                    $a = 1;
                    break;
                case 31:
                    $input = 'ks';
                    $a = 1;
                    break;
                
                default:
                    
                    break;
            }

            $data += ['lkk'.$i.'' => html_escape($this->input->post(''.$input.$a++.''))];
            if (!is_numeric($data['lkk'.$i.''])) {
                if (isset($data['lkk'.$i.''])) {
                    $this->session->set_flashdata(
                    'message','<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert"><strong>Gagal mengubah lkk.</strong><br><small>Ada kesalahan dalam pengisian formulir lkk.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>'
                    );
                    redirect('pemegangposisi/ubah/lkk/?incomben='.md5($this->session->npp_incomben).'');
                    break;
                }
            }
        }
        $result = $this->Pemegangposisi_model->ubahPemegangPosisi($this->uraianjabatan, $this->admin, $data, 'lkk');
        if ($result > 0) {
            $this->session->set_flashdata(
            'message','<div class="alert alert-info alert-dismissible fade show mr-3" role="alert"><strong>Berhasil mengubah LKK.</strong><br><small>LKK dari pemegang posisi tersebut berhasil diubah.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>'
            );
            redirect('pemegangposisi/ubah/lkk/');
        }else{
            $this->session->set_flashdata(
            'message','<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert"><strong>Gagal mengubah LKK.</strong><br><small>Ada kesalahan dalam sistem untuk mengubah LKK pemegang posisi.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>'
            );
            redirect('pemegangposisi/ubah/lkk/?incomben='.md5($this->session->npp_incomben).'');
        }
        
    }

    public function cetak($format='')
    {
        if ($format != '') {
            if ($format == 'kirim') {
                $this->unsetSession();
                $this->load->model('UraianJabatan_model','uraianjabatan');
                $this->load->model('Admin_model','admin');
                $data['pegawai'] = $this->tampilPegawai();
                $data['judul'] = 'Company | Pemegang Posisi - cetak';
                $data['konten'] = 'pemegang_posisi';
                $data['fungsi'] = 'pemegang_posisi-cetak';
                $this->load->view('header',$data);
                $this->load->view('sidebar',$data);
                $this->load->view('pemegangposisi/kirim',$data);
                $this->load->view('footer',$data);
            }else{
                $this->load->model('UraianJabatan_model','uraianjabatan');
                $this->load->model('Admin_model','admin');
                $npp_incomben = $this->input->get('incomben');
                if (isset($npp_incomben)) {
                    $pemegang_posisi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan, $this->admin);
                    $pemegang_posisi = array_filter($pemegang_posisi, function ($v) use ($npp_incomben)
                    {
                        return md5($v->npp_incomben) == $npp_incomben;
                    });
                    if (!empty($pemegang_posisi)) {
                        switch ($format) {
                            case 'formatlama':
                                $pemegang_posisi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan, $this->admin, 'cetak');
                                $uraian_jabatan = $pemegang_posisi['uraian_jabatan'];
                                $pemegang_posisi = $pemegang_posisi['pemegang_posisi'];
    
                                $pemegang_posisi = array_filter($pemegang_posisi, function ($v) use ($npp_incomben)
                                {
                                    return md5($v->npp_incomben) == $npp_incomben;
                                });
    
                                foreach ($pemegang_posisi as $key => $value) {
                                    $id_jd = $value->id_jd;
                                    $id_jbt = $value->id_jbt;
                                }
    
                                if ($id_jd != 0) {
                                    $data['uraian_jabatan'] = array_filter($uraian_jabatan, function ($v) use ($id_jd)
                                    {
                                        return $v->id_jd == $id_jd;
                                    });
                                }else{
                                    $data['uraian_jabatan'] = [];
                                }
                                $data['pemegang_posisi'] = $pemegang_posisi;
                                $this->load->view('pemegangposisi/uraian_jabatan_format_lama',$data);
    
                                break;
                            case 'formatbaru':
                                $pemegang_posisi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan, $this->admin, 'cetak');
                                $uraian_jabatan = $pemegang_posisi['uraian_jabatan'];
                                $pemegang_posisi = $pemegang_posisi['pemegang_posisi'];
                                $data['pemegang_posisi'] = array_filter($pemegang_posisi, function ($v) use ($npp_incomben)
                                {
                                    return md5($v->npp_incomben) == $npp_incomben;
                                });
                                foreach ($data['pemegang_posisi'] as $key => $value) {
                                    $id_jd = $value->id_jd;
                                }
                                $data['uraian_jabatan'] = array_filter($uraian_jabatan, function ($v) use ($id_jd)
                                {
                                    return $v->id_jd == $id_jd;
                                });
                                $this->load->view('pemegangposisi/uraian_jabatan_format_baru', $data);
                                break;
                            
                            default:
                                redirect('pemegangposisi/cetak');
                                break;
                        }
                    }else{
                        redirect('pemegangposisi/cetak/'.$format.'');
                    }
                }else{
                    $this->session->set_userdata('format',$format);
                    $this->load->model('UraianJabatan_model','uraianjabatan');
                    $this->load->model('Admin_model','admin');
                    $data['judul'] = 'Company | Pemegang Posisi - cetak';
                    $data['konten'] = 'pemegang_posisi';
                    $data['fungsi'] = 'pemegang_posisi-cetak';
                    $pegawai = $this->tampilPegawai();
                    $pemegang_posisi = $this->Pemegangposisi_model->tampilPemegangPosisi($this->uraianjabatan, $this->admin);
                    if (!empty($pemegang_posisi)) {
                        foreach ($pegawai as $key => $value) {
                            foreach ($pemegang_posisi as $key2 => $value2) {
                                if ($value->npp == $value2->npp_atasan) {
                                    $hasil[] = 
                                    [
                                        'npp' => $value->npp,
                                        'namaPegawai' => $value->namaPegawai,
                                    ];
                                }
                            }
                        }
                        $hasil = $this->unique_multidim_array($hasil,'npp'); 
                    }else {
                        $hasil = '';
                    }
                    $data['pegawai'] = $hasil;
    
                    $this->load->view('header',$data);
                    $this->load->view('sidebar',$data);
                    $this->load->view('pemegangposisi/cetak_pilihpemegangposisi',$data);
                    $this->load->view('footer',$data);
                }
                
            }
        }else{
            $this->unsetSession();
            $data['judul'] = 'Company | Pemegang Posisi - cetak';
            $data['konten'] = 'pemegang_posisi';
            $data['fungsi'] = 'pemegang_posisi-cetak';
            $this->load->view('header',$data);
            $this->load->view('sidebar',$data);
            $this->load->view('pemegangposisi/cetak',$data);
            $this->load->view('footer',$data);
        }
    }

    private function multipleUpload($path, $files)
    {
        $config = array(
            'upload_path'   => $path,
            'allowed_types' => 'pdf',
            'overwrite'     => TRUE,                       
        );

        $this->load->library('upload', $config);

        $images = array();
        $status = [];
        foreach ($files['name'] as $key => $image) {
            $_FILES['file[]']['name']= $files['name'][$key];
            $_FILES['file[]']['type']= $files['type'][$key];
            $_FILES['file[]']['tmp_name']= $files['tmp_name'][$key];
            $_FILES['file[]']['error']= $files['error'][$key];
            $_FILES['file[]']['size']= $files['size'][$key];

            $fileName = $files['name'][$key];

            $file[] = $fileName;

            $config['file_name'] = $fileName;
            $name = [];
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file[]')) {
                $status = true;
            } else {
                // $error = array('error' => $this->upload->display_errors());
                // var_dump($error);
                return FALSE;
            }
        }
        return $status;
    }

    public function prosesKirim()
    {
        $files = $_FILES['uraianjabatan'];
        $pegawai = $this->input->post('incomben');
        $jumlah_pemegang_posisi = count($pegawai);
        $jumlah_uraian_jabatan = count($files['name']);
        $path = 'assets/uraian_jabatan/';
        $upload = $this->multipleUpload($path, $files);
        if ($upload === TRUE) {
            for ($i=1; $i <= $jumlah_pemegang_posisi; $i++) { 
                $this->load->library('Phpmailer_library');
                $mail = $this->phpmailer_library->load();
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'mramadhan123456@gmail.com';
                $mail->Password = 'rama1101987';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('mramadhan123456@gmail.com','rama');
                $mail->addAddress($pegawai[($i-1)]);
                $mail->addReplyTo('mramadhan123456@gmail.com', 'rama');
                $mail->Subject = 'Uraian Jabatan';
                $mail->AllowEmpty = true;
                $mail->isHTML(true);
                $mail->Debugoutput = 'html';
                $mailContent = "<h1>Uraian Jabatan</h1>
                    <p>Uraian jabatan yang dikirim oleh ". $this->session->nama .".</p>";
                $mail->Body = $mailContent;
                for ($j=1; $j <= $jumlah_uraian_jabatan; $j++) { 
                    $mail->addAttachment('assets/uraian_jabatan/'. str_replace(' ','_',$files['name'][($j-1)]) .'');
                    // var_dump(str_replace(' ','_',$files['name'][($j-1)]));
                    // var_dump($files['name'][($j-1)]);
                }
                // var_dump($mail);
                // die;
                $mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) );
                if(!$mail->send()) {
                    $this->session->set_flashdata(
                    'message','<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert"><strong>Gagal mengirim.</strong><br><small>Koneksi internet kurang memadai atau berkas terlalu besar.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>'
                    );
                    redirect('pemegangposisi/cetak/kirim');
                } else {
                    $this->session->set_flashdata(
                    'message','<div class="alert alert-info alert-dismissible fade show mr-3" role="alert"><strong>Berhasil mengirim.</strong><br><small>Berkas uraian jabatan berhasil dikirim.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>'
                    );
                    redirect('pemegangposisi/cetak/kirim');
                }
            }
        }else{
            $this->session->set_flashdata(
            'message','<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert"><strong>Gagal mengirim.</strong><br><small>Berkas yang diunggah bermasalah.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>'
            );
            redirect('pemegangposisi/cetak/kirim');
        }
    }

}
