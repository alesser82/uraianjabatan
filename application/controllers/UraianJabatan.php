<?php

class UraianJabatan extends Jabatan_Controller
{
    public function __construct()
	{
        parent::__construct();
        if ($this->session->has_userdata('masuk_admin')) {
            $this->load->model('UraianJabatan_model');
            $this->load->helper('form');
            return true;
        }else{
            redirect('');
        }
    }

    public function coba()
    {
        $tugas = 
        [
            'tugas1' => '1',
            'tugas2' => '',
            'tugas3' => '',
            'tugas4' => '4',
            'tugas5' => '',
            'tugas6' => '',
            'tugas7' => '5',
            'tugas8' => '6',
            'tugas9' => '',
            'tugas10' => '',
        ];

        // $coba[] = $tugas;

        foreach ($tugas as $key => $value)
        { 
            if ($value === "")
            { 
                unset($tugas[$key]);
                $tugas[] = $value;
            }
        }

        // rebuild array index
        $tugas = array_values($tugas);
        // $tugas = count($tugas);
        $key = [];
        for ($i=1; $i < 11; $i++) { 
            $key[] = 'tugas'.$i.''; 
        }
        // $a = 1;
        // while ($a <= 10) {
        //     $key = ['tugas'.$a.'']; 
        //     $a++;
        // }
        $tugas = array_combine($key,$tugas);
        // var_dump($key);
        var_dump($tugas);
    }

    private function rulesUraian()
    {
        $rules = 
        [
            ['field' => 'tujuan',
			'label' => 'Tujuan',
            'rules' => 'trim'
            ],
            ['field' => 'ruanglingkup',
			'label' => 'Ruanglingkup',
            'rules' => 'trim'
            ],
            ['field' => 'kondisi',
			'label' => 'Kondisi',
            'rules' => 'trim'
            ]
        ];
        for ($i=1; $i <= 20 ; $i++) { 
            $rules[] = [
                'field' => 'tugas'.$i.'',
                'label' => 'Tugas'.$i.'',
                'rules' => 'trim'
            ];
            $rules[] = [
                'field' => 'tanggungjawab'.$i.'',
                'label' => 'Tanggungjawab'.$i.'',
                'rules' => 'trim'
            ];
        }
        for ($i=1; $i <= 3; $i++) { 
            $rules[] = 
            [
                'field' => 'dimensi'.$i.'',
                'label' => 'Dimensi'.$i.'',
                'rules' => 'trim'
            ];
        }
        for ($i=1; $i <= 10; $i++) { 
            $rules[] = 
            [
                'field' => 'wewenang'.$i.'',
                'label' => 'Wewenang'.$i.'',
                'rules' => 'trim'
            ];
            $rules[] = 
            [
                'field' => 'prasyarat'.$i.'',
                'label' => 'Prasyarat'.$i.'',
                'rules' => 'trim'
            ];
            $rules[] = 
            [
                'field' => 'kompetensikorporat'.$i.'',
                'label' => 'Kompetensikorporat'.$i.'',
                'rules' => 'trim'
            ];
            $rules[] = 
            [
                'field' => 'kompetensirumpun'.$i.'',
                'label' => 'Kompetensirumpun'.$i.'',
                'rules' => 'trim'
            ];
            $rules[] = 
            [
                'field' => 'kompetensiunit'.$i.'',
                'label' => 'Kompetensiunit'.$i.'',
                'rules' => 'trim'
            ];
            $rules[] = 
            [
                'field' => 'kompetensispesifik'.$i.'',
                'label' => 'Kompetensispesifik'.$i.'',
                'rules' => 'trim'
            ];
        }
        for ($i=1; $i <= 5; $i++) { 
            $rules[] = 
            [
                'field' => 'hubintern'.$i.'',
                'label' => 'Hubintern'.$i.'',
                'rules' => 'trim'
            ];
            $rules[] = 
            [
                'field' => 'hubeks'.$i.'',
                'label' => 'Hubeks'.$i.'',
                'rules' => 'trim'
            ];
        }
        for ($i=1; $i <= 15; $i++) { 
            $rules[] = 
            [
                'field' => 'pengetahuanketerampilan'.$i.'',
                'label' => 'Pengetahuanketerampilan'.$i.'',
                'rules' => 'trim'
            ];
        }
        return $rules;
    }

