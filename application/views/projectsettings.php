<h2>プロジェクト設定</h2>

<?php
echo '<p>タグ一覧</p>';
foreach ($tags as $tag) {
    echo '<div class="row">'. $tag .'<a href="'.base_url().'profile/delete_tagmap/'. $tag .'"><i class="material-icons offset-s5">delete</i></a></div>';
}

echo form_open('profile/validation_tag');

echo validation_errors();

echo '<div class="row">';
echo '<div class="input-field col s12">';
echo '<input name="tag" type="text" class="validate">';
echo '<label for="tag">new tag</label>';
echo '</div>';
echo '</div>';

echo '<div class="row">';
echo '<button class="btn waves-effect waves-light orange darken-4 col s3 offset-s9" type="submit" name="action">create Tag ';
echo '<i class="material-icons">input</i>';
echo '</button>';
echo '</div>';

echo form_close();
?>
