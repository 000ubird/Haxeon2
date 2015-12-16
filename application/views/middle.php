<h3><?php echo $projectName ?></h3>
<p> プロジェクト作成者 : <a href="<?php echo base_url().'profile/information/'.$owner;?>">@<?php echo $owner; ?></a></p>
<!-- タグ一覧 -->
<div class="row">
    <div class="col s12">
        <?php
        foreach($tags as $tag){
            echo '<div class="chip"><a href="'.base_url().'search/searchResult/'.$tag.'/1/0/0/1/0/0/">'.$tag.'</div></a>';
        }
        ?>
    </div>
</div>
<div>
    <a href=<?php echo '"'.base_url().'profile/tagsettings/'.$projectID.'"';?> >タグを編集</a>
	<?php 
		//説明文の編集リンクは所有者のみ
		if ($owner == $this->session->userdata('userID')) {
			echo '<a href= "'.base_url().'profile/projectsettings/'.$projectID.'">説明文を編集</a>';
		}
	?>
    
</div>

<div class="row description">
    <div class="col s12">
        <div class="card-panel white">
            <span>
                <?php 
					//説明文が未登録の場合
					if ($description == "") {
						echo "このプロジェクトの説明はありません。";
					}
					else {
						echo nl2br($description); 
					}
				?>
            </span>
        </div>
    </div>
</div>

<!-- pvなどのデータ群 -->
<div class="row">
<ul style="text-align: right;">
    <li class="middle">閲覧数:<?php echo $pv; ?>, </li>
    <li class="middle">フォーク数:<?php echo $fork; ?>, </li>
    <li class="middle">最終更新日:<?php echo $modified;?></li>
</ul>
</div>

<hr />

<pre><code class="haxe"><?php echo $program; ?></code></pre>

<div class="row">
    <div class="col s12">
        <?php 
			if ($owner == $this->session->userdata('userID')) {
				echo '<a class="waves-effect waves-light btn col s4 offset-s4" href="' . base_url() . 'try-haxe/index.html#' . $projectID . '">編集</a>'; 
			}
			elseif ($this->session->userdata('userID') == null) {
				echo '<a class="waves-effect waves-light btn col s4 offset-s4" href="' . base_url() . 'try-haxe/index.html#' . $projectID . '">フォーク (未ログイン状態のため保存できません)</a>'; 
			}
			else {
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
    echo '<div class="timestamp"><small>'.$comment->modified;
	//自身が登録したコメントのみ削除可能
	if ($comment->commentedUserID == $this->session->userdata('userID')) {
		echo '<a href="'.base_url().'middle/delete_comment/'.$comment->commentID.'"><i class="material-icons">delete</i></a>';
	}
	echo '</small></div>';
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
        <label for="comment">コメント</label>
    </div>

    <button class="btn waves-effect waves-light col s4 offset-s4" type="submit" name="action">
        コメントを投稿
        <i class="material-icons">chat_bubble_outline</i>
    </button>
</div>

<?php 
}
echo form_close(); ?>

<?php 
//プロジェクト削除ボタンの表示
if ($owner == $this->session->userdata('userID')) { ?>
<br><br><br>
<div id="important" class="col s12">
    <div class="row">
        <?php
        echo '<button class="btn waves-effect waves-light red darken-4 col s4 offset-s4" value="プロジェクトを削除する" onClick="location.href=\''. base_url() .'profile/delete_project/'. $projectID .'\'">プロジェクトを削除';
        ?>
        <i class="material-icons left">delete</i>
        </button>
    </div>
</div>
<?php } ?>
