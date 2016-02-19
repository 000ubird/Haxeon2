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
		$this->load->model('ModelProject');
		$this->ModelProject->pvCountUp($projectID);
	}

	//プロジェクトの説明文を取得する
    public function get_description($projectID = ""){
        $this->load->model('ModelProject');
        $description = $this->ModelProject->getDescription($projectID);

        //文字列と改行文字をhtmlに対応した形に
        if($description) echo nl2br(htmlspecialchars($description[0]->description));
    }
}
