<h1>Profile</h1>

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

echo '<div class="profile row">';

echo '    <div class="icons col s3" style="text-align: center">';
echo '      <img class="responsive-img" src="'. $icon .'">';
echo '      <h4 class="truncate">'. $uname. '<br><small> @'. $uid .'</small></h4>';

//フォローボタンの表示
if($isown || !$this->session->userdata('userID')) {
    echo '<a href="' . base_url() . 'profile/profilesettings/' . $uid . '"><i class="material-icons">settings</i></a>';
}else{
    //自分以外のユーザーのときはプロフィール設定をしないため何も表示しない
}

echo '    </div>';

$info = 'profile/information/';
echo '    <ul class="info col s8 offset-s1">';
echo '      <li class="name">name: '. $uname .'</li>';
echo '      <li class="codes">codes: <a href="'.base_url().''.$info.''.$uid.'/'.PROJECTS.'">'. $project_total .'</a></li>';
echo '      <li class="forked">forked: </li>';
echo '      <li class="favorites">favorite: <a href="'.base_url().''.$info.''.$uid.'/'.FAVORITES.'">'. $favorite_total .'</a></li>';
echo '      <li class="following">follow: <a href="'.base_url().''.$info.''.$uid.'/'.FOLLOW.'">'. $follow_total .'</a></li>';
echo '      <li class="followers">follower: <a href="'.base_url().''.$info.''.$uid.'/'.FOLLOWER.'">'. $follower_total .'</a></li>';
echo '      <li class="url">url: <a href='. $url .'>'. $url .'</a></li>';
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
            <h2>Projects</h2>

            <?php
            //トップページのとき
            //複数項目ある場合の書き方例
            if (count($projects) > 0) {
                //            //プロジェクトを降順ソート
                $num = 0;
                foreach ($projects as $project) {
                    if ($category == "" && $num >= MAX_PROJECTS) break;
?>
                    <div class="col s3">
                        <div class="card amber">
                            <div class="card-content">
                                <span class="card-title">
					                <p class="truncate"><a href="<?php echo base_url().'middle/detail/'.$project->projectID;?>"><?php echo $project->projectName; ?></a></p>
                                </span>

                                <span class="card-title activator black-text"><i class="material-icons right">info</i></span>
                                <div class="card-action">
                                    <p><i class="material-icons">visibility</i>PV : <?php echo $project->pv;?></p>
                                    <p><i class="material-icons">trending_down</i>Forked : <?php echo $project->fork;?></p>
                                    <p><i class="material-icons">grade</i>Favorite : <?php echo $project->favorite;?></p>
                                    <p class="truncate"><i class="material-icons">perm_identity</i>
                                        <a href="<?php echo base_url().'profile/information/'.$project->ownerUserID;?>">
                                            <?php echo "@".$project->ownerUserID;?>
                                        </a></p>
                                    <?php
                                    $isfavorite = false;
                                    $i = 0;

                                    $pro_id = $project->projectID;
                                    foreach($favorites as $favorite){
                                        $favo_id = $favorite[0]->projectID;

                                        if($favo_id == $pro_id) {
                                            $isfavorite = true;
                                            break;
                                        }
                                    }

                                    if($isfavorite){
                                        $this->load->model('Model_favorite');
                                        $this->Model_favorite->updateFavoriteNum($project->projectID);
                                        echo '<p><a href="' . base_url() . 'favorite/release_favorite/' . $favorite[0]->projectID . '"><span><i class="material-icons">grade</i></span></a></p>';
                                    }else {
                                        $this->load->model('Model_favorite');
                                        $this->Model_favorite->updateFavoriteNum($project->projectID);
                                        echo '<p><a href="'.base_url().'favorite/regist_favorite/' .$project->projectID. '"><span><i class="material-icons">stars</i></span></a></p>';
                                    }
                                    ?>
                                </div>

                                <center>
                                    <a href="<?php echo base_url().'middle/detail/'.$project->projectID;?>"><i class="material-icons">play_for_work</i>Edit Project</a>
                                </center>
                            </div>
                            <div class="card-reveal orange lighten-4">
                                <span class="card-title black-text"><i class="material-icons right">close</i></span>
                                <p><i class="material-icons">loop</i>LastModified : <?php echo $project->modified;?></p>
                                <p><i class="material-icons">album</i>ProjectID : <?php echo $project->projectID;?></p>
                                <p><i class="material-icons">assignment</i>Description : <?php echo $project->description;?></p>
                            </div>

                        </div>
                    </div>

            <?php
            $num += 1;
                }
            } else {
                echo '<p>you have no project.</p>';
            }

            //ページネーション
            if ($category == PROJECTS) {
            //プロジェクト一覧を表示するとき
            $this->load->library('pagination');
            echo $this->pagination->create_links();
            }
            ?>

            </div>
            <?php if (!(current_url() == base_url() . '' . $info . '' . $uid . '/' . PROJECTS)) {
                echo '<h4 align="right"><a href="' . base_url() . '' . $info . '' . $uid . '/' . PROJECTS . '">...more projects</a></h4>';
            }
            ?>

<hr>
<?php }?>

