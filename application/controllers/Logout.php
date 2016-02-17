<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
	//セッションを破棄してログインページに遷移
    public function index() {
        $this->session->sess_destroy();
        redirect("login");
    }
}
