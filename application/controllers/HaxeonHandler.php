<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//try-haxeからアクセスする
class HaxeonHandler extends CI_Controller {

	public function index() {
		//echo "this is index";
	}

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

        //projectIDを取得したい。できれば説明文の取得ができる
        //Model_project()->getDescription($projectID)をしたい
        //現在はhelloが入っているが、ここに説明文を入れたい
//        $this->model->Model_project();
		echo '{"userID":"'.$userID.'","projectName":"'.$projectName.'"}';
	}

	public function update_pv($projectID) {
		$this->load->model('Model_project');
		$this->Model_project->pvCountUp($projectID);
	}

    public function get_description($projectID){
        $this->load->model('Model_project');
        $description = $this->Model_project->getDescription($projectID);

        echo $description[0]->description;
    }
}
