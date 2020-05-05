<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class VideoController extends CI_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("VideoModel");
    }
    public function index(){
        $data['title'] = 'Video';
        $data['menu'] = 'Konten';
        $data['halaman'] = 'konten/video';

        $this->load->view('layout', $data);
    }

    public function simpanVideo(){
        parse_str(file_get_contents('php://input'), $data);
        $this->VideoModel->simpanVideo($data);

        $response = array(
            'Success' => true,
            'Info' => 'Video berhasi ditambahkan.'
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

    private function action($id_video){
        $link = "<div class='btn-group'>".
        "<button type='button' class='btn btn-success btn-xs' id='btn-ubah-Artikel' onClick='TampilUbahArtikel(".$id_video.")' title='Ubah' ><i class='fa fa-edit'></i></button>".
        "<button type='button' class='btn btn-warning btn-xs' id='btn-detail-Artikel' onClick='TampilDetailArtikel(".$id_video.")' title='Hapus'><i class='fa fa-trash'></i></button>".
        "</div>";
        return $link;
    }

    public function getTabelVideo(){
        $list = $this->VideoModel->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach($list as $field){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->judul_video;
            $row[] = $field->deskripsi_video;
            $row[] = $field->nama_kategori;
            $row[] = "<img src='".base_url().'assets/gambar/thumbnail/'.$field->gambar."' width='100' >";
            $row[] = $this->action($field->id_video);
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
			"recordsTotal" => $this->VideoModel->count_all(),
			"recordsFiltered" => $this->VideoModel->count_filtered(),
            "data" => $data, 
        );
        echo json_encode($output);
    }

    
}
