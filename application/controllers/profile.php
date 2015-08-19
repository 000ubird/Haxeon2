<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function index(){
        $this->load->view('profile');
    }

    /**
     * 必要な処理
     * プロフィールの取得
     * フォロー、フォロワーの取得
     * 作成したプロジェクトの取得
     */
}
