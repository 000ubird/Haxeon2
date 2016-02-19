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
	public function validationPassword() {
		$this->load->library("form_validation");
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules("password", "パスワード", "required|callback_passwordCheck");
		$this->form_validation->set_message("required", "%s は必須入力項目です。");

        $uid = $this->session->userdata('userID');

		//正しい場合はアカウントの削除を実行
		if ($this->form_validation->run()) {
            //セッション情報の削除
            $this->session->sess_destroy();

			$this->load->model("ModelProject");
            $this->load->model('ModelUsers');
            $this->load->model('ModelFollow');
            $projects = $this->ModelUsers->getProjects($uid);
            print_r($projects);

            foreach ($projects as $p) {
                $this->ModelProject->deleteOneProject($p->projectID, $uid);
            }

			$this->ModelFollow->deleteFollow($uid);
            //アカウントを削除
            $this->ModelUsers->deleteAccount($uid);
            //tmpアカウントからも削除
            $this->ModelUsers->deleteTmpAccount($uid);

			//アカウント削除処理完了後はトップページに遷移
			redirect('');
		}else {
			$this->index();
		}
	}

	//パスワードのチェック
	public function passwordCheck($str) {
		$this->form_validation->set_message('passwordCheck', 'パスワードが間違っています。');

		//DBからパスワードを取得
		$this->load->model("ModelUsers");
		$result = $this->ModelUsers->getUserData($this->session->userdata('userID'));
		foreach($result as $row) $pass = $row->userPass;

		return ($pass == $str);
	}
}
