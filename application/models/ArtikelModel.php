<?php
defined('BASEPATH') or exit('No direct script allowed');

ini_set('memory_limit', '1');
ini_set('max_execution_time', 1800);

class ArtikelModel extends CI_Model{
    public $tabel = 'tbl_artikel';
    public $primary_key = 'id_artikel';
    public $referensi = 'tbl_kategori';
    public $fk_referensi = 'id_kategori';

    function getIDArtikel(){
        return $this->db->select("id_artikel")
                        ->order_by('tgl_dibuat', 'desc')
                        ->order_by('jam_dibuat', 'desc')
                        ->limit(1)
                        ->get('tbl_artikel');
    }
    function simpanArtikel($data){
        // $gambar = $_FILES['file']['name'];
        $val = array(
            'id_kategori' => $data['id_kategori'],
            'judul_artikel' => $data['judul_artikel'],
            'deskripsi_artikel' => $data['deskripsi_artikel'],
            'tgl_dibuat' => date('Y-m-d'),
            'jam_dibuat' => date('H:i:s'),
            'gambar' => $data['gambar'],
            'status' => '1'
        );
        $this->db->insert($this->tabel, $val);

        if(isset($data['gbr'])) {
            $gambar = $data['gbr'];
            if($gambar != '') {
                $record = $this->getIDArtikel()->row();
                $id_artikel = $record->id_artikel;
                foreach($gambar as $key => $val) {
                    if($data['gbr'][$key] != '') {
                        $value[] = array(
                            'id_artikel' => $id_artikel,
                            'nama_gambar' => $data['gbr'][$key],
                            'token'       => $data['token'][$key],
                            'jam_upload' => date('H:i:s'),
                            'tgl_upload' => date('Y-m-d')
                        );
                    }
                }
                $this->db->insert_batch("tbl_gambar_pendukung", $value);
            }
        }
    }
    public $column_order = array(null, 'judul_artikel', 'nama_kategori', 'deskripsi_artikel', 'status');
    public $column_search = array('judul_artikel', 'nama_kategori', 'deskripsi_artikel', 'status');
    public $order = array('id_artikel', 'desc');

    private function _get_datatables_query(){
        $this->db->from($this->tabel)
                 ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_artikel.id_kategori', 'left');
        
        $i = 0;

        foreach($this->column_search as $item){
            if($_POST['search']['value']){
                if($i==0){
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }
                if(count($this->column_search)-1 == $i)
                $this->db->group_end();
            }
        $i++;
        }
        if(isset($_POST['order'])){
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }

    }
    function get_datatables(){
        $this->_get_datatables_query();
        if($_POST['length'] != -1);
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
        }
    function count_filtered(){
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
        }
    public function count_all(){
        $this->db->from($this->tabel);
        return $this->db->count_all_results();
    }
}