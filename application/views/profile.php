<html>
<head>
    <meta charset="UTF-8">
    <title>profile</title>
</head>
<body>
<div class="container">
    <h1>セッション情報</h1>

    <?php

    print_r($this->session->all_userdata());

    foreach($user as $row){
        $uid = $row->userID;
        $email = $row->userMail;
    }

    foreach($projects as $row){
        $pid = $row->projectID;
        $projectName = $row->projectName;
    }

    ?>
<!--  単一表示例  -->
    <p><?php echo $uid; ?></p>
    <p><?php echo $email; ?></p>

    <div class="profile">
<!--   アイコン、ユーザー名、フォロー系、ファボ、プロフィール     -->
        <div class="icon">

        </div>

        <div class="relation">
<!--     コード、フォーク、ファボ、フォロー、URLなど     -->
        </div>

        <div class="comment">

        </div>

    </div>

    <div class="contents">

        <div class="recently">
<!--      複数項目ある場合の書き方例      -->
            <p><?php foreach($projects as $project){
                    echo '<p>'.$project->projectID.'</p>';
                }?></p>
        </div>

        <div class="following">

        </div>

    </div>

</div>
</body>
</html>
