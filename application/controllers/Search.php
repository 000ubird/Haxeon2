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
		
		//データベースから検索
		$this->load->model("Model_project");
		$result = $this->Model_project->searchProject($str,$searchArray);
		
		//デバッグ
		foreach($result as $row){
			echo $row['projectID'].$row['ownerUserID']."<br>";
		}
		
		//Viewを表示
		$this->load->view('header');
		//$this->load->view('search_result');
		$this->load->view('footer');
	}
}
