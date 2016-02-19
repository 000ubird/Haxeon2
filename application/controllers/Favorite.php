<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Favorite extends CI_Controller {

    public function index(){

    }

	//プロジェクトをお気に入りに登録
    public function regist_favorite($projectID) {
		//プロジェクトテーブルからtmpIDの情報を取得
		$this->load->model('ModelProject');
		$result = $this->ModelProject->getOneProject($projectID);
		foreach ($result as $row) {
			$tmpPro = $row->tmpPro;
		}

        $this->load->model('ModelFavorite');
        $this->ModelFavorite->setFavorite($this->session->userdata('userID'), $projectID,$tmpPro);

        $this->ModelFavorite->updateFavoriteCount($projectID);

        redirect($_SERVER['HTTP_REFERER']);
    }

	//お気に入り情報を削除
    public function release_favorite($projectID){
        $this->load->model('ModelFavorite');
        $this->ModelFavorite->unsetFavorite($this->session->userdata('userID'), $projectID);
        $this->ModelFavorite->updateFavoriteCount($projectID);
        redirect($_SERVER['HTTP_REFERER']);
    }

}
