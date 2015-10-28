<?php

class Model_project extends CI_Model{

    //データベースにプロジェクト名があったらtrueを返す
    public function isProjectName() {
        $this->db->where(array('projectName' => $this->input->post('projectName'), 'ownerUserID' => $this->session->userdata('userID')));
        $query = $this->db->get('project');

		return ($query->num_rows() > 0);
    }

	//指定したプロジェクトのPV数を増やす
	public function pvCountUp($projectID) {
		//プロジェクトのPV数の取得と更新
		$array = array('projectID' => $projectID);
		$query = $this->db->get_where('project', $array);
		foreach ($query->result() as $row) $pv = $row->pv + 1;
		$this->db->update('project', array('pv' => $pv), $array);

		//デイリーランキングのPV数の取得と更新
		$array = array('proID' => $projectID);
		$query = $this->db->get_where('day_ranking', $array);
		foreach ($query->result() as $row) $pv = $row->pv + 1;
		$this->db->update('day_ranking', array('pv' => $pv), $array);
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
//        $this->db->select('id');
        $array = array('tag' => $tagname);
        $query = $this->db->get_where('tag', $array);

        $id = 0;

        //ひとまずこれ。idのみなら綺麗にできないのかな
        foreach($query->result() as $i){
            $id = $i->id;
        }
        return $id;
    }

    //タグをtagテーブルに登録する
    //返り値 登録したタグのid
    public function registTag($tagname){
        $array = array(
            'tag' => $tagname
        );

        $this->db->insert('tag', $array);

        //return $this->db->insert_id();
    }

    //tagmapテーブルに登録する
    public function registTagMap($projectID, $tagID, $tmpPro){
        $array = array(
            'projectID' => $projectID,
            'tagID' => $tagID,
			'tmpPro' => $tmpPro
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

    //tagmapテーブルに登録されている個数を返す
    public function countTagMap($projectID){
        $array = array(
            'projectID' => $projectID
        );

        $query = $this->db->get_where('tagmap', $array);
        return $query->num_rows();
    }

    //tagmapテーブルの重複チェック
    //重複していたらtrue
    public function checkOverlap($projectID, $tagID){
        $array = array(
            'projectID' => $projectID,
            'tagID' => $tagID
        );

        $query = $this->db->get_where('tagmap', $array);

        return ($query->num_rows() > 0);
    }
	
	//タグテーブルから引数のタグを持つタグIDを返す
	//存在しなかった場合は0を返す
	public function searchTagID($str) {
		$this->db->select('id')->from('tag')->where('tag', array('tag' => $str));
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	//タグマップテーブルから引数のタグIDを持つプロジェクトIDを返す
	public function getProIDfromTagmap($tagID) {
		$this->db->select('projectID')->from('tagmap')->where('tagID', $tagID);
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	//検索単語と検索対象からプロジェクトを検索
	//$searchFor => 0:tag, 1:projectName, 2:projectID, 3:accountID
	public function searchProject($searchStr, $searchFor) {
		//プロジェクトテーブルからプロジェクトIDを検索
		$this->db->select('*')->from('project');
		
		//検索文字列と完全一致するタグを検索し、プロジェクトIDで検索
		if ($searchFor[0]) {
			//タグテーブルから条件に一致するプロジェクトIDを取得する
			$tagID = $this->Model_project->getTagID($searchStr);
			$result = $this->Model_project->getProIDfromTagmap($tagID);
			
			//取得したプロジェクトIDからクエリ文を生成
			$this->db->from('project');
			foreach($result as $id) {
				$this->db->or_where('projectID', $id['projectID']);
			}
		}
		
		//検索文字列と部分一致するプロジェクト名を検索
		if ($searchFor[1]) {
			// OR projectName LIKE '%【検索文字列】%'
			$this->db->or_like('projectName', $searchStr); 
		}
		
		//検索文字列と完全一致するプロジェクトIDを検索
		if ($searchFor[2]) {
			// OR projectID = '%【検索文字列】%'
			$this->db->or_where('projectID', $searchStr);
		}
		
		//検索文字列と部分一致するアカウント名を検索
		if ($searchFor[3]) {
			// OR ownerUserID LIKE '%【検索文字列】%'
			$this->db->or_like('ownerUserID', $searchStr); 
		}
		
		//クエリの実行
		$query = $this->db->get();
		
		//デバッグ
		//echo $this->db->last_query()."<br/><br/>";
		
		return $query->result_array();
	}
	
	//プロジェクトIDを指定してプロジェクトを取得する
	public function getOneProject($id) {
		$query = $this->db->get_where('project', array('projectID' => $id));
		return $query->result();
	}

	//範囲を指定してプロジェクトを取得
	public function getProject($beginDate,$endDate,$top,$end,$order) {
		$this->db->where("modified BETWEEN '$beginDate' AND '$endDate'");
		$this->db->order_by($order, "desc");
		$result = $this->db->get('project',$top,$end);
		return $result->result();
	}

	//デイリーランキングページからプロジェクトを9個取得
	public function getRankingProject() {
		$this->db->order_by("pv","desc");
		$this->db->limit(9);
		$result = $this->db->get('day_ranking');
		return $result->result();
	}

	//登録されているプロジェクトの総数を取得
	public function getProjectNum($beginDate,$endDate){
		$query = $this->db->query("SELECT * FROM project WHERE modified BETWEEN '$beginDate' AND '$endDate'");
		return $query->num_rows();
	}

	//指定したユーザーが所持するプロジェクトを全て削除(アカウント削除時)
	public function deleteProject($userID){
		$this->db->delete('project', array('ownerUserID'=>$userID));
        $this->deleteDayRanking($userID);
	}

    //プロジェクトをひとつ削除する
    public function deleteOneProject($projectID, $userID){
        $this->db->delete('project', array('ownerUserID'=>$userID, 'projectID'=>$projectID));
        $this->db->delete('day_ranking', array('usrID'=>$userID, 'proID'=>$projectID));
    }

    //day_rankingから削除
    public function deleteDayRanking($userID){
        $this->db->delete('day_ranking', array('usrID'=>$userID));
    }
	
}
