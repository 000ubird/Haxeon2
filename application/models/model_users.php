<?php

class Model_users extends CI_Model{

    //DBにユーザーデータがあったらtrueを返す
    public function can_log_in(){
        $this->db->where(array('userID' => $this->input->post("userID"), 'userPass' => $this->input->post("password")));
        $query = $this->db->get('account');

        if($query->num_rows() == 1){
            return true;
        }else{
            return false;
        }
    }

	//ユーザIDからアイコンのあるURLを取得
	public function get_icon_url($userID) {
		$icon = "";

		$query = $this->db->get_where('account', array('userID' => $userID));
		foreach ($query->result() as $row) {
			$icon = $row->userIcon;
		}

		return $icon;
	}

	//ユーザIDの重複チェック
	public function is_overlap_uid($userID) {
		$this->db->where(array('userID' => $userID));
		$query = $this->db->get('account');

		//重複していた場合は真
		if($query->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

    //プロジェクト取得

    //フォロー情報取得

    //ユーザー情報取得
}
