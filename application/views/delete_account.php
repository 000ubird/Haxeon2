<h1>アカウントを削除します<br/></h1>

<p>あなたのパスワードを入力してください。</p>

<?php

echo form_open("profile/password_validation");

echo validation_errors();

echo '<div class="row">';
echo '<div class="input-field col s4">';
echo '<input name="password" type="password" class="validate">';
echo '<label for="password">Password</label>';
echo '</div>';
echo '</div>';

echo '<div class="row">';
echo '<button class="btn waves-effect waves-light orange darken-4" style="float:right" type="submit" name="action">削除を実行';
echo '<i class="material-icons">delete</i>';
echo '</button>';
echo '</div>';

echo form_close();

?>
