<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function validation(){
        $this->load->helper('form');

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
            //正常な入力のとき
            $id = $_POST['userID'];
            $pass = $_POST['password'];

            $result = $this->checkDB($id, $pass);

            if(!$result){
                echo "failed";
            }else{
                echo "login";
            //TODO セッション登録など、ログインを保持する部分の実装
                $data = array(
                    'userID' => $id,
                );
                $this->session->set_userdata($data);

                redirect("haxeon2");
            }

        }else{
            //初回、もしくはエラーがあったとき
            $this->index();
        }
    }

    private function checkDB($id, $password){
        /**
         * SELECT * FROM 'account' WHERE 'userID'=$id AND 'userPass'=$password
         * の結果の数をチェックする
         */
        $this->db->from('account');
        $this->db->where(array('userID' => $id, 'userPass' => $password));
        return $this->db->count_all_results();
    }

    public function index(){
        $this->load->view('login');
    }
}
