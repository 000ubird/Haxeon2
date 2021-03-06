<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailSettings extends CI_Controller {

	//メールアドレス設定ページを表示する
    public function index($userID){
		if ($this->session->userdata('userID') == null) header('Location: '.base_url().'login');

        $data['userID'] = $userID;
        $this->load->view('header');
        $this->load->view('emailsettings',$data);
        $this->load->view('footer');
    }

    //メールアドレス設定ページ用のバリデーション
    public function validationEmail($userID){
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        //検証ルールの設定
        $this->form_validation->set_rules("new", "メールアドレス", "required|valid_email");
        $this->form_validation->set_rules("current", "現在のパスワード", "required|alpha_numeric|callback_checkPassword");

        //エラーメッセージの設定
        $this->form_validation->set_message("required", "%s を入力してください。");
        $this->form_validation->set_message("valid_email", "有効なメールアドレスを入力してください。");

        if($this->form_validation->run()){
            //認証キーの生成
            $key = md5(uniqid());
            $send = $this->input->post("new");

            //Emailライブラリを読み込む。メールタイプをHTMLに設定（デフォルトはテキストです）
            $this->load->library("email", array("mailtype" => "html"));
            $this->email->from("delldell201507@gmail.com", "Haxeon");	//送信元の情報
            $this->email->to($send);	//送信先の設定
            $this->email->subject("【Haxeon】アカウントの認証");	//タイトルの設定

            //メッセージの本文
            $message = "メールアドレスの変更が行われました。";
            $message .= "<h1><a href=' ".base_url(). "emailsettings/registerEmail/$key'>こちら</h1>をクリックして、メールアドレスの変更を完了してください。</a>";
            $this->email->message($message);

            $this->load->model("ModelUsers");

            //仮登録用データベースへの登録が完了した場合
            if ($this->ModelUsers->insertTemporaryEmail($userID, $key, $send)) {
                //アカウントテーブルの鍵を上書き
                $this->ModelUsers->updateKey($key, $userID);

                //メール送信
                if ($this->email->send()) {
					$data['msg'] = "登録用メールが送信されました。";
                    $this->load->view('header');
                    $this->load->view('signup_msg',$data);
                    $this->load->view('footer');
                }else {
					$data['msg'] = "登録用メールの送信に失敗しました。お手数ですがやり直して下さい。";
                    $this->load->view('header');
                    $this->load->view('signup_msg',$data);
                    $this->load->view('footer');
                }
            } else {
					$data['msg'] = "内部エラーです。再度お試し下さい。";
					$this->load->view('header');
					$this->load->view('signup_msg',$data);
					$this->load->view('footer');
            }
        }else{
            $this->index($userID);
        }
    }

    //パスワードチェック
    function checkPassword($str){
        $userID = $this->session->userdata('userID');
        $this->load->model('ModelUsers');

        $array = $this->ModelUsers->getUserData($userID);
        $pass = "";

        foreach($array as $row){
            $pass = $row->userPass;
        }

        if(count($array) != 0){
            if($pass == $str){
                return true;
            }
            $this->form_validation->set_message('checkPassword','パスワードが間違っています');
            return false;
        }else{
            $this->form_validation->set_message('checkPassword','パスワードが間違っています2');
            return false;
        }
    }

    //メールアドレス変更メールのURLを認証
    public function registerEmail($key) {
        $redirectTime = 3;
        $this->load->model("ModelUsers");

        if ($this->ModelUsers->updateMail($key)) {
			$data['msg'] = "メールアドレスが変更されました。<br/>".$redirectTime."後にトップページに戻ります。";
			$this->load->view('header');
			$this->load->view('signup_msg',$data);
			$this->load->view('footer');

            //仮テーブルから削除
            $this->ModelUsers->deleteTmpAccountFromKey($key);
        } else {
            $data['msg'] = "メールアドレスの変更に失敗しました。<br/>" . $redirectTime . "後にトップページに戻ります。";
            $this->load->view('header');
            $this->load->view('signup_msg', $data);
            $this->load->view('footer');
        }
		//3秒後にリダイレクト
		echo '<meta http-equiv="refresh" content="'.$redirectTime.';URL=/haxeon/">';
    }
}
