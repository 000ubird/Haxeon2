<!DOCTYPE html>

<link href="../css/convenience.css" type="text/css" rel="stylesheet">
<html>
<head>
    <meta charset="utf-8">
    <title>sign up</title>
</head>
<body>

<div id="container">
    <h1>アカウント登録</h1>

    <?php

    echo form_open("signup/validation");
	
	echo "<p>userID: ";
    echo form_input("userID", set_value('userID'));
    echo " 【必須】 </p>";
	echo form_error('userID');
	
    echo "<p>password: ";
    echo form_password("password", set_value('password'));
    echo " 【必須】 </p>";
	echo form_error('password');
	
    echo "<p>Email  : ";
    echo form_input("email", set_value('email'));
    echo " 【必須】 </p>";
	echo form_error('email');
	
	//送信ボタン
    echo form_submit("signin_submit", "送信");

    echo form_close();
    ?>

</div>
</body>
</html>
