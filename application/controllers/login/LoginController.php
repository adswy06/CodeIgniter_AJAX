<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }
    
    public function index(){
        $data['title'] = "Login Administrator";
        
        $this->load->view('admin/login', $data);  
    }
}