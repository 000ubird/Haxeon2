<h1>ログインページ</h1>
<h3>セッション情報</h3>
<?php

print_r($this->session->all_userdata());
echo form_open("login/validation");

echo validation_errors();

echo "<p>userID*: ";
echo form_input("userID");
echo "</p>";

echo "<p>password*: ";
echo form_password("password");
echo "</p>";

echo "<p>";
?>

<button class="btn waves-effect waves-light amber accent-4" type="submit" name="action">Login
    <i class="material-icons">input</i>
</button>

<?php
echo "</p>";

echo form_close();

?>
