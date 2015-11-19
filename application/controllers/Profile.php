<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//タグの登録上限数
define("TAG_LIMIT", 3);
//プロジェクト、お気に入りの表示数
define("PROJECT_PER_PAGE", 18);
//フォロー、フォロワーの表示数
define("FOLLOW_PER_PAGE", 28);

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

    public function information($userID, $category = ""){
        $this->view($this->getUserData($userID, $category));
    }

    //プロフィールページを表示する本体
    public function view($data){
        //新しい順にソートしておく
        krsort($data['projects']);
        krsort($data['follow']);
        krsort($data['follower']);
        krsort($data['favorites']);

        $category = $data['category'];

        if(!$category == "") {
            //ページネーション
            $this->load->library('pagination');

            $config['base_url'] = base_url().'profile/information/Tom0/'.$category.'/';
            $config['total_rows'] = count($data[$category]);
            $config['per_page'] = PROJECT_PER_PAGE;
            if($category == 'follow' || $category == 'follower') $config['per_page'] = FOLLOW_PER_PAGE;

            $config['uri_segment'] = 5;

            //Viewに関する指定
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            $config['first_tag_open'] = '<li class="waves-effect"><i class="material-icons">';
            $config['first_link'] = 'fast_rewind';
            $config['first_tag_close'] = '</i></li>';
            $config['last_tag_open'] = '<li class="waves-effect"><i class="material-icons">';
            $config['last_link'] = 'fast_forward';
            $config['last_tag_close'] = '</i></li>';
            $config['cur_tag_open'] = '<li class="active">';
            $config['cur_tag_close'] = '</li>';
            $config['num_tag_open'] = '<li class="waves-effect">';
            $config['num_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li class="waves-effect"><i class="material-icons">';
            $config['next_link'] = '&gt;';
            $config['next_tag_close'] = '</i></li>';
            $config['prev_tag_open'] = '<li class="waves-effect"><i class="material-icons">';
            $config['prev_link'] = '&lt;';
            $config['prev_tag_close'] = '</i></li>';

            $this->pagination->initialize($config);

            if($category == 'projects') $data['projects'] = array_slice($data['projects'], $this->uri->segment(5), PROJECT_PER_PAGE);
            if($category == 'follow') $data['follow'] = array_slice($data['follow'], $this->uri->segment(5), FOLLOW_PER_PAGE);
        }


        $this->load->view('header');
        $this->load->view('profile',$data);
        $this->load->view('footer');
    }

    private function getUserData($userID, $category){
        $this->load->model('Model_users');
        $this->load->model('Model_project');
        $this->load->model('Model_favorite');

        $data['category'] = $category;
        $data['user'] = $this->Model_users->getUserData($userID);
        $data['projects'] = $this->Model_users->getProjects($userID);
        $data['project_total'] = count($data['projects']);
        $data['follow'] = $this->Model_users->getFollowInfo($userID);
        $data['follow_total'] = count($data['follow']);
        $data['follower'] = $this->Model_users->getFollowedInfo($userID);
        $data['follower_total'] = count($data['follower']);
        $data['isown'] = ($this->session->userdata('userID') == $userID);
        $data['isfollow'] = $this->Model_users->getIsFollow($userID);
        $data['isfollowed'] = $this->Model_users->getIsFollowed($userID);

        $favorite_list = $this->Model_favorite->getFavorite($userID);

        $favorite_projects = array();
        foreach($favorite_list as $f){
            $id = $f->projectID;
            array_push($favorite_projects, $this->Model_project->getOneProject($id));
        }
        $data['favorites'] = $favorite_projects;
        $data['favorite_total'] = count($data['favorites']);

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
            $data['projectID'] = $projectID;

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

				//プロジェクトテーブルからtmpIDの情報を取得
				$this->load->model('Model_project');
				$result = $this->Model_project->getOneProject($pid);
				foreach($result as $row) {
					$tmpPro = $row->tmpPro;
				}

				//マップに登録
                $this->Model_project->registTagMap($pid, $tagid,$tmpPro);
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

        $uid = $this->session->userdata('userID');

		//正しい場合はアカウントの削除を実行
		if ($this->form_validation->run()) {
            //セッション情報の削除
            $this->session->sess_destroy();
			//アカウントとプロジェクトを削除
			$this->load->model("Model_users");
			$this->Model_users->deleteAccount($uid);
            //tmpアカウントからも削除
            $this->Model_users->deleteTmpAccount($uid);
			$this->load->model("Model_project");
			$this->Model_project->deleteProject($uid);

			//アカウント削除処理完了後に遷移するページ
			redirect('');
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
					$data['msg'] = "登録用メールが送信されました。";
                    $this->load->view('header');
                    $this->load->view('signup_msg',$data);
                    $this->load->view('footer');
                }else {
					$data['msg'] = "登録用メールの送信に失敗しました。お手数ですがやり直して下さい。";
					$this->load->view('signup_msg',$data);
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
			$data['msg'] = "アカウントが有効になりました。";
            $this->load->view('header');
			$this->load->view('signup_msg', $data);
			$this->load->view('footer');

            //仮テーブルから削除
            $this->Model_users->deleteTmpAccountFromKey($key);
        } else {
			$data['msg'] = "アカウントの認証に失敗しました。";
            $this->load->view('header');
            $this->load->view('signup_msg', $data);
			$this->load->view('footer');
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
        $this->form_validation->set_rules("userName", "ユーザー名", "min_length[0]|callback_space_check");
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

            //userNameが入力されていた場合、userIDの使用されているすべてのテーブルを書き換える
            //更新

            //ユーザー名は入力がなければidと同じにするように
            $username = $_POST['userName'];
            if(strlen($username) == 0){
                $this->Model_users->updateUserName($userID, $userID);
            }else {
                $this->Model_users->updateUserName($username, $userID);
            }

            //入力されていたら更新
            if($_POST['url']){
                $this->Model_users->updateUserURL($_POST['url'], $userID);
            }

            //入力されていたら更新
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
        $pattern = ".*[\\s 　]";
        if(!mb_ereg_match($pattern, $str)){
            return true;
        }else{
            if(count($str) == 0) return true;
            $this->form_validation->set_message('space_check','スペースは無効です。日本語と[a-zA-Z0-9_-]が有効です');
            return false;
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
//            $error = array('userID' => $userID, 'error' => $this->upload->display_errors());
            echo $this->upload->display_errors();
            $this->profilesettings($userID);
        }else{
//            $data = array('upload_data' => $this->upload->data());
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
        $this->form_validation->set_rules("current", "現在のパスワード", "required|alpha_numeric|callback_current_check");

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

    //プロジェクトを削除する
    public function delete_project($projectID){
        $this->load->model("Model_project");
        $userID = $this->session->userdata('userID');
        $this->Model_project->deleteOneProject($projectID, $userID);

        $this->information($userID);
    }

}
