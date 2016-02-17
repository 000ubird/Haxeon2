<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//URL手打ち対策
define('LIMIT_MAX', 100);
define('URI_SEGMENT', 6);

class Ranking extends CI_Controller {

	//ランキングページ
	public function index($days = "day", $order = "pv ", $num = 0 ,$offset = 0) {
		$this->load->model('Model_project');
        $this->load->model('Model_favorite');
		$this->load->library('pagination');

		$config['base_url'] = base_url().'ranking/index/'.$days.'/'.$order.'/'.$num.'/';
		if ($num > LIMIT_MAX ) $num = LIMIT_MAX;	//最高数以上の場合は弾く
		$config['per_page'] = $num;		//何ページ目にいるかを保持
		$config['uri_segment'] = URI_SEGMENT;

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

		//検索対象の日時の設定
		$beginDate = date('Y-m-d H:i:s',strtotime('-1 days'));
		$endDate = date('Y-m-d H:i:s');
		switch($days) {
			case 'day':  $beginDate = date('Y-m-d H:i:s', strtotime('-1 days')); 	break;
			case 'week': $beginDate = date('Y-m-d H:i:s', strtotime('-7 days')); 	break;
			case 'all':  $beginDate = date('Y-m-d H:i:s', strtotime('-365 days')); 	break;
			default :    $beginDate = date('Y-m-d H:i:s', strtotime('-1 days')); 	break;
		}

		//ページネーションの設定
		$config['total_rows'] = $this->Model_project->getProjectNum($beginDate,$endDate);
		$this->pagination->initialize($config);

		//条件に一致するプロジェクトを取得
		$projects = $this->Model_project->getProject($beginDate, $endDate, $config['per_page'], $offset, $order);
        //お気に入り登録情報の取得
		$favorites = $this->Model_favorite-> getFavorite($this->session->userdata('userID'));
		//それぞれのパラメータを保持
		$data['ranking'] = array('days'=>$days,'order'=>$order,'num'=>$num,'cur_page'=>$offset,'projects'=>$projects,'favorites'=>$favorites);

		//ビューの表示
		$this->load->view('header');
		$this->load->view('ranking',$data);
		$this->load->view('footer');
	}
}
