<h2><?php echo $projectName ?></h2>
<!-- タグ一覧 -->
<div class="row">
    <div class="col s12">
        <?php
        foreach($tags as $tag){
            echo '<div class="chip">' .$tag. '</div>';
        }
        ?>
    </div>
</div>
<div>
    <a href="">タグ編集</a>
</div>

<div class="row description">
    <div class="col s12">
        <div class="card-panel white">
            <span>
                <?php echo nl2br($description); ?>
            </span>
        </div>
    </div>
</div>

<!-- pvなどのデータ群 -->
<div class="row">
<ul style="text-align: right;">
    <li class="middle">pv:<?php echo $pv; ?>,</li>
    <li class="middle">fork:<?php echo $fork; ?>,</li>
    <li class="middle">modified:<?php echo $modified;?></li>
</ul>
</div>

<hr />

<div class="row">
    <div class="col s12">
        <a class="waves-effect waves-light btn col s4 offset-s4" href="">フォーク</a>
    </div>
</div>

<pre><code class="haxe"><?php echo $program; ?></code></pre>

<div class="row">
    <div class="col s12">
        <a class="waves-effect waves-light btn col s4 offset-s4" href="">フォーク</a>
    </div>
</div>

<hr />


<!-- コメント部分 -->

<!-- フォーム -->
<div class="row">
    <div class="input-field col s10 offset-s1">
        <i class="material-icons prefix">mode_edit</i>
        <textarea name="comment" class="materialize-textarea" maxlength="1000" placeholder=""></textarea>
        <label for="comment">comment</label>
    </div>
</div>

<?php echo form_open('middle/validation_comment/'.$projectID);
      echo form_error('comment');?>

<div class="row">
    <button class="btn waves-effect waves-light col s4 offset-s4" type="submit" name="action">
        コメントを投稿する
        <i class="material-icons">chat_bubble_outline</i>
    </button>
</div>
