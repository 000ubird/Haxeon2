<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Haxeon extends CI_Controller {

	public function index() {
		$this->load->model('Model_project');
        $this->load->model('Model_favorite');

		$ranking_projects = $this->Model_project->getRankingProject();
		$table_project = array();

		//デイリーランキングテーブルから取得したプロジェクトIDで、プロジェクトテーブルを検索
		foreach($ranking_projects as $project) {
			$pro = $this->Model_project->getOneProject($project->proID);

            if($pro) {
                //公開プロジェクトのみを配列に追加する
                if ($pro[0]->isPublic) {
                    $pro[0]->pv = $project->pv;    //デイリーランキングからPV数を取得
                    array_push($table_project, $pro);
                }
            }
		}

		$data['ranking'] = array('projects'=>$table_project);

        $favorite_list = $this->Model_favorite->getFavorite($this->session->userdata['userID']);
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
        $data['favorites'] = $favorite_projects;

		$this->load->view('header');
		$this->load->view('haxeon',$data);
		$this->load->view('footer');
	}
}
