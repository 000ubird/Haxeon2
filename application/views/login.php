<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>login</title>
</head>
<body>
<h1>セッション情報</h1>
<?php

print_r($this->session->all_userdata());
echo form_open("main/login_validation");

echo validation_errors();

echo "<p>userID: ";
echo form_input("userID");
echo "</p>";

echo "<p>password: ";
echo form_password("password");
echo "</p>";

$data = array(
    'value' => "signin",
    'name' => "signin_submit",
);

echo "<p>";
echo form_submit($data);
echo "</p>";

echo form_close();

?>
</body>
</html>
