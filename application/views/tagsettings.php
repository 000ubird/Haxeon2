<h3>タグ設定</h3>

<p>タグ一覧</p>
<?php
foreach ($tags as $tag) {
    echo '<div class="chip">' .$tag. '<a href="'.base_url().'tagsettings/deleteTagmap/'. $tag .'"><i class="material-icons">delete</i></a></div>';
}

echo form_open('tagsettings/validationTag');
echo validation_errors();
?>

<div class="row">
    <div class="input-field col s12">
        <input name="tag" type="text" class="validate">
        <label for="tag">新しいタグを追加</label>
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
