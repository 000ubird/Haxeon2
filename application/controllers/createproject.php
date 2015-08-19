<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Createproject extends CI_Controller {

    public function index(){
        //セッションにuserIDがあったら遷移するようにする
        if(isset($_SESSION['userID'])){
            $this->load->view('createproject');
        }else{
            redirect('login');
        }
    }

    public function create_validation(){
        //フォームバリデーションライブラリを呼び出し
        $this->load->library("form_validation");

        $this->form_validation->set_error_delimiters('<div class="error">','</div>');

        //入力の有無確認
        $this->form_validation->set_rules("projectName", "プロジェクト名", "require");
        $this->form_validation->set_message("required", "%sが入力されていません");

        //入力されたプロジェクト名がすでに登録されてないかを確認
        //モデルに問い合わせる
        //$this->form_validation->set_message("required", "すでに登録されているプロジェクト名です");
        //登録、try-haxeへ
        //リダイレクト
    }
}
