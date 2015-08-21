<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    //一応おいてあるindex。本体のみ表示する
    public function index() {
        //$this->load->view('header');
        $this->load->view('profile');
    }

    public function information($userID){
        $this->view($this->getUserData($userID));
    }

    //プロフィールページを表示する本体
    public function view($data){
        $this->load->view('header');
        $this->load->view('profile',$data);
        $this->load->view('footer');
    }

    /**
     * 必要な処理
     * プロフィールの取得
     * フォロー、フォロワーの取得
     * 作成したプロジェクトの取得
     */
    private function getUserData($userID){
        $this->load->model('model_users');

        $data['user'] = $this->model_users->getUserData($userID);
        $data['projects'] = $this->model_users->getProjects($userID);
        $data['follow'] = $this->model_users->getFollowInfo($userID);
        $data['followed'] = $this->model_users->getFollowedInfo($userID);

        return $data;
    }

}
