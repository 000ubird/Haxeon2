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

//echo '<div>';
echo '    <ul class="info col s8 offset-s1">';
//echo '      <li class="email"><i class="material-icons">email</i> '. $email .'</li>';
echo '      <li class="codes">codes: </li>';
echo '      <li class="forked">forked: </li>';
echo '      <li class="favorites">favorites: </li>';
echo '      <li class="followig">following: </li>';
echo '      <li class="followes">followers: </li>';
echo '      <li class="url">url: <a href='. $url .'>'. $url .'</a></li>';
echo '      <li class="comment">'. $comment .'</li>';
echo '    </ul>';

//echo '</div>';

echo '      <a class="btn-floating btn-large waves-effect waves-light orange darken-4" style="float:right">follow</a>';

echo '</div>';

echo '<hr>';

echo '<div class="contents">';

echo '<div class="recently">';
echo '    <div class="row">';
echo '      <h2>Projects</h2>';
        //<!--      複数項目ある場合の書き方例      -->
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

                //echo '<p><a href=' . $project->url . '>' . $project->projectID . '</a></p>';
            }
        }
echo '    </div>';
echo '</div>';

echo '<div class="following">';

echo '</div>';
echo '</div>';

?>
