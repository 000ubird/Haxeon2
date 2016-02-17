<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProfileSettings extends CI_Controller {
    //プロフィール編集ページを表示
    public function index($userID) {
		if ($this->session->userdata('userID') == null) header('Location: '.base_url().'login');

        $this->load->model("Model_users");
        $userData = $this->Model_users->getUserData($userID);

        $data['userID'] = $userID;
        $data['user'] = $userData;
        $data['error'] = '';
        $this->load->view('header');
        $this->load->view('profilesettings',$data);
        $this->load->view('footer');
    }
	
	//プロフィール編集時のバリデーション
    public function validation_profile($userID){
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        //検証ルールの設定
        $this->form_validation->set_rules("password", "パスワード", "alpha_numeric|min_length[4]");
        $this->form_validation->set_rules("email", "メールアドレス", "valid_email|callback_mail_check");
        $this->form_validation->set_rules("profile", "メッセージ", "max_length[140]");
        $this->form_validation->set_rules("url", "url", "min_length[1]|callback_url_check");

        //エラーメッセージの設定
        $this->form_validation->set_message("alpha_numeric", "%s は半角英数字で入力してください。");
        $this->form_validation->set_message("min_length", "%s は4文字以上で入力してください。");
        $this->form_validation->set_message("valid_email", "有効なメールアドレスを入力してください。");
        $this->form_validation->set_message("max_length", "%s は140文字以内で入力してください。");
        $this->form_validation->set_message("url_check", "有効なURLを入力してください。");

        if ($this->form_validation->run()){
            $this->load->model('Model_users');

            //入力されていたら更新
            if($_POST['url']){
                $this->Model_users->updateUserURL($_POST['url'], $userID);
            }

            //プロフィール文の更新
            $this->Model_users->updateUserProfile($_POST['profile'], $userID);

            header("Location: ".base_url()."profile/information/". $userID);

        }else{
            header("Location: ".base_url()."profilesettings/index/".$userID);
        }
    }
	
	//既存のメールアドレスの重複チェック
    public function mail_check($str) {
        $this->load->model("Model_users");

        if($this->Model_users->is_overlap_mail($str)){
            $this->form_validation->set_message('mail_check','入力された %s '.$str.' は既に使われております。');
            return false;
        }
        else {
            return true;
        }
    }
	
    public function url_check($url){
        if (preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $url)) {
            //            echo "正しいURLです";
            $header = get_headers($url);
            if (preg_match('#^HTTP/.*\s+[200|302]+\s#i', $header[0])) {
                return true;
            }
        }
        if($url == "") return true;
        return false;
    }
	
	//画像アップロードメソッド
    public function icon_upload($userID){
        $config['upload_path'] = './img/icon/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        //ファイル名の指定
        $config['file_name'] = $userID;
        $config['overwrite'] = TRUE;
        $config['max_size'] = 2048;

        //アップロードライブラリ
        $this->load->library('upload',$config);

        //アップロードを実行した結果
        if(!$this->upload->do_upload()){
            $this->index($userID);
        }else{
            //データベースに反映
            $this->load->model('Model_users');
            $this->load->model('Model_users');
            $data = $this->upload->data();

            $iconURL = base_url().'img/icon/'.$data['file_name'];
            $this->Model_users->updateIconURL($iconURL, $this->session->userdata('userID'));

            //画像のリサイズ
            $config = array(
                'image_library' => 'gd2',
                'source_image' => $data['full_path'],
                'create_thumb' => FALSE,
                'maintain_ratio' => FALSE,
                'width' => 300,
                'height' => 300,
                'quality' => 100
            );

            $this->load->library("image_lib");
            $this->image_lib->initialize($config);

            if($this->image_lib->resize()){
//                print_r("success");
            }else{
//                echo $this->image_lib->display_errors();
//                print_r("failed");
            }

            $this->index($userID);
        }
    }
}