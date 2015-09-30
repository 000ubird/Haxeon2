<?php

class Model_favorite extends CI_Model {

    //favoriteテーブルにuserIDとprojectIDを登録する
    public function favorite($userID, $projectID){
        $data = array(
            'userID' => $userID,
            'projectID' => $projectID
        );

        $this->db->insert('favorite', $data);
    }

    //favoriteテーブルからuserIDとprojectIDで検索したものを削除する
    public function release_favorite($userID, $projectID){
        $this->db->delete('favorite', array('userID' => $userID, 'projectID' => $projectID));
    }

    //favoriteテーブルのprojectIDをアップデートする
    public function update_favorite($userID, $beforeID, $afterID){
        $data = array(
            'userID' => $userID,
            'projectID' => $beforeID
        );
        $this->db->where($data);
        $this->db->update('favorite', array('projectID' => $afterID));
    }

    //userIDがふぁぼしたリストを返す
    public function getFavorite($userID){
        $query = $this->db->get_where('favorite', array('userID' => $userID));
        return $query->result();
    }
}
