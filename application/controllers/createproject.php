<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Createproject extends CI_Controller {

    public function index(){
        //セッションにuserIDがあったら遷移するようにする
        if(isset($_SESSION['userID'])){
            $this->load->view('createproject');
        }else{
            redirect('login');
        }
    }

    public function create_validation(){

    }
}
