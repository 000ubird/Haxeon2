<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>login</title>
</head>
<body>
<?php

echo form_open("login/validation");

echo validation_errors();

echo "<p>userID: ";
echo form_input("userID");
echo "</p>";

echo "<p>password: ";
echo form_password("password");
echo "</p>";

echo "<p>";
echo form_submit("signin_submit", "signin");
echo "</p>";

echo form_close();

?>
</body>
</html>
