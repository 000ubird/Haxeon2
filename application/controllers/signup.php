<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {

	public function index() {
		$this->load->view('header');
		$this->load->view('signup');
		$this->load->view('footer');
	}
		
	public function validation() {
		$this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		//検証ルールの設定
		$this->form_validation->set_rules("userID", "ユーザID", "callback_username_check");
		$this->form_validation->set_rules("password", "パスワード", "required");
		$this->form_validation->set_rules("email", "メールアドレス", "valid_email|required|callback_mail_check");
		
		//エラーメッセージの設定
		$this->form_validation->set_message("required", "全てのフォームを入力してください。");
		$this->form_validation->set_message("valid_email", "有効なメールアドレスを入力してください。");
		
		//正常な入力のとき
		if ($this->form_validation->run()) {
			redirect("Welcome");
        }else{
            $this->index();
        }
	}
	
	//既存のユーザIDとの重複チェック
	public function username_check($str) {
		if($str == "test"){
			$this->form_validation->set_message('username_check','フィールド%sに、'.$str.'は使えません。');
			return false;
		}
		else {
			return true;
		}
	}
	
	public function mail_check($str) {
	
	}
}
