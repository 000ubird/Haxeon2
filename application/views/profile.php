<h1>Profile</h1>

<?php
define("PROJECTS", "projects");
define("FAVORITES", "favorites");
define("FOLLOW", "follow");
define("FOLLOWER", "follower");
define("MAX_PROJECTS", 3);
define("MAX_FOLLOW", 12);
define("MAX_FAVORITE", 3);

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

                    echo '<a href="' . base_url() . 'try-haxe/index.html#' . $project->projectID . '">';
                    echo '    <div class="col s4">';
                    echo '        <div class="card">';

                    echo '<div class="card-image waves-effect waves-block waves-light">';
                    echo '<img class="activator" src="' . base_url() . 'img/project.jpg">';
                    echo '</div>';

                    echo '        <div class="card-content">';
                    echo '            <span class="card-title activator black-text text-darken-4 truncate">' . $project->projectName;
                    if ($project->ownerUserID == $this->session->userdata('userID')) echo '<a href="' . base_url() . 'profile/projectsettings/' . $project->projectID . '"><i class="material-icons">settings</i></a>';
                    echo '</span>';
                    echo '</a>';
                    echo '            <p class="truncate">User : <a href="' . base_url() . 'profile/information/' . $project->ownerUserID . '">@' . $project->ownerUserID . '</a></p>';
                    echo '            <p class="truncate">PV : ' . $project->pv . '</p>';
                    echo '            <p class="truncate">Fork : ' . $project->fork . '</p>';
                    echo '            <p class="truncate"><a href="' . base_url() . 'try-haxe/index.html#' . $project->projectID . '">Edit Code</a></p>';
                    echo '        </div>';

                    echo '        <div class="card-reveal">';
                    echo '            <span class="card-title grey-text text-darken-4">' . $project->projectName . '<i class="material-icons right">close</i></span>';
                    echo '            <p>Project ID : ' . $project->projectID . '</p>';
                    echo '            <p>pv : ' . $project->pv . '</p>';
                    echo '            <p>User : ' . $project->ownerUserID . '</p>';
                    echo '        </div>';

                    echo '      </div>';
                    echo '  </div>';
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
                echo '<a href="'.base_url().'try-haxe/index.html#'.$favorite[0]->projectID.'">';

                echo '    <div class="col s4">';

                echo '        <div class="card">';

                echo '<div class="card-image waves-effect waves-block waves-light">';
                echo '<img class="activator" src="'.base_url().'img/project.jpg">';
                echo '</div>';

                echo '        <div class="card-content">';
                echo '            <span class="card-title activator black-text text-darken-4 truncate">' . $favorite[0]->projectName . '</span>';
                echo '</a>';
                echo '            <p class="truncate">User : <a href="'.base_url().'profile/information/'.$favorite[0]->ownerUserID.'">@' . $favorite[0]->ownerUserID .'</a></p>';
                echo '            <p class="truncate">PV : '.$favorite[0]->pv.'</p>';
                echo '            <p class="truncate">Fork : '.$favorite[0]->fork.'</p>';
                echo '            <p class="truncate"><a href="'.base_url().'try-haxe/index.html#'.$favorite[0]->projectID.'">Edit Code</a></p>';
                echo '        </div>';

                echo '        </div>';
                echo '        </div>';
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
