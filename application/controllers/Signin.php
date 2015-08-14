<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends CI_Controller {

    public function validation(){
        //フォームバリデーションライブラリを呼び出し
        $this->load->library("form_validation");

        $this->form_validation->set_error_delimiters('<div class="error">','</div>');

        /**
         * required : 必要事項
         * trim : バリデーション実行前に、文字列の最初と最後の空白を自動的に削除
         * xss_clean : クロスサイトスクリプティングを禁止
         * md5 : 暗号化処理
         */
        $this->form_validation->set_rules("userID", "ユーザID", "required|trim");
        $this->form_validation->set_rules("email", "メールアドレス", "required|trim");
        $this->form_validation->set_rules("password", "パスワード", "required|md5|trim");

        $this->form_validation->set_message("required", "%sが入力されていません");

        if($this->form_validation->run()){
            //正常なとき
            $data['userID'] = $_POST['userID'];
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];

            //データベースにポストする処理へ委譲
           // redirect("signin/postdb");
        }else{
            //初回、もしくはエラーがあったとき
            $this->index();
        }
    }

    //項目が正しく入力されていたら、データベースに仮登録する
    public function postdb() {
    }

    public function index(){
        $this->load->view('signin');
    }
}
