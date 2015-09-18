<h1>アカウントを削除します<br/></h1>

<p>あなたのパスワードを入力してください。</p>

<?php

echo form_open("profile/password_validation");
echo validation_errors();

?>

<div class="row">
<div class="input-field col s4">
<input name="password" type="password" class="validate">
<label for="password">Password</label>
</div>
</div>

<div class="row">
<button class="btn waves-effect waves-light orange darken-4" style="float:right" type="submit" name="action">削除を実行
<i class="material-icons">delete</i>
</button>
</div>

<?php
echo form_close();
?>
