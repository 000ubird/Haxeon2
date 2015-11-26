<h2>プロジェクト設定</h2>

<p>タグ一覧</p>
<?php
foreach ($tags as $tag) {
    echo '<div class="row">'. $tag .'<a href="'.base_url().'profile/delete_tagmap/'. $tag .'"><i class="material-icons offset-s5">delete</i></a></div>';
}

echo form_open('profile/validation_project');
echo validation_errors();
?>

<div class="row">
    <div class="input-field col s12">
        <input name="tag" type="text" class="validate">
        <label for="tag">new tag</label>
    </div>
</div>

<br />

<div class="row">
    <div class="input-field col s12">
        <textarea name="description" class="materialize-textarea"><?php echo $description[0]->description; ?></textarea>
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
