<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//フォロー関係のクラス
class Follow extends CI_Controller {

    public function index(){

    }

    //引数に入るフォロー相手のuserIDと、セッションにある自分のIDを使う
    public function accountFollow($data){
        //DBにinsertする
        $this->load->model('model_follow');
        $this->model_follow->apply($data);

        $this->load->view('haxeon2');
    }

    public function accountUnFollow($data){
        $this->load->model('model_follow');
        $this->model_follow->release($data);

        $this->load->view('haxeon2');
    }

}