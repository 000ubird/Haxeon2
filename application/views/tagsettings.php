<h2>タグ設定</h2>

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

<div class="row">
    <button class="btn waves-effect waves-light orange darken-4 col s3 offset-s9" type="submit" name="action">UPDATE
        <i class="material-icons">input</i>
    </button>
</div>

<?php
echo form_close();
?>
