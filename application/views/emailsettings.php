<h1>メールアドレス変更</h1>

<?php echo form_open('profile/validation_email/'.$userID); ?>

<div class="row">
<div class="input-field col s12">
<input name="new" type="email">
<label for="new">new email</label>
</div>
<?php form_error('new'); ?>
</div>

<div class="row">
    <button class="btn waves-effect waves-light orange darken-4 col s3 offset-s9" type="submit" name="action">change
        <i class="material-icons">open_in_new</i>
    </button>
</div>

<?php echo form_close(); ?>