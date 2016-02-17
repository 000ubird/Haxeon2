<h3>アカウント作成</h3>

<?php

echo form_open('signup/validation_signup/');

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="userID" type="text">';
echo '<label for="userID">ユーザーID</label>';
echo '</div>';
echo form_error('userID');
echo '</div>';

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="password" type="password">';
echo '<label for="password">パスワード</label>';
echo '</div>';
echo form_error('password');
echo '</div>';

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="email" type="email">';
echo '<label for="email">メールアドレス</label>';
echo '</div>';
echo form_error('email');
echo '</div>';

echo '<div class="row">';
echo '<button class="btn waves-effect waves-light orange darken-4 col s3 offset-s9" type="submit" name="action">登録';
echo '<i class="material-icons">open_in_new</i>';
echo '</button>';
echo '</div>';

echo form_close();
?>
