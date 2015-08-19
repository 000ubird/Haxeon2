<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function index() {
        $this->load->view('profile');
    }

    public function infomation($userID){
        echo $userID;

        $data = $this->getUserData($userID);

        $this->profile($data);
    }
    public function profile($data){
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

        $data['projects'] = $this->model_users->getProjects($userID);
        $data['profile'] = $this->model_users->getProfile($userID);
    }

}
