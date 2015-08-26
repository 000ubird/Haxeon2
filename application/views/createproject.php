<h1>新規プロジェクトページ</h1>
<!--テスト表示-->
<h2>セッション情報</h2>
<?php

print_r($this->session->all_userdata());
//ここまで

echo form_open("createproject/validation");

echo validation_errors();

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="projectName" type="text">';
echo '<label for="projectName">projectName</label>';
echo '</div>';
echo '</div>';

echo '<div class="row">';
echo '<button class="btn waves-effect waves-light orange darken-4 z-depth-2" style="float:right" type="submit" name="action">Create ';
echo '<i class="material-icons">note_add</i>';
echo '</button>';
echo '</div>';

echo form_close();

?>
