<?php 
defined('BASEPATH') or exit('No direct script access allowed');

ini_set('memory_limit', '1');
ini_set('max_execution_time', 1800);

class KategoriModel extends CI_Model{
    public $tabel = 'tbl_kategori';
    public $primay_key = 'id_kategori';
    function simpanKategori($data){
        $val = array(
            'id_kategori' => $data['id_kategori'],
            'nama_kategori' => $data['nama_kategori'],
            'jam_dibuat' => date('H:m:s'),
            'tgl_dibuat' => date('Y-m-d'),
            'status' => 1
        );
        $this->db->insert($this->tabel, $val);
    }
    public $column_order = array(null, 'nama_kategori', 'status');
    public $column_search = array('nama_kategori', 'status');
    public $order = array('id_kategori', 'desc');

    private function _get_datatables_query(){
        $this->db->from($this->tabel);
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

    public function hapusKategori($id){
        $this->db->where('id_kategori', $id);
        $this->db->delete('tbl_kategori');
        
    }

    public function getJumlahKategori($keyword){
        return $this->db->select("id_kategori as id, nama_kategori as text")
                        ->like("nama_kategori", $keyword)
                        ->count_all_results('tbl_kategori');
    }

    public function getListKategori($keyword, $page, $limit){
        return $this->db->select("id_kategori as id, nama_kategori as text")
                        ->like("nama_kategori", $keyword)
                        ->get('tbl_kategori', $limit, $page)->result_array();
    }

}