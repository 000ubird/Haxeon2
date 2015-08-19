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
	echo validation_errors();
    
	echo "<p>userID: ";
    echo form_input("userID");
    //echo form_error("userID");
    echo " 【必須】 </p>";

    echo "<p>password: ";
    echo form_password("password");
    //echo form_error("password");
    echo " 【必須】 </p>";
	
    echo "<p>Email  : ";
    echo form_input("email", $this->input->post("email"));
    //echo form_error("email");
    echo "</p>";
	
    echo "<p>";
    echo form_submit("signin_submit", "送信");
    echo " 【必須】 </p>";

    echo form_close();

    ?>

</div>
</body>
</html>
