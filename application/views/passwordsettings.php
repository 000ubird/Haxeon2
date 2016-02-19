<h3>パスワード変更確認</h3>

<?php echo form_open('passwordsettings/validationPasswordSettings/'.$userID); ?>

<div class="row">
	<div class="input-field col s12">
		<input name="current" type="password"></input>
		<label for="current">現在のパスワード</label>
	</div>
	<?php echo form_error('current'); ?>
</div>

<div class="row">
	<div class="input-field col s12">
		<input name="new" type="password"></input>
		<label for="new">新しいパスワード</label>
	</div>
	<?php echo form_error('new'); ?>
</div>

<div class="row">
	<div class="input-field col s12">
		<input name="again" type="password"></input>
		<label for="again">新しいパスワード(再入力)</label>
	</div>
	<?php echo form_error('again'); ?>
</div>

<div class="row">
	<button class="btn waves-effect waves-light orange darken-4 col s3 offset-s9" type="submit" name="action">変更
		<i class="material-icons">open_in_new</i>
	</button>
</div>

<?php echo form_close(); ?>
