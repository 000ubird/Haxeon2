<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PasswordSettings extends CI_Controller {
    //パスワード変更ページを表示
    public function index($userID) {
		if ($this->session->userdata('userID') == null) header('Location: '.base_url().'login');

        $data['userID'] = $userID;
        $this->load->view('header');
        $this->load->view('passwordsettings',$data);
        $this->load->view('footer');
    }

    //パスワード変更ページ用のバリデーション
    public function validation_password($userID){
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        //検証ルールの設定
        $this->form_validation->set_rules("current", "現在のパスワード", "required|alpha_numeric|callback_current_check");
        $this->form_validation->set_rules("new", "新しいパスワード", "required|alpha_numeric|min_length[4]|callback_setnewPass");
        $this->form_validation->set_rules("again", "新しいパスワード(再入力)", "required|alpha_numeric|min_length[4]|callback_again_check");

        //エラーメッセージの設定
        $this->form_validation->set_message("required", "%s を入力してください。");
        $this->form_validation->set_message("alpha_numeric", "%s は半角英数字で入力してください。");
        $this->form_validation->set_message("min_length", "%s は4文字以上で入力してください。");

        if($this->form_validation->run()){
            if($_POST['current'] && $_POST['new'] && $_POST['again']){
                //新しいパスワードでアップデートする
                $this->load->model('ModelUsers');
                $this->ModelUsers->updatePassword($_POST['new'], $userID);
                //unsetする理由は不要なデータになるのでセッションから削除している
                $this->session->unset_userdata('newPass');
                //$this->information($userID);
				redirect('profile/information/'.$userID.'/', 'refresh');
            }
            $this->session->unset_userdata('newPass');
            $this->index($userID);
        }else{
            $this->session->unset_userdata('newPass');
            $this->index($userID);
        }
    }

	//新しいパスワードの確認のためにセッション登録をするだけのメソッド
    function setnewPass($str){
        $this->session->set_userdata(array('newPass' => $str));
        return true;
    }

    function again_check($str){
        $new = $this->session->userdata('newPass');

        if($new == $str) return true;
        else{
            $this->form_validation->set_message('again_check','新しいパスワードと一致しません');
            return false;
        }
    }

	//個別にバリデーションルールを作成する
    //current: データベースのパスワードと照合
    //new: とくにはないかも
    //again: newで入力された内容と一致しているかどうか
    function current_check($str){
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
            $this->form_validation->set_message('current_check','パスワードが間違っています');
            return false;
        }else{
            $this->form_validation->set_message('current_check','パスワードが間違っています2');
            return false;
        }
    }
}
