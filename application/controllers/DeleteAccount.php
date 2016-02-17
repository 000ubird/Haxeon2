<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DeleteAccount extends CI_Controller {
	//アカウント削除
	public function index() {
		if ($this->session->userdata('userID') == null) header('Location: '.base_url().'login');

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

        $uid = $this->session->userdata('userID');

		//正しい場合はアカウントの削除を実行
		if ($this->form_validation->run()) {
            //セッション情報の削除
            $this->session->sess_destroy();

			$this->load->model("Model_project");
            $this->load->model('Model_users');
            $this->load->model('Model_follow');
            $projects = $this->Model_users->getProjects($uid);
            print_r($projects);

            foreach ($projects as $p) {
                $this->Model_project->deleteOneProject($p->projectID, $uid);
            }

			$this->Model_follow->deleteFollow($uid);
            //アカウントを削除
            $this->Model_users->deleteAccount($uid);
            //tmpアカウントからも削除
            $this->Model_users->deleteTmpAccount($uid);

			//アカウント削除処理完了後はトップページに遷移
			redirect('');
		}else {
			$this->index();
		}
	}
	
	//パスワードのチェック
	public function pass_check($str) {
		$this->form_validation->set_message('pass_check', 'パスワードが間違っています。');

		//DBからパスワードを取得
		$this->load->model("Model_users");
		$result = $this->Model_users->getUserData($this->session->userdata('userID'));
		foreach($result as $row) $pass = $row->userPass;

		return ($pass == $str);
	}
}
