<h1>新規プロジェクトページ</h1>

<h2>セッション情報</h2>
<?php
print_r($this->session->all_userdata());

echo form_open("createproject/validation");
echo validation_errors();
?>

<div class="row">
<div class="input-field col s12">
<input name="projectName" type="text">
<label for="projectName">projectName</label>
</div>
</div>

<div class="row">';
<button class="btn waves-effect waves-light orange darken-4" style="float:right" type="submit" name="action">Create<i class="material-icons">note_add</i>
</button>
</div>

<?php
echo form_close();
?>
