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
    public function getTagIDs($projectID) {
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

    //tagテーブルのタグ名からidを取得する
    public function getTagID($tagname){
        $this->db->select('id');
        $array = array('tag' => $tagname);
        $query = $this->db->get_where('tag', $array);

        $id = 0;

        //ひとまずこれ。idのみなら綺麗にできないのかな
        foreach($query->result()->id as $i){
            $id = $i;
        }

        return $id;
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

    //tagmapテーブルに登録する
    public function createTagMap($projectID, $tagID){
        $array = array(
            'projectID' => $projectID,
            'tagID' => $tagID
        );

        $this->db->insert('tagmap', $array);
    }

    //tagmapテーブルから削除する
    public function deleteTagMap($projectID, $tagID){
        $array = array(
            'projectID' => $projectID,
            'tagID' => $tagID
        );

        $this->db->delete('tagmap', $array);
    }

	//範囲を指定してプロジェクトを取得
	public function getProject($beginDate,$endDate,$top,$end,$order) {
		$this->db->where("modified BETWEEN '$beginDate' AND '$endDate'");
		$this->db->order_by($order, "desc");
		$result = $this->db->get('project',$top,$end);
		return $result->result();
	}

	//登録されているプロジェクトの総数を取得
	public function getProjectNum($beginDate,$endDate){
		$query = $this->db->query("SELECT * FROM project WHERE modified BETWEEN '$beginDate' AND '$endDate'");
		return $query->num_rows();
	}

}
