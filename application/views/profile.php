
<?php
define("PROJECTS", "projects");
define("FAVORITES", "favorites");
define("FOLLOW", "follow");
define("FOLLOWER", "follower");
define("MAX_PROJECTS", 4);
define("MAX_FOLLOW", 12);
define("MAX_FAVORITE", 4);

foreach($user as $row){
    $uid = $row->userID;
    $uname = $row->userName;
    $icon = $row->userIcon;
    $comment = $row->userProfile;
    $url = $row->userURL;
    $email = $row->userMail;
}
echo '<h3>'.$uname.' さんのプロフィール</h3>';
echo '<div class="profile row">';

echo '    <div class="icons col s3" style="text-align: center">';
echo '      <img class="responsive-img" src="'. $icon .'" width="100" height="100">';
echo '      <h4 class="truncate">'. $uname. '<br><small><a href="'.base_url().'profile/information/'.$uid.'">@'.$uid.'</a></small></h4>';

//プロフィール設定ページへのリンク
if($this->session->userdata('userID') == $uid && $this->session->userdata('userID') !=null ) {
    echo '<a href="' . base_url() . 'profile/profilesettings/' . $uid . '"><i class="material-icons">settings</i>アカウント設定</a>';
}else{
    //自分以外のユーザーのときはプロフィール設定をしないため何も表示しない
}

echo '    </div>';

$info = 'profile/information/';
echo '    <ul class="info col s8 offset-s1">';
echo '      <li class="name">公開ネーム : '. $uname .'</li>';
echo '      <li class="codes">所持プロジェクト数 : <a href="'.base_url().''.$info.''.$uid.'/'.PROJECTS.'">'. $project_total .'</a></li>';
if($this->session->userdata('userID')) {
    echo '      <li class="favorites">お気に入りプロジェクト数 : <a href="' . base_url() . '' . $info . '' . $uid . '/' . FAVORITES . '">' . $favorite_total . '</a></li>';
}
echo '      <li class="following">フォロー : <a href="'.base_url().''.$info.''.$uid.'/'.FOLLOW.'">'. $follow_total .'</a></li>';
echo '      <li class="followers">フォロワー : <a href="'.base_url().''.$info.''.$uid.'/'.FOLLOWER.'">'. $follower_total .'</a></li>';
echo '      <li class="url">URL: <a href='. $url .'>'. $url .'</a></li>';
echo '      <li class="comment">'. nl2br($comment) .'</li>';
echo '    </ul>';

if($isown || !$this->session->userdata('userID')){
    //自分自身なので何も表示させない
}else{
    if ($isfollow) {
        echo '<a href="' . base_url() . 'follow/accountunfollow/' . $uid . '"><button class="follow btn btn-large waves-effect waves-light cyan darken-4 z-depth-2 col s2 offset-s10">フォロー解除</button></a>';
    } else {
        echo '<a href="' . base_url() . 'follow/accountfollow/' . $uid . '"><button class="follow btn btn-large waves-effect waves-light orange darken-4 z-depth-2 col s2 offset-s10">フォロー</button></a>';
    }
}
?>
</div>
<hr>

<div class="contents">

