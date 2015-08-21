<?php

class Model_users extends CI_Model{

    //DBにユーザーデータがあったらtrueを返す
    public function can_log_in(){
        $this->db->where(array('userID' => $this->input->post("userID"), 'userPass' => $this->input->post("password")));
        $query = $this->db->get('account');

        return ($query->num_rows() == 1);
    }

	//ユーザIDからアイコンのあるURLを取得
    public function is_overlap_uid($userID)
    {
        $this->db->where(array('userID' => $userID));
        $query = $this->db->get('account');

        //重複していた場合は真
        return ($query->num_rows() == 1);
    }

    public function get_icon_url($userID){
		$icon = "";

		$query = $this->db->get_where('account', array('userID' => $userID));
		foreach ($query->result() as $row) {
			$icon = $row->userIcon;
		}

		return $icon;
	}
    //ユーザIDの重複チェック

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
}
