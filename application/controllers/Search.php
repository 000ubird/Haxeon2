<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {
	//検索フォームの表示
	public function index() {
		$this->load->view('header');
		$this->load->view('search');
		$this->load->view('footer');
	}
	
	//検索を実行
	public function doSearch() {
		$this->load->view('header');
		
		//検索文字列の取得
		$str = $this->input->get_post('search', TRUE);
		echo $str."<br>";
		
		//チェックボックス情報の取得
		if (set_checkbox('chk[0]', '1')) echo "TAG is checked <br>";
		if (set_checkbox('chk[1]', '2')) echo "ProjectName is checked <br>";
		if (set_checkbox('chk[2]', '3')) echo "ProjectID is checked <br>";
		if (set_checkbox('chk[3]', '4')) echo "AccountID is checked <br>";
		
		$this->load->view('footer');
	}
}
