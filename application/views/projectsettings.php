<h3>説明文を更新</h3>

<?php
echo form_open('profile/validation_project');
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

<br>
<div id="important" class="col s12">

    <div class="row">
        <?php
        echo '<button class="btn waves-effect waves-light red darken-4 col s4 offset-s4" value="プロジェクトを削除する" onClick="location.href=\''. base_url() .'profile/delete_project/'. $projectID .'\'">プロジェクトを削除';
        ?>
        <i class="material-icons left">delete</i>
        </button>
    </div>
</div>
