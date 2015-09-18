<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//タグの登録上限数
define("TAG_LIMIT", 3);

class Profile extends CI_Controller {

    public function index() {
        $this->load->view('header');
        $this->load->view('haxeon');
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
        $this->load->model('Model_users');

        $data['user'] = $this->Model_users->getUserData($userID);
        $data['projects'] = $this->Model_users->getProjects($userID);
        $data['follow'] = $this->Model_users->getFollowInfo($userID);
        $data['followed'] = $this->Model_users->getFollowedInfo($userID);
        $data['isown'] = ($this->session->userdata('userID') == $userID);
        $data['isfollow'] = $this->Model_users->getIsFollow($userID);
        $data['isfollowed'] = $this->Model_users->getIsFollowed($userID);

        return $data;
    }

    /**
     * projectsettings
     * プロジェクトの所有者のみが変更できる設定を行う
     * タグ設定やプロジェクトの削除など
     */
    public function projectsettings($projectID){
        $this->session->set_userdata(array('pid' => $projectID));

        $this->load->model('Model_project');
        $this->load->library('tag');

        //sessionのuserIDとprojectIDの所有者が同じかチェック
        if($this->Model_project->isOwner($projectID)) {

            $data['tags'] = $this->tag->getTag($projectID);

            $this->load->view('header');
            $this->load->view('projectsettings', $data);
            $this->load->view('footer');
        }else{
            $this->index();
        }
    }

    public function validation_tag(){
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        //検証ルールの設定
        $this->form_validation->set_rules("tag", "タグ", "required|callback_tag_table_check");

        $this->form_validation->set_message("required", "%s を入力してください");

        $pid = $this->session->userdata('pid');
        //正しい場合は登録処理
        if ($this->form_validation->run()) {
            $this->load->model("Model_project");
            //タグマップテーブルの登録数についての確認
                //入力を保持
                $tag = $this->input->post('tag');

                if(!$this->tag_check($tag)){
                    //タグテーブルに存在しないタグのとき
                     $this->Model_project->registTag($tag);
                }

                //idを取得
                $tagid = $this->Model_project->getTagID($tag);
                //マップに登録
                $this->Model_project->registTagMap($pid, $tagid);
                $this->projectsettings($pid);

        }else{
            $this->projectsettings($pid);
        }
    }

    public function tag_table_check($str){
        $this->load->model("Model_project");
        $pid = $this->session->userdata('pid');

        //タグマップテーブルの登録数についての確認
        if($this->Model_project->countTagMap($pid) == TAG_LIMIT){
            $this->form_validation->set_message("tag_table_check", 'タグ登録数の上限は'. TAG_LIMIT .'個です');
            return false;
        }

        $tagid = $this->Model_project->getTagID($str);

        if($this->Model_project->checkOverlap($pid, $tagid)){
            $this->form_validation->set_message("tag_table_check", '入力した%sはすでに登録されています');
            return false;
        }

        return true;
    }

    //タグテーブルの重複チェック
    //あればtrue
    public function tag_check($tagname) {
        $this->load->model("Model_project");

        if($this->Model_project->isTag($tagname)){
            return true;
        }else{
            return false;
        }
    }

