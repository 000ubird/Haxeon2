<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function validation(){
        //フォームバリデーションライブラリを呼び出し
        $this->load->library("form_validation");

        $this->form_validation->set_error_delimiters('<div class="error">','</div>');

        /**
         * required : 必要事項
         * "|" 区切りで以下のオプションを付けたい
         * trim : バリデーション実行前に、文字列の最初と最後の空白を自動的に削除
         * xss_clean : クロスサイトスクリプティングを禁止
         * md5 : 暗号化処理
         */
        $this->form_validation->set_rules("userID", "ユーザID", "required");
        $this->form_validation->set_rules("password", "パスワード", "required");

        $this->form_validation->set_message("required", "%sが入力されていません");

        if($this->form_validation->run()){
            //正常なとき
            $data['userID'] = $_POST['userID'];
            $data['password'] = $_POST['password'];

            $result = $this->checkDB($_POST['userID'], $_POST['password']);
            echo $result;

            //データベースにポストする処理へ委譲
            // redirect("signin/postdb");
        }else{
            //初回、もしくはエラーがあったとき
            $this->index();
        }
    }

    private function checkDB($id, $password){
//        $this->db->get_where('account', array('userID' => $id, 'userPass' => $password));
        $this->db->from('account');
        $this->db->where(array('userID' => $id, 'userPass' => $password));
        return $this->db->count_all_results();
    }

    public function index(){
        $this->load->view('login');
    }
}
