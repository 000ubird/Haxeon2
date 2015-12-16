<h3>検索結果</h3>

<?php echo form_open('search/doSearch'); ?>

<div class="row">
	<form class="col s12">
		<div class="input-field col s2">
			<input id="search" type="text" value="<?php echo urldecode($str);?>" class="validate" name="search">
			<label for="search">検索文字列を入力</label>
			<?php form_error('search'); ?>
		</div>

		<div class="input-field col s2">
			<button class="btn waves-effect waves-light" >検索
				<i class="material-icons right">send</i>
			</button>
		</div>

		<p>並べ替え</p>
		<div class="input-field col s8">
			<input name="sort" type="radio" id="new" value="New" <?php if($sort[0]) echo 'checked="checked"';?> />
			<label for="new">新着</label>
			<input name="sort" type="radio" id="pv" value="PV" <?php if($sort[1]) echo 'checked="checked"';?> />
			<label for="pv">閲覧数</label>
			<input name="sort" type="radio" id="name" value="Name" <?php if($sort[2]) echo 'checked="checked"';?> />
			<label for="name">名前</label>

		<p>検索対象</p>
			<input type="checkbox" id="tag" value="0" name="chk[0]" <?php if($search[0]) echo 'checked="checked"';?> />
			<label for="tag">タグ</label>

			<input type="checkbox" id="projectName" value="1" name="chk[1]" <?php if($search[1]) echo 'checked="checked"';?> />
			<label for="projectName">プロジェクト名</label>

			<input type="checkbox" id="accountID" value="2" name="chk[2]" <?php if($search[3]) echo 'checked="checked"';?> />
			<label for="accountID">アカウントID</label>
		</div>
	</form>
</div>

<div class="projects">
	<div class="row">
		<?php
			if (count($result) == 0) {
				echo "<p>条件に一致するプロジェクトはありませんでした。</p>";
			} else {
				foreach($result as $row){
                ?>
                <div class="col s3">
		        <div class="card amber">
		        	<div class="card-content">
		        		<span class="card-title">
		        			<p class="truncate"><?php echo $row['projectName']; ?></p>
                </span>

                <span class="card-title activator black-text"><i class="material-icons right">info</i></span>
                <div class="card-action">
                    <p><i class="material-icons">visibility</i>閲覧数 : <?php echo $row['pv'];?></p>
                    <p><i class="material-icons">trending_down</i>フォーク数 : <?php echo $row['fork'];?></p>
                    <p><i class="material-icons">grade</i>お気に入り数 : <?php echo $row['favorite'];?></p>
                    <p class="truncate"><i class="material-icons">perm_identity</i>
                        <a href="<?php echo base_url().'profile/information/'.$row['ownerUserID'];?>">
                            <?php echo "@".$row['ownerUserID'];?>
                        </a></p>
                    <?php
                    $isfavorite = false;
                    $i = 0;

                    $pro_id = $row['projectID'];
                    foreach($favorites as $favorite){
                        $favo_id = $favorite[0]->projectID;

                        if($favo_id == $pro_id) {
                            $isfavorite = true;
                            break;
                        }
                    }
					
					if($this->session->userdata('userID') !=null) {
						if($isfavorite){
							$this->load->model('Model_favorite');
							$this->Model_favorite->updateFavoriteNum($row['projectID']);
							echo '<p><a href="' . base_url() . 'favorite/release_favorite/' . $favorite[0]->projectID . '"><span><i class="material-icons">grade</i></span></a></p>';
						}else {
							$this->load->model('Model_favorite');
							$this->Model_favorite->updateFavoriteNum($row['projectID']);
							echo '<p><a href="'.base_url().'favorite/regist_favorite/' .$row['projectID']. '"><span><i class="material-icons">stars</i></span></a></p>';
						}
					}
                    ?>
                </div>
                <center>
                    <a href="<?php echo base_url().'middle/detail/'.$row['projectID'];?>"><i class="material-icons">play_for_work</i>プロジェクトを編集</a>
                </center>
            </div>
            <div class="card-reveal orange lighten-4">
                <span class="card-title black-text"><i class="material-icons right">close</i></span>
                <p><i class="material-icons">loop</i>最終更新日 : <?php echo $row['modified'];?></p>
                <p><i class="material-icons">album</i>プロジェクトID : <?php echo $row['projectID'];?></p>
                <p><i class="material-icons">assignment</i>説明 : <?php echo $row['description'];?></p>
            </div>
        </div>
        </div>
<?php
                }
			}
		?>
	</div>
</div>
