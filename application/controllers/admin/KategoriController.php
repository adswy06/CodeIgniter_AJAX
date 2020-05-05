<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class KategoriController extends CI_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('KategoriModel');
    }

    public function index(){
        $data['title'] = 'Kategori Konten';
        $data['menu'] = 'Konten';
        $data['halaman'] = 'konten/kategori';

        $this->load->view('layout', $data);
    }
    ///simpan kategori
    public function simpanKategori(){
        parse_str(file_get_contents('php://input'), $data);
        $this->KategoriModel->simpanKategori($data);

        $response = array(
            'Success' => true,
            'Info' => 'Kategori berhasil ditambahkan.'
        );
        $this->output
             ->set_status_header(201)
             ->set_content_type('application/json')
             ->set_output(json_encode($response, JSON_PRETTY_PRINT))
             ->_display();
        exit;
    }
    
    private function action($id_kategori){
        $link = "<div class='button-items'>".
        "<button type='button' class='btn btn-danger waves-effect waves-light' onClick='hapusKategori(".$id_kategori.")' title='Hapus'>Hapus</button>".
        "</div>";
        return $link;
    }

    public function status($status){
        if($status == '1'){
            $hsl = "<span class='badge badge-success'><h6>Aktif</h6></span>";
        }else{
            $hsl = "<span class='badge badge-warning'><h6>Tidak Aktif</h6></span>";
        }
        return $hsl;
    }

    public function getTabelKategori(){
        $list = $this->KategoriModel->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach($list as $field){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nama_kategori;
            $row[] = $this->status($field->status);
            $row[] = $this->action($field->id_kategori);

            $data[] = $row;
        }
        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->KategoriModel->count_all(),
			"recordsFiltered" => $this->KategoriModel->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function hapusKategori($id){
        $this->KategoriModel->hapusKategori($id);

	    $response = array(
	      'Success' => true,
	      'Info' => 'Data kategori berhasil dihapus.'
	    );

	    $this->output
	         ->set_status_header(200)
	         ->set_content_type('application/json')
	         ->set_output(json_encode($response, JSON_PRETTY_PRINT))
	         ->_display();
	    exit;
    }
    
    public function getKategori(){
        $response = array(
            "total_count" => $this->KategoriModel->getJumlahKategori($this->input->get("q")),
            "results" => $this->KategoriModel->getListKategori(
                $this->input->get("q"),
                $this->input->get("page") * $this->input->get("page_limit"),
                $this->input->get("page_limit")
            )
            );
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT))
            ->_display();
       exit();
    }
    
}