<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jabatan_Controller extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('Jabatan_model');
    }

    public function tampilJabatan()
    {
        $result = $this->Jabatan_model->tampilJabatan();
        return $result;
    }

    public function tampilUnitKerja()
    {
        $result = $this->Jabatan_model->tampilUnitKerja();
        return $result;
    }

    public function tampilLokasi()
    {
        $result = $this->Jabatan_model->tampilLokasi();
        return $result;
    }
}


trait Pegawai_Controller
{
    public function tampilPegawai()
    {
        return $this->db->get('tbl_pegawaiincomben')->result();
    }
}

