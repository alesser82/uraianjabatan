<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UraianJabatan_model extends Jabatan_model
{

    private $tugas,
    $prasyarat,
    $tujuan,
    $tanggungjawab,
    $dimensi,
    $ruanglingkup,
    $wewenang,
    $hubunganinternal,
    $hubunganeksternal,
    $kondisi_kerja,
    $pengetahuanketerampilan,
    $strukturorganisasi,
    $setkompetensi,
    $tanggal,
    $nama_admin,
    $table_uraian = 'tbl_jobdesc',
    $table_tugas = 'tbl_tugas',
    $table_dimensi = 'tbl_dimensi',
    $table_hubunganeksternal = 'tbl_hubunganeksternal',
    $table_hubunganinternal = 'tbl_hubunganinternal',
    $table_kondisikerja = 'tbl_kondisikerja',
    $table_prasyarat = 'tbl_prasyarat',
    $table_ruanglingkup = 'tbl_ruanglingkup',
    $table_setkompetensi = 'tbl_setkompetensi',
    $table_strukturorganisasi = 'tbl_strukturorganisasi',
    $table_tanggungjawab = 'tbl_tanggung_jawab',
    $table_tujuan = 'tbl_tujuan',
    $table_pengetahuanketerampilan = 'tbl_pengetahuanketerampilan',
    $table_wewenang = 'tbl_wewenang';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function tampilUraianJabatan(Admin_model $admin, Pemegangposisi_model $pemegang_posisi)
    {
        $uraian_jabatan = $this->db->get(''.$this->table_uraian.'')->result();
        if (empty($uraian_jabatan)) {
            return $uraian_jabatan;
        }else{
            $this->db->select('*');
            $this->db->from(''.$this->table_uraian.'');
            $this->db->join(''.$this->table_dimensi.'', ''.$this->table_dimensi.'.id_dimensi = '.$this->table_uraian.'.id_dimensi','inner');
            $this->db->join(''.$this->table_hubunganeksternal.'', ''.$this->table_hubunganeksternal.'.id_hubeks = '.$this->table_uraian.'.id_hubeks','inner');
            $this->db->join(''.$this->table_hubunganinternal.'', ''.$this->table_hubunganinternal.'.id_hubintern = '.$this->table_uraian.'.id_hubintern','inner');
            $this->db->join(''.$this->table_kondisikerja.'', ''.$this->table_kondisikerja.'.id_kondisi = '.$this->table_uraian.'.id_kondisi','inner');
            $this->db->join(''.$this->table_pengetahuanketerampilan.'', ''.$this->table_pengetahuanketerampilan.'.id_pk = '.$this->table_uraian.'.id_pk','inner');
            $this->db->join(''.$this->table_prasyarat.'', ''.$this->table_prasyarat.'.id_ps = '.$this->table_uraian.'.id_ps','inner');
            $this->db->join(''.$this->table_ruanglingkup.'', ''.$this->table_ruanglingkup.'.id_rulingkup = '.$this->table_uraian.'.id_rulingkup','inner');
            $this->db->join(''.$this->table_setkompetensi.'', ''.$this->table_setkompetensi.'.id_sk = '.$this->table_uraian.'.id_sk','inner');
            $this->db->join(''.$this->table_strukturorganisasi.'', ''.$this->table_strukturorganisasi.'.id_so = '.$this->table_uraian.'.id_so','inner');
            $this->db->join(''.$this->table_tanggungjawab.'', ''.$this->table_tanggungjawab.'.id_tanggungjawab = '.$this->table_uraian.'.id_tanggungjawab','inner');
            $this->db->join(''.$this->table_tugas.'', ''.$this->table_tugas.'.id_tgs = '.$this->table_uraian.'.id_tgs','inner');
            $this->db->join(''.$this->table_tujuan.'', ''.$this->table_tujuan.'.id_tj = '.$this->table_uraian.'.id_tj','inner');
            $this->db->join(''.$this->table_wewenang.'', ''.$this->table_wewenang.'.id_wwg = '.$this->table_uraian.'.id_wwg','inner');
            $query = $this->db->get()->result();
            $admin_data = $admin->tampilAdmin();
            $pemegang_posisi_data = $pemegang_posisi->tampilPemegangPosisi($this,$admin);
            if (!empty($pemegang_posisi_data)) {
                foreach ($query as $key => $value) {
                    foreach ($admin_data as $key2 => $value2) {
                        foreach ($pemegang_posisi_data as $key3 => $value3) {
                            if ($value->id_admin == $value2->id) {
                                $query[$key]->nama_admin = $value2->nama;
                            }
                            if ($value->id_jd == $value3->id_jd) {
                                $query[$key]->npp_incomben = $value3->npp_incomben;
                            }
                        }
                    }
                }
            }else {
                foreach ($query as $key => $value) {
                    foreach ($admin_data as $key2 => $value2) {
                        if ($value->id_admin == $value2->id) {
                            $query[$key]->nama_admin = $value2->nama;
                        }
                    }
                }
            }
            return $query;
        }
    }

    public function tambahUraianJabatan($data_unitkerja,$data_jabatan,$data_lokasi)
    {
        $unitkerja = html_escape($this->input->post('unitkerja'));
        $jabatan = html_escape($this->input->post('jabatan'));
        $lokasi = html_escape($this->input->post('lokasi'));

        $filter_unitkerja = array_filter($data_unitkerja, function ($var) use ($unitkerja) {
			return (md5($var->id_uk) == $unitkerja);
        });

        $filter_jabatan = array_filter($data_jabatan, function ($var) use ($jabatan) {
			return (md5($var->id_jbt) == $jabatan);
        });

        $filter_lokasi = array_filter($data_lokasi, function ($var) use ($lokasi) {
			return (md5($var->id_lokasi) == $lokasi);
        });

        foreach ($filter_unitkerja as $value) {
            $unitkerja = $value->id_uk;
        }

        foreach ($filter_jabatan as $value) {
            $jabatan = $value->id_jbt;
        }

        foreach ($filter_lokasi as $value) {
            $lokasi = $value->id_lokasi;
        }
        $this->tugas = [];
        $this->tanggungjawab = [];
        $this->dimensi = [];
        $this->wewenang = [];
        $this->prasyarat = [];
        $this->setkompetensi = [];
        $this->hubunganeksternal = [];
        $this->hubunganinternal = [];
        $this->pengetahuanketerampilan = [];
        $this->kondisi_kerja = [];
        $this->ruanglingkup = [];
        $this->strukturorganisasi = [];
        $this->tujuan = [];
        $this->ruanglingkup += ['ruanglingkup' => html_escape($this->input->post('ruanglingkup'))];
        $this->kondisi_kerja += ['kondisi_kerja' => html_escape($this->input->post('kondisi'))];
        $this->tujuan += ['tujuanposisi' => html_escape($this->input->post('tujuan'))];
        for ($i=1; $i <= 20 ; $i++) { 
            $this->tugas += ['tugas'.$i.'' => html_escape($this->input->post('tugas'.$i.''))];
            $this->tanggungjawab += ['tj'.$i.'' => html_escape($this->input->post('tanggungjawab'.$i.''))];
        }

        //Urut isian tugas
        foreach ($this->tugas as $key => $value) {
            if ($value === "")
            { 
                unset($this->tugas[$key]);
                $this->tugas[] = $value;
            }
        }
        $this->tugas = array_values($this->tugas);
        $key_tugas = [];
        for ($i=1; $i < 21; $i++) { 
            $key_tugas[] = 'tugas'.$i.''; 
        }
        $this->tugas = array_combine($key_tugas,$this->tugas);

        //Urut isian tanggung jawab
        foreach ($this->tanggungjawab as $key => $value) {
            if ($value === "")
            { 
                unset($this->tanggungjawab[$key]);
                $this->tanggungjawab[] = $value;
            }
        }
        $this->tanggungjawab = array_values($this->tanggungjawab);
        $key_tanggungjawab = [];
        for ($i=1; $i < 21; $i++) { 
            $key_tanggungjawab[] = 'tj'.$i.''; 
        }
        $this->tanggungjawab = array_combine($key_tanggungjawab,$this->tanggungjawab);

        for ($i=1; $i <= 3 ; $i++) { 
            $this->dimensi += ['dimensi'.$i.'' => html_escape($this->input->post('dimensi'.$i.''))];
        }

        //urut isian dimensi
        foreach ($this->dimensi as $key => $value) {
            if ($value === "")
            { 
                unset($this->dimensi[$key]);
                $this->dimensi[] = $value;
            }
        }
        $this->dimensi = array_values($this->dimensi);
        $key_dimensi = [];
        for ($i=1; $i < 4; $i++) { 
            $key_dimensi[] = 'dimensi'.$i.''; 
        }
        $this->dimensi = array_combine($key_dimensi,$this->dimensi);

        $kompetensikorporat = [];
        $kompetensirumpun = [];
        $kompetensiunit = [];
        $kompetensispesifik = [];
        for ($i=1; $i <= 10 ; $i++) { 
            $this->wewenang += ['wewenang'.$i.'' =>html_escape($this->input->post('wewenang'.$i.''))];
            $this->prasyarat += ['prasyarat'.$i.'' => html_escape($this->input->post('prasyarat'.$i.''))];
            $kompetensikorporat += ['kk_'.$i.'' => html_escape($this->input->post('kompetensikorporat'.$i.''))];
            $kompetensirumpun += ['kr_'.$i.'' => html_escape($this->input->post('kompetensirumpun'.$i.''))];
            $kompetensiunit += ['ku_'.$i.'' => html_escape($this->input->post('kompetensiunit'.$i.''))];
            $kompetensispesifik += ['ks_'.$i.'' => html_escape($this->input->post('kompetensispesifik'.$i.''))];
        }  

        //isian usut isian wewenang
        foreach ($this->wewenang as $key => $value) {
            if ($value === "")
            { 
                unset($this->wewenang[$key]);
                $this->wewenang[] = $value;
            }
        }
        $this->wewenang = array_values($this->wewenang);
        $key_wewenang = [];
        for ($i=1; $i < 11; $i++) { 
            $key_wewenang[] = 'wewenang'.$i.''; 
        }
        $this->wewenang = array_combine($key_wewenang,$this->wewenang);

        //urut isian prasyarat
        foreach ($this->prasyarat as $key => $value) {
            if ($value === "")
            { 
                unset($this->prasyarat[$key]);
                $this->prasyarat[] = $value;
            }
        }
        $this->prasyarat = array_values($this->prasyarat);
        $key_prasyarat = [];
        for ($i=1; $i < 11; $i++) { 
            $key_prasyarat[] = 'prasyarat'.$i.''; 
        }
        $this->prasyarat = array_combine($key_prasyarat,$this->prasyarat);

        //urut isian kompetensi korporat
        foreach ($kompetensikorporat as $key => $value) {
            if ($value === "")
            { 
                unset($kompetensikorporat[$key]);
                $kompetensikorporat[] = $value;
            }
        }
        $kompetensikorporat = array_values($kompetensikorporat);
        $key_kompetensi_korporat = [];
        for ($i=1; $i < 11; $i++) { 
            $key_kompetensi_korporat[] = 'kk_'.$i.''; 
        }
        $kompetensikorporat = array_combine($key_kompetensi_korporat,$kompetensikorporat);

        // urut isian kompetensi rumpun
        foreach ($kompetensirumpun as $key => $value) {
            if ($value === "")
            { 
                unset($kompetensirumpun[$key]);
                $kompetensirumpun[] = $value;
            }
        }
        $kompetensirumpun = array_values($kompetensirumpun);
        $key_kompetensi_rumpun = [];
        for ($i=1; $i < 11; $i++) { 
            $key_kompetensi_rumpun[] = 'kr_'.$i.''; 
        }
        $kompetensirumpun = array_combine($key_kompetensi_rumpun,$kompetensirumpun);

        // urut isian kompetensi unit
        foreach ($kompetensiunit as $key => $value) {
            if ($value === "")
            { 
                unset($kompetensiunit[$key]);
                $kompetensiunit[] = $value;
            }
        }
        $kompetensiunit = array_values($kompetensiunit);
        $key_kompetensi_unit = [];
        for ($i=1; $i < 11; $i++) { 
            $key_kompetensi_unit[] = 'ku_'.$i.''; 
        }
        $kompetensiunit = array_combine($key_kompetensi_unit,$kompetensiunit);

        // urut isian kompetensi spesifik
        foreach ($kompetensispesifik as $key => $value) {
            if ($value === "")
            { 
                unset($kompetensispesifik[$key]);
                $kompetensispesifik[] = $value;
            }
        }
        $kompetensispesifik = array_values($kompetensispesifik);
        $key_kompetensi_spesifik = [];
        for ($i=1; $i < 11; $i++) { 
            $key_kompetensi_spesifik[] = 'ks_'.$i.''; 
        }
        $kompetensispesifik = array_combine($key_kompetensi_spesifik,$kompetensispesifik);

        $this->setkompetensi = array_merge_recursive($this->setkompetensi,$kompetensikorporat);
        $this->setkompetensi = array_merge_recursive($this->setkompetensi,$kompetensirumpun);
        $this->setkompetensi = array_merge_recursive($this->setkompetensi,$kompetensiunit);
        $this->setkompetensi = array_merge_recursive($this->setkompetensi,$kompetensispesifik);

        for ($i=1; $i <= 5 ; $i++) { 
            $this->hubunganeksternal += ['hubeks'.$i.'' => html_escape($this->input->post('hubeks'.$i.''))];
            $this->hubunganinternal += ['hubintern'.$i.''  => html_escape($this->input->post('hubintern'.$i.''))];
        }

        //urut isian hubungan eksternal
        foreach ($this->hubunganeksternal as $key => $value) {
            if ($value === "")
            { 
                unset($this->hubunganeksternal[$key]);
                $this->hubunganeksternal[] = $value;
            }
        }
        $this->hubunganeksternal = array_values($this->hubunganeksternal);
        $key_hubunganeksternal = [];
        for ($i=1; $i < 6; $i++) { 
            $key_hubunganeksternal[] = 'hubeks'.$i.''; 
        }
        $this->hubunganeksternal = array_combine($key_hubunganeksternal,$this->hubunganeksternal);

        //urut isian hubungan internal
        foreach ($this->hubunganinternal as $key => $value) {
            if ($value === "")
            { 
                unset($this->hubunganinternal[$key]);
                $this->hubunganinternal[] = $value;
            }
        }
        $this->hubunganinternal = array_values($this->hubunganinternal);
        $key_hubunganinternal = [];
        for ($i=1; $i < 6; $i++) { 
            $key_hubunganinternal[] = 'hubintern'.$i.''; 
        }
        $this->hubunganinternal = array_combine($key_hubunganinternal,$this->hubunganinternal);

        for ($i=1; $i <= 15 ; $i++) { 
            $this->pengetahuanketerampilan += ['pk'.$i.'' => html_escape($this->input->post('pengetahuanketerampilan'.$i.''))];
        }

        // urut isian pengetahuan dan keterampilan
        foreach ($this->pengetahuanketerampilan as $key => $value) {
            if ($value === "")
            { 
                unset($this->pengetahuanketerampilan[$key]);
                $this->pengetahuanketerampilan[] = $value;
            }
        }
        $this->pengetahuanketerampilan = array_values($this->pengetahuanketerampilan);
        $key_pengetahuanketerampilan = [];
        for ($i=1; $i < 16; $i++) { 
            $key_pengetahuanketerampilan[] = 'pk'.$i.''; 
        }
        $this->pengetahuanketerampilan = array_combine($key_pengetahuanketerampilan,$this->pengetahuanketerampilan);

        if ($_FILES['strukturorganisasi']['size'] != '') {
            $config['upload_path']          = 'assets/img/struktur_organisasi';
            $config['allowed_types']        = 'jpg|png|jpeg|svg';
            $config['max_size']             = 1000000;
            $config['max_width']            = 1920;
            $config['max_height']           = 1920;
            $config['overwrite']            = FALSE;
            $config['remove_space']         = TRUE;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('strukturorganisasi'))
            {   
                $result = 'Gagal upload';
                return $result;
            }
            else
            {
                $this->strukturorganisasi += ['struktur' => $this->upload->data('file_name')];
                for ($i=1; $i <= 14; $i++) { 
                    switch ($i) {
                        case 1:
                            ${'table'.$i} = $this->table_tugas;
                            ${'value'.$i} = $this->tugas;
                            ${'id'.$i} = 'id_tgs';
                            break;
                        case 2:
                            ${'table'.$i} = $this->table_tanggungjawab;
                            ${'value'.$i} = $this->tanggungjawab;
                            ${'id'.$i} = 'id_tanggungjawab';
                            break;
                        case 3:
                            ${'table'.$i} = $this->table_dimensi;
                            ${'value'.$i} = $this->dimensi;
                            ${'id'.$i} = 'id_dimensi';
                            break;
                        case 4:
                            ${'table'.$i} = $this->table_hubunganeksternal;
                            ${'value'.$i} = $this->hubunganeksternal;
                            ${'id'.$i} = 'id_hubeks';
                            break;
                        case 5:
                            ${'table'.$i} = $this->table_hubunganinternal;
                            ${'value'.$i} = $this->hubunganinternal;
                            ${'id'.$i} = 'id_intern';
                            break;
                        case 6:
                            ${'table'.$i} = $this->table_kondisikerja;
                            ${'value'.$i} = $this->kondisi_kerja;
                            ${'id'.$i} = 'id_kondisi';
                            break;
                        case 7:
                            ${'table'.$i} = $this->table_pengetahuanketerampilan;
                            ${'value'.$i} = $this->pengetahuanketerampilan;
                            ${'id'.$i} = 'id_pk';
                            break;
                        case 8:
                            ${'table'.$i} = $this->table_prasyarat;
                            ${'value'.$i} = $this->prasyarat;
                            ${'id'.$i} = 'id_ps';
                            break;
                        case 9:
                            ${'table'.$i} = $this->table_ruanglingkup;
                            ${'value'.$i} = $this->ruanglingkup;
                            ${'id'.$i} = 'id_rulingkup';
                            break;
                        case 10:
                            ${'table'.$i} = $this->table_setkompetensi;
                            ${'value'.$i} = $this->setkompetensi;
                            ${'id'.$i} = 'id_sk';
                            break;
                        case 11:
                            ${'table'.$i} = $this->table_strukturorganisasi;
                            ${'value'.$i} = $this->strukturorganisasi;
                            ${'id'.$i} = 'id_so';
                            break;
                        case 12:
                            ${'table'.$i} = $this->table_tujuan;
                            ${'value'.$i} = $this->tujuan;
                            ${'id'.$i} = 'id_tj';
                            break;
                        case 13:
                            ${'table'.$i} = $this->table_wewenang;
                            ${'value'.$i} = $this->wewenang;
                            ${'id'.$i} = 'id_wwg';
                            break;
                        case 14:
                            ${'table'.$i} = $this->table_uraian;
                            ${'value'.$i} = [
                                'id_uk' => $unitkerja,
                                'id_jbt' => $jabatan,
                                'id_lokasi' => $lokasi,
                                'id_ps' => $hasil_id8,
                                'id_tj' => $hasil_id12,
                                'id_tgs' => $hasil_id1,
                                'id_tanggungjawab' => $hasil_id2,
                                'id_dimensi' => $hasil_id3,
                                'id_rulingkup' => $hasil_id9,
                                'id_wwg' => $hasil_id13,
                                'id_hubintern' => $hasil_id5,
                                'id_hubeks' => $hasil_id4,
                                'id_kondisi' => $hasil_id6,
                                'id_pk' => $hasil_id7,
                                'id_sk' => $hasil_id10,
                                'id_so' => $hasil_id11,
                                'tgl_input' => date('Y-m-d'),
                                'tgl_update' => '',
                                'id_admin' => $this->session->id_admin
                            ];
                            ${'id'.$i} = 'id_jd';
                            break;
                        
                        default:
                            break;
                    }
                    $insert = $this->db->insert(${'table'.$i},${'value'.$i});
                    ${'hasil_id'.$i} = $this->db->insert_id();
                    ${'hasil_rows'.$i} = $this->db->affected_rows();
                    if (${'hasil_rows'.$i} === 0) {
                        for ($a=$i-1; $a > 0 ; $a--) { 
                            $this->db->delete(${'table'.$a},[${'id'.$a} => ${'hasil_id'.$a}]);
                            if ($a === 1) {
                                return 0;
                            }
                            break;
                        }
                    }
                    if ($i === 14) {
                        if (${'hasil_rows'.$i} === 1) {
                            return 1;
                        }else{
                            return 0;
                        }
                    }
                }   
            }
        }else{
            $this->strukturorganisasi += ['struktur' => ''];
            for ($i=1; $i <= 14; $i++) { 
                switch ($i) {
                    case 1:
                        ${'table'.$i} = $this->table_tugas;
                        ${'value'.$i} = $this->tugas;
                        ${'id'.$i} = 'id_tgs';
                        break;
                    case 2:
                        ${'table'.$i} = $this->table_tanggungjawab;
                        ${'value'.$i} = $this->tanggungjawab;
                        ${'id'.$i} = 'id_tanggungjawab';
                        break;
                    case 3:
                        ${'table'.$i} = $this->table_dimensi;
                        ${'value'.$i} = $this->dimensi;
                        ${'id'.$i} = 'id_dimensi';
                        break;
                    case 4:
                        ${'table'.$i} = $this->table_hubunganeksternal;
                        ${'value'.$i} = $this->hubunganeksternal;
                        ${'id'.$i} = 'id_hubeks';
                        break;
                    case 5:
                        ${'table'.$i} = $this->table_hubunganinternal;
                        ${'value'.$i} = $this->hubunganinternal;
                        ${'id'.$i} = 'id_intern';
                        break;
                    case 6:
                        ${'table'.$i} = $this->table_kondisikerja;
                        ${'value'.$i} = $this->kondisi_kerja;
                        ${'id'.$i} = 'id_kondisi';
                        break;
                    case 7:
                        ${'table'.$i} = $this->table_pengetahuanketerampilan;
                        ${'value'.$i} = $this->pengetahuanketerampilan;
                        ${'id'.$i} = 'id_pk';
                        break;
                    case 8:
                        ${'table'.$i} = $this->table_prasyarat;
                        ${'value'.$i} = $this->prasyarat;
                        ${'id'.$i} = 'id_ps';
                        break;
                    case 9:
                        ${'table'.$i} = $this->table_ruanglingkup;
                        ${'value'.$i} = $this->ruanglingkup;
                        ${'id'.$i} = 'id_rulingkup';
                        break;
                    case 10:
                        ${'table'.$i} = $this->table_setkompetensi;
                        ${'value'.$i} = $this->setkompetensi;
                        ${'id'.$i} = 'id_sk';
                        break;
                    case 11:
                        ${'table'.$i} = $this->table_strukturorganisasi;
                        ${'value'.$i} = $this->strukturorganisasi;
                        ${'id'.$i} = 'id_so';
                        break;
                    case 12:
                        ${'table'.$i} = $this->table_tujuan;
                        ${'value'.$i} = $this->tujuan;
                        ${'id'.$i} = 'id_tj';
                        break;
                    case 13:
                        ${'table'.$i} = $this->table_wewenang;
                        ${'value'.$i} = $this->wewenang;
                        ${'id'.$i} = 'id_wwg';
                        break;
                    case 14:
                        ${'table'.$i} = $this->table_uraian;
                        ${'value'.$i} = [
                            'id_uk' => $unitkerja,
                            'id_jbt' => $jabatan,
                            'id_lokasi' => $lokasi,
                            'id_ps' => $hasil_id8,
                            'id_tj' => $hasil_id12,
                            'id_tgs' => $hasil_id1,
                            'id_tanggungjawab' => $hasil_id2,
                            'id_dimensi' => $hasil_id3,
                            'id_rulingkup' => $hasil_id9,
                            'id_wwg' => $hasil_id13,
                            'id_hubintern' => $hasil_id5,
                            'id_hubeks' => $hasil_id4,
                            'id_kondisi' => $hasil_id6,
                            'id_pk' => $hasil_id7,
                            'id_sk' => $hasil_id10,
                            'id_so' => $hasil_id11,
                            'tgl_input' => date('Y-m-d'),
                            'tgl_update' => '',
                            'id_admin' => $this->session->id_admin
                        ];
                        ${'id'.$i} = 'id_jd';
                        break;
                    
                    default:
                        break;
                }
                $insert = $this->db->insert(${'table'.$i},${'value'.$i});
                ${'hasil_id'.$i} = $this->db->insert_id();
                ${'hasil_rows'.$i} = $this->db->affected_rows();
                if (${'hasil_rows'.$i} === 0) {
                    for ($a=$i-1; $a > 0 ; $a--) { 
                        $this->db->delete(${'table'.$a},[${'id'.$a} => ${'hasil_id'.$a}]);
                        if ($a === 1) {
                            return 0;
                        }
                        break;
                    }
                }
                if ($i === 14) {
                    if (${'hasil_rows'.$i} === 1) {
                        return 1;
                    }else{
                        return 0;
                    }
                }
            }
        }
    }

    public function ubahUraianJabatan($data_jabatan,$uraian_jabatan)
    {
        $jabatan = $this->session->id_jabatan;
        $filter_jabatan = array_filter($data_jabatan, function ($var) use ($jabatan) {
			return (md5($var->id_jbt) == $jabatan);
        });
        foreach ($filter_jabatan as $value) {
            $jabatan = $value->id_jbt;
        }
        foreach ($uraian_jabatan as $key => $value) {
            $so = $value->struktur;
        }
        $this->tugas = [];
        $this->tanggungjawab = [];
        $this->dimensi = [];
        $this->wewenang = [];
        $this->prasyarat = [];
        $this->setkompetensi = [];
        $this->hubunganeksternal = [];
        $this->hubunganinternal = [];
        $this->pengetahuanketerampilan = [];
        $this->kondisi_kerja = [];
        $this->ruanglingkup = [];
        $this->strukturorganisasi = [];
        $this->tujuan = [];
        $this->ruanglingkup += ['ruanglingkup' => html_escape($this->input->post('ruanglingkup'))];
        $this->kondisi_kerja += ['kondisi_kerja' => html_escape($this->input->post('kondisi'))];
        $this->tujuan += ['tujuanposisi' => html_escape($this->input->post('tujuan'))];
        for ($i=1; $i <= 20 ; $i++) { 
            $this->tugas += ['tugas'.$i.'' => html_escape($this->input->post('tugas'.($i).''))];
            $this->tanggungjawab += ['tj'.$i.'' => html_escape($this->input->post('tanggungjawab'.($i).''))];
        }
        foreach ($this->tugas as $key => $value) {
            if ($value === "")
            { 
                unset($this->tugas[$key]);
                $this->tugas[] = $value;
            }
        }
        $this->tugas = array_values($this->tugas);
        $key_tugas = [];
        for ($i=1; $i < 21; $i++) { 
            $key_tugas[] = 'tugas'.$i.''; 
        }
        $this->tugas = array_combine($key_tugas,$this->tugas);

        foreach ($this->tanggungjawab as $key => $value) {
            if ($value === "")
            { 
                unset($this->tanggungjawab[$key]);
                $this->tanggungjawab[] = $value;
            }
        }
        $this->tanggungjawab = array_values($this->tanggungjawab);
        $key_tanggungjawab = [];
        for ($i=1; $i < 21; $i++) { 
            $key_tanggungjawab[] = 'tj'.$i.''; 
        }
        $this->tanggungjawab = array_combine($key_tanggungjawab,$this->tanggungjawab);


        for ($i=1; $i <= 3 ; $i++) { 
            $this->dimensi += ['dimensi'.$i.'' => html_escape($this->input->post('dimensi'.$i.''))];
        }
        foreach ($this->dimensi as $key => $value) {
            if ($value === "")
            { 
                unset($this->dimensi[$key]);
                $this->dimensi[] = $value;
            }
        }
        $this->dimensi = array_values($this->dimensi);
        $key_dimensi = [];
        for ($i=1; $i < 4; $i++) { 
            $key_dimensi[] = 'dimensi'.$i.''; 
        }
        $this->dimensi = array_combine($key_dimensi,$this->dimensi);

        $kompetensikorporat = [];
        $kompetensirumpun = [];
        $kompetensiunit = [];
        $kompetensispesifik = [];
        for ($i=1; $i <= 10 ; $i++) { 
            $this->wewenang += ['wewenang'.$i.'' =>html_escape($this->input->post('wewenang'.$i.''))];
            $this->prasyarat += ['prasyarat'.$i.'' => html_escape($this->input->post('prasyarat'.$i.''))];
            $kompetensikorporat += ['kk_'.$i.'' => html_escape($this->input->post('kompetensikorporat'.$i.''))];
            $kompetensirumpun += ['kr_'.$i.'' => html_escape($this->input->post('kompetensirumpun'.$i.''))];
            $kompetensiunit += ['ku_'.$i.'' => html_escape($this->input->post('kompetensiunit'.$i.''))];
            $kompetensispesifik += ['ks_'.$i.'' => html_escape($this->input->post('kompetensispesifik'.$i.''))];
        }  

        foreach ($this->wewenang as $key => $value) {
            if ($value === "")
            { 
                unset($this->wewenang[$key]);
                $this->wewenang[] = $value;
            }
        }
        $this->wewenang = array_values($this->wewenang);
        $key_wewenang = [];
        for ($i=1; $i < 11; $i++) { 
            $key_wewenang[] = 'wewenang'.$i.''; 
        }
        $this->wewenang = array_combine($key_wewenang,$this->wewenang);

        foreach ($this->prasyarat as $key => $value) {
            if ($value === "")
            { 
                unset($this->prasyarat[$key]);
                $this->prasyarat[] = $value;
            }
        }
        $this->prasyarat = array_values($this->prasyarat);
        $key_prasyarat = [];
        for ($i=1; $i < 11; $i++) { 
            $key_prasyarat[] = 'prasyarat'.$i.''; 
        }
        $this->prasyarat = array_combine($key_prasyarat,$this->prasyarat);

        foreach ($kompetensikorporat as $key => $value) {
            if ($value === "")
            { 
                unset($kompetensikorporat[$key]);
                $kompetensikorporat[] = $value;
            }
        }
        $kompetensikorporat = array_values($kompetensikorporat);
        $key_kompetensi_korporat = [];
        for ($i=1; $i < 11; $i++) { 
            $key_kompetensi_korporat[] = 'kk_'.$i.''; 
        }
        $kompetensikorporat = array_combine($key_kompetensi_korporat,$kompetensikorporat);

        foreach ($kompetensirumpun as $key => $value) {
            if ($value === "")
            { 
                unset($kompetensirumpun[$key]);
                $kompetensirumpun[] = $value;
            }
        }
        $kompetensirumpun = array_values($kompetensirumpun);
        $key_kompetensi_rumpun = [];
        for ($i=1; $i < 11; $i++) { 
            $key_kompetensi_rumpun[] = 'kr_'.$i.''; 
        }
        $kompetensirumpun = array_combine($key_kompetensi_rumpun,$kompetensirumpun);

        foreach ($kompetensispesifik as $key => $value) {
            if ($value === "")
            { 
                unset($kompetensispesifik[$key]);
                $kompetensispesifik[] = $value;
            }
        }
        $kompetensispesifik = array_values($kompetensispesifik);
        $key_kompetensi_spesifik = [];
        for ($i=1; $i < 11; $i++) { 
            $key_kompetensi_spesifik[] = 'ks_'.$i.''; 
        }
        $kompetensispesifik = array_combine($key_kompetensi_spesifik,$kompetensispesifik);

        foreach ($kompetensiunit as $key => $value) {
            if ($value === "")
            { 
                unset($kompetensiunit[$key]);
                $kompetensiunit[] = $value;
            }
        }
        $kompetensiunit = array_values($kompetensiunit);
        $key_kompetensi_unit = [];
        for ($i=1; $i < 11; $i++) { 
            $key_kompetensi_unit[] = 'ku_'.$i.''; 
        }
        $kompetensiunit = array_combine($key_kompetensi_unit,$kompetensiunit);

        $this->setkompetensi = array_merge_recursive($this->setkompetensi,$kompetensikorporat);
        $this->setkompetensi = array_merge_recursive($this->setkompetensi,$kompetensirumpun);
        $this->setkompetensi = array_merge_recursive($this->setkompetensi,$kompetensiunit);
        $this->setkompetensi = array_merge_recursive($this->setkompetensi,$kompetensispesifik);


        for ($i=1; $i <= 5 ; $i++) { 
            $this->hubunganeksternal += ['hubeks'.$i.'' => html_escape($this->input->post('hubeks'.$i.''))];
            $this->hubunganinternal += ['hubintern'.$i.''  => html_escape($this->input->post('hubintern'.$i.''))];
        }
        

        foreach ($this->hubunganeksternal as $key => $value) {
            if ($value === "")
            { 
                unset($this->hubunganeksternal[$key]);
                $this->hubunganeksternal[] = $value;
            }
        }
        $this->hubunganeksternal = array_values($this->hubunganeksternal);
        $key_hubunganeksternal = [];
        for ($i=1; $i < 6; $i++) { 
            $key_hubunganeksternal[] = 'hubeks'.$i.''; 
        }
        $this->hubunganeksternal = array_combine($key_hubunganeksternal,$this->hubunganeksternal);

        foreach ($this->hubunganinternal as $key => $value) {
            if ($value === "")
            { 
                unset($this->hubunganinternal[$key]);
                $this->hubunganinternal[] = $value;
            }
        }
        $this->hubunganinternal = array_values($this->hubunganinternal);
        $key_hubunganinternal = [];
        for ($i=1; $i < 6; $i++) { 
            $key_hubunganinternal[] = 'hubintern'.$i.''; 
        }
        $this->hubunganinternal = array_combine($key_hubunganinternal,$this->hubunganinternal);

        for ($i=1; $i <= 15 ; $i++) { 
            $this->pengetahuanketerampilan += ['pk'.$i.'' => html_escape($this->input->post('pengetahuanketerampilan'.$i.''))];
        }

        foreach ($this->pengetahuanketerampilan as $key => $value) {
            if ($value === "")
            { 
                unset($this->pengetahuanketerampilan[$key]);
                $this->pengetahuanketerampilan[] = $value;
            }
        }
        $this->pengetahuanketerampilan = array_values($this->pengetahuanketerampilan);
        $key_pengetahuanketerampilan = [];
        for ($i=1; $i < 16; $i++) { 
            $key_pengetahuanketerampilan[] = 'pk'.$i.''; 
        }
        $this->pengetahuanketerampilan = array_combine($key_pengetahuanketerampilan,$this->pengetahuanketerampilan);

        if ($_FILES['strukturorganisasi']['size'] != '') {
            $config['upload_path']          = 'assets/img/struktur_organisasi';
            $config['allowed_types']        = 'jpg|png|jpeg|svg';
            $config['max_size']             = 1000000;
            $config['max_width']            = 1920;
            $config['max_height']           = 1920;
            $config['overwrite']            = FALSE;
            $config['remove_space']         = TRUE;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('strukturorganisasi'))
            {   
                $result = 'Gagal upload';
                return $result;
            }
            else
            {
                $this->strukturorganisasi += ['struktur' => $this->upload->data('file_name')];
                for ($a=1; $a <= 14 ; $a++) { 
                    switch ($a) {
                        case 1:
                            $data = $this->dimensi;
                            $table = $this->table_dimensi;
                            $id_name = 'id_dimensi';
                            $id_value = $this->session->id_dimensi;
                            break;
                        case 2:
                            $data = $this->hubunganeksternal;
                            $table = $this->table_hubunganeksternal;
                            $id_name = 'id_hubeks';
                            $id_value = $this->session->id_hubungan_eksternal;
                            break;
                        case 3:
                            $data = $this->hubunganinternal;
                            $table = $this->table_hubunganinternal;
                            $id_name = 'id_hubintern';
                            $id_value = $this->session->id_hubungan_internal;
                            break;
                        case 4:
                            $data = $this->kondisi_kerja;
                            $table = $this->table_kondisikerja;
                            $id_name = 'id_kondisi';
                            $id_value = $this->session->id_kondisi;
                            break;
                        case 5:
                            $data = $this->pengetahuanketerampilan;
                            $table = $this->table_pengetahuanketerampilan;
                            $id_name = 'id_pk';
                            $id_value = $this->session->id_pengetahuan_keterampilan;
                            break;
                        case 6:
                            $data = $this->prasyarat;
                            $table = $this->table_prasyarat;
                            $id_name = 'id_ps';
                            $id_value = $this->session->id_prasyarat;
                            break;
                        case 7:
                            $data = $this->ruanglingkup;
                            $table = $this->table_ruanglingkup;
                            $id_name = 'id_rulingkup';
                            $id_value = $this->session->id_ruang_lingkup;
                            break;
                        case 8:
                            $data = $this->setkompetensi;
                            $table = $this->table_setkompetensi;
                            $id_name = 'id_sk';
                            $id_value = $this->session->id_set_kompetensi;
                            break;
                        case 9:
                            $data = $this->tanggungjawab;
                            $table = $this->table_tanggungjawab;
                            $id_name = 'id_tanggungjawab';
                            $id_value = $this->session->id_tanggung_jawab;
                            break;
                        case 10:
                            $data = $this->tugas;
                            $table = $this->table_tugas;
                            $id_name = 'id_tgs';
                            $id_value = $this->session->id_tugas;
                            break;
                        case 11:
                            $data = $this->tujuan;
                            $table = $this->table_tujuan;
                            $id_name = 'id_tj';
                            $id_value = $this->session->id_tujuan;
                            break;
                        case 12:
                            $data = $this->wewenang;
                            $table = $this->table_wewenang;
                            $id_name = 'id_wwg';
                            $id_value = $this->session->id_wewenang;
                            break;
                        case 13:
                            $data = [
                                'tgl_update' => date('Y-m-d'),
                                'id_admin' => $this->session->id_admin
                            ];
                            $table = $this->table_uraian;
                            $id_name = 'id_jbt';
                            $id_value = $jabatan;
                            break;
                        case 14:
                            $data = $this->strukturorganisasi;
                            $table = $this->table_strukturorganisasi;
                            $id_name = 'id_so';
                            $id_value = $this->session->id_struktur_organisasi;;
                            break;
                        default:
                            break;
                    }
                    $this->db->set($data, FALSE);
                    $this->db->where($id_name, $id_value);
                    $result = $this->db->update($table);
                    ${'hasil_rows'.$a} = $this->db->affected_rows();
                    if ($a === 14) {
                        $path = 'assets/img/struktur_organisasi/'.$so.'';
                        unlink($path);
                        return 1;
                    }
                }
            }
        }else{
            $this->strukturorganisasi += ['struktur' => ''];
            for ($a=1; $a <= 13 ; $a++) { 
                switch ($a) {
                    case 1:
                        $data = $this->dimensi;
                        $table = $this->table_dimensi;
                        $id_name = 'id_dimensi';
                        $id_value = $this->session->id_dimensi;
                        break;
                    case 2:
                        $data = $this->hubunganeksternal;
                        $table = $this->table_hubunganeksternal;
                        $id_name = 'id_hubeks';
                        $id_value = $this->session->id_hubungan_eksternal;
                        break;
                    case 3:
                        $data = $this->hubunganinternal;
                        $table = $this->table_hubunganinternal;
                        $id_name = 'id_hubintern';
                        $id_value = $this->session->id_hubungan_internal;
                        break;
                    case 4:
                        $data = $this->kondisi_kerja;
                        $table = $this->table_kondisikerja;
                        $id_name = 'id_kondisi';
                        $id_value = $this->session->id_kondisi;
                        break;
                    case 5:
                        $data = $this->pengetahuanketerampilan;
                        $table = $this->table_pengetahuanketerampilan;
                        $id_name = 'id_pk';
                        $id_value = $this->session->id_pengetahuan_keterampilan;
                        break;
                    case 6:
                        $data = $this->prasyarat;
                        $table = $this->table_prasyarat;
                        $id_name = 'id_ps';
                        $id_value = $this->session->id_prasyarat;
                        break;
                    case 7:
                        $data = $this->ruanglingkup;
                        $table = $this->table_ruanglingkup;
                        $id_name = 'id_rulingkup';
                        $id_value = $this->session->id_ruang_lingkup;
                        break;
                    case 8:
                        $data = $this->setkompetensi;
                        $table = $this->table_setkompetensi;
                        $id_name = 'id_sk';
                        $id_value = $this->session->id_set_kompetensi;
                        break;
                    case 9:
                        $data = $this->tanggungjawab;
                        $table = $this->table_tanggungjawab;
                        $id_name = 'id_tanggungjawab';
                        $id_value = $this->session->id_tanggung_jawab;
                        break;
                    case 10:
                        $data = $this->tugas;
                        $table = $this->table_tugas;
                        $id_name = 'id_tgs';
                        $id_value = $this->session->id_tugas;
                        break;
                    case 11:
                        $data = $this->tujuan;
                        $table = $this->table_tujuan;
                        $id_name = 'id_tj';
                        $id_value = $this->session->id_tujuan;
                        break;
                    case 12:
                        $data = $this->wewenang;
                        $table = $this->table_wewenang;
                        $id_name = 'id_wwg';
                        $id_value = $this->session->id_wewenang;
                        break;
                    case 13:
                        $data = [
                            'tgl_update' => date('Y-m-d'),
                            'id_admin' => $this->session->id_admin
                        ];
                        $table = $this->table_uraian;
                        $id_name = 'id_jbt';
                        $id_value = $jabatan;
                        break;
                    default:
                        break;
                }
                $this->db->set($data, FALSE);
                $this->db->where($id_name, $id_value);
                ${'result'.$a} = $this->db->update($table);
                ${'hasil_rows'.$a} = $this->db->affected_rows();
                // if (!${'result'.$a}) {
                //     return 0;
                //     break;
                // }
                if ($a === 13) {
                    return 1;
                }
            }
        }
        
    }

}