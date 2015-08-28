<h2>profile</h2>

<?php

foreach($user as $row){
    $uid = $row->userID;
    $uname = $row->userName;
    $icon = $row->userIcon;
    $profile = $row->profile;
    $url = $row->url;
    $email = $row->userMail;
}

echo '<div class="profile">';
echo '    <div class="icon">';

echo '    </div>';

echo '    <div class="relation">';
echo '      <div class="usename">';
echo '          <p>name: '. $uname .'</p>';
echo '      </div>';

echo '      <div class="email">';
echo '          <p>email: '. $email .'</p>';
echo '      </div>';

echo '      <div>';
echo '      </div>';

echo '    </div>';

echo '    <div class="comment">';

echo '    </div>';

echo '</div>';

echo '<div class="contents">';

echo '    <div class="recently">';
echo '<div class="row">';
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
echo '</div>';
    echo '</div>';

    echo '<div class="following">';

    echo '</div>';
echo '</div>';

?>
