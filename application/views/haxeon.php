
<h2>Today's HotCode!</h2>

<?php
$cur_page = 0;
$projects = $ranking['projects'];

//カードの表示
echo '<div class="row">';
$i = 0;
foreach($projects as $project) {
?>
	<div class="col s3">
		<div class="card amber">
			<div class="card-content">
				<span class="card-title">
					<p class="truncate"><a href="<?php echo base_url().'middle/detail/'.$project[0]->projectID;?>">
						<?php echo $project[0]->projectName; ?>
					</a></p>
				</span>

				<span class="card-title activator grey-text text-darken-4"><i class="material-icons right">info</i></span>
				<div class="card-action">
					<font color="#000000">
						<p><i class="material-icons">visibility</i>PV : <?php echo $project[0]->pv;?></p>
                        <p><i class="material-icons">trending_down</i>Forked : <?php echo $project[0]->fork;?></p>
                        <p><i class="material-icons">grade</i>Favorite : <?php echo $project[0]->favorite;?></p>
						<p><i class="material-icons">perm_identity</i>Author :
						<a href="<?php echo base_url().'profile/information/'.$project[0]->ownerUserID;?>">
							<?php echo "@".$project[0]->ownerUserID;?>
						</a></p>
					</font>
				</div>
				<center>
					<a href="<?php echo base_url().'middle/detail/'.$project[0]->projectID;?>"><i class="material-icons">play_for_work</i>Edit Project</a>
				</center>
			</div>
			<div class="card-reveal orange lighten-4">
				<span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
				<font color="#000000">
					<p><i class="material-icons">loop</i>LastModified : <?php echo $project[0]->modified;?></p>
					<p><i class="material-icons">album</i>ProjectID : <?php echo $project[0]->projectID;?></p>
					<p><i class="material-icons">assignment</i>Description : <?php echo $project[0]->description;?></p>
				</font>
			</div>
		</div>
	</div>
<?php	$i++;
}
echo '</div>';

if($i==0) {
	echo "<p>現在、ランキングに関する情報がありません。</p>";
}

echo '<Div Align="right"><p><a href="'.base_url().'ranking/index/day/pv/30/0">show more...</a></p></Div>';

?>
