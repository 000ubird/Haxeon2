<h1>パスワード変更確認</h1>

<?php

echo form_open();

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="new" type="text">';
echo '<label for="new">new password</label>';
echo '</div>';
echo form_error('new');
echo '</div>';

echo '<div class="row">';
echo '<a class="btn waves-effect waves-light orange darken-4 col s3 offset-s9 modal-trigger" href="#modal1" name="action">Change';
echo '<i class="material-icons">open_in_new</i>';
echo '</a>';
echo '</div>';

echo '<div id="modal1" class="modal">';
echo '<div class="modal-content">';
echo '<h4>modal header</h4>';
echo '</div>';
echo '</div>';



echo form_close();
?>
