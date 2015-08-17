<html>
<head>
    <title></title>
</head>
<body>
<div id="container">
    <h1>セッション情報</h1>

    <?php

    print_r($this->session->all_userdata());

    ?>
<a href="<?php echo base_url()."logout/index" ?>">ログアウト</a>
</div>
</body>
</html>
