<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Haxeon extends CI_Controller {

	public function index() {
		$this->load->model('Model_project');
		$projects = $this->Model_project->getRankingProject();
		$data['ranking'] = array('projects'=>$projects);
		
		$this->load->view('header');
		$this->load->view('haxeon',$data);
		$this->load->view('footer');
	}
}
