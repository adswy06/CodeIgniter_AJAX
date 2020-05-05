<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class ArtikelController extends CI_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('ArtikelModel');
    }
    public function index(){
        $data['title'] = 'Artikel';
        $data['menu'] = 'Konten';
        $data['halaman'] = 'konten/artikel';

        $this->load->view('layout', $data);
    }
    ///simpan artikel
    public function simpanArtikel(){
        parse_str(file_get_contents('php://input'), $data);
        $this->ArtikelModel->simpanArtikel($data);

        $response = array(
            'Success' => true,
            'Info' => 'Artikel berhasil ditambahkan.'
        );
        $this->output
             ->set_status_header(201)
             ->set_content_type('application/json')
             ->set_output(json_encode($response, JSON_PRETTY_PRINT))
             ->_display();
        exit();
    }

    public function uploadGambar(){
        $this->load->view('upload/thumbnail');
    }

    private function action($id_artikel){
        $link = "<div class='btn-group'>".
        "<button type='button' class='btn btn-success btn-xs' id='btn-ubah-Artikel' onClick='TampilUbahArtikel(".$id_artikel.")' title='Ubah' ><i class='fa fa-edit'></i></button>".
        "<button type='button' class='btn btn-warning btn-xs' id='btn-detail-Artikel' onClick='TampilDetailArtikel(".$id_artikel.")' title='Hapus'><i class='fa fa-trash'></i></button>".
        "</div>";
        return $link;
    }

    public function getTabelArtikel(){
        $list = $this->ArtikelModel->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach($list as $field){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->judul_artikel;
            $row[] = $field->deskripsi_artikel;
            $row[] = $field->nama_kategori;
            $row[] = "<img src='".base_url().'assets/gambar/thumbnail/'.$field->gambar."' width='100' >";
            $row[] = $this->action($field->id_artikel);
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
			"recordsTotal" => $this->ArtikelModel->count_all(),
			"recordsFiltered" => $this->ArtikelModel->count_filtered(),
            "data" => $data, 
        );
        echo json_encode($output);
    }

    
}