<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pemegangposisi_model extends Jabatan_Model
{
    private
    $pegawai_incomben,
    $pegawai_atasan,
    $jabatan,
    $uraianjabatan,
    $lkk,
    $tanggal_masuk,
    $tanggal_ubah,
    $tabel_pemegang_posisi = 'tbl_jd_org',
    $tabel_pegawai_atasan = 'tbl_pegawaiatasan',
    $tabel_pegawai_incomben = 'tbl_pegawaiincomben',
    $tabel_lkk = 'tbl_lkk';

    use Pegawai_Model;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function tampilPemegangPosisi(UraianJabatan_model $uraianjabatan, Admin_model $admin, $status = '')
    {
        if ($status == 'lkk') {
            $this->db->select('*');
            $this->db->from(''.$this->tabel_pemegang_posisi.'');
            $this->db->join(''.$this->tabel_lkk.'', ''.$this->tabel_lkk.'.id_lkk = '.$this->tabel_pemegang_posisi.'.id_lkk','inner');
            $data_pemegang_posisi = $this->db->get()->result();
            $data_uraian_jabatan = $uraianjabatan->tampilUraianJabatan($admin, $this);
            $filter_pemegang_posisi = array_filter($data_pemegang_posisi,function ($v) use ($data_uraian_jabatan)
            {
                foreach ($data_uraian_jabatan as $key => $value) {
                    // return $v->id_jd == $value->id_jd;
                    while ($v->id_jd == $value->id_jd) {
                        return $v->id_jd == $value->id_jd;
                    }
                }
            });
            foreach ($filter_pemegang_posisi as $key => $value) {
                foreach ($data_uraian_jabatan as $key2 => $value2) {
                    if ($value->id_jd == $value2->id_jd) {
                        $filter_pemegang_posisi[$key]->id_sk = $value2->id_sk;
                    }
                    if (isset($value->id_sk)) {
                        if ($value->id_sk == $value2->id_sk) {
                            for ($i=1; $i < 11; $i++) { 
                                $filter_pemegang_posisi[$key]->{'kk_'.$i} = $value2->{'kk_'.$i};
                            }
                            for ($i=1; $i < 11; $i++) { 
                                $filter_pemegang_posisi[$key]->{'ks_'.$i} = $value2->{'ks_'.$i};
                            }
                            for ($i=1; $i < 11; $i++) { 
                                $filter_pemegang_posisi[$key]->{'kr_'.$i} = $value2->{'kr_'.$i};
                            }
                            for ($i=1; $i < 11; $i++) { 
                                $filter_pemegang_posisi[$key]->{'ku_'.$i} = $value2->{'ku_'.$i};
                            }
                        }
                    }
                }
            }
            return $filter_pemegang_posisi;
        }elseif ($status == 'cetak') {
            $this->db->select('*');
            $this->db->from(''.$this->tabel_pemegang_posisi.'');
            $this->db->join(''.$this->tabel_lkk.'', ''.$this->tabel_lkk.'.id_lkk = '.$this->tabel_pemegang_posisi.'.id_lkk','inner');
            $data_pemegang_posisi = $this->db->get()->result();
            $data_jabatan = $this->tampilJabatan();
            $data_pegawai = $this->tampilPegawai();
            $data_unit_kerja = $this->tampilUnitKerja();
            foreach ($data_pemegang_posisi as $key => $value) {
                foreach ($data_pegawai as $key2 => $value2) {        
                    if ($value->npp_incomben == $value2->npp) {
                        $data_pemegang_posisi[$key]->nama_pegawai_incomben = $value2->namaPegawai;
                    }
                    if ($value->npp_atasan == $value2->npp) {
                        $data_pemegang_posisi[$key]->nama_pegawai_atasan = $value2->namaPegawai;
                    }
                }
            }

            foreach ($data_pemegang_posisi as $key => $value) {
                foreach ($data_jabatan as $key3 => $value3) {
                    if ($value->id_jbt == $value3->id_jbt) {
                        $data_pemegang_posisi[$key]->nama_jbt = $value3->nama_jbt;
                        $data_pemegang_posisi[$key]->kode_jbt = $value3->kode_jbt;
                        $data_pemegang_posisi[$key]->org_id = $value3->org_id;
                    }
                }
            }

            foreach ($data_pemegang_posisi as $key => $value) {
                foreach ($data_unit_kerja as $key2 => $value2) {
                    if ($value->org_id == $value2->org_id) {
                        $data_pemegang_posisi[$key]->lokasi = $value2->lokasi;
                        $data_pemegang_posisi[$key]->alamat = $value2->alamat;
                    }
                }
            }

            $data_uraian_jabatan = $uraianjabatan->tampilUraianJabatan($admin, $this);
            $all = 
            [
                'pemegang_posisi' => $data_pemegang_posisi,
                'uraian_jabatan' => $data_uraian_jabatan
            ];  
            return $all;
        }elseif ($status == 'daftar_admin') {
            $this->db->select('*');
            $this->db->from(''.$this->tabel_pemegang_posisi.'');
            $this->db->join(''.$this->tabel_lkk.'', ''.$this->tabel_lkk.'.id_lkk = '.$this->tabel_pemegang_posisi.'.id_lkk','inner');
            $data_pemegang_posisi = $this->db->get()->result();
            $data_jabatan = $this->tampilJabatan();
            $data_pegawai = $this->tampilPegawai();
            $data_unit_kerja = $this->tampilUnitKerja();
            foreach ($data_pemegang_posisi as $key => $value) {
                foreach ($data_pegawai as $key2 => $value2) {        
                    if ($value->npp_incomben == $value2->npp) {
                        $data_pemegang_posisi[$key]->nama_pegawai_incomben = $value2->namaPegawai;
                    }
                    if ($value->npp_atasan == $value2->npp) {
                        $data_pemegang_posisi[$key]->nama_pegawai_atasan = $value2->namaPegawai;
                    }
                }
            }

            foreach ($data_pemegang_posisi as $key => $value) {
                foreach ($data_jabatan as $key3 => $value3) {
                    if ($value->id_jbt == $value3->id_jbt) {
                        $data_pemegang_posisi[$key]->nama_jbt = $value3->nama_jbt;
                        $data_pemegang_posisi[$key]->kode_jbt = $value3->kode_jbt;
                        $data_pemegang_posisi[$key]->org_id = $value3->org_id;
                    }
                }
            }

            foreach ($data_pemegang_posisi as $key => $value) {
                foreach ($data_unit_kerja as $key2 => $value2) {
                    if ($value->org_id == $value2->org_id) {
                        $data_pemegang_posisi[$key]->lokasi = $value2->lokasi;
                        $data_pemegang_posisi[$key]->alamat = $value2->alamat;
                    }
                }
            }
            $data_pegawai = $this->tampilPegawai();
            foreach ($data_pemegang_posisi as $key => $value) {
                foreach ($data_pegawai as $key2 => $value2) {
                    if ($value->npp_incomben == $value2->npp) {
                        $data_pemegang_posisi[$key]->email = $value2->mail;
                    }
                }
            }
            return $data_pemegang_posisi;
        }else{
            $this->db->select('*');
            $this->db->from(''.$this->tabel_pemegang_posisi.'');
            $this->db->join(''.$this->tabel_lkk.'', ''.$this->tabel_lkk.'.id_lkk = '.$this->tabel_pemegang_posisi.'.id_lkk','inner');
            $result = $this->db->get()->result();
            $pegawai = $this->tampilPegawai();
            foreach ($result as $key => $value) {
                foreach ($pegawai as $key2 => $value2) {
                    if ($value->npp_incomben == $value2->npp) {
                        $result[$key]->namaPegawai = $value2->namaPegawai;
                        $result[$key]->email = $value2->mail;
                    }
                }
            }
            return $result;
        }
    }

    public function tambahPemegangPosisi(UraianJabatan_model $uraianjabatan, Admin_model $admin,$data)
    {
        $id_jbt = $data['id_jbt'];
        $data_uraian_jabatan = $uraianjabatan->tampilUraianJabatan($admin,$this);
        $data_uraian_jabatan = array_filter($data_uraian_jabatan,function ($val) use ($id_jbt)
        {
            return $val->id_jbt == $id_jbt;
        });
        if (empty($data_uraian_jabatan)) {
            $insert_pemegang_posisi = $this->db->insert($this->tabel_pemegang_posisi,$data);
            $data_lkk = ['id_lkk' => $data['id_lkk']];
            $insert_lkk = $this->db->insert($this->tabel_lkk,$data_lkk);
            $result = $this->db->affected_rows();
            if ($result > 0) {
                return 'no_jobdesc';
            }else{
                return $result;
            }
        }else{
            foreach ($data_uraian_jabatan as $key => $value) {
                $id_jd = $value->id_jd;
            }
            $data['id_jd'] = $id_jd;
            $insert_pemegang_posisi = $this->db->insert($this->tabel_pemegang_posisi,$data);
            $insert_id = $this->db->insert_id();
            $result_pemegang_posisi = $this->db->affected_rows();
            if ($result_pemegang_posisi > 0) {
                $data_lkk = ['id_lkk' => $data['id_lkk']];
                $insert_lkk = $this->db->insert($this->tabel_lkk,$data_lkk);
                $result_lkk = $this->db->affected_rows();
                if ($result_lkk > 0) {
                    return $insert_id;
                }else{
                    return $result;
                }
            }else{
                return $result;
            }
        }
    }

    public function ubahPemegangPosisi(UraianJabatan_model $uraianjabatan, Admin_model $admin, $data, $status = '')
    {
        if ($status == 'lkk') {
            $this->lkk = [];
            
            for ($i=1; $i < 41; $i++) { 
                $this->lkk += ['lkk'.$i.'' => $data['lkk'.$i.'']];
            }

            $id_value = $data['id_lkk'];
            $this->db->set($this->lkk, FALSE);
            $this->db->where('id_lkk', $id_value);
            $this->db->update($this->tabel_lkk);
            $row = $this->db->affected_rows();
            return $row;
        }else{
            $data_uraian_jabatan = $uraianjabatan->tampilUraianJabatan($admin, $this);
            $this->pegawai_atasan = $data['npp_atasan'];
            $this->pegawai_incomben = $data['npp_incomben'];
            $this->jabatan = $data['id_jbt'];
            $this->tanggal_ubah = $data['tgl_ubah_pemegang_posisi'];

            $data_uraian_jabatan = array_filter($data_uraian_jabatan, function ($v)
            {
                return $v->id_jbt == $this->jabatan;
            });

            if (empty($data_uraian_jabatan)) {
                $this->uraianjabatan = '';
            }else{
                foreach ($data_uraian_jabatan as $key => $value) {
                    $this->uraianjabatan = $value->id_jd;
                }
            }

            $data = 
            [
                'id_jbt' => $this->jabatan,
                'id_jd' => $this->uraianjabatan,
                'npp_atasan' => $this->pegawai_atasan,
                'tgl_ubah_pemegang_posisi' => $this->tanggal_ubah
            ];
            $this->db->set($data, FALSE);
            $this->db->where('npp_incomben', $this->pegawai_incomben);
            $this->db->update($this->tabel_pemegang_posisi);
            $result = $this->db->affected_rows();
            return $result;
        }
    }
}
