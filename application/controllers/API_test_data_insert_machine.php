<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API_test_data_insert_machine extends CI_Controller {

	public function index() {
		$i = 0;
		$add_num = 500;		//1000以上はタイムアウトする可能性有り
		
		while ($i < $add_num) {
			//アカウント追加
			$user1 = array(
				'userID' => "Tom".$i,
				'userPass' => $this->makeRandStr(8),
				'userName' => "Tom".$i,
				'userIcon' => "../../img/icon/default.jpg",
				'userMail' => "tom@gmail.com",
			);
			$this->db->insert('account', $user1);
			
			$user2 = array(
				'userID' => "Jack".$i,
				'userPass' => $this->makeRandStr(8),
				'userName' => "Jack".$i,
				'userIcon' => "../../img/icon/default.jpg",
				'userMail' => "jack@gmail.com",
			);
			$this->db->insert('account', $user2);
			
			//プロジェクト追加
			$project1 = array(
				'projectID' => $this->makeRandStr(5),
				'projectName' => "HelloWorld_Tom".$i,
				'ownerUserID' => "Tom".$i,
				'pv' => $i,
				'fork' => rand(),
				'url' => "http://localhost/haxeon2/try-haxe/index.html#",
			);
			$this->db->insert('project', $project1);
			
			$project2 = array(
				'projectID' => $this->makeRandStr(5),
				'projectName' => "HelloWorld_Jack".$i,
				'ownerUserID' => "Jack".$i,
				'pv' => $i,
				'fork' => rand(),
				'url' => "http://localhost/haxeon2/try-haxe/index.html#",
			);
			$this->db->insert('project', $project2);
			
			//フォロワー追加
			for ($j = 0; $j < 10; $j++ ) {
				$follow = array(
					'userID' => "Tom".$i,
					'userFollowingID' => "Jack".$j,
				);
				$this->db->insert('follow', $follow);
			}
			
			$i++;
		}
		
		echo "<h1>complete!</h1>";
	}
	
	public function makeRandStr($length) {
		static $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
		$str = '';
		for ($i = 0; $i < $length; ++$i) {
			$str .= $chars[mt_rand(0, 61)];
		}
		return $str;
	}
}
