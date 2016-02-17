<h3>新規プロジェクト作成</h3>

<?php
	echo form_open("createproject/validation");
	echo validation_errors();
?>

<div class="row">
	<div class="input-field col s12">
		<input name="projectName" type="text">
		<label for="projectName">プロジェクト名を入力して下さい。日本語入力も可能です。</label>
	</div>
</div>

<div class="row">
	<button class="btn waves-effect waves-light orange darken-4" style="float:right" type="submit" name="action">プロジェクト作成
		<i class="material-icons">note_add</i>
	</button>
</div>

<?php
	echo form_close();
?>
