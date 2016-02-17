<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//try-haxeとHaxeonのデータのやり取りを行うクラス
class HaxeonHandler extends CI_Controller {

	public function index() {
		//echo "this is index";
	}

	//ログイン状態をechoする
	public function get_is_login() {
        $userID = $this->session->userdata('userID');
        $projectName = $this->session->userdata('projectName');

		if(($userID == null)) {
			echo '{"error":"not login"}';
			exit;
		}

		if(($projectName == null)) {
			echo '{"userID":"'.$userID.'","projectName":""}';
			exit;
		}
		
		//ログイン中のユーザーIDと編集中のプロジェクト名を出力
		echo '{"userID":"'.$userID.'","projectName":"'.$projectName.'"}';
	}

	//指定したプロジェクトのPV数を増やす
	public function update_pv($projectID) {
		$this->load->model('Model_project');
		$this->Model_project->pvCountUp($projectID);
	}

	//プロジェクトの説明文を取得する
    public function get_description($projectID = ""){
        $this->load->model('Model_project');
        $description = $this->Model_project->getDescription($projectID);

        if($description) echo nl2br(htmlspecialchars($description[0]->description));
    }
}
