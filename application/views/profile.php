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

echo '<div class="profile row">';

echo '    <div class="icons col s3" style="text-align: center">';
echo '      <img class="responsive-img" src="'. $icon .'"></img>';
echo '      <h4>'. $uname. '<small> @'. $uid .'</small></h4>';
echo '    </div>';

echo '    <ul class="info col s8 offset-s1">';
echo '      <li class="codes">codes: </li>';
echo '      <li class="forked">forked: </li>';
echo '      <li class="favorites">favorites: </li>';
echo '      <li class="following">following: </li>';
echo '      <li class="followers">followers: </li>';
echo '      <li class="url">url: <a href='. $url .'>'. $url .'</a></li>';
echo '      <li class="comment">'. $comment .'</li>';
echo '    </ul>';

if($isown || !$this->session->userdata('userID')){

}else{
    if ($isfollow) {
        echo '      <a href="' . base_url() . 'follow/accountunfollow/' . $uid . '"><button class="follow btn btn-large waves-effect waves-light cyan darken-4 z-depth-2 col s2 offset-s10">unfollow</button></a>';

    } else {
        echo '      <a href="' . base_url() . 'follow/accountfollow/' . $uid . '"><button class="follow btn btn-large waves-effect waves-light orange darken-4 z-depth-2 col s2 offset-s10">follow</button></a>';
    }
}

echo '</div>';

echo '<hr>';

echo '<div class="contents">';

echo '<div class="recently">';
echo '    <div class="row">';
echo '      <h2>Projects</h2>';
        //複数項目ある場合の書き方例
        if($projects != 0) {
            foreach ($projects as $project) {

                echo '    <div class="col s3">';
                echo '<a href=' . $project->url . '>';
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
echo '    </div>';
echo '</div>';

echo '<div class="following">';

echo '</div>';
echo '</div>';

?>
