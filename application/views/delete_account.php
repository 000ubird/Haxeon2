<h3>アカウント削除</h3>

<?php

echo form_open("profile/password_validation");
echo validation_errors();

?>

<div class="row">
	<div class="input-field col s6">
		<input name="password" type="password" class="validate">
		<label for="password">パスワードを入力</label>
	</div>
	<div class="input-field col s4">
		<button class="btn waves-effect waves-light orange darken-4" style="float:right" type="submit" name="action">アカウント削除
		<i class="material-icons">delete</i>
		</button>
	</div>
</div>

<?php
echo form_close();
?>
