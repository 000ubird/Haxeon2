<?php

class Model_project extends CI_Model{

    //データベースにプロジェクト名があったらtrueを返す
    public function isProjectName() {
        $this->db->where(array('projectName' => $this->input->post('projectName'), 'ownerUserID' => $this->session->userdata('userID')));
        $query = $this->db->get('project');

		return ($query->num_rows() > 0);
    }

	//指定したプロジェクトのPV数を増やす
	public function pvCountUp($uid, $projectName) {
		$array = array('projectName' => $projectName, 'ownerUserID' => $uid);
		$query = $this->db->get_where('project', $array);

		//PV数の取得と更新
		foreach ($query->result() as $row) $pv = $row->pv+1;
		//echo $pv;	//デバッグ
		$this->db->update('project', array('pv'=>$pv),$array);
	}

    //プロジェクト所有者とログインユーザが同一ならtrueを返す
    public function isOwner($projectID) {
        $array = array('projectID' => $projectID, 'ownerUserID' => $this->session->userdata('userID'));
        $query = $this->db->get_where('project', $array);

        return ($query->num_rows() > 0);
    }

    //タグ情報を返す
    public function getTagID($projectID) {
        $ids = array();

        $array = array('projectID' => $projectID);
        //tagmapの情報を取得
        $query = $this->db->get_where('tagmap', $array);
        foreach($query->result() as $res){
            array_push($ids, $res->tagID);
        }

        return $ids;
    }

    //タグを取得する
    public function getTag($id){
        $array = array('id' => $id);
        $query = $this->db->get_where('tag', $array);

        $tagname = "";
        foreach ($query->result() as $row) {
            $tagname = $row->tag;
        }

        return $tagname;
    }

    //タグの有無を取得する。あればtrueになる
    public function isTag($tagname){
        $array = array('tag' => $tagname);
        $query = $this->db->get_where('tag', $array);

        return ($query->num_rows() > 0);
    }

    //タグをtagテーブルに登録する
    //返り値 登録したタグのid
    public function createTag($tagname){
        $array = array(
            'tag' => $tagname
        );

        $this->db->insert('tag', $array);

        return $this->db->insert_id();
    }

}
