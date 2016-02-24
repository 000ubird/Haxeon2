<h3>説明文を更新</h3>

<?php
echo form_open('projectsettings/validationProject');
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

<div class="row">
    <a href=<?php echo base_url();?>middle/detail/<?php echo $projectID ?>
        <button class="btn waves-effect waves-light col s3 offset-s4" type="submit" name="action">プロジェクトページに戻る
        <i class="material-icons">done</i>
    </button>
    </a>
</div>
