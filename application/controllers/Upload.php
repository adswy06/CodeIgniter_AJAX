<?php 

class Upload extends CI_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'file'));
    }

    function upload_files(){
        $this->load->view('upload/pendukung');
    }

    function remove(){
        $token= $this->input->post('token');
        $foto = $this->db->get_where('tbl_gambar_pendukung', array('token' => $token));
        if($foto->num_rows()>0) {
            $hasil=$foto->row();
            $nama = $hasil->nama_gambar;
            if(file_exists($file='assets/gambar/pendukung/'.$nama)){
                unlink($file);
            }
            $this->db->delete('tbl_gambar_pendukung', array('token' => $token));
        }
        echo "{}";
    }
    
}