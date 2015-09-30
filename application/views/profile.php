<h2>profile</h2>

<?php

foreach($user as $row){
    $uid = $row->userID;
    $uname = $row->userName;
    $icon = $row->userIcon;
    $comment = $row->userProfile;
    $url = $row->userURL;
    $email = $row->userMail;
}

$project_total = 0;

//プロジェクトは何も作られていない場合がある
if(count($projects) > 1){
    foreach($projects as $project) {
        $project_total++;
    }
}

$follow_total = count($follow);

$followed_total= count($followed);

echo '<div class="profile row">';

echo '    <div class="icons col s3" style="text-align: center">';
echo '      <img class="responsive-img" src="'. $icon .'"></img>';
echo '      <h4>'. $uname. '<small> @'. $uid .'</small></h4>';

if($isown || !$this->session->userdata('userID')) {
    echo '<a href="' . base_url() . 'profile/profilesettings/' . $uid . '"><i class="material-icons">settings</i></a>';
}else{
    //自分以外のユーザーのときはプロフィール設定をしないため何も表示しない
}

echo '    </div>';

echo '    <ul class="info col s8 offset-s1">';
echo '      <li class="codes">codes: '. $project_total .'</li>';
echo '      <li class="forked">forked: </li>';
echo '      <li class="favorites">favorites: </li>';
echo '      <li class="following">following: '. $follow_total .'</li>';
echo '      <li class="followers">followers: '. $followed_total .'</li>';
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

echo '<div class="recently">';
echo '    <div class="row">';
echo '      <h2>Projects</h2>';
        //複数項目ある場合の書き方例
        if(count($projects) > 0) {
            foreach ($projects as $project) {

                echo '    <div class="col s3">';
                echo '<a href=http://localhost/haxeon/try-haxe/index.html#' . $project->projectID . '>';
                echo '        <div class="card blue-grey lighten-4">';
                echo '            <div class="card-content">';
                echo '                <span class="card-title">' . $project->projectName . '</span>';
                echo '                <p>'. $project->projectID . ', pv:' . $project->pv . '</p>';
                echo '            </div>';
                echo '            <div class="card-action">';
                echo '              <a href="';
                echo                    base_url().'profile/projectsettings/'. $project->projectID .'"><i class="material-icons">settings</i></a>';
                echo '             </div>';
                echo '        </div>';
                echo '    </div>';

            }
        }
?>
    </div>
</div>

<div class="following">

</div>
</div>
