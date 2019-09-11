<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jabatan_Model extends CI_Model
{
    private $id_jabatan,
    $nama_jabatan,
    $kode_jabatan,
    $org_id,
    $unit_kerja,
    $lokasi,
    $alamat,
    $table_jbt = 'tbl_jbt_uk',
    $table_uk = 'tbl_uk',
    $table_lokasi = 'tbl_lokasi';

    public function __construct() {
        parent::__construct();
        // $this->load->database();
    }

    public function tampilJabatan()
    {
        $query = $this->db->get(''.$this->table_jbt.'')->result();
        return $query;
    }

    public function tampilUnitKerja()
    {
        $query = $this->db->get(''.$this->table_uk.'')->result();
        return $query;
    }

    public function tampilLokasi()
    {
        $query = $this->db->get(''.$this->table_lokasi.'')->result();
        return $query;
    }
}

trait Pegawai_Model
{
    public function tampilPegawai()
    {
        return $this->db->get('tbl_pegawaiincomben')->result();
    }
}
