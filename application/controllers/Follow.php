<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//フォロー関係のクラス
class Follow extends CI_Controller {

    public function index(){
    }

    public function accountFollow($uid){
        //DBにinsertする
        $this->load->model('ModelFollow');
        $this->ModelFollow->setFollow($uid);

        redirect(base_url().'profile/information/'. $uid .'');
    }

    public function accountUnFollow($uid){
        $this->load->model('ModelFollow');
        $this->ModelFollow->unsetFollow($uid);

        redirect(base_url().'profile/information/'. $uid .'');
    }
}