<?php if($category == "" || $category == PROJECTS) { ?>
    <div class="projects">

        <div class="row">
            <h4>プロジェクト一覧</h4>

            <?php
            //トップページのとき
            //複数項目ある場合の書き方例
            if (count($projects) > 0) {
                //プロジェクトを降順ソート
                $num = 0;
                foreach ($projects as $project) {
                    if ($category == "" && $num >= MAX_PROJECTS) break;
?>
                    <div class="col s3">
						<?php 
							//公開プロジェクトと非公開プロジェクトはそれぞれ色を変える
							if($project->isPublic) echo '<div class="card amber">';
							else echo '<div class="card grey lighten-1">';
						?>
                            <div class="card-content">
                                <span class="card-title">
									<p class="truncate">
					<?php
					//公開アイコンの表示
					if($project->isPublic) {
						echo '<i class="material-icons">';
						//所持プロジェクトのみ公開・非公開設定の変更可能
						if($this->session->userdata('userID') == $project->ownerUserID){
							echo '<a href="'.base_url().'profile/changePublic/'.$project->projectID.'/1">';
						}
						echo 'settings_input_antenna';
						if($this->session->userdata('userID') == $project->ownerUserID) echo '</a>'; 
						echo '</i>';
					}
					//非公開アイコンの表示
					else {
						echo '<i class="material-icons">';
						//所持プロジェクトのみ公開・非公開設定の変更可能
						if($this->session->userdata('userID') == $project->ownerUserID){
							echo '<a href="'.base_url().'profile/changePublic/'.$project->projectID.'/0">';
						}
						echo 'lock';
						if($this->session->userdata('userID') == $project->ownerUserID) echo '</a>'; 
						echo '</i>';
					}
					?>
						<?php echo $project->projectName; ?></p>
                                </span>

                                <span class="card-title activator black-text"><i class="material-icons right">info</i></span>
                                <div class="card-action">
                                    <p><i class="material-icons">visibility</i>閲覧数 : <?php echo $project->pv;?></p>
                                    <p><i class="material-icons">trending_down</i>フォーク数 : <?php echo $project->fork;?></p>
                                    <p><i class="material-icons">grade</i>お気に入り数 : <?php echo $project->favorite;?></p>
                                    <p class="truncate"><i class="material-icons">perm_identity</i>
                                        <a href="<?php echo base_url().'profile/information/'.$project->ownerUserID;?>">
                                            <?php echo "@".$project->ownerUserID;?>
                                        </a></p>
                                    <?php
                                    $isfavorite = false;
                                    $i = 0;

                                    $pro_id = $project->projectID;
                                    if($this->session->userdata('userID') != FALSE) {
                                        foreach ($my_favorites as $f) {
                                            $favo_id = $f[0]->projectID;

                                            if ($favo_id == $pro_id) {
                                                $isfavorite = true;
                                                break;
                                            }
                                        }

                                        if ($isfavorite) {
                                            echo '<p><a href="' . base_url() . 'favorite/release_favorite/' . $project->projectID . '"><span><i class="material-icons">grade</i></span></a></p>';
                                        } else {
                                            echo '<p><a href="' . base_url() . 'favorite/regist_favorite/' . $project->projectID . '"><span><i class="material-icons">stars</i></span></a></p>';
                                        }
                                    }
                                    ?>
                                </div>

                                <center>
                                    <a href="<?php echo base_url().'middle/detail/'.$project->projectID;?>"><i class="material-icons">play_for_work</i>プロジェクトを編集</a>
                                </center>
                            </div>
                            <div class="card-reveal orange lighten-4">
                                <span class="card-title black-text"><i class="material-icons right">close</i></span>
                                <p><i class="material-icons">loop</i>最終更新日 : <?php echo $project->modified;?></p>
                                <p><i class="material-icons">album</i>プロジェクトID : <?php echo $project->projectID;?></p>
                                <p><i class="material-icons">assignment</i>説明 : <?php echo $project->description;?></p>
                            </div>

                        </div>
                    </div>

            <?php
            $num += 1;
                }
            } else {
                echo '<p>no project.</p>';
            }

            ?>

            </div>
            <?php if (!(current_url() == base_url() . '' . $info . '' . $uid . '/' . PROJECTS)) {
                echo '<h6 align="right"><a href="' . base_url() . '' . $info . '' . $uid . '/' . PROJECTS . '">さらにプロジェクトを表示...</a></h6>';
            }
            //ページネーション
            if ($category == PROJECTS) {
                //プロジェクト一覧を表示するとき
                $this->load->library('pagination');
                echo '<br>';
                echo '<div>'.$this->pagination->create_links().'</div>';
            }
            ?>

<hr>
<?php }?>

<!--フォローしている人たちをリスト表示する $followをつかう-->
<?php if($category == "" || $category == FOLLOW){?>
    <div class="follow">
    <div class="row">
        <h4>フォロー</h4>
        <?php
        if($follow_total > 0){
        //フォローが新しい人ほど先にくるように降順ソート
        $num = 0;
        $this->load->model('Model_users');
        foreach($follow as $f){
            if($category == "") if($num >= MAX_FOLLOW) break;
            $id = $f->userFollowingID;
            $icon = $this->Model_users->get_icon_url($id);
            echo '<a href="'.base_url().'/profile/information/'.$id.'"><div class="userchip chip col s2"><img src="'.$icon.'"><span class="truncate">'.$id.'</span></div></a>';
            $num += 1;
        }
        }else{
            echo '<p>フォローアカウントはありません。</p>';
        }
?>

    </div>

    <?php
    if(!(current_url() == base_url().''.$info.''.$uid.'/'.FOLLOW)) {
        echo '<h6 align="right"><a href="' . base_url() . '' . $info . '' . $uid . '/' . FOLLOW . '">さらにフォローアカウントを表示...</a></h6>';
    }
    ?>

    </div>

<hr>
<?php }?>

<?php if($category == FOLLOWER){?>
    <div class="follower">
        <div class="row">
            <h2>Follower</h2>
            <?php
            if($follower_total > 0){
            //フォローが新しい人ほど先にくるように降順ソート
                foreach($follower as $f){
                    $id = $f->userID;
                    $icon = $this->Model_users->get_icon_url($id);
                    echo '<a href="'.base_url().'/profile/information/'.$id.'"><div class="userchip chip col s2"><img src="'.$icon.'"><span class="truncate">'.$id.'</span></div></a>';
                }
            }else{
                echo '<p>no follower.</p>';
            }
?>
        </div>
    </div>
    <hr>
<?php }?>

