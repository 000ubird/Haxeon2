<?php

class model_follow extends CI_Model {

    //$userID フォロー相手のuserID
    //フォローをする
    //データベースに登録する
    public function apply($userID){
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
    public function release($userID){
        $this->db->delete('follow', array('userID'=>$this->session->userdata('userID'), 'userFollowingID'=>$userID));
    }

}
