<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	//ログインページの表示
    public function index() {
		$this->load->view('header');
        $this->load->view('login');
		$this->load->view('footer');
    }

	//ログインのバリデーション処理を行う
    public function validation() {
        //フォームバリデーションライブラリを呼び出し
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		//バリデーションルールの設定
        $this->form_validation->set_rules("userID", "ユーザID", "alpha_numeric|callback_validate_credentials");
        $this->form_validation->set_rules("password", "パスワード", "required");
        $this->form_validation->set_message("required", "");
        $this->form_validation->set_message("alpha_numeric", "IDは半角英数字で入力してください。");

		//正常な入力のとき
        if ($this->form_validation->run()) {
			//セッション情報の設定
            $data = array('userID' => $_POST['userID']);
			$this->session->set_userdata($data);
			//トップページに遷移
			redirect('');
        }else{
            //異常入力
            $this->index();
        }
    }

	//ポストされたログイン情報をデータベースに問い合わせ
    public function validate_credentials() {
        $this->load->model("ModelUsers");

		//ユーザー名とパスワードの一致を確認
        if($this->ModelUsers->isLogin()) {
            return true;
        } else {
            $this->form_validation->set_message("validate_credentials", "IDもしくはパスワードが間違っています");
            return false;
        }
    }
}
