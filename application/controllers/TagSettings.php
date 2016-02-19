<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//タグの登録上限数
define("TAG_LIMIT", 10);

class TagSettings extends CI_Controller {

    //タグ情報を更新
    public function index($projectID) {
		if ($this->session->userdata('userID') == null) header('Location: '.base_url().'login');

		$this->session->set_userdata(array('pid' => $projectID));

        $this->load->model('ModelProject');
        $this->load->library('tag');

        $data['tags'] = $this->tag->getTag($projectID);
        $data['projectID'] = $projectID;

        $this->load->view('header');
        $this->load->view('tagsettings', $data);
        $this->load->view('footer');
    }

	//タグ入力のバリデーション
	public function validationTag(){
		$this->load->library("form_validation");
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->form_validation->set_rules("tag", "タグ", "callback_checkTagTable");

		$pid = $this->session->userdata('pid');
		$tag = $_POST['tag'];

		//タグに関する登録
		if (strlen($tag) > 0) {
			$this->load->model("ModelProject");
			//正しい場合は登録処理
			if ($this->form_validation->run()) {
				//タグマップテーブルの登録数についての確認
				//入力を保持
				$tag = $this->input->post('tag');

				if (!$this->checkTag($tag)) {
					//タグテーブルに存在しないタグのとき
					$this->ModelProject->registTag($tag);
				}

				//idを取得
				$tagid = $this->ModelProject->getTagID($tag);

				//プロジェクトテーブルからtmpIDの情報を取得
				$this->load->model('ModelProject');
				$result = $this->ModelProject->getOneProject($pid);
				foreach ($result as $row) {
					$tmpPro = $row->tmpPro;
				}

				//マップに登録
				$this->ModelProject->registTagMap($pid, $tagid, $tmpPro);
			}
		}
		//処理が終わったらとりあえず同じ画面を表示する
		$this->index($pid);
	}

	//タグ情報に関するデータベースを確認
    public function checkTagTable($str){
        $this->load->model("ModelProject");
        $pid = $this->session->userdata('pid');

        //タグマップテーブルの登録数についての確認
        if($this->ModelProject->countTagMap($pid) == TAG_LIMIT){
            $this->form_validation->set_message("checkTagTable", 'タグ登録数の上限は'. TAG_LIMIT .'個です');
            return false;
        }

        $tagid = $this->ModelProject->getTagID($str);

        if($this->ModelProject->checkOverlap($pid, $tagid)){
            $this->form_validation->set_message("checkTagTable", '入力した%sはすでに登録されています');
            return false;
        }

        return true;
    }

	//タグテーブルの重複チェック
    public function checkTag($tagname) {
        $this->load->model("ModelProject");
		//重複していたら真
        if($this->ModelProject->isTag($tagname)){
            return true;
        }else{
            return false;
        }
    }

	public function deleteTagmap($tagname){
		$this->load->model("ModelProject");

		$tagname = urldecode($tagname);
		file_put_contents("out.txt", $tagname);
		$tagID = $this->ModelProject->getTagID($tagname);

		$pid = $this->session->userdata('pid');
		$this->ModelProject->deleteTagMap($pid, $tagID);

		$this->index($pid);
	}
}
