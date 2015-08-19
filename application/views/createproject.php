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

echo "<p>プロジェクト名*: ";
echo form_input("projectName");
echo "</p>";

$data = array(
    'value' => "create",
    'name' => "signin_submit",
);

echo "<p>";
echo form_submit($data);
echo "</p>";

echo form_close();

?>
</body>
</html>
