<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//フォロー関係のクラス
class Follow extends CI_Controller {

    public function index(){
    }

    public function accountFollow($uid){
        //DBにinsertする
        $this->load->model('Model_follow');
        $this->Model_follow->apply($uid);

        redirect(base_url().'profile/information/'. $uid .'');
    }

    public function accountUnFollow($uid){
        $this->load->model('Model_follow');
        $this->Model_follow->release($uid);

        redirect(base_url().'profile/information/'. $uid .'');
    }
}
