<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Haxeon2 extends CI_Controller {
	
	public function index() {
		$this->load->view('header');
		$this->load->view('haxeon2');
		$this->load->view('footer');
	}
}
