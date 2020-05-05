<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class DashboardController extends CI_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AdminModel');
    }

    public function index(){
        $data['title'] = "Dashboard";
        $data['halaman'] = 'dashboard';
        $this->load->view('layout', $data);
    }
    
}