<!--ファボしたプロジェクトをリスト表示する $favoritesをつかう-->
<?php if($category == "" || $category == FAVORITES){ ?>
        <div class="favs">

            <div class="row">
                <h4>お気に入りのプロジェクト</h4>
                <?php
                $num = 0;
                    if (count($favorites) > 0) {
                        //ふぁぼが新しいものほど先にくるように降順ソート
                        krsort($favorites);
                        foreach ($favorites as $favorite) {
                            if ($category == "") if ($num >= MAX_FAVORITE) break;
                            ?>
                            <div class="col s3">
								<?php 
									//公開プロジェクトと非公開プロジェクトはそれぞれ色を変える
									if($favorite[0]->isPublic) echo '<div class="card amber">';
									else echo '<div class="card grey lighten-1">';
								?>
                                    <div class="card-content">
                                <span class="card-title">
					                <p class="truncate">
					<?php
					//公開アイコンの表示
					if($favorite[0]->isPublic) {
						echo '<i class="material-icons">';
						//所持プロジェクトのみ公開・非公開設定の変更可能
						if($this->session->userdata('userID') == $favorite[0]->ownerUserID){
							echo '<a href="'.base_url().'profile/changePublic/'.$favorite[0]->projectID.'/1">';
						}
						echo 'settings_input_antenna';
						if($this->session->userdata('userID') == $favorite[0]->ownerUserID) echo '</a>'; 
						echo '</i>';
					}
					//非公開アイコンの表示
					else {
						echo '<i class="material-icons">';
						//所持プロジェクトのみ公開・非公開設定の変更可能
						if($this->session->userdata('userID') == $favorite[0]->ownerUserID){
							echo '<a href="'.base_url().'profile/changePublic/'.$favorite[0]->projectID.'/0">';
						}
						echo 'lock';
						if($this->session->userdata('userID') == $favorite[0]->ownerUserID) echo '</a>'; 
						echo '</i>';
					}
					?>
								<?php echo $favorite[0]->projectName; ?></p>
                                </span>

                                <span class="card-title activator black-text"><i
                                        class="material-icons right">info</i></span>

                                        <div class="card-action">
                                            <p><i class="material-icons">visibility</i>閲覧数
                                                : <?php echo $favorite[0]->pv; ?>
                                            </p>

                                            <p><i class="material-icons">trending_down</i>フォーク数
                                                : <?php echo $favorite[0]->fork; ?></p>

                                            <p><i class="material-icons">grade</i>お気に入り数
                                                : <?php echo $favorite[0]->favorite; ?></p>

                                            <p class="truncate"><i class="material-icons">perm_identity</i>
                                                <a href="<?php echo base_url() . 'profile/information/' . $favorite[0]->ownerUserID; ?>">
                                                    <?php echo "@" . $favorite[0]->ownerUserID; ?>
                                                </a></p>
                                            <?php
                                            if($this->session->userdata('userID') != FALSE) {
                                                $isfavorite = false;
                                                $i = 0;

                                                $pro_id = $favorite[0]->projectID;
                                                foreach ($my_favorites as $f) {
                                                    $favo_id = $f[0]->projectID;

                                                    if ($favo_id == $pro_id) {
                                                        $isfavorite = true;
                                                        break;
                                                    }
                                                }

                                                if ($isfavorite) {
                                                    echo '<p><a href="' . base_url() . 'favorite/release_favorite/' . $favorite[0]->projectID . '"><span><i class="material-icons">grade</i></span></a></p>';
                                                } else {
                                                    echo '<p><a href="' . base_url() . 'favorite/regist_favorite/' . $favorite[0]->projectID . '"><span><i class="material-icons">stars</i></span></a></p>';
                                                }
                                            }
                                            ?>
                                        </div>

                                        <center>
                                            <a href="<?php echo base_url() . 'middle/detail/' . $favorite[0]->projectID; ?>"><i
                                                    class="material-icons">play_for_work</i>プロジェクト編集</a>
                                        </center>
                                    </div>
                                    <div class="card-reveal orange lighten-4">
                                        <span class="card-title black-text"><i
                                                class="material-icons right">close</i></span>

                                        <p><i class="material-icons">loop</i>最終更新日
                                            : <?php echo $favorite[0]->modified; ?></p>

                                        <p><i class="material-icons">album</i>プロジェクトID
                                            : <?php echo $favorite[0]->projectID; ?>
                                        </p>

                                        <p><i class="material-icons">assignment</i>説明
                                            : <?php echo $favorite[0]->description; ?></p>
                                    </div>

                                </div>
                            </div>

                            <?php
                            $num += 1;
                        }
                }else {
            echo '<p>お気に入りのプロジェクトはありません。</p>';
        }
        ?>
    </div>
    <?php
    if(!(current_url() == base_url().''.$info.''.$uid.'/'.FAVORITES)) {
        echo '<h6 align="right"><a href="' . base_url() . '' . $info . '' . $uid . '/' . FAVORITES . '">さらにお気に入りを表示...</a></h6>';
    }

    //ページネーション
    if ($category == FAVORITES) {
        //プロジェクト一覧を表示するとき
        $this->load->library('pagination');
        echo '<br>';
        echo '<div>'.$this->pagination->create_links().'</div>';
    }
    ?>
</div>
<hr>
<?php }?>

</div>

</div>
