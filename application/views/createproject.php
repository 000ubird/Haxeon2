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
?>

<button class="btn waves-effect waves-light amber accent-4" type="submit" name="action">Create
    <i class="material-icons">note_add</i>
</button>

<?php
echo "</p>";

echo form_close();

?>
