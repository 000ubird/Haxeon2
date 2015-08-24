<h1>アカウント登録</h1>

<?php

echo form_open("signup/validation");

echo "<p>userID: ";
echo form_input("userID", set_value('userID'));
echo " 【必須】 </p>";
echo form_error('userID');

echo "<p>password: ";
echo form_password("password", set_value('password'));
echo " 【必須】 </p>";
echo form_error('password');

echo "<p>Email  : ";
echo form_input("email", set_value('email'));
echo " 【必須】 </p>";
echo form_error('email');

?>

<button class="btn waves-effect waves-light amber accent-4" type="submit" name="action">Signup
    <i class="material-icons">open_in_new</i>
</button>

<?php
echo form_close();
?>
