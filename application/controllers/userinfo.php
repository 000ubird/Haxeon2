<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userinfo extends CI_Controller {

    public function index(){
        if(($this->session->userdata('userID') == null))
        {
            echo '{ "error":"not login"}';
            exit;
        }

        if(($this->session->userdata('projectName') == null))
        {
            echo '{"userID":"'.$this->session->userdata('userID').'","projectName":""}';
            exit;
        }


        echo '{"userID":"'.$this->session->userdata('userID').'","projectName":"'.$this->session->userdata('projectName').'"}';
      }
}
