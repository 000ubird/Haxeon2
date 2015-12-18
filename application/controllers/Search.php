<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

	//検索フォームの表示
	public function index() {
		$this->load->view('header');
		$this->load->view('search');
		$this->load->view('footer');
	}

    //検索結果の表示
    public function searchResult($str="", $chk0, $chk1, $chk2, $sort0, $sort1, $sort2) {
		$str = urldecode($str);	//URLデコード
		
		$searchArray = [0, 0, 0, 0];
		if ($chk0 == '1') $searchArray[0] = true;
		if ($chk1 == '1') $searchArray[1] = true;
		if ($chk2 == '1') $searchArray[3] = true;

		$sortBy = [0, 0, 0];
		if ($sort0 == '1') $sortBy[0] = true;
		if ($sort1 == '1') $sortBy[1] = true;
		if ($sort2 == '1') $sortBy[2] = true;

		$this->load->model("Model_project");
		$result['result'] = $this->Model_project->searchProject($str,$searchArray,$sortBy);
		$result['str'] = $str;
		$result['search'] = $searchArray;
		$result['sort'] = $sortBy;

        $this->load->model("Model_favorite");
		
		if ($this->session->userdata('userID') != null) {
			$favorite_list = $this->Model_favorite->getFavorite($this->session->userdata['userID']);
		} else {
			$favorite_list = [];
		}
        $favorite_projects = array();
        foreach ($favorite_list as $f) {
            //プロジェクトテーブルから情報を取得
            $project = $this->Model_project->getOneProject($f->projectID);

            //ログイン中のユーザが自分のお気に入りリストを閲覧する場合
            if ($this->session->userdata('userID')) {
                //すべてのプロジェクトを取得
                array_push($favorite_projects, $project);
            }
            //ログイン中のユーザが他人のお気に入りリストを閲覧する場合
            else {
                //公開プロジェクトのみ取得
                if($project[0]->isPublic) array_push($favorite_projects, $project);
            }
        }
        $result['favorites'] = $favorite_projects;

        $this->load->view('header');
        $this->load->view('search_result',$result);
        $this->load->view('footer');
    }

	//検索の実行と結果表示
	public function doSearch() {
		//検索文字列の取得
		$str = set_value('search', 'search');
		
		//記号の削除
		$str = preg_replace('/[][}{)(!"#$%&\'~|\*+,\/@.\^<>`;:?_=\\\\-]/i', '', $str);
			
		$searchArray = ['0','0','0'];
		for ($i = 0; $i < 3; $i++) {
			if(set_checkbox('chk['.$i.']', $i)) $searchArray[$i] = '1';
		}

		$sortBy = ['0','0','0'];
		if (set_radio('sort', 'New')) $sortBy[0] = '1';
		else if (set_radio('sort', 'PV')) $sortBy[1] = '1';
		else if (set_radio('sort', 'Name')) $sortBy[2] = '1';

		//バリデーション
		$this->load->library("form_validation");
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		//エラーメッセージの設定
		$this->form_validation->set_rules("search", "検索", "required");
        $this->form_validation->set_message("required", "%s項目を入力して下さい。");

		//正しい場合は検索を実行
        if ($this->form_validation->run()) {
			header("Location: ".base_url()."search/searchResult/".
				$str."/".
				$searchArray[0]."/".
				$searchArray[1]."/".
				$searchArray[2]."/".
				$sortBy[0]."/".
				$sortBy[1]."/".
				$sortBy[2]."/"
			);
		}
		//問題のある文字列が入力された場合は検索画面に戻る
		else {
			$this->index();
		}
	}

}
