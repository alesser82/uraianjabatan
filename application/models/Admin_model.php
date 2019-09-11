<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    use Pegawai_model;

    private $id_admin,
    $npp_incomben,
    $kata_sandi,
    $nama_admin,
    $status,
    $org_id = 261,
    $table = 'tbl_admin';

    public function __construct()
    {
        parent::__construct();
    }

    public function tampilAdmin()
    {
        $query = $this->db->get(''.$this->table.'')->result();
        return $query;
    }

    public function masukAplikasi()
    {
        $post = $this->input->post();
        $this->npp_incomben = htmlspecialchars($post['npp']);
        $this->kata_sandi = htmlspecialchars($post['katasandi']);
        $newadmin = $this->tampilAdminDenganNpp();
        if ($newadmin['password'] == 'hcsucofindo') {
            $sql = "SELECT * FROM ". $this->table ." WHERE npp = ? AND password = ?";
            $query = $this->db->query($sql, [$this->npp_incomben,$this->kata_sandi]);
            $result = $query->row_array();
            if ($result != '') {
                $this->npp_incomben = $result['npp'];
                $data = [
                    'npp_incomben' => $this->npp_incomben
                ];
                $this->session->set_userdata($data);
                return 'admin_baru';
            }else {
                return 'null';
            }
        }else {
            $sql = "SELECT * FROM ". $this->table ." WHERE npp = ?";
            $query = $this->db->query($sql, [$this->npp_incomben]);
            $result = $query->row_array();
            if (password_verify($this->kata_sandi, $result['password_baru'])) {
                return $result;
            }else {
                return null;
            }
        }
    }

    public function ubahKatasandi($ket = '')
    {
        if ($ket == '') {
            $this->npp_incomben = $this->session->userdata('npp_incomben');
            $this->kata_sandi = htmlspecialchars($this->input->post('katasandi1'));
            $sql = "UPDATE ". $this->table ." SET password = ?,password_baru = ? WHERE npp = ?";
            $query = $this->db->query($sql, ['',password_hash($this->kata_sandi,PASSWORD_DEFAULT),$this->npp_incomben]);
            $result = $this->db->affected_rows();
            return $result;
        }else{
            $this->npp_incomben = htmlspecialchars($this->input->post('npp'));
            $this->kata_sandi = htmlspecialchars($this->input->post('katasandibaru'));
            $sql = "UPDATE ". $this->table ." SET password = ?,password_baru = ? WHERE npp = ?";
            $query = $this->db->query($sql, ['',password_hash($this->kata_sandi,PASSWORD_DEFAULT),$this->npp_incomben]);
            $result = $this->db->affected_rows();
            return $result;
        }
    }

    public function hapusAkun($npp)
    {
        $this->npp_incomben = $npp;
        $this->db->delete($this->table, array('npp' => $this->npp_incomben));
        return $this->db->affected_rows();
    }

    public function tampilAdminDenganNpp()
    {
        $this->npp_incomben = htmlspecialchars($this->input->post('npp'));
        $sql = "SELECT * FROM ".$this->table." WHERE npp = ?";
        $query = $this->db->query($sql, [$this->npp_incomben]);
        $result = $query->row_array();
        $pegawai = $this->tampilPegawai();
        foreach ($pegawai as $key => $value) {
            if ($value->npp == $result['npp']) {
                $result['email'] = $value->mail;
            }
        }
        return $result;
    }

    public function daftarAkun(Pemegangposisi_model $pemegangposisi, UraianJabatan_model $uraianjabatan,$npp,$status = null)
    {
        $this->npp_incomben = $npp;
        if ($status == null) {
            $pemegangposisi = $pemegangposisi->tampilPemegangPosisi($uraianjabatan, $this,'daftar_admin');
            $pemegangposisi = array_filter($pemegangposisi, function ($v)
            {
                return $v->npp_incomben == $this->npp_incomben;
            });

            $pemegangposisi = array_filter($pemegangposisi, function ($v)
            {
                return $v->org_id == 261;
            });

            if (!empty($pemegangposisi)) {
                foreach ($pemegangposisi as $key => $value) {
                    $email = $value->email;
                    $this->npp = $value->npp_incomben;
                    $this->nama_admin = $value->nama_pegawai_incomben;
                }
                $admin = $this->tampilAdmin();
                $this->id_admin = end($admin);
                if ($this->id_admin == '') {
                    $this->id_admin = 1;
                }else{
                    $this->id_admin = reset($this->id_admin) + 1;
                }
                $data_insert = 
                [
                    'id' => $this->id_admin,
                    'npp' => $this->npp_incomben,
                    'password' => 'hcsucofindo',
                    'password_baru' => '',
                    'nama' => $this->nama_admin,
                    'org_id' => 261,
                    'status' => 0
                ];
                $this->db->insert($this->table,$data_insert);
                $result = $this->db->affected_rows();
                if ($result > 0) {
                    return $email;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            $this->npp_incomben = $npp;
            $admin = $this->tampilAdmin();
            $admin = array_filter($admin, function($v)
            {
                return $v->npp == $this->npp_incomben;
            });
            foreach ($admin as $key => $value) {
                $this->id_admin = $value->id;
                $this->nama_admin = $value->nama;
            }
            $data_replace =
            [
                'id' => $this->id_admin,
                'npp' => $this->npp_incomben,
                'password' => 'hcsucofindo',
                'password_baru' => '',
                'nama' => $this->nama_admin,
                'org_id' => $this->org_id,
                'status' => 1
            ];
            $this->db->replace($this->table, $data_replace);
            $result = $this->db->affected_rows();
            return $result;
        }
    }
}
