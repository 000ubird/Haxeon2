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

</div>
</body>
</html>
