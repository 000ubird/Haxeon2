<?php
class Site extends CI_Controller {

	public function index() {
		$this->top();
	}

	//トップページの表示
	public function top() {
		$flag['isLogin'] = false;
		$icon = "";
		if (isset($_SESSION['userID'])) {
			$flag['isLogin'] = true;
			$this->load->model("model_users");

			echo $icon['url'] = $this->model_users->get_icon_url($_SESSION['userID']);

			$this->load->view("header",array($flag,$icon));
		}
		else {
			$this->load->view("header",$flag);
		}

		$this->load->view("haxeon");
		$this->load->view("footer");
	}
}

?>
