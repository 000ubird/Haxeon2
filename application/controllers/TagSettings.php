<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TagSettings extends CI_Controller {

    //タグ情報を更新
    public function tagsettings($projectID) {
		if ($this->session->userdata('userID') == null) header('Location: '.base_url().'login');

		$this->session->set_userdata(array('pid' => $projectID));

        $this->load->model('Model_project');
        $this->load->library('tag');

        $data['tags'] = $this->tag->getTag($projectID);
        $data['projectID'] = $projectID;

        $this->load->view('header');
        $this->load->view('tagsettings', $data);
        $this->load->view('footer');
    }
	
	//タグ入力のバリデーション
	public function validation_tag(){
		$this->load->library("form_validation");
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->form_validation->set_rules("tag", "タグ", "callback_tag_table_check");

		$pid = $this->session->userdata('pid');
		$tag = $_POST['tag'];

		//タグに関する登録
		if (strlen($tag) != 0) {
			$this->load->model("Model_project");
			//正しい場合は登録処理
			if ($this->form_validation->run()) {
				//タグマップテーブルの登録数についての確認
				//入力を保持
				$tag = $this->input->post('tag');

				if (!$this->tag_check($tag)) {
					//タグテーブルに存在しないタグのとき
					$this->Model_project->registTag($tag);
				}

				//idを取得
				$tagid = $this->Model_project->getTagID($tag);

				//プロジェクトテーブルからtmpIDの情報を取得
				$this->load->model('Model_project');
				$result = $this->Model_project->getOneProject($pid);
				foreach ($result as $row) {
					$tmpPro = $row->tmpPro;
				}

				//マップに登録
				$this->Model_project->registTagMap($pid, $tagid, $tmpPro);
			}
		}
		//処理が終わったらとりあえず同じ画面を表示する
		header('Location:'.base_url().'profile/tagsettings/'.$pid);
	}

	//タグ情報に関するデータベースを確認
    public function tag_table_check($str){
        $this->load->model("Model_project");
        $pid = $this->session->userdata('pid');

        //タグマップテーブルの登録数についての確認
        if($this->Model_project->countTagMap($pid) == TAG_LIMIT){
            $this->form_validation->set_message("tag_table_check", 'タグ登録数の上限は'. TAG_LIMIT .'個です');
            return false;
        }

        $tagid = $this->Model_project->getTagID($str);

        if($this->Model_project->checkOverlap($pid, $tagid)){
            $this->form_validation->set_message("tag_table_check", '入力した%sはすでに登録されています');
            return false;
        }

        return true;
    }
	
	    //タグテーブルの重複チェック
    public function tag_check($tagname) {
        $this->load->model("Model_project");
		//重複していたら真
        if($this->Model_project->isTag($tagname)){
            return true;
        }else{
            return false;
        }
    }
