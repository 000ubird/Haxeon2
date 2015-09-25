<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Follow extends CI_Controller {

    public function favorite($projectID){
        $this->load->model(Model_favorite);
        $this->Model_favorite->favorite($this->session->userdata('userID'), $projectID);
    }

    public function release_favorite($projectID){
        $this->load->model(Model_favorite);
        $this->Model_favorite->release_favorite($this->session->userdata('userID'), $projectID);
    }

}
