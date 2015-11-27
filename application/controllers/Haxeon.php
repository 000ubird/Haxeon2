<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Haxeon extends CI_Controller {

	public function index() {
		$this->load->model('Model_project');
		$ranking_projects = $this->Model_project->getRankingProject();
		$table_project = array();
		
		//デイリーランキングテーブルから取得したプロジェクトIDで、プロジェクトテーブルを検索
		foreach($ranking_projects as $project) {
			$pro = $this->Model_project->getOneProject($project->proID);
			
			//公開プロジェクトのみを配列に追加する
			if ($pro[0]->isPublic) {
				$pro[0]->pv = $project->pv;	//デイリーランキングからPV数を取得
				array_push($table_project,$pro);
			}
		}
		
		$data['ranking'] = array('projects'=>$table_project);
		
		$this->load->view('header');
		$this->load->view('haxeon',$data);
		$this->load->view('footer');
	}
}
