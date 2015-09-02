<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function index() {
        $this->load->view('header');
        $this->load->view('haxeon2');
        $this->load->view('footer');
    }

    public function signup(){
        $this->load->view('header');
        $this->load->view('signup');
        $this->load->view('footer');
    }

    public function information($userID){
        $this->view($this->getUserData($userID));
    }

    //プロフィールページを表示する本体
    public function view($data){
        $this->load->view('header');
        $this->load->view('profile',$data);
        $this->load->view('footer');
    }

    private function getUserData($userID){
        $this->load->model('model_users');

        $data['user'] = $this->model_users->getUserData($userID);
        $data['projects'] = $this->model_users->getProjects($userID);
        $data['follow'] = $this->model_users->getFollowInfo($userID);
        $data['followed'] = $this->model_users->getFollowedInfo($userID);
        $data['isown'] = ($this->session->userdata('userID') == $userID);
        $data['isfollow'] = $this->model_users->getIsFollow($userID);
        $data['isfollowed'] = $this->model_users->getIsFollowed($userID);

        return $data;
    }

    /**
     * projectsettings
     * プロジェクトの所有者のみが変更できる設定を行う
     * タグ設定やプロジェクトの削除など
     */
    public function projectsettings($projectID){
        $this->session->set_userdata(array('pid' => $projectID));

        $this->load->model('model_project');
        $this->load->library('tag');

        //sessionのuserIDとprojectIDの所有者が同じかチェック
        if($this->model_project->isOwner($projectID)) {

            $data['tags'] = $this->tag->getTag($projectID);

            $this->load->view('header');
            $this->load->view('projectsettings', $data);
            $this->load->view('footer');
        }else{
            $this->index();
        }
    }

	//アカウント削除
	public function delete() {
		$this->load->view('header');
		$this->load->view('delete_account');
		$this->load->view('footer');
	}

	//アカウント削除処理に使用するパスワードのバリデーション
	public function password_validation() {
		$this->load->library("form_validation");
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules("password", "パスワード", "required|callback_pass_check");
		$this->form_validation->set_message("required", "%s は必須入力項目です。");

		//正しい場合はアカウントの削除を実行
		if ($this->form_validation->run()) {
			//アカウントとプロジェクトを削除
			$this->load->model("model_users");
			$this->model_users->deleteAccount($this->session->userdata('userID'));
            //tmpアカウントからも削除
            $this->model_users->deleteTmpAccount($this->session->userdata('userID'));
			$this->load->model("model_project");
			$this->model_project->deleteProject($this->session->userdata('userID'));

			//セッション情報の削除
			$this->session->sess_destroy();

			//アカウント削除処理完了後に遷移するページ
			$this->index();
		}else {
			$this->delete();
		}
	}

    public function validation_tag(){
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        //検証ルールの設定
        $this->form_validation->set_rules("tag", "タグ", "required|callback_tag_check");

        $this->form_validation->set_message("required", "%s を入力してください");

        //正しい場合は登録処理
        if ($this->form_validation->run()) {

        }else{
            $this->projectsettings($this->session->userdata('pid'));
        }
    }

	//パスワードのチェック
	public function pass_check($str) {
		$this->form_validation->set_message('pass_check', 'パスワードが間違っています。');

		//DBからパスワードを取得
		$this->load->model("model_users");
		$result = $this->model_users->getUserData($this->session->userdata('userID'));
		foreach($result as $row) $pass = $row->userPass;

		return ($pass == $str);
	}

    //タグの重複チェック
    public function tag_check($str) {
        $this->load->model("model_project");

        if($this->model_project->isTag($str)){
            $this->form_validation->set_message('tag_check','入力された %s '.$str.' は既に使われております。');
            return false;
        }
        else {
            return true;
        }
    }

    public function validation_signup() {
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        //検証ルールの設定
        $this->form_validation->set_rules("userID", "ユーザID", "required|alpha_numeric|min_length[4]|callback_username_check");
        $this->form_validation->set_rules("password", "パスワード", "required|alpha_numeric|min_length[4]");
        $this->form_validation->set_rules("email", "メールアドレス", "valid_email|required|callback_mail_check");

        //エラーメッセージの設定
        $this->form_validation->set_message("alpha_numeric", "%s は半角英数字で入力してください。");
        $this->form_validation->set_message("min_length", "%s は4文字以上で入力してください。");
        $this->form_validation->set_message("required", "%s を入力してください。");
        $this->form_validation->set_message("valid_email", "有効なメールアドレスを入力してください。");

        //正しい場合はメールを送信
        if ($this->form_validation->run()) {
            //認証キーの生成
            $key = md5(uniqid());

            //Emailライブラリを読み込む。メールタイプをHTMLに設定（デフォルトはテキストです）
            $this->load->library("email", array("mailtype" => "html"));
            $this->email->from("delldell201507@gmail.com", "Haxeon2");	//送信元の情報
            $this->email->to($this->input->post("email"));	//送信先の設定
            $this->email->subject("【Haxeon】アカウントの認証");	//タイトルの設定

            //メッセージの本文
            $message = "仮登録が完了しました。";
            $message .= "<h1><a href=' ".base_url(). "profile/register/$key'>こちら</h1>をクリックして、会員登録を完了してください。</a>";
            $this->email->message($message);

            $this->load->model("model_users");

            //仮登録用データベースへの登録が完了した場合
            if ($this->model_users->add_tmp_user($key)) {
                //メール送信
                if ($this->email->send()) {
                    $this->load->view('header');
                    echo "登録用メールが送信されました。";
                    $this->load->view('footer');
                }else {
                    echo "登録用メールの送信に失敗しました。お手数ですがやり直して下さい。";
                    $this->signup();
                }
            } else {
                $this->signup();
            }
        } else {
            $this->signup();
        }
    }

    //仮登録メールのURLを認証
    public function register($key) {
        $this->load->model("model_users");
        if ($this->model_users->add_user($key)) {
            $this->load->view('header');
            echo "アカウントが有効になりました。";
        } else {
            $this->load->view('header');
            echo "アカウントの認証に失敗しました。";
        }
    }

    //既存のユーザIDとの重複チェック
    public function username_check($str) {
        $this->load->model("model_users");

        if($this->model_users->is_overlap_tmp_uid($str) || $this->model_users->is_overlap_uid($str) ){
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

    //プロフィール編集ページを表示
    public function profilesettings($userID){
        $data['userID'] = $userID;
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
        $this->form_validation->set_rules("userName", "ユーザー名", "min_length[1]|callback_space_check");
        $this->form_validation->set_rules("password", "パスワード", "alpha_numeric|min_length[4]");
        $this->form_validation->set_rules("email", "メールアドレス", "valid_email|callback_mail_check");
        $this->form_validation->set_rules("profile", "メッセージ", "max_length[140]");

        //エラーメッセージの設定
        $this->form_validation->set_message("alpha_numeric", "%s は半角英数字で入力してください。");
        $this->form_validation->set_message("min_length", "%s は4文字以上で入力してください。");
        $this->form_validation->set_message("valid_email", "有効なメールアドレスを入力してください。");
        $this->form_validation->set_message("max_length", "%s は140文字以内で入力してください。");

        if ($this->form_validation->run()){
            $this->load->model('model_users');

            //userNameが入力されていた場合、userIDの使用されているすべてのテーブルを書き換える
            if($_POST['userName']){
                //更新
                $this->model_users->updateUserName($_POST['userName'], $userID);
            }

            //メッセージの更新
            if($_POST['profile']){
                $this->model_users->updateUserProfile($_POST['profile'], $userID);
            }
            $this->information($userID);
        }else{
            $this->profilesettings($userID);
        }
    }

    //空白文字があったらfalseになるコールバック
    public function space_check($str){
        $pattern = "^[a-zA-Z0-9_-]+$";
        if(mb_ereg_match($pattern, $str)){
            return true;
        }else{
            if(count($str) == 0) return true;
            $this->form_validation->set_message('space_check','[a-zA-Z0-9_-]です');
            return false;
        }
    }

    //画像アップロードメソッド
    public function do_upload($userID){
        $config['upload_path'] = './img/';
        $config['allowed_types'] = 'jpg|png';
        //ファイル名の指定
        $config['file_name'] = $userID;
        $config['overwrite'] = TRUE;
        $config['max_size'] = 2000;

        $this->load->library('upload',$config);

        if(!$this->upload->do_upload()){
//            $error = array('userID' => $userID, 'error' => $this->upload->display_errors());

            $this->profilesettings($userID);
        }else{
//            $data = array('upload_data' => $this->upload->data());

            $this->information($userID);
        }
    }

    //パスワード変更ページを表示
    public function change_pass($userID){
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
        $this->form_validation->set_rules("current", "現在のパスワード", "required|alpha_numeric|min_length[4]");
        $this->form_validation->set_rules("new", "新しいパスワード", "required|alpha_numeric|min_length[4]");
        $this->form_validation->set_rules("again", "新しいパスワード(再入力)", "required|alpha_numeric|min_length[4]");

        //エラーメッセージの設定
        $this->form_validation->set_message("required", "%s を入力してください。");
        $this->form_validation->set_message("alpha_numeric", "%s は半角英数字で入力してください。");
        $this->form_validation->set_message("min_length", "%s は4文字以上で入力してください。");

        if($this->form_validation->run()){
            if($_POST['current'] && $_POST['new'] && $_POST['again']){
                $this->information($userID);
            }
            $this->change_pass($userID);
        }else{
            $this->change_pass($userID);
        }
    }
}