    private function rulesForm($ket)
	{
		switch ($ket) {
            case 'tambah':
                // $rules = [];
                $rules = 
                [
                    [
                    'field' => 'unitkerja',
					'label' => 'Unitkerja',
					'rules' => 'trim|required'],
					['field' => 'jabatan',
					'label' => 'Jabatan',
                    'rules' => 'trim|required'],
                    ['field' => 'lokasi',
					'label' => 'Lokasi',
                    'rules' => 'trim|required']
                ];
                $rules2 = $this->rulesUraian();
                $rules += $rules2;
				return $rules;
				break;
			case 'ubah':
				return $this->rulesUraian();
				break;
			case 'cetak':
				return [
					['field' => 'katasandi1',
					'label' => 'Katasandi1',
					'rules' => 'trim|required'],
					['field' => 'katasandi2',
					'label' => 'Katasandi2',
					'rules' => 'trim|required|matches[katasandi1]']
				];
				break;
			default:
				return 0;
				break;
		}
    }
    
    public function tambah()
    {   
        $unitkerja = $this->tampilUnitKerja();
        $jabatan = $this->tampilJabatan();
        $this->load->model('Admin_model');
        $this->load->model('Pemegangposisi_model');
        $admin = $this->Admin_model;
        $pemegang_posisi = $this->Pemegangposisi_model;
        $uraianjabatan = $this->UraianJabatan_model->tampilUraianJabatan($admin,$pemegang_posisi);
        $count_orgid = array_count_values(array_column($jabatan,'org_id'));
        $count_iduk_uraian = array_count_values(array_column($uraianjabatan,'id_uk'));
        $this->unsetSession();
        foreach($unitkerja as $key => $value){
            foreach($jabatan as $value2){
                foreach ($uraianjabatan as $value3) {
                    if($value->org_id == $value2->org_id){
                        $unitkerja[$key]->nama_jbt = $value2->nama_jbt;
                    }
                }               
            }
        }

        foreach ($unitkerja as $key => $value) {
            foreach ($count_iduk_uraian as $key2 => $value2) {
                $value->id_uk == $key2 ? $unitkerja[$key]->jml_uraian = $value2 :'';
            }
        }

        foreach ($unitkerja as $key => $value) {
            foreach ($count_orgid as $key2 => $value2) {
                $value->org_id == $key2 ? $unitkerja[$key]->max_jbt = $value2 :'';
                $data['list_unitkerja'] = $unitkerja;
            }
        }
        foreach ($unitkerja as $key => $value) {
            if (isset($value->jml_uraian)) {
                if ($value->jml_uraian == $value->max_jbt) {
                    unset($unitkerja[$key]);
                    $data['list_unitkerja'];
                }
            }
        }

        $data['list_lokasi'] = $this->tampilLokasi();
        $data['judul'] = 'Company | Uraian Jabatan - tambah';
        $data['konten'] = 'uraian_jabatan';
        $data['fungsi'] = 'uraian_jabatan-tambah';
        $this->load->view('header',$data);
        $this->load->view('sidebar',$data);
        $this->load->view('uraianjabatan/tambah',$data);
        $this->load->view('footer',$data);
    }

