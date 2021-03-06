<?php

class ModelProject extends CI_Model{

    //データベースにプロジェクト名があったらtrueを返す
    //プロジェクト作成時の重複判定に使用
    public function isProjectName() {
        $this->db->where(array('projectName' => $this->input->post('projectName'), 'ownerUserID' => $this->session->userdata('userID')));
        $query = $this->db->get('project');

		return ($query->num_rows() > 0);
    }

	//指定したプロジェクトのPV数を増やす
    //デイリーランキングテーブルを別で作成しているためこちらも更新している
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
    //プロジェクト設定ページの本人判定で使用
    public function isOwner($projectID) {
        $array = array('projectID' => $projectID, 'ownerUserID' => $this->session->userdata('userID'));
        $query = $this->db->get_where('project', $array);

        return ($query->num_rows() > 0);
    }

    //$projectIDの全てのタグ情報を返す
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

    //タグ名を取得する
    //タグテーブルはidを指定することでタグ名を取得する
    public function getTag($id) {
        $array = array('id' => $id);
        $query = $this->db->get_where('tag', $array);

        $tagname = "";
        foreach ($query->result() as $row) {
            $tagname = $row->tag;
        }

        return $tagname;
    }

    //tagテーブルのタグ名からidを取得する
    public function getTagID($tagname) {
        $array = array('tag' => $tagname);
        $query = $this->db->get_where('tag', $array);

        $id = 0;

        //ひとまずこれ。idのみなら綺麗にできないのかな
        foreach($query->result() as $i) {
            $id = $i->id;
        }
        return $id;
    }

    //タグの有無を取得する。あればtrueになる
    public function isTag($tagname) {
        $array = array('tag' => $tagname);
        $query = $this->db->get_where('tag', $array);

        return ($query->num_rows() > 0);
    }

    //新しいタグ名をtagテーブルに登録する
    public function registTag($tagname) {
        $array = array(
            'tag' => $tagname
        );

        $this->db->insert('tag', $array);
    }

    //tagmapテーブルに登録する
    public function registTagMap($projectID, $tagID, $tmpPro) {
        $array = array(
            'projectID' => $projectID,
            'tagID' => $tagID,
			'tmpPro' => $tmpPro
        );

        $this->db->insert('tagmap', $array);
    }

    //tagmapテーブルから削除する
    public function deleteTagMap($projectID, $tagID) {
        $array = array(
            'projectID' => $projectID,
            'tagID' => $tagID
        );

        $this->db->delete('tagmap', $array);
    }

    //tagmapテーブルに$projectIDが登録されている数を返す
    //タグの登録数上限の判定で使用している
    public function countTagMap($projectID) {
        $array = array(
            'projectID' => $projectID
        );

        $query = $this->db->get_where('tagmap', $array);
        return $query->num_rows();
    }

