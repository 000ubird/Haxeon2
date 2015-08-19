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

    //プロフィール取得
    public function getProfile($userID){

    }

    //プロジェクト取得
    public function getProjects($userID){
        $this->db->where(array('ownerUserID' => $userID));
        $query = $this->db->get('project');

        return $query->result();
    }

    //フォロー情報取得
    public function getFollowInfo($userID){

    }
}
