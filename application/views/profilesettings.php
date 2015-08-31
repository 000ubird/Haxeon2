<h2>プロフィール設定</h2>

<?php
echo $error;
//ファイルアップロードフォーム
echo form_open_multipart('profile/do_upload/'.$userID);
//アイコン
echo '<input type="file" name="userfile" size="20" />';
echo '<input type="submit" value="upload" />';
echo form_close();

echo form_open('profile/validation_profile/'.$userID);

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="userName" type="text">';
echo '<label for="userName">userName</label>';
echo '</div>';
echo form_error('userName');
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

//メッセージ文
echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="profile" type="text">';
echo '<label for="profile">message</label>';
echo '</div>';
echo form_error('profile');
echo '</div>';

echo '<div class="row">';
echo '<button class="btn waves-effect waves-light orange darken-4 col s3 offset-s9" type="submit" name="action">Change';
echo '<i class="material-icons">open_in_new</i>';
echo '</button>';
echo '</div>';

echo form_close();
?>
