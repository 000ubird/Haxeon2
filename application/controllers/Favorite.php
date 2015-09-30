<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Favorite extends CI_Controller {

    public function index(){

    }

    public function regist_favorite($projectID){
        $this->load->model('Model_favorite');
        $this->Model_favorite->favorite($this->session->userdata('userID'), $projectID);
    }

    public function release_favorite($projectID){
        $this->load->model('Model_favorite');
        $this->Model_favorite->release_favorite($this->session->userdata('userID'), $projectID);
    }

}
