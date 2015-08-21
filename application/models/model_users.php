<?php

class Model_users extends CI_Model{

    //DBにユーザーデータがあったらtrueを返す
    public function can_log_in(){
        $this->db->where(array('userID' => $this->input->post('userID'), 'userPass' => $this->input->post('password')));
        $query = $this->db->get('account');

        return ($query->num_rows() == 1);
    }

	//ユーザIDからアイコンのあるURLを取得	
	public function get_icon_url($userID) {
		$icon = '';
		
		$query = $this->db->get_where('account', array('userID' => $userID));
		foreach ($query->result() as $row) {
			$icon = $row->userIcon;
		}

		return $icon;
	}

    public function getProfile($userID){
        $result = array(
            'userData' => $this->getUserData($userID),
            'projects' => $this->getUserData($userID),
            'follow' => $this->getFollowInfo($userID),
            'followed' => $this->getFollowedInfo($userID)
        );
        return $result;
    }

    //プロフィール取得
    public function getUserData($userID){
        $this->db->where(array('userID' => $userID));
        $query = $this->db->get('account');

        if($query->num_rows() > 0){
            return $query->result();
        }else{
            //とりあえず
            return 0;
        }
    }

    //プロジェクト取得
    public function getProjects($userID){
        $this->db->where(array('ownerUserID' => $userID));
        $query = $this->db->get('project');

        if($query->num_rows() > 0){
            return $query->result();
        }else{
            //とりあえず
            return 0;
        }
    }

    //フォロー情報取得
    public function getFollowInfo($userID){
        $this->db->where(array('userID' => $userID));
        $query = $this->db->get('follow');

        return $query->result();
    }

    //フォロワー情報取得
    public function getFollowedInfo($userID){
        $this->db->where(array('userFollowingID' => $userID));
        $query = $this->db->get('follow');

        return $query->result();
    }
	
	//一時登録用テーブルにユーザー情報を追加する
	public function add_tmp_user($key) {
		$data = array(
			'userID' => $this->input->post('userID'),
			'password' => $this->input->post('password'),	//暗号化必要?
			'userMail' => $this->input->post('email'),
			'registKey'=> $key
		);
		
		return $this->db->insert('tmp_account',$data);
	}
	
	//一時登録用テーブルにユーザー情報を追加する
	public function add_user($key) {
		$this->db->where('registKey', $key);	//キーからユーザー情報を取得
		$data = $this->db->get('tmp_account');
		
		if ($data) {
			$row = $data->row();
			$info = array(
				'userID' => $row->userID,
				'userPass' => $row->password,
				'userName' => $row->userID,
				'userMail' => $row->userMail
			);
			if ($this->db->insert("account", $info)) {
				echo "アカウントが有効になりました!";
			}
		}
	}
	
	//ユーザIDの重複チェック
	public function is_overlap_uid($userID) {
		$this->db->where('userID',$userID);
		$query1 = $this->db->get('account');
		
		//一時登録用のテーブルも確認
		$this->db->where('userID',$userID);
		$query2 = $this->db->get('tmp_account');
		
		//重複していた場合は真
		return ($query1->num_rows() > 0 || $query2->num_rows() > 0);
	}
	
	//メールアドレスの重複チェック
	public function is_overlap_mail($mail) {
		$this->db->where('userMail',$mail);
		$query1 = $this->db->get('account');
		
		//一時登録用のテーブルも確認
		$this->db->where('userMail',$mail);
		$query2 = $this->db->get('tmp_account');
		
		//重複していた場合は真
		return ($query1->num_rows() > 0 || $query2->num_rows() > 0);
	}
}