    public function daftarJabatan()
    {
        $id_unitkerja = $this->input->post('id_unitkerja');
        $result_unitkerja = $this->tampilUnitKerja();
        $unitkerja = array_filter($result_unitkerja, function ($var) use ($id_unitkerja) {
			return (md5($var->id_uk) == $id_unitkerja);
        });

        foreach ($unitkerja as $data) {
            $org_id = $data->org_id;
        }
        $this->load->model('Admin_model');
        $this->load->model('Pemegangposisi_model');
        $result_uraianjabatan = $this->UraianJabatan_model->tampilUraianJabatan($this->Admin_model,$this->Pemegangposisi_model);

        $result_jabatan = $this->tampilJabatan();
        $jabatan = array_filter($result_jabatan, function ($var) use ($org_id) {
            return ($var->org_id == $org_id);
        });
        $list = "<option value=''>Pilih Jabatan</option>";
        if (empty($result_uraianjabatan)) {
            foreach ($jabatan as $data) {
                $list .= "<option value='".$data->id_jbt."'>".$data->nama_jbt."</option>";
            }
            $callback = array('list_jabatan'=>$list);
            echo json_encode($callback);
        }else{
            foreach ($result_uraianjabatan as $key => $value) {
                foreach ($jabatan as $key2 => $value2) {
                    if ($value2->id_jbt == $value->id_jbt) {
                        // $jabatan[$key2] = '';
                        unset($jabatan[$key2]);
                    }
                }
            }

            foreach ($jabatan as $data) {
                $list .= "<option value='".$data->id_jbt."'>".$data->nama_jbt."</option>";
            }
            $callback = array('list_jabatan'=>$list);
            echo json_encode($callback);
        }
    }

    public function daftarAlamat()
    {
        $id_lokasi = $this->input->post('lokasi');
        $result_lokasi = $this->tampilLokasi();
        $alamat = array_filter($result_lokasi, function ($var) use ($id_lokasi) {
			return (md5($var->id_lokasi) == $id_lokasi);
        });

        $hasil = "";
        foreach ($alamat as $data) {
            $hasil .= "".$data->alamat."";
        }
        $callback = array('alamat'=>$hasil);
        echo json_encode($callback);
    }

