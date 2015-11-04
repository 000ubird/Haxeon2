<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

	//検索フォームの表示
	public function index() {
		$this->load->view('header');
		$this->load->view('search');
		$this->load->view('footer');
	}
	
	//検索の実行と結果表示
	public function doSearch() {
		//検索文字列の取得
		$str = set_value('search', 'search');
		
		//チェックボックス情報の取得
		$searchArray = [
			set_checkbox('chk[0]', 0),	//tag
			set_checkbox('chk[1]', 1),	//projectName
			set_checkbox('chk[2]', 2),	//projectID
			set_checkbox('chk[3]', 3),	//accountID
		];
		$sortBy = [
			set_radio('sort', 'New'),	//new
			set_radio('sort', 'PV'),	//pv
			set_radio('sort', 'Name')	//name
		];
		
		//バリデーション
		$this->load->library("form_validation");
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
				
		//エラーメッセージの設定
		$this->form_validation->set_rules("search", "検索", "alpha_numeric");
        $this->form_validation->set_message("alpha_numeric", "%s は半角英数字で入力してください。");
		
		//正しい場合は検索を実行
        if ($this->form_validation->run()) {
			//データベースから検索
			$this->load->model("Model_project");
			$result['result'] = $this->Model_project->searchProject($str,$searchArray,$sortBy);
			$result['str'] = $str;
			
			//Viewを表示
			$this->load->view('header');
			$this->load->view('search_result',$result);
			$this->load->view('footer');
		}
		//問題のある文字列が入力された場合は検索画面に戻る
		else {
			$this->load->view('header');
			$this->load->view('search');
			$this->load->view('footer');
		}
	}
	
}
