<?php

class ModelFavorite extends CI_Model {

    //favoriteテーブルにuserIDとprojectIDを登録する
    public function setFavorite($userID, $projectID, $tmpPro){
        $data = array(
            'userID' => $userID,
            'projectID' => $projectID,
			'tmpPro' => $tmpPro
        );

        $this->db->insert('favorite', $data);
    }

    //favoriteテーブルからuserIDとprojectIDで検索したものを削除する
    public function unsetFavorite($userID, $projectID){
        $this->db->delete('favorite', array('userID' => $userID, 'projectID' => $projectID));
    }

    //favoriteテーブルのprojectIDをアップデートする
    public function updateProjectIDonFavorite($userID, $beforeID, $afterID){
        //変更する行を特定する部分
        $data = array(
            'userID' => $userID,
            'projectID' => $beforeID
        );
        $this->db->where($data);

        $this->db->update('favorite', array('projectID' => $afterID));
    }

    //userIDのファボの全てを返す
    public function getFavorite($userID){
        $query = $this->db->get_where('favorite', array('userID' => $userID));

        return $query->result();
    }

	//指定したプロジェクトのお気に入り数を更新
	public function updateFavoriteCount($projectID) {
        //$projectIDがファボされている全てのレコードを取得
		$query = $this->db->get_where('favorite', array('projectID' => $projectID));

		//プロジェクトテーブル内のお気に入り数更新
		$this->db->where('projectID', $projectID);
        //お気に入り数=取得した行数=$query->num_rows()
		$this->db->update('project', array('favorite'=>$query->num_rows()));

	}
}
