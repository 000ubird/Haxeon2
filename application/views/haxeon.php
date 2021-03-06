<h3>人気のプロジェクト</h3>

<div class="row">
	
<?php
	$projects = $ranking['projects'];
	if(count($projects)==0) echo "<p>現在、ランキングに関する情報がありません。</p>";
	foreach($projects as $project) {
?>
	<div class="col s3">
		<div class="card amber">
			<div class="card-content">

				<span class="card-title">
					<p class="truncate"><?php echo $project[0]->projectName; ?></p>
				</span>

				<span class="card-title activator black-text">
					<i class="material-icons right">info</i>
				</span>

				<div class="card-action">
					<p><i class="material-icons">visibility</i>閲覧数 : <?php echo $project[0]->pv;?></p>
					<p><i class="material-icons">trending_down</i>フォーク数 : <?php echo $project[0]->fork;?></p>
					<p><i class="material-icons">grade</i>お気に入り数 : <?php echo $project[0]->favorite;?></p>
					<p class="truncate"><i class="material-icons">perm_identity</i>
						<a href="<?php echo base_url().'profile/information/'.$project[0]->ownerUserID;?>">
							<?php echo $project[0]->ownerUserID;?>
						</a>
					</p>
<?php
	//お気に入り登録ボタンの表示
	$isfavorite = false;

	$pro_id = $project[0]->projectID;
	if($this->session->userdata('userID') != FALSE) {
		foreach ($favorites as $f) {
			$favo_id = $f[0]->projectID;
			if ($favo_id == $pro_id) {
				$isfavorite = true;
				break;
			}
		}

		if ($isfavorite) {
			$this->load->model('ModelFavorite');
			$this->ModelFavorite->updateFavoriteCount($project[0]->projectID);
			echo '<p><a href="' . base_url() . 'favorite/releaseFavorite/' . $project[0]->projectID . '"><span><i class="material-icons">grade</i></span></a></p>';
		} else {
			$this->load->model('ModelFavorite');
			$this->ModelFavorite->updateFavoriteCount($project[0]->projectID);
			echo '<p><a href="' . base_url() . 'favorite/registerFavorite/' . $project[0]->projectID . '"><span><i class="material-icons">stars</i></span></a></p>';
		}
	}
?>
				</div>
				<center>
					<a href="<?php echo base_url().'middle/detail/'.$project[0]->projectID;?>"><i class="material-icons">play_for_work</i>プロジェクトを編集</a>
				</center>
			</div>

			<div class="card-reveal orange lighten-4">
				<span class="card-title black-text">
					<i class="material-icons right">close</i>
				</span>

				<p><i class="material-icons">loop</i>最終更新日時 : <?php echo $project[0]->modified;?></p>
				<p><i class="material-icons">album</i>プロジェクトID : <?php echo $project[0]->projectID;?></p>
				<p><i class="material-icons">assignment</i>説明 : <?php echo $project[0]->description;?></p>
			</div>

		</div>
	</div>
<?php } ?>
</div>

<Div Align="right"><p><a href="<?php echo base_url()?>ranking/index/day/pv/30/0">さらに表示...</a></p></Div>


