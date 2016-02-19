<?php

class ModelFollow extends CI_Model {

    //フォローをする
    //データベースに登録する
    //自分のIDはログインしているため、セッションを使用
    //引数$userIDは相手のID
    public function setFollow($userID) {
        //データの作成
        $data = array(
            'userID' => $this->session->userdata('userID'),
            'userFollowingID' => $userID
        );

        //insert
        $this->db->insert('follow', $data);
    }

    //アンフォローをする
    //データベースから削除する
    public function unsetFollow($userID) {
        $this->db->delete('follow', array('userID'=>$this->session->userdata('userID'), 'userFollowingID'=>$userID));
    }

    //アカウント削除時に$userIDのフォロー、フォロワーをすべて削除する
	public function deleteFollow($userID) {
		$this->db->where('userFollowingID',$userID);
		$this->db->or_where('userID',$userID);
		$this->db->delete('follow');
	}

}
