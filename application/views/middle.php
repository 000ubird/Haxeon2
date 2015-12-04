<h2><?php echo $projectName ?></h2>
<p>author: <?php echo $owner; ?></p>
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

<pre><code class="haxe"><?php echo $program; ?></code></pre>

<div class="row">
    <div class="col s12">
        <?php 
			if ($owner == $this->session->userdata('userID')) {
				echo '<a class="waves-effect waves-light btn col s4 offset-s4" href="' . base_url() . 'try-haxe/index.html#' . $projectID . '">編集</a>'; 
			} else {
				echo '<a class="waves-effect waves-light btn col s4 offset-s4" href="' . base_url() . 'try-haxe/index.html#' . $projectID . '">フォーク</a>'; 
			}
		?>
    </div>
</div>

<hr />

<!-- コメント部分 -->
<?php
foreach($comments as $comment){
    echo '<div class="row">';
    echo '<a href="'.base_url().'/profile/information/'.$comment->commentedUserID.'"><div class="userchip chip col s2"><img src="'.$comment->icon.'"><span class="truncate">'.$comment->commentedUserName.'</span></div></a>';
    echo '<div class="col s10 offset-s"><div class="card-panel white"><span>'.$comment->comment.'</span></div></div>';
    echo '<div class="timestamp"><small>'.$comment->modified.'</small></div>';
    echo '</div>';
}

//ログイン状態の時のみコメントフォームを表示する。
if($this->session->userdata('userID') != null) {

echo form_open('middle/validation_comment/'.$projectID);
      echo form_error('comment');?>
<div class="row">
    <div class="input-field col s10 offset-s1">
        <i class="material-icons prefix">mode_edit</i>
        <textarea name="comment" class="materialize-textarea" minlength="5" maxlength="1000"></textarea>
        <label for="comment">comment</label>
    </div>

    <button class="btn waves-effect waves-light col s4 offset-s4" type="submit" name="action">
        コメントを投稿する
        <i class="material-icons">chat_bubble_outline</i>
    </button>
</div>

<?php 
}
echo form_close(); ?>
