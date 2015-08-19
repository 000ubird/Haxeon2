<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function index(){
        $this->login();
    }

    public function login(){
        $this->load->view('login');
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect("login");
    }

    public function login_validation(){
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
        $this->form_validation->set_rules("userID", "ユーザID", "callback_validate_credentials");
        $this->form_validation->set_rules("password", "パスワード", "required");

        $this->form_validation->set_message("required", "");

        if($this->form_validation->run()){
            //正常な入力のとき
            $data = array(
                'userID' => $_POST['userID'],
            );
            $this->session->set_userdata($data);

            redirect("haxeon2");
        }else{
            //初回、もしくはエラーがあったとき
            $this->index();
        }
    }

    //userIDポスト時に呼び出されるコールバック機能
    public function validate_credentials(){
        $this->load->model("model_users");

        if($this->model_users->can_log_in()){
            return true;
        }else{
            $this->form_validation->set_message("validate_credentials", "IDもしくはパスワードが間違っています");
            return false;
        }
    }

}
