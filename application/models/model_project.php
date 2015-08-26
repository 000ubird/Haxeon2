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
		$this->db->update('project', array('pv'=>$pv ),$array);
	}

    //プロジェクト所有者とログインユーザが同一ならtrueを返す
    public function isOwner($projectID) {
        $array = array('projectID' => $projectID, 'ownerUserID' => $this->session->userdata('userID'));
        $query = $this->db->get_where('project', $array);

        return ($query->num_rows() > 0);
    }

    //プロジェクト設定ページに必要な情報を返す
    public function getProjectInfo($projectID) {

    }

}
