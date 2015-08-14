<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {
	
	public function index() {
		$url['commonURL'] = "http://localhost/haxeon2/common/index/";
		
		//ログイン時はアイコンURLを取得する
		if (isset($_COOKIE["PHPSESSID"])){
			//セッションがアクティブでない場合はセッションを起動する
			if (!(session_status() == PHP_SESSION_ACTIVE)) {
				session_start();
			}
			
			$id['id'] = $_SESSION['userID']; 
			$flag['isLogin'] = false;
			
			$query = $this->db->get_where('account', array('userID' => $_SESSION['userID']));
			
			foreach ($query->result() as $row) {
				$icon['iconURL'] = $row->userIcon;
				$name['userName']= $row->userName;
			}
			$this->load->view('common', $flag, $url, $id, $icon, $name);
		}
		else {
			$flag['isLogin'] = false; 
			$this->load->view('common', $flag, $url);
		}
	}
}