<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>create</title>
</head>
<body>
<h1>新規プロジェクトページ</h1>
<!--テスト表示-->
<h2>セッション情報</h2>
<?php

print_r($this->session->all_userdata());
//ここまで

echo form_open("createproject/validation");

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
