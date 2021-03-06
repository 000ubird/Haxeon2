<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProfileSettings extends CI_Controller {
    //プロフィール編集ページを表示
    public function index($userID) {
		if ($this->session->userdata('userID') == null || $this->session->userdata('userID') != $userID ) {
			//他人のアカウント情報は設定不可
			header('Location: '.base_url().'profilesettings/index/'.$this->session->userdata('userID'));
		}

        $this->load->model("ModelUsers");
        $userData = $this->ModelUsers->getUserData($userID);

        $data['userID'] = $userID;
        $data['user'] = $userData;
        $data['error'] = '';
        $this->load->view('header');
        $this->load->view('profilesettings',$data);
        $this->load->view('footer');
    }

	//プロフィール編集時のバリデーション
    public function validationProfile($userID){
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        //検証ルールの設定
        $this->form_validation->set_rules("password", "パスワード", "alpha_numeric|min_length[4]");
        $this->form_validation->set_rules("email", "メールアドレス", "valid_email|callback_isDuplicateEmail");
        $this->form_validation->set_rules("profile", "メッセージ", "max_length[140]");
        $this->form_validation->set_rules("url", "url", "min_length[1]|callback_checkURL");

        //エラーメッセージの設定
        $this->form_validation->set_message("alpha_numeric", "%s は半角英数字で入力してください。");
        $this->form_validation->set_message("min_length", "%s は4文字以上で入力してください。");
        $this->form_validation->set_message("valid_email", "有効なメールアドレスを入力してください。");
        $this->form_validation->set_message("max_length", "%s は140文字以内で入力してください。");
        $this->form_validation->set_message("checkURL", "有効なURLを入力してください。");

        if ($this->form_validation->run()){
            $this->load->model('ModelUsers');

            //入力されていたら更新
            if($_POST['url']){
                $this->ModelUsers->updateUserURL($_POST['url'], $userID);
            }

            //プロフィール文の更新
            $this->ModelUsers->updateUserProfile($_POST['profile'], $userID);

            header("Location: ".base_url()."profile/information/". $userID);

        }else{
            header("Location: ".base_url()."profilesettings/index/".$userID);
        }
    }

	//既存のメールアドレスの重複チェック
    public function isDuplicateEmail($str) {
        $this->load->model("ModelUsers");

        if($this->ModelUsers->isDuplicateEmail($str)){
            $this->form_validation->set_message('isDuplicateEmail','入力された %s '.$str.' は既に使われております。');
            return false;
        }
        else {
            return true;
        }
    }

    public function checkURL($url){
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
    public function uploadIcon($userID){
        $config['upload_path'] = './img/icon/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        //ファイル名の指定
        $config['file_name'] = $userID;
        $config['overwrite'] = TRUE;

        //アップロードライブラリ
        $this->load->library('upload',$config);

        //アップロードを実行した結果
        if(!$this->upload->do_upload()){
            $this->index($userID);
        }else{
            //データベースに反映
            $this->load->model('ModelUsers');
            $this->load->model('ModelUsers');
            $data = $this->upload->data();

            $iconURL = base_url().'img/icon/'.$data['file_name'];
            $this->ModelUsers->updateIconURL($iconURL, $this->session->userdata('userID'));

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
