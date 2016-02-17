<h3>説明文を更新</h3>

<?php
echo form_open('projectsettings/validation_project');
echo validation_errors();
?>

<br />

<div class="row">
    <div class="input-field col s12">
        <textarea name="description" class="materialize-textarea"><?php echo $description[0]->description; ?></textarea>
    <label for="description">プロジェクトの説明</label>
    </div>
</div>

<div class="row">
    <button class="btn waves-effect waves-light orange darken-4 col s3 offset-s9" type="submit" name="action">更新
        <i class="material-icons">input</i>
    </button>
</div>

<?php
    echo form_close();
?>
