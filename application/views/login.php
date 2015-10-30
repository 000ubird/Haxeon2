<h1>ログインページ</h1>
<?php
echo form_open("login/validation");
echo validation_errors();
?>

<div class="row">
<div class="input-field col s12">
<input name="userID" type="text" class="validate">
<label for="userID">userID</label>
</div>
</div>

<div class="row">
<div class="input-field col s12">
<input name="password" type="password" class="validate">
<label for="password">password</label>
</div>
</div>

<div class="row">
<button class="btn waves-effect waves-light orange darken-4 col s3 offset-s9" type="submit" name="action">Login<i class="material-icons">input</i>
</button>
</div>

<?
echo form_close();
?>
