<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProjectSettings extends CI_Controller {
    //プロジェクトの説明文を更新
    public function index($projectID) {
		if ($this->session->userdata('userID') == null) header('Location: '.base_url().'login');

        $this->session->set_userdata(array('pid' => $projectID));

        $this->load->model('Model_project');
        $this->load->library('tag');

        //sessionのuserIDとprojectIDの所有者が同じかチェック
        if ($this->Model_project->isOwner($projectID)) {

            $data['tags'] = $this->tag->getTag($projectID);
            $data['projectID'] = $projectID;
            $data['description'] = $this->Model_project->getDescription($projectID);

            $this->load->view('header');
            $this->load->view('projectsettings', $data);
            $this->load->view('footer');
        } else {
            $this->index($projectID);
        }
    }
	
	//プロジェクト説明の入力バリデーション
	public function validation_project() {
		$this->load->library("form_validation");
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		//検証ルールの設定
		//ひとまず500文字程度にしておく
		$this->form_validation->set_rules("description", "プロジェクト説明", 'max_length[500]|callback_description_check');
		$this->form_validation->set_message("max_length", "%sは500文字以内でお願いします");

		$pid = $this->session->userdata('pid');
		$this->load->model("Model_project");

		//プロジェクトの説明
		$des = $_POST['description'];
		//登録処理
		if ($this->form_validation->run()) {
			$this->Model_project->updateDescription($pid, $des);
		} else {
		}

		//元のプロジェクト設定ページに移動する
		header("Location: ".$_SERVER['HTTP_REFERER']);
	}
	
	//プロジェクト説明のバリデーション
    //バリデーションの必要がでたらここに書く
    //2015/11/19 特に制限するものが浮かばないので、trueにしている
    public function description_check($str){
        return true;
    }
	
	//プロジェクトの公開非公開を入れ替える
	public function changePublic($projectID, $isPublic) {
		$this->load->model("Model_project");
		$this->Model_project->switchPublic($projectID, $isPublic);

		//ひとつ前のページに自動的に遷移
		header('Location:'.$_SERVER['HTTP_REFERER']);
	}
	
	//プロジェクトを削除する
    public function delete_project($projectID){
		if ($this->session->userdata('userID') == null) header('Location: '.base_url().'login');

        $this->load->model("Model_project");
        $userID = $this->session->userdata('userID');
        $this->Model_project->deleteOneProject($projectID, $userID);

        header('Location: '.base_url().'profile/information/'.$userID);
    }
}
