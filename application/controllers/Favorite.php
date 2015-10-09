<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Favorite extends CI_Controller {

    public function index(){

    }

    public function regist_favorite($projectID) {
		//プロジェクトテーブルからtmpIDの情報を取得
		$this->load->model('Model_project');
		$result = $this->Model_project->getOneProject($projectID);
		foreach ($result as $row) {
			$tmpPro = $row->tmpPro;
		}
		
        $this->load->model('Model_favorite');
        $this->Model_favorite->favorite($this->session->userdata('userID'), $projectID,$tmpPro);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function release_favorite($projectID){
        $this->load->model('Model_favorite');
        $this->Model_favorite->release_favorite($this->session->userdata('userID'), $projectID);
        redirect($_SERVER['HTTP_REFERER']);
    }

}