    //tagmapテーブルの重複チェック
    //重複していたらtrue
    public function checkOverlap($projectID, $tagID) {
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

	//$tagIDを持つ全てのプロジェクトIDを返す
    //タグ検索など
	public function getProIDfromTagmap($tagID) {
		$this->db->select('projectID')->from('tagmap')->where('tagID', $tagID);
		$query = $this->db->get();

		return $query->result_array();
	}

	//検索単語($searchStr)と検索対象($searchFor)からプロジェクトを検索
	//$searchFor => 0:tag, 1:projectName, 2:projectID, 3:accountID
	public function searchProject($searchStr, $searchFor, $sortBy) {
		//プロジェクトテーブルからプロジェクトIDを検索
		$this->db->select('*')->from('project');

		//検索文字列と完全一致するタグを検索し、プロジェクトIDで検索
		if ($searchFor[0]) {
			//タグテーブルから条件に一致するプロジェクトIDを取得する
			$tagID = $this->ModelProject->getTagID($searchStr);
			$result = $this->ModelProject->getProIDfromTagmap($tagID);

			//取得したプロジェクトIDからクエリ文を生成
			//取得してきたIDがなかった場合はダミープロジェクトIDで検索を行う
			if (count($result) == 0) {
				$this->db->from('project');
				$this->db->or_where('projectID', '_____');
			} else {
				$this->db->from('project');
				foreach($result as $id) {
					$this->db->or_where('projectID', $id['projectID']);
				}
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

		//更新日時が新しい順にソートする
		if ($sortBy[0]) {
			$this->db->order_by("modified", "desc");
		}

		//PV数が多い順にソートする
		else if ($sortBy[1]) {
			$this->db->order_by("pv", "desc");
		}

		//名前順にソートする
		else if ($sortBy[2]) {
			$this->db->order_by("projectName", "asc");
		}

		//公開プロジェクトのみ取得
		$this->db->where('isPublic', true);

		//クエリの実行
		$query = $this->db->get();

		//デバッグ
		//echo $this->db->last_query()."<br/><br/>";

		return $query->result_array();
	}

	//指定したプロジェクトIDを取得する
	public function getOneProject($projectID) {
		$query = $this->db->get_where('project', array('projectID' => $projectID));
		return $query->result();
	}

	//範囲を指定してプロジェクトを取得
    //$beginDate, $endDate: 最終更新日時の範囲
    //$top: 取得件数 LIMIT句
    //$end: 開始位置 OFFSET句
	public function getProject($beginDate, $endDate, $top, $end, $order) {
		$this->db->where("modified BETWEEN '$beginDate' AND '$endDate'");

		//公開プロジェクトのみ取得
		$this->db->where('isPublic', true);

		$this->db->order_by($order, "desc");
		$result = $this->db->get('project', $top, $end);
		return $result->result();
	}

	//デイリーランキングページからプロジェクトをlimit個取得
	public function getRankingProject() {
		$this->db->order_by("pv","desc");
		$this->db->limit(12);
		$result = $this->db->get('day_ranking');
		return $result->result();
	}

	//$beginDateから$endDate期間中に登録されたプロジェクトの総数を取得
	public function getProjectNum($beginDate, $endDate) {
		$query = $this->db->query("SELECT * FROM project WHERE modified BETWEEN '$beginDate' AND '$endDate'");
		return $query->num_rows();
	}

	//指定したユーザーが所持するプロジェクトを全て削除(アカウント削除時)
	public function deleteProject($userID) {
		$this->db->delete('project', array('ownerUserID'=>$userID));
        $this->deleteDayRanking($userID);
	}

	//公開/非公開の変更
	public function switchPublic($projectID,$isPublic) {
		$this->db->where('projectID', $projectID);

		//公開プロジェクトの場合は非公開にする
		if($isPublic=='1') {
			$this->db->update('project', array('isPublic' => 0));
		} else {
			$this->db->update('project', array('isPublic' => 1));
		}
	}

    //プロジェクトをひとつ削除する
    public function deleteOneProject($projectID, $userID) {
        $this->db->delete('project', array('ownerUserID'=>$userID, 'projectID'=>$projectID));
        $this->db->delete('day_ranking', array('userID'=>$userID, 'proID'=>$projectID));
        $this->db->delete('comment', array('projectID'=>$projectID));
        $this->db->delete('tagmap', array('projectID'=>$projectID));
        $this->db->delete('favorite', array('projectID'=>$projectID));
    }

    //day_rankingテーブルから削除
    public function deleteDayRanking($userID) {
        $this->db->delete('day_ranking', array('userID'=>$userID));
    }

    //プロジェクトの説明文を取得する
    public function getDescription($projectID) {
        $this->db->select('description');
        $query = $this->db->get_where('project', array('projectID' => $projectID));
        return $query->result();
    }

    //プロジェクトの説明文を更新
    public function updateDescription($projectID, $description){
        $this->db->where('projectID', $projectID);
        $this->db->update('project', array('description' => $description));
    }

}
