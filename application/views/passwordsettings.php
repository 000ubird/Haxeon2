<h1>パスワード変更確認</h1>

<?php

echo form_open();

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="current" type="text">';
echo '<label for="current">現在のパスワード</label>';
echo '</div>';
echo form_error('current');
echo '</div>';

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="new" type="text">';
echo '<label for="new">新しいパスワード</label>';
echo '</div>';
echo form_error('new');
echo '</div>';

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="again" type="text">';
echo '<label for="again">新しいパスワード(再入力)</label>';
echo '</div>';
echo form_error('again');
echo '</div>';

echo '<div class="row">';
echo '<button class="btn waves-effect waves-light orange darken-4 col s3 offset-s9" type="submit" name="action">change';
echo '<i class="material-icons">open_in_new</i>';
echo '</button>';
echo '</div>';

echo form_close();
?>
