<h1>アカウント登録</h1>

<?php

echo form_open("signup/validation");

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="userID" type="text">';
echo '<label for="userID">userID</label>';
echo '</div>';
echo form_error('userID');
echo '</div>';

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="password" type="text">';
echo '<label for="password">password</label>';
echo '</div>';
echo form_error('password');
echo '</div>';

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="email" type="text">';
echo '<label for="email">email</label>';
echo '</div>';
echo form_error('email');
echo '</div>';

echo '<div class="row">';
echo '<button class="btn waves-effect waves-light orange darken-4 z-depth-2" style="float:right" type="submit" name="action">Signup';
echo '<i class="material-icons">open_in_new</i>';
echo '</button>';
echo '</div>';

echo form_close();
?>
