<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ranking extends CI_Controller {

	public function index() {
		$this->load->view('header');
		$this->load->view('ranking');
		$this->load->view('footer');
	}
	
	public function paging($days, $order, $offset) {
		$this->load->model('model_project');
		$this->load->library('pagination');
		
		$config['base_url'] = 'http://localhost/haxeon2/ranking/paging/'.$days.'/'.$order.'/';
		$config['total_rows'] = $this->model_project->getProjectNum();
		$config['per_page'] = 20;
		$config['uri_segment'] = 5;
		
		//Viewに関する指定
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li class="waves-effect"><i class="material-icons">';
		$config['first_link'] = 'fast_rewind';
		$config['first_tag_close'] = '</i></li>';
		
		$config['last_tag_open'] = '<li class="waves-effect"><i class="material-icons">';
		$config['last_link'] = 'fast_forward';
		$config['last_tag_close'] = '</i></li>';
		
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		
		$config['num_tag_open'] = '<li class="waves-effect">';
		$config['num_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li class="waves-effect"><i class="material-icons">';
		$config['next_link'] = '&gt;';
		$config['next_tag_close'] = '</i></li>';
		
		$config['prev_tag_open'] = '<li class="waves-effect"><i class="material-icons">';
		$config['prev_link'] = '&lt;';
		$config['prev_tag_close'] = '</i></li>';
		
		$this->pagination->initialize($config); 
		
		$this->load->view('header');
		$this->load->view('ranking');
		$this->load->view('footer');
		
		$beginDate = date('Y-m-d H:i:s',strtotime('-1 days'));
		$endDate = date('Y-m-d H:i:s');
		switch($days) {
			case 'day':  $beginDate = date('Y-m-d H:i:s', strtotime('-1 days')); break;
			case 'week': $beginDate = date('Y-m-d H:i:s', strtotime('-7 days')); break;
			case 'all':  $beginDate = date('Y-m-d H:i:s', strtotime('-365 days')); break;
			default :    $beginDate = date('Y-m-d H:i:s', strtotime('-1 days')); break;
		}
		
		$pro = $this->model_project->getProject($beginDate, $endDate, $config['per_page'], $offset, $order);
		//print_r($pro);
	}
}
