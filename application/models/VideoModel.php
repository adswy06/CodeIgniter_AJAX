<?php
defined('BASEPATH') or exit('No direct script allowed');

ini_set('memory_limit', '1');
ini_set('max_execution_time', 1800);

class VideoModel extends CI_Model{
    public $tabel = 'tbl_video';
    public $primary_key = 'id_video';
    public $referensi = 'tbl_kategori';
    public $fk_referensi = 'id_kategori'; 

    
    function getIDVideo(){
        return $this->db->select("id_video")
                        ->order_by('tgl_dibuat', 'desc')
                        ->order_by('jam_dibuat', 'desc')
                        ->limit(1)
                        ->get('tbl_video');
    }

    function simpanVideo($data){
        // $gambar = $_FILES['file']['name'];
        $val = array(
            'id_kategori' => $data['id_kategori'],
            'judul_video' => $data['judul_video'],
            'deskripsi_video' => $data['deskripsi_video'],
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
                $id_video = $record->id_video;
                foreach($gambar as $key => $val) {
                    if($data['gbr'][$key] != '') {
                        $value[] = array(
                            'id_video' => $id_video,
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

    public $column_order = array(null, 'judul_video', 'nama_kategori', 'deskripsi_video', 'status');
    public $column_search = array('judul_video', 'nama_kategori', 'deskripsi_video', 'status');
    public $order = array('id_video', 'desc');

    private function _get_datatables_query(){
        $this->db->from($this->tabel)
                 ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_video.id_kategori', 'left');
        
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