<!--フォローしている人たちをリスト表示する $followをつかう-->
<?php if($category == "" || $category == FOLLOW){?>
    <div class="follow">
    <div class="row">
        <h2>Follow</h2>
        <?php
        if($follow_total > 0){
        //フォローが新しい人ほど先にくるように降順ソート
        $num = 0;
        $this->load->model('Model_users');
        foreach($follow as $f){
            if($category == "") if($num >= MAX_FOLLOW) break;
            $id = $f->userFollowingID;
            $icon = $this->Model_users->get_icon_url($id);
            echo '<div class="col s3">';
            echo '<a href="'.base_url().'profile/information/'.$id.'">';
            echo '<div class="card-panel waves-effect waves-light z-depth-1 truncate">';
            echo '<img src="'.$icon.'" width="30%" height="auto">';
            echo '<span style="text-align: center"> '.$id.'</span>';
            echo '</div>';
            echo '</a>';
            echo '</div>';
            $num += 1;
        }
        }else{
            echo '<p>you have no follow.</p>';
        }

        //ページネーション
        if($category == FOLLOW) {
            $this->load->library('pagination');
            echo $this->pagination->create_links();
        }?>

    </div>

    <?php
    if(!(current_url() == base_url().''.$info.''.$uid.'/'.FOLLOW)) {
        echo '<h4 align="right"><a href="' . base_url() . '' . $info . '' . $uid . '/' . FOLLOW . '">...more followers</a></h4>';
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
                    echo '<div class="col s3">';
                    echo '<a href="'.base_url().'profile/information/'.$id.'">';
                    echo '<div class="card-panel waves-effect waves-light z-depth-1 truncate">';
                    echo '<img src="'.$icon.'" width="30%" height="auto">';
                    echo '<span style="text-align: center"> '.$id.'</span>';
                    echo '</div>';
                    echo '</a>';
                    echo '</div>';
                }
            }else{
                echo '<p>you have no follower.</p>';
            }

            //ページネーション
            if($category == FOLLOW) {
                $this->load->library('pagination');
                echo $this->pagination->create_links();
            }?>
            ?>
        </div>
    </div>

    <hr>
<?php }?>

<!--ファボしたプロジェクトをリスト表示する $favoritesをつかう-->
<?php if($category == "" || $category == FAVORITES){?>
<div class="favs">
    <?php     if($category == FAVORITES) {
        $this->load->library('pagination');
        echo $this->pagination->create_links();
    }?>
    <div class="row">
        <h2>Favorites</h2>
        <?php
        $num = 0;
        if($favorite_total > 0) {
            //ふぁぼが新しいものほど先にくるように降順ソート
            foreach ($favorites as $favorite) {
                if($category == "") if($num >= MAX_FAVORITE) break;
                ?>
        <div class="col s3">
            <div class="card amber">
                <div class="card-content">
                                <span class="card-title">
					                <p class="truncate"><a href="<?php echo base_url().'middle/detail/'.$favorite[0]->projectID;?>"><?php echo $favorite[0]->projectName; ?></a></p>
                                </span>

                    <span class="card-title activator black-text"><i class="material-icons right">info</i></span>
                    <div class="card-action">
                        <p><i class="material-icons">visibility</i>PV : <?php echo $favorite[0]->pv;?></p>
                        <p><i class="material-icons">trending_down</i>Forked : <?php echo $favorite[0]->fork;?></p>
                        <p><i class="material-icons">grade</i>Favorite : <?php echo $favorite[0]->favorite;?></p>
                        <p class="truncate"><i class="material-icons">perm_identity</i>
                            <a href="<?php echo base_url().'profile/information/'.$favorite[0]->ownerUserID;?>">
                                <?php echo "@".$favorite[0]->ownerUserID;?>
                            </a></p>
                        <?php
                        $this->load->model('Model_favorite');
                        $this->Model_favorite->updateFavoriteNum($favorite[0]->projectID);
                        echo '<p><a href="'.base_url().'favorite/release_favorite/' .$favorite[0]->projectID. '"><span><i class="material-icons">grade</i></span></a></p>';
                        ?>
                    </div>

                    <center>
                        <a href="<?php echo base_url().'middle/detail/'.$favorite[0]->projectID;?>"><i class="material-icons">play_for_work</i>Edit Project</a>
                    </center>
                </div>
                <div class="card-reveal orange lighten-4">
                    <span class="card-title black-text"><i class="material-icons right">close</i></span>
                    <p><i class="material-icons">loop</i>LastModified : <?php echo $favorite[0]->modified;?></p>
                    <p><i class="material-icons">album</i>ProjectID : <?php echo $favorite[0]->projectID;?></p>
                    <p><i class="material-icons">assignment</i>Description : <?php echo $favorite[0]->description;?></p>
                </div>

            </div>
        </div>

    <?php
                $num += 1;
            }
        }else{
            echo '<p>you have no favorite project.</p>';
        }
        ?>
    </div>
    <?php
    if(!(current_url() == base_url().''.$info.''.$uid.'/'.FAVORITES)) {
        echo '<h4 align="right"><a href="' . base_url() . '' . $info . '' . $uid . '/' . FAVORITES . '">...more favorites</a></h4>';
    }
    ?>
</div>
<hr>
<?php }?>

</div>

</div>
