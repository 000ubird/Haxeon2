<!-- バリデーションは設定していないので、形だけです。後付する予定 -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>sign in</title>
</head>
<body>

<div id="container">
    <h1>sign in</h1>

    <?php

    echo validation_errors();
    echo form_open("signin/signin_validation");

    echo "<p>userID: ";
    echo form_input("userID");
    echo "</p>";

    echo "<p>Email: ";
    echo form_input("email");
    echo "</p>";

    echo "<p>password: ";
    echo form_password("password");
    echo "</p>";

    echo "<p>";
    echo form_submit("signin_submit", "signin");
    echo "</p>";

    echo form_close();

    ?>

</div>
</body>
</html>
