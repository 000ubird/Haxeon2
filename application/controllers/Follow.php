<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//フォロー関係のクラス
class Follow extends CI_Controller {

    public function index(){

    }

    //引数に入るフォロー相手のuserIDと、セッションにある自分のIDを使う
    public function accountFollow($uid){
        //DBにinsertする
        $this->load->model('model_follow');
        $this->model_follow->apply($uid);

        redirect(base_url().'profile/information/'. $uid .'');
    }

    public function accountUnFollow($uid){
        $this->load->model('model_follow');
        $this->model_follow->release($uid);

        redirect(base_url().'profile/information/'. $uid .'');
    }

}
