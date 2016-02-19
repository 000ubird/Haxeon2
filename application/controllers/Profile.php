<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//タグの登録上限数
define("TAG_LIMIT", 10);
//プロジェクト、お気に入りの表示数
define("PROJECT_PER_PAGE", 20);
//フォロー、フォロワーの表示数
define("FOLLOW_PER_PAGE", 28);

class Profile extends CI_Controller {
	//トップページの表示
    public function index() {
        $this->load->view('header');
        $this->load->view('haxeon');
        $this->load->view('footer');
    }

	//ユーザIDとプロフィールカテゴリを指定してプロフィール情報を表示
    public function information($userID, $category = "") {
        $this->view($this->getUserData($userID, $category));
    }

    //プロフィールページを表示する本体
    public function view($data) {
        //新しい順にソートしておく
        krsort($data['projects']);
        krsort($data['follow']);
        krsort($data['follower']);
        if($data['favorites'] != null) {
            krsort($data['favorites']);
        }

		//プロフィールページのカテゴリを取得
        $category = $data['category'];

        if (!$category == "") {
            //ページネーション
            $this->load->library('pagination');

            $config['base_url'] = base_url() . 'profile/information/'.$data['userID'].'/' . $category . '/';
            $config['total_rows'] = count($data[$category]);
            $config['per_page'] = PROJECT_PER_PAGE;
            if ($category == 'follow' || $category == 'follower') $config['per_page'] = FOLLOW_PER_PAGE;

            $config['uri_segment'] = 5;

            //Viewに関する指定
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            $config['first_tag_open'] = '<li class="waves-effect"><i class="material-icons">';
            $config['first_link'] = 'fast_rewind';
            $config['first_tag_close'] = '</i></li>';
            $config['last_tag_open'] = '<li class="waves-effect"><i class="material-icons">';
            $config['last_link'] = 'fast_forward';
            $config['last_tag_close'] = '</i></li>';
            $config['cur_tag_open'] = '<li class="active">';
            $config['cur_tag_close'] = '</li>';
            $config['num_tag_open'] = '<li class="waves-effect">';
            $config['num_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li class="waves-effect"><i class="material-icons">';
            $config['next_link'] = '&gt;';
            $config['next_tag_close'] = '</i></li>';
            $config['prev_tag_open'] = '<li class="waves-effect"><i class="material-icons">';
            $config['prev_link'] = '&lt;';
            $config['prev_tag_close'] = '</i></li>';

            $this->pagination->initialize($config);

            if ($category == 'projects' || $category == 'favorites') {
				$data['projects'] = array_slice($data['projects'], $this->uri->segment(5), PROJECT_PER_PAGE);
			}

            //Viewに関する指定
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';

            $config['first_tag_open'] = '<li class="waves-effect"><i class="material-icons">';
            $config['first_link'] = 'fast_rewind';
            $config['first_tag_close'] = '</i></li>';

            $config['last_tag_open'] = '<li class="waves-effect"><i class="material-icons">';
            $config['last_link'] = 'fast_forward';
            $config['last_tag_close'] = '</i></li>';

            $config['cur_tag_open'] = '<li class="active">';
            $config['cur_tag_close'] = '</li>';

            $config['num_tag_open'] = '<li class="waves-effect">';
            $config['num_tag_close'] = '</li>';

            $config['next_tag_open'] = '<li class="waves-effect"><i class="material-icons">';
            $config['next_link'] = '&gt;';
            $config['next_tag_close'] = '</i></li>';

            $config['prev_tag_open'] = '<li class="waves-effect"><i class="material-icons">';
            $config['prev_link'] = '&lt;';
            $config['prev_tag_close'] = '</i></li>';
        }


        $this->load->view('header');
        $this->load->view('profile', $data);
        $this->load->view('footer');
    }

	//
    private function getUserData($userID, $category) {
        $this->load->model('ModelUsers');
        $this->load->model('Model_project');
        $this->load->model('Model_favorite');

		$array = [];
		//ログイン中のユーザが自分のプロフィールを閲覧する場合
		if ($this->session->userdata('userID') == $userID) {
			$data['projects'] = $this->ModelUsers->getProjects($userID);
		}
		//ログイン中のユーザが他人のプロフィールを閲覧する場合
		else {
			$projects = $this->ModelUsers->getProjects($userID);
			//公開プロジェクトだけを抽出する
			foreach($projects as $pro) {
				if ($pro->isPublic) array_push($array, $pro);
			}

			$data['projects'] = $array;
		}

        $data['category'] = $category;
        $data['user'] = $this->ModelUsers->getUserData($userID);
        $data['userID'] = $userID;
        $data['project_total'] = count($data['projects']);
        $data['follow'] = $this->ModelUsers->getFollowInfo($userID);
        $data['follow_total'] = count($data['follow']);
        $data['follower'] = $this->ModelUsers->getFollowedInfo($userID);
        $data['follower_total'] = count($data['follower']);
        $data['isown'] = ($this->session->userdata('userID') == $userID);
        $data['isfollow'] = $this->ModelUsers->getIsFollow($userID);
        $data['isfollowed'] = $this->ModelUsers->getIsFollowed($userID);

		//お気に入りプロジェクトの取得
		$myID = $this->session->userdata('userID');
		$myfavofite_list = $this->Model_favorite->getFavorite($myID);
		$favorite_list = $this->Model_favorite->getFavorite($userID);

		$favorite_projects = array();
		//自分の方
		$my_favorite_projects = array();

        $data['favorites'] = $favorite_projects;
        $data['my_favorites'] = $my_favorite_projects;

        foreach ($favorite_list as $f) {
            //プロジェクトテーブルから情報を取得
            $project = $this->Model_project->getOneProject($f->projectID);

            //ログイン中のユーザが自分のお気に入りリストを閲覧する場合
            if ($this->session->userdata('userID') == $userID) {
                //すべてのプロジェクトを取得
                array_push($favorite_projects, $project);
            } //ログイン中のユーザが他人のお気に入りリストを閲覧する場合
            else {
                //公開プロジェクトのみ取得
                if ($project[0]->isPublic) array_push($favorite_projects, $project);
            }
        }

		foreach ($myfavofite_list as $mf) {
			//プロジェクトテーブルから情報を取得
			$project = $this->Model_project->getOneProject($mf->projectID);
			//ログイン中のユーザが自分のお気に入りリストを閲覧する場合
			$ownUserID = $this->session->userdata('userID');
			if ($ownUserID == $userID) {
				//公開かつ自分のプロジェクトを取得
				if ($project[0]->isPublic || $project[0]->ownerUserID == $ownUserID) {
					array_push($my_favorite_projects, $project);
				}
			}
			//ログイン中のユーザが他人のお気に入りリストを閲覧する場合
			else {
				//公開のプロジェクトを取得
				if ($project[0]->isPublic) {
					array_push($my_favorite_projects, $project);
				}
			}
		}

		//お気に入りがあれば更新する
		$data['favorites'] = $favorite_projects;
		$data['my_favorites'] = $my_favorite_projects;
		$data['favorite_total'] = count($favorite_projects);

        return $data;
    }
}