    public function delete_tagmap($tagname){
        $this->load->model("Model_project");

        $tagID = $this->Model_project->getTagID($tagname);

        $pid = $this->session->userdata('pid');
        $this->Model_project->deleteTagMap($pid, $tagID);

        $this->projectsettings($pid);
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
			$this->load->model("Model_users");
			$this->Model_users->deleteAccount($this->session->userdata('userID'));
            //tmpアカウントからも削除
            $this->Model_users->deleteTmpAccount($this->session->userdata('userID'));
			$this->load->model("Model_project");
			$this->Model_project->deleteProject($this->session->userdata('userID'));

			//セッション情報の削除
			$this->session->sess_destroy();

			//アカウント削除処理完了後に遷移するページ
			$this->index();
		}else {
			$this->delete();
		}
	}

	//パスワードのチェック
	public function pass_check($str) {
		$this->form_validation->set_message('pass_check', 'パスワードが間違っています。');

		//DBからパスワードを取得
		$this->load->model("Model_users");
		$result = $this->Model_users->getUserData($this->session->userdata('userID'));
		foreach($result as $row) $pass = $row->userPass;

		return ($pass == $str);
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
            $this->email->from("delldell201507@gmail.com", "Haxeon");	//送信元の情報
            $this->email->to($this->input->post("email"));	//送信先の設定
            $this->email->subject("【Haxeon】アカウントの認証");	//タイトルの設定

            //メッセージの本文
            $message = "仮登録が完了しました。";
            $message .= "<h1><a href=' ".base_url(). "profile/register/$key'>こちら</h1>をクリックして、会員登録を完了してください。</a>";
            $this->email->message($message);

            $this->load->model("Model_users");

            //仮登録用データベースへの登録が完了した場合
            if ($this->Model_users->add_tmp_user($key)) {
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
        $this->load->model("Model_users");
        if ($this->Model_users->add_user($key)) {
            $this->load->view('header');
            echo "アカウントが有効になりました。";
            //仮テーブルから削除
            $this->Model_users->deleteTmpAccountFromKey($key);
        } else {
            $this->load->view('header');
            echo "アカウントの認証に失敗しました。";
        }
    }

    //既存のユーザIDとの重複チェック
    public function username_check($str) {
        $this->load->model("Model_users");

        if($this->Model_users->is_overlap_tmp_uid($str) || $this->Model_users->is_overlap_uid($str) ){
            $this->form_validation->set_message('username_check','入力された %s '.$str.' は既に使われております。');
            return false;
        }
        else {
            return true;
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
            $this->load->model('Model_users');

            //userNameが入力されていた場合、userIDの使用されているすべてのテーブルを書き換える
            if($_POST['userName']){
                //更新
                $this->Model_users->updateUserName($_POST['userName'], $userID);
            }

            //メッセージの更新
            if($_POST['profile']){
                $this->Model_users->updateUserProfile($_POST['profile'], $userID);
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
                $this->load->model('Model_users');
                $this->Model_users->updatePassword($_POST['new'], $userID);
                //unsetする理由は不要なデータになるのでセッションから削除している
                $this->session->unset_userdata('abcdnewpass');
                $this->information($userID);
            }
            $this->session->unset_userdata('abcdnewpass');
            $this->change_pass($userID);
        }else{
            $this->session->unset_userdata('abcdnewpass');
            $this->change_pass($userID);
        }
    }

    //個別にバリデーションルールを作成する
    //current: データベースのパスワードと照合
    //new: とくにはないかも
    //again: newで入力された内容と一致しているかどうか
    function current_check($str){
        $userID = $this->session->userdata('userID');
        $this->load->model('Model_users');

        $array = $this->Model_users->getUserData($userID);
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

    //新しいパスワードの確認のためにセッション登録をするだけのメソッド
    function setnewPass($str){
        $this->session->set_userdata(array('abcdnewpass' => $str));
        return true;
    }

    function again_check($str){
        $new = $this->session->userdata('abcdnewpass');

        if($new == $str) return true;
        else{
            $this->form_validation->set_message('again_check','新しいパスワードと一致しません');
            return false;
        }
    }

    //メールアドレス設定ページを表示する
    public function change_email($userID){
        $data['userID'] = $userID;
        $this->load->view('header');
        $this->load->view('emailsettings',$data);
        $this->load->view('footer');
    }

    //メールアドレス設定ページ用のバリデーション
    public function validation_email($userID){
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        //検証ルールの設定
        $this->form_validation->set_rules("new", "メールアドレス", "required|valid_email");

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
            $message .= "<h1><a href=' ".base_url(). "profile/email_register/$key'>こちら</h1>をクリックして、メールアドレスの変更を完了してください。</a>";
            $this->email->message($message);

            $this->load->model("Model_users");

            //仮登録用データベースへの登録が完了した場合
            if ($this->Model_users->add_tmp_email_user($userID, $key, $send)) {
                //アカウントテーブルの鍵を上書き
                $this->Model_users->updateKey($key, $userID);

                //メール送信
                if ($this->email->send()) {
                    $this->load->view('header');
                    echo "登録用メールが送信されました。";
                    $this->load->view('footer');
                }else {
                    echo "登録用メールの送信に失敗しました。お手数ですがやり直して下さい。";
                    $this->change_email($userID);
                }
            } else {
                $this->information($userID);
            }
        }else{
            echo '正しいメールアドレスを入力してください';
            $this->change_email($userID);
        }
    }

    //メールアドレス変更メールのURLを認証
    public function email_register($key) {
        $this->load->model("Model_users");
        //add_userメソッドを変更する
        if ($this->Model_users->updateMail($key)) {
            $this->load->view('header');
            echo "メールアドレスが変更されました。";
            //仮テーブルから削除
            $this->Model_users->deleteTmpAccountFromKey($key);
        } else {
            $this->load->view('header');
            echo "メールアドレスの変更に失敗しました。";
        }
    }

}