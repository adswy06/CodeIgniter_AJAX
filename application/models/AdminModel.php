<?php 
defined('BASEPATH') or exit('No direct script access allowed');

ini_set('memory_limit', '1');
ini_set('max_execution_time', 1800);

class AdminModel extends CI_Model{
    public $tabel = "tbl_admin";
    public $primary_key = "id_admin";

    function loginAdmin($data){
        return $this->db->where('username', $data['username'])
                        ->where('password', $data['password'])
                        ->get($this->tabel);
    }

    function getIDAdmin($data){
        return $this->db->select("id_admin, nama, username")
                        ->where('username', $data['username'])
                        ->where('password', $data['password'])
                        ->get($this->tabel);
    }
}               