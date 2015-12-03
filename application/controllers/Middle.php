<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Middle extends CI_Controller{

    public function index(){
        $this->load->view('header');
        $this->load->view('middle');
        $this->load->view('footer');
    }

    //取得したデータをビューの引数にする
    public function detail($projectID){
        $data = array(); //引き渡すデータ
        $data['program'] = $this->getProgramData($projectID); //プログラム文字列

        $this->load->model('Model_project');
        $information = $this->Model_project->getOneProject($projectID);
        $i = $information[0]; //この後でたくさん使うので変数化

        $data['projectID'] = $projectID;
        $data['projectName'] = $i->projectName;
        $data['owner'] = $i->ownerUserID;
        $data['pv'] = $i->pv;
        $data['fork'] = $i->fork;
        $data['originUserID'] = $i->originUserID;
        $data['modified'] = $i->modified;
        $data['description'] = $i->description;

        $this->load->model('Model_project');
        $this->load->library('tag');

        $data['tags'] = $this->tag->getTag($projectID);

        $this->load->view('header');
        $this->load->view('middle', $data);
        $this->load->view('footer');
    }

    //プロジェクトのデータの取得
    //プロジェクトのhxファイル読み込み
    public function getProgramData($projectID){
        //ファイルの場所
        $filepath = 'try-haxe/tmp/'.$projectID;
        //$filepathのファイルリストを作成する
        $files = scandir($filepath);

        //正規表現で*.hxファイル名リストをつくる。実際はファイル名は1つしかこないはず
        $reg = '/.*?\.hx/';
        $filename = implode(preg_grep($reg, $files)); //パターンマッチした結果を文字列化

        //$filenameの内容を取得
        return file_get_contents($filepath.'/'.$filename);
    }

    //コメントのバリデーション
    public function validation_comment(){
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules("comment", "コメント", "min_length[5]");
        $this->form_validation->set_message("min_length", "%s は5文字以上で入力してください。");

        if ($this->form_validation->run()){
            //投稿するメソッドを作る
            //ビューを呼び出す(リダイレクト)
        }
    }
}
