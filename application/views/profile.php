<!--<h1>セッション情報</h1>-->
<h2>profile</h2>

<?php

//print_r($this->session->all_userdata());

foreach($user as $row){
    $uid = $row->userID;
    $email = $row->userMail;
}


echo $uid;
echo $email;

echo '<div class="profile">';
echo '    <div class="icon">';

echo '    </div>';

echo '    <div class="relation">';

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
                echo '<a href=' . $project->url . ' />';
                echo '        <div class="card blue-grey lighten-4">';
                echo '            <div class="card-content">';
                echo '                <div class="card-title">' . $project->projectName . '</div>';
                echo '               <p>'. $project->projectID . ', pv:' . $project->pv . '</p>';
                echo '            </div>';
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
