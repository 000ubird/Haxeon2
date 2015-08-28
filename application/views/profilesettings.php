<h2>プロフィール設定</h2>

<?php

echo form_open('profile/validation_profile');

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="userID" type="text">';
echo '<label for="userID">userID</label>';
echo '</div>';
echo form_error('userID');
echo '</div>';

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="password" type="password">';
echo '<label for="password">password</label>';
echo '</div>';
echo form_error('password');
echo '</div>';

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="email" type="email">';
echo '<label for="email">email</label>';
echo '</div>';
echo form_error('email');
echo '</div>';

//アイコン
echo '<div class="row">';
echo '<div class="input-field col s12>';
echo '<input name="icon" type="icon">';
echo '<label for="icon">icon</label>';
echo '</div>';
echo form_error('icon');
echo '</div>';

//メッセージ文
echo '<div class="row">';
echo '<div class="input-field col s12>';
echo '<input name="message" type="message">';
echo '<label for="message">message</label>';
echo '</div>';
echo form_error('message');
echo '</div>';

echo form_close();
?>
