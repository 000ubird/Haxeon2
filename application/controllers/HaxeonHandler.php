<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//try-haxeからアクセスする
class HaxeonHandler extends CI_Controller {
	
	public function index() {
		//echo "this is index";
	}

	public function get_is_login() {
		if(($this->session->userdata('userID') == null)) {
			echo '{ "error":"not login"}';
			exit;
		}
	
		if(($this->session->userdata('projectName') == null)) {
			echo '{"userID":"'.$this->session->userdata('userID').'","projectName":""}';
			exit;
		}
		
		echo '{"userID":"'.$this->session->userdata('userID').'","projectName":"'.$this->session->userdata('projectName').'"}';
	}
	
	public function update_pv($projectID) {
		$this->load->model('model_project');
		$this->model_project->pvCountUp($projectID);
	}
}
