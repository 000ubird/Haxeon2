<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

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
        $data['isown'] = ($this->session->userdata('userID') == $userID);
        $data['isfollow'] = $this->model_users->getIsFollow($userID);
        $data['isfollowed'] = $this->model_users->getIsFollowed($userID);

        return $data;
    }

    /**
     * projectsettings
     * プロジェクトの所有者のみが変更できる設定を行う
     * タグ設定やプロジェクトの削除など
     */
    public function projectsettings($projectID){
        $this->session->set_userdata(array('pid' => $projectID));

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
	
	//アカウント削除
	public function delete() {
		$this->load->view('header');
		$this->load->view('delete_account');
		$this->load->view('footer');
	}
	
	//アカウント削除処理に使用するパスワードのバリデーション
	public function password_validation() {
		$this->load->library("form_validation");
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules("password", "パスワード", "required|callback_pass_check");
		$this->form_validation->set_message("required", "%s は必須入力項目です。");
		
		//正しい場合はアカウントの削除を実行
		if ($this->form_validation->run()) {
			//アカウントとプロジェクトを削除
			$this->load->model("model_users");
			$this->model_users->deleteAccount($this->session->userdata('userID'));
			$this->load->model("model_project");
			$this->model_project->deleteProject($this->session->userdata('userID'));
			
			//セッション情報の削除
			$this->session->sess_destroy();
			
			//アカウント削除処理完了後に遷移するページ
			$this->index();
		}else {
			$this->delete();
		}
	}
	
    public function validation(){
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        //検証ルールの設定
        $this->form_validation->set_rules("tag", "タグ", "required|callback_tag_check");

        $this->form_validation->set_message("required", "%s を入力してください");

        //正しい場合は登録処理
        if ($this->form_validation->run()) {

        }else{
            $this->projectsettings($this->session->userdata('pid'));
        }
    }
	
	//パスワードのチェック
	public function pass_check($str) {
		$this->form_validation->set_message('pass_check', 'パスワードが間違っています。');
		
		//DBからパスワードを取得
		$this->load->model("model_users");
		$result = $this->model_users->getUserData($this->session->userdata('userID'));
		foreach($result as $row) $pass = $row->userPass;
		
		return ($pass == $str);
	}

    //タグの重複チェック
    public function tag_check($str) {
        $this->load->model("model_project");

        if($this->model_project->isTag($str)){
            $this->form_validation->set_message('tag_check','入力された %s '.$str.' は既に使われております。');
            return false;
        }
        else {
            return true;
        }
    }
}
