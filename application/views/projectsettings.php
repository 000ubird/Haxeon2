<h2>プロジェクト設定</h2>

<?php
echo form_open('profile/validation_project');
echo validation_errors();
?>

<br />

<div class="row">
    <div class="input-field col s12">
        <textarea name="description" class="materialize-textarea" placeholder="このプロジェクトについての説明"><?php echo $description[0]->description; ?></textarea>
    <label for="description">project description</label>
    </div>
</div>

<div class="row">
    <button class="btn waves-effect waves-light orange darken-4 col s3 offset-s9" type="submit" name="action">UPDATE
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
        echo '<button class="btn waves-effect waves-light red darken-4 col s4 offset-s4" value="プロジェクトを削除する" onClick="location.href=\''. base_url() .'profile/delete_project/'. $projectID .'\'">プロジェクトを削除する';
        ?>
        <i class="material-icons left">delete</i>
        </button>
    </div>
</div>
