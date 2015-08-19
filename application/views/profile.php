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

    ?>

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

        </div>

        <div class="following">

        </div>

    </div>

</div>
</body>
</html>