    public function prosesTambah()
    {
        $ket = 'tambah';
        $validation = $this->form_validation->set_rules($this->rulesForm($ket));
        if ($validation->run()) {
            $data_unitkerja = $this->tampilUnitKerja();
            $data_jabatan = $this->tampilJabatan();
            $data_lokasi = $this->tampilLokasi();
            $result = $this->UraianJabatan_model->tambahUraianJabatan($data_unitkerja,$data_jabatan,$data_lokasi);
            switch ($result) {
                case 'Gagal Upload':
                    $this->session->set_flashdata(
                    'message','<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert"><strong>Gagal Unggah.</strong><br><small>Berkas tidak memenuhi ketentuan.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>'
                    );
                    redirect('uraianjabatan/tambah');
                    break;
                case 0:
                    $this->session->set_flashdata(
                    'message','<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert"><strong>Gagal memasukkan data.</strong><br><small>Ada kesalahan dalam pemasukkan data uraian jabatan.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>'
                    );
                    redirect('uraianjabatan/tambah');
                    break;
                case 1:
                    $this->session->set_flashdata(
                    'message','<div class="alert alert-info alert-dismissible fade show mr-3" role="alert"><strong>Berhasil menambah uraian jabatan.</strong><br><small>Data uraian jabatan yang telah diisi telah berhasil disimpan.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>'
                    );
                    redirect('uraianjabatan/tambah');
                    break;
                default:
                    redirect('uraianjabatan/tambah');
                    break;
            }
        }else {
            $this->session->set_flashdata(
					'message','<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal memasukkan data.</strong><br><small>Isilah formlir dengan benar.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button></div></div>'
				);
			redirect('uraianjabatan/tambah');
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

    public function dataUnitKerja()
    {
        $unitkerja = $this->tampilUnitKerja();
        $this->load->model('Admin_model');
        $this->load->model('Pemegangposisi_model');
        $uraianjabatan = $this->UraianJabatan_model->tampilUraianJabatan($this->Admin_model,$this->Pemegangposisi_model);
        $hasil = [];
        if (empty($uraianjabatan)) {
            $data['unitkerja'] = '';
        }else{
            foreach ($unitkerja as $key => $value) {
                foreach ($uraianjabatan as $key2 => $value2) {
                    if ($value->id_uk == $value2->id_uk) {
                        // unset($unitkerja[$key]);
                        $hasil[] = ['id_uk' => $value->id_uk,
                                'nama_uk' => $value->nama_uk];
                    }
                }
            }
        }
        $hasil = $this->unique_multidim_array($hasil,'id_uk'); 
        return $hasil;
    }

    private function unsetSession()
    {
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
    }

    public function ubah()
    {
        $jabatan = $this->input->get('jabatan');
        if ($jabatan == '') {
            $data['judul'] = 'Company | Uraian Jabatan - ubah';
            $data['konten'] = 'uraian_jabatan';
            $data['fungsi'] = 'uraian_jabatan-ubah';
            $data['unitkerja'] = $this->dataUnitKerja();
            $this->unsetSession();
            $this->load->view('header',$data);
            $this->load->view('sidebar',$data);
            $this->load->view('uraianjabatan/ubah',$data);
            $this->load->view('footer',$data);
        }else{
            $all_jabatan = $this->tampilJabatan();
            $this->load->model('Admin_model','admin');
            $this->load->model('Pemegangposisi_model','pemegangposisi');
            $all_uraian = $this->UraianJabatan_model->tampilUraianJabatan($this->admin,$this->pemegangposisi);
            $data['uraian_jabatan'] = array_filter($all_uraian,function($v) use($jabatan)
            {
                return md5($v->id_jbt) == $jabatan;
            });
            foreach ($data['uraian_jabatan'] as $key => $value) {
                $id_uraian_jabatan = [
                    'id_jabatan' => $jabatan,
                    'id_tugas' => $value->id_tgs,
                    'id_prasyarat' => $value->id_ps,
                    'id_tujuan' => $value->id_tj,
                    'id_tanggung_jawab' => $value->id_tanggungjawab,
                    'id_dimensi' => $value->id_dimensi,
                    'id_ruang_lingkup' => $value->id_rulingkup,
                    'id_wewenang' => $value->id_wwg,
                    'id_hubungan_internal' => $value->id_hubintern,
                    'id_hubungan_eksternal' => $value->id_hubeks,
                    'id_kondisi' => $value->id_kondisi,
                    'id_pengetahuan_keterampilan' => $value->id_pk,
                    'id_set_kompetensi' => $value->id_sk,
                    'id_struktur_organisasi' => $value->id_so,
                ];
            }
            $this->session->set_userdata($id_uraian_jabatan);
            $data['judul'] = 'Company | Uraian Jabatan - ubah';
            $data['konten'] = 'uraian_jabatan';
            $data['fungsi'] = 'uraian_jabatan-ubah';
            $data['jabatan'] = $jabatan;
            $this->load->view('header',$data);
            $this->load->view('sidebar',$data);
            $this->load->view('uraianjabatan/ubah_lanjutan',$data);
            $this->load->view('footer',$data);
        }
    }

    public function daftarUbahJabatan()
    {
        $id_unitkerja = $this->input->post('id_unitkerja');
        $result_unitkerja = $this->tampilUnitKerja();
        $unitkerja = array_filter($result_unitkerja, function ($var) use ($id_unitkerja) {
			return (md5($var->id_uk) == $id_unitkerja);
        });

        foreach ($unitkerja as $data) {
            $org_id = $data->org_id;
        }
        $this->load->model('Admin_model','admin');
        $this->load->model('Pemegangposisi_model','pemegangposisi');
        $result_uraianjabatan = $this->UraianJabatan_model->tampilUraianJabatan($this->admin,$this->pemegangposisi);

        $result_jabatan = $this->tampilJabatan();
        $jabatan = array_filter($result_jabatan, function ($var) use ($org_id) {
            return ($var->org_id == $org_id);
        });
        $list = "<option value=''>Pilih jabatan</option>";
        if (empty($result_uraianjabatan)) {
            $callback = array('list_jabatan'=>$list);
            echo json_encode($callback);
        }else{
            $uintersect = array_uintersect($jabatan,$result_uraianjabatan, function($v1,$v2)
            {
                $areaA = $v1->id_jbt;
                $areaB = $v2->id_jbt;
                if ($areaA < $areaB) {
                    return -1;
                } elseif ($areaA > $areaB) {
                    return 1;
                } else {
                    return 0;
                }
            });

            foreach ($uintersect as $data) {
                $list .= "<option value='".md5($data->id_jbt)."'>".$data->nama_jbt."</option>";
            }
            $callback = array('list_jabatan'=>$list);
            echo json_encode($callback);
        }
    }

    public function pengolahUraianJabatan()
    {
        $id_jbt = $this->input->post('id_jbt');
        // $id_jbt = '37693cfc748049e45d87b8c7d8b9aacd';
        $this->load->model('Admin_model');
        $this->load->model('Pemegangposisi_model');
        $all_uraian = $this->UraianJabatan_model->tampilUraianJabatan($this->Admin_model,$this->Pemegangposisi_model);
        $filter_uraian = array_filter($all_uraian,function($v) use ($id_jbt)
        {
            return md5($v->id_jbt) == $id_jbt;
        });
        $hasil = "";
        foreach ($filter_uraian as $data) {
            $hasil = $data->nama_admin;
        }
        $callback = array('nama_admin'=>$hasil);
        echo json_encode($callback);
        // echo json_encode($all_uraian);
    }

    public function prosesUbah()
    {
        $ket = 'ubah';
        $validation = $this->form_validation->set_rules($this->rulesForm($ket));
        if ($validation->run()) {
            $data_jabatan = $this->tampilJabatan();
            $this->load->model('Admin_model');
            $this->load->model('Pemegangposisi_model');
            $uraian_jabatan = $this->UraianJabatan_model->tampilUraianJabatan($this->Admin_model,$this->Pemegangposisi_model);
            $uraian_jabatan = array_filter($uraian_jabatan,function ($v)
            {
                return md5($v->id_jbt) == $this->session->id_jabatan;
            });
            $result = $this->UraianJabatan_model->ubahUraianJabatan($data_jabatan,$uraian_jabatan);
            // var_dump($result);
            switch ($result) {
                case 'Gagal Upload':
                    $this->session->set_flashdata(
                    'message','<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal Unggah.</strong><br><small>Berkas tidak memenuhi ketentuan.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>'
                    );
                    redirect('uraianjabatan/ubah');
                    break;
                case 0:
                    $this->session->set_flashdata(
                    'message','<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal mengubah data.</strong><br><small>Ada kesalahan dalam mengubah data uraian jabatan.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>'
                    );
                    redirect('uraianjabatan/ubah');
                    break;
                case 1:
                    $this->session->set_flashdata(
                    'message','<div class="alert alert-info alert-dismissible fade show mr-3" role="alert"><strong>Berhasil mengubah uraian jabatan.</strong><br><small>Data uraian jabatan yang telah diisi telah berhasil disimpan.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>'
                    );
                    redirect('uraianjabatan/ubah');
                    break;
                default:
                    redirect('uraianjabatan/ubah');
                    break;
            }
        }else {
            $this->session->set_flashdata(
					'message','<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal mengubah data.</strong><br><small>Isilah formlir dengan benar.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button></div></div>'
				);
			redirect('uraianjabatan/ubah');
        }
    }

    public function cetak()
    {
        $format = $this->input->get('format');
        $jabatan = $this->input->get('jabatan');
        if (($format == 'formatbaru') || ($format == 'formatlama')) {
            $session = ['format' => $format];
            $this->session->set_userdata($session);
            $data['judul'] = 'Company | Uraian Jabatan - cetak';
            $data['konten'] = 'uraian_jabatan';
            $data['fungsi'] = 'uraian_jabatan-cetak';
            $data['unitkerja'] = $this->dataUnitKerja();
            $this->load->view('header',$data);
            $this->load->view('sidebar',$data);
            $this->load->view('uraianjabatan/cetak_pilihjabatan',$data);
            $this->load->view('footer',$data);
        }else if(isset($jabatan)){
            $this->load->model('Admin_model');
            $this->load->model('Pemegangposisi_model');
            $uraian_jabatan = $this->UraianJabatan_model->tampilUraianJabatan($this->Admin_model,$this->Pemegangposisi_model);
            $filter_uraian_jabatan = array_filter($uraian_jabatan, function($v) use($jabatan)
            {
                return md5($v->id_jbt) == $jabatan;
            });
            // var_dump($fiter_uraian_jabatan);
            if (empty($filter_uraian_jabatan)) {
                $data['judul'] = 'Company | Uraian Jabatan - cetak';
                $data['konten'] = 'uraian_jabatan';
                $data['fungsi'] = 'uraian_jabatan-cetak';
                $data['unitkerja'] = $this->dataUnitKerja();
                $this->load->view('header',$data);
                $this->load->view('sidebar',$data);
                $this->load->view('uraianjabatan/cetak_pilihjabatan',$data);
                $this->load->view('footer',$data);
            }else{
                switch ($this->session->format) {
                    case 'formatlama':
                        $data_jabatan = $this->tampilJabatan();
                        $data_unit_kerja = $this->tampilUnitKerja();
                        foreach ($filter_uraian_jabatan as $key => $value) {
                            foreach ($data_jabatan as $key2 => $value2) {
                                foreach ($data_unit_kerja as $key3 => $value3) {
                                    if ($value->id_jbt == $value2->id_jbt) {
                                        $filter_uraian_jabatan[$key]->nama_jbt = $value2->nama_jbt;
                                        $filter_uraian_jabatan[$key]->kode_jbt = $value2->kode_jbt;
                                    }
                                    if ($value->id_uk == $value3->id_uk) {
                                        $filter_uraian_jabatan[$key]->nama_uk = $value3->nama_uk;
                                    }
                                }
                            }
                        }
                        $data['uraian_jabatan'] = $filter_uraian_jabatan;
                        $this->load->view('uraianjabatan/uraian_jabatan_format_lama',$data);
                        break;
                    
                    case 'formatbaru':
                        $data_jabatan = $this->tampilJabatan();
                        $data_unit_kerja = $this->tampilUnitKerja();
                        foreach ($filter_uraian_jabatan as $key => $value) {
                            foreach ($data_jabatan as $key2 => $value2) {
                                if ($value->id_jbt == $value2->id_jbt) {
                                    $filter_uraian_jabatan[$key]->nama_jbt = $value2->nama_jbt;
                                    $filter_uraian_jabatan[$key]->kode_jbt = $value2->kode_jbt;
                                }
                            }
                        }
                        $data['uraian_jabatan'] = $filter_uraian_jabatan;
                        $this->load->view('uraianjabatan/uraian_jabatan_format_baru',$data);
                        break;
                    
                    default:
                        $data['judul'] = 'Company | Uraian Jabatan - cetak';
                        $data['konten'] = 'uraian_jabatan';
                        $data['fungsi'] = 'uraian_jabatan-cetak';
                        $data['unitkerja'] = $this->dataUnitKerja();
                        $this->load->view('header',$data);
                        $this->load->view('sidebar',$data);
                        $this->load->view('uraianjabatan/cetak_pilihjabatan',$data);
                        $this->load->view('footer',$data);
                        break;
                }
            }
        }else{
            $this->unsetSession();
            $data['judul'] = 'Company | Uraian Jabatan - cetak';
            $data['konten'] = 'uraian_jabatan';
            $data['fungsi'] = 'uraian_jabatan-cetak';
            $this->load->view('header',$data);
            $this->load->view('sidebar',$data);
            $this->load->view('uraianjabatan/cetak',$data);
            $this->load->view('footer',$data);
        }
    }

    public function keluar()
    {
        $this->session->sess_destroy();
        redirect('');
    }
}
