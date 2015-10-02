<h2>profile</h2>

<?php
define("PROJECTS", "projects");
define("FAVORITES", "favorites");
define("FOLLOW", "follow");
define("FOLLOWER", "follower");

foreach($user as $row){
    $uid = $row->userID;
    $uname = $row->userName;
    $icon = $row->userIcon;
    $comment = $row->userProfile;
    $url = $row->userURL;
    $email = $row->userMail;
}
$project_total = count($projects);

$favorite_total = count($favorites);

$follow_total = count($follow);

$follower_total= count($follower);

echo '<div class="profile row">';

echo '    <div class="icons col s3" style="text-align: center">';
echo '      <img class="responsive-img" src="'. $icon .'">';
echo '      <h4>'. $uname. '<small> @'. $uid .'</small></h4>';

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
echo '      <li class="comment">message: '. $comment .'</li>';
echo '    </ul>';

if($isown || !$this->session->userdata('userID')){
    //自分自身なので何も表示させない
}else{
    if ($isfollow) {
        echo '<a href="' . base_url() . 'follow/accountunfollow/' . $uid . '"><button class="follow btn btn-large waves-effect waves-light cyan darken-4 z-depth-2 col s2 offset-s10">unfollow</button></a>';
    } else {
        echo '<a href="' . base_url() . 'follow/accountfollow/' . $uid . '"><button class="follow btn btn-large waves-effect waves-light orange darken-4 z-depth-2 col s2 offset-s10">follow</button></a>';
    }
}

echo '</div>';
echo '<hr>';

echo '<div class="contents">';

if($category == "" || $category == PROJECTS) {
echo '<div class="projects">';
echo '    <div class="row">';

    echo '      <h2>Projects</h2>';
    //複数項目ある場合の書き方例
    if (count($projects) > 0) {
        //プロジェクトを降順ソート
        krsort($projects);
        foreach ($projects as $project) {

            echo '    <div class="col s3">';
            echo '<a href="' . base_url() . 'try-haxe/index.html#' . $project->projectID . '">';
            echo '        <div class="card blue-grey lighten-4">';
            echo '            <div class="card-content">';
            echo '                <span class="card-title">' . $project->projectName . '</span>';
            echo '                <p>' . $project->projectID . ', pv:' . $project->pv . '</p>';
            echo '            </div>';
            echo '            <div class="card-action">';
            echo '              <a href="';
            echo base_url() . 'profile/projectsettings/' . $project->projectID . '"><i class="material-icons">settings</i></a>';
            echo '             </div>';
            echo '        </div>';
            echo '    </div>';

        }
    }else{
        echo '<p>you have no project.</p>';
    }

echo  '</div>';
echo '<hr>';
}
?>

<!--フォローしている人たちをリスト表示する $followをつかう-->
<?php if($category == "" || $category == FOLLOW){?>
    <div class="follow">
    <div class="row">
        <h2>follow</h2>
        <?php
        if($follow_total > 0){
        foreach($follow as $f){
            echo($f->userFollowingID);
            echo('<br>');
        }
        }else{
            echo '<p>you have no follow.</p>';
        }
        ?>
    </div>
</div>

<hr>
<?php }?>

<?php if($category == FOLLOWER){?>
    <div class="follower">
        <div class="row">
            <h2>follower</h2>
            <?php
            if($follower_total > 0){
                foreach($follower as $f){
                    echo($f->userID);
                    echo('<br>');
                }
            }else{
                echo '<p>you have no follower.</p>';
            }
            ?>
        </div>
    </div>

    <hr>
<?php }?>

<!--ファボしたプロジェクトをリスト表示する $favoritesをつかう-->
<?php if($category == "" || $category == FAVORITES){?>
<div class="favs">
    <div class="row">
        <h2>favorites</h2>
        <?php
        if($favorite_total > 0) {
            foreach ($favorites as $favorite) {
                echo($favorite->projectID);
                echo('<br>');
            }
        }else{
            echo '<p>you have no favorite project.</p>';
        }
        ?>
    </div>
</div>
<?php }?>

</div>

</div>
