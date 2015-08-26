<h1>ログインページ</h1>
<h3>セッション情報</h3>
<?php

print_r($this->session->all_userdata());
echo form_open("login/validation");

echo validation_errors();

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="userID" type="text" class="validate">';
echo '<label for="userID">userID</label>';
echo '</div>';
echo '</div>';

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="password" type="password" class="validate">';
echo '<label for="password">password</label>';
echo '</div>';
echo '</div>';

echo '<div class="row">';
echo '<button class="btn waves-effect waves-light orange darken-4 z-depth-2" style="float:right" type="submit" name="action">Login ';
echo '<i class="material-icons">input</i>';
echo '</button>';
echo '</div>';

echo form_close();

?>
