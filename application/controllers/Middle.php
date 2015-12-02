<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Middle extends CI_Controller{

    public function index(){
        $this->load->view('header');
        $this->load->view('middle');
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

    //取得したデータをビューの引数にする
}
