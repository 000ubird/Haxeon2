<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index(){
		$this->load->view('header');
        $this->load->view('login');
		$this->load->view('footer');
    }

    public function validation(){
        //フォームバリデーションライブラリを呼び出し
        $this->load->library("form_validation");

        $this->form_validation->set_error_delimiters('<div class="error">','</div>');

        /**
         * required : 必要事項
         * "|" 区切りで以下のオプションを付けたい
         * trim : バリデーション実行前に、文字列の最初と最後の空白を自動的に削除
         * xss_clean : クロスサイトスクリプティングを禁止
         * md5 : 暗号化処理
         */
        $this->form_validation->set_rules("userID", "ユーザID", "alpha_numeric|callback_validate_credentials");
        $this->form_validation->set_rules("password", "パスワード", "required");

        $this->form_validation->set_message("required", "");
        $this->form_validation->set_message("alpha_numeric", "IDは半角英数字で入力してください。");

        if($this->form_validation->run()){
            //正常な入力のとき
                $data = array(
                    'userID' => $_POST['userID'],
                );
                $this->session->set_userdata($data);

                redirect("haxeon");
        }else{
            //初回、もしくはエラーがあったとき
            $this->index();
        }
    }

    public function validate_credentials(){
        $this->load->model("Model_users");

        if($this->model_users->can_log_in()){
            return true;
        }else{
            $this->form_validation->set_message("validate_credentials", "IDもしくはパスワードが間違っています");
            return false;
        }
    }
}
