<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Createproject extends CI_Controller {

	//プロジェクトを作成する
    public function index() {
		if ($this->session->userdata('userID') == null) header('Location: '.base_url().'login');
		
        //セッションにuserIDがあったら遷移するようにする
        if(isset($_SESSION['userID'])){
            $this->load->view('header');
            $this->load->view('createproject');
            $this->load->view('footer');
        }else{
            redirect('login');
        }
    }

    public function validation(){
        //フォームバリデーションライブラリを呼び出し
        $this->load->library("form_validation");

        $this->form_validation->set_error_delimiters('<div class="error">','</div>');

        //入力の有無確認
        $this->form_validation->set_rules("projectName", "プロジェクト名", "required");
        $this->form_validation->set_message("required", "%sが入力されていません");

        if($this->form_validation->run()){
            //セッションにuserNameを登録
            $data = array(
                'projectName' => $_POST['projectName'],
            );
            $this->session->set_userdata($data);

            //try-haxeへのリンク
            //仮リンク
            redirect("try-haxe/index.html");
        }else{
            //リダイレクト
            $this->index();
        }
    }

    public function validate_credentials(){
        $this->load->model("Model_project");

        if(!($this->Model_project->isProjectName())){
            //DBに登録されていなかったとき
            return true;
        }else{
            $this->form_validation->set_message("validate_credentials", "すでに登録されているプロジェクト名です");
            return false;
        }
    }

}
