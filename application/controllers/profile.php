<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    //一応おいてあるindex。本体のみ表示する
    public function index() {
        $this->load->view('header');
        $this->load->view('haxeon2');
        $this->load->view('footer');
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

    private function getUserData($userID){
        $this->load->model('model_users');

        $data['user'] = $this->model_users->getUserData($userID);
        $data['projects'] = $this->model_users->getProjects($userID);
        $data['follow'] = $this->model_users->getFollowInfo($userID);
        $data['followed'] = $this->model_users->getFollowedInfo($userID);

        return $data;
    }

    /**
     * projectsettings
     * プロジェクトの所有者のみが変更できる設定を行う
     * タグ設定やプロジェクトの削除など
     */
    public function projectsettings($projectID){
        $this->load->model('model_project');
        $this->load->library('tag');
        
        //sessionのuserIDとprojectIDの所有者が同じかチェック
        if($this->model_project->isOwner($projectID)) {

            $data['tags'] = $this->tag->getTag($projectID);

            $this->load->view('header');
            $this->load->view('projectsettings', $data);
            $this->load->view('footer');
        }else{
            $this->index();
        }
    }
}
