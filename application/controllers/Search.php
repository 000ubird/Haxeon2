<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('NUM_CHECKBOX', 4);	//サーチ画面のチェックボックスの数

class Search extends CI_Controller {

	//検索フォームの表示
	public function index() {
		$this->load->view('header');
		$this->load->view('search');
		$this->load->view('footer');
	}
	
	//検索を実行
	public function doSearch() {
		//検索文字列の取得
		$str = $this->input->get_post('search', TRUE);
		
		//チェックボックス情報の取得
		//0:tag, 1:projectName, 2:projectID, 3:accountID
		$searchArray = [false, false, false, false];
		for ($i = 0; $i < NUM_CHECKBOX; $i++ ) {
			//チェックが付いていた所だけtrueを代入する
			if (set_checkbox('chk['.$i.']', $i)) $searchArray[$i] = true;
		}
		
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
			$result['result'] = $this->Model_project->searchProject($str,$searchArray);
			$result['str'] = $str;
			$result['chkbox'] = $searchArray;
			
			//Viewを表示
			$this->load->view('header');
			$this->load->view('search_result',$result);
			$this->load->view('footer');
		} else {
			$this->load->view('header');
			$this->load->view('search');
			$this->load->view('footer');
		}
	}
	
}
