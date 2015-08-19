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
		$this->form_validation->set_rules("userID", "ユーザID", "alpha_numeric|min_length[4]|callback_username_check");
		$this->form_validation->set_rules("password", "パスワード", "required|alpha_numeric|min_length[4]");
		$this->form_validation->set_rules("email", "メールアドレス", "valid_email|required|callback_mail_check");
		
		//エラーメッセージの設定
		$this->form_validation->set_message("alpha_numeric", "%s は半角英数字で入力してください。");
		$this->form_validation->set_message("min_length", "%s は4文字以上で入力してください。");
		$this->form_validation->set_message("required", "%s を入力してください。");
		$this->form_validation->set_message("valid_email", "有効なメールアドレスを入力してください。");
		
		//正しい場合はメールを送信
		if ($this->form_validation->run()) {
			//ランダムキーを生成する
			$key = md5(uniqid());
			
			//Emailライブラリを読み込む。メールタイプをHTMLに設定（デフォルトはテキストです）
			$this->load->library("email", array("mailtype"=>"html"));
			$this->load->model("model_users");
			$this->email->from("delldell201507@gmail.com", "Haxeon2");//送信元の情報
			$this->email->to($this->input->post("email"));	//送信先の設定
			$this->email->subject("【Haxeon】アカウントの認証");	//タイトルの設定
			
			//メッセージの本文
			$message = "<p>仮登録が完了しました。</p>";
			// 各ユーザーにランダムキーをパーマリンクに含むURLを送信する
			$message .= "<p><a href=' ".base_url(). "resister_user/$key'>こちらをクリックして、会員登録を完了してください。</a></p>";
			$this->email->message($message);
			//メール送信
			if($this->email->send()){
				echo "Message has been sent.";
			}else {
				echo "Coulsn't send the message.";
			}
		} else {
            $this->index();
        }
	}
	
	//既存のユーザIDとの重複チェック
	public function username_check($str) {
		$this->load->model("model_users");
		
		if($this->model_users->is_overlap_uid($str)){
			$this->form_validation->set_message('username_check','入力された %s '.$str.' は既に使われております。');
			return false;
		}
		else {
			return true;
		}
	}
	
	//既存のメールアドレスの重複チェック
	public function mail_check($str) {
		$this->load->model("model_users");
		
		if($this->model_users->is_overlap_mail($str)){
			$this->form_validation->set_message('mail_check','入力された %s '.$str.' は既に使われております。');
			return false;
		}
		else {
			return true;
		}
	}
}
