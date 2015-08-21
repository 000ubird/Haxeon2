<?php

class model_follow extends CI_Model {

    //$userID フォロー相手のuserID
    //フォローをする
    public function apply($userID){
        //データの作成
        $data = array(
            'userID' => $this->session->userdata('userID'),
            'userFollowingID' => $userID
        );

        //insert
        $this->db->insert('follow', $data);

    }

}
