<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class AdminController extends CI_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AdminModel');
    }
    public function loginPengguna(){
        parse_str(file_get_contents('php://input'), $data);
        $status = $this->AdminModel->loginAdmin($data)->num_rows();

        if($status>0){
            $record = $this->AdminModel->getIDAdmin($data)->row();
            set_cookie('nama_admin', $record->username, 3600*2);

            $response = array(
                'Success' => true,
                'Info' => 'Administrator berhasil terauntetikasi.'
            );
        }else{
            $response = array(
                'Success' => false,
                'Info' => 'Administrator gagal terauntetikasi.'
            );
        }
        $this->output
             ->set_status_header(201)
             ->set_content_type('application/json')
             ->set_output(json_encode($response, JSON_PRETTY_PRINT))
             ->_display();
        exit;
    }
    
}