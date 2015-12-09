
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

				<span class="card-title activator black-text"><i class="material-icons right">info</i></span>
				<div class="card-action">
						<p><i class="material-icons">visibility</i>PV : <?php echo $project[0]->pv;?></p>
                        <p><i class="material-icons">trending_down</i>Forked : <?php echo $project[0]->fork;?></p>
                        <p><i class="material-icons">grade</i>Favorite : <?php echo $project[0]->favorite;?></p>
						<p class="truncate"><i class="material-icons">perm_identity</i>
						<a href="<?php echo base_url().'profile/information/'.$project[0]->ownerUserID;?>">
							<?php echo "@".$project[0]->ownerUserID;?>
						</a></p>
                    <?php
                    $isfavorite = false;
                    $i = 0;

                    $pro_id = $project[0]->projectID;
                    foreach($favorites as $favorite){
                        $favo_id = $favorite[0]->projectID;

                        if($favo_id == $pro_id) {
                            $isfavorite = true;
                            break;
                        }
                    }

                    if($isfavorite){
                        $this->load->model('Model_favorite');
                        $this->Model_favorite->updateFavoriteNum($project[0]->projectID);
                        echo '<p><a href="' . base_url() . 'favorite/release_favorite/' . $favorite[0]->projectID . '"><span><i class="material-icons">grade</i></span></a></p>';
                    }else {
                        $this->load->model('Model_favorite');
                        $this->Model_favorite->updateFavoriteNum($project[0]->projectID);
                        echo '<p><a href="'.base_url().'favorite/regist_favorite/' .$project[0]->projectID. '"><span><i class="material-icons">stars</i></span></a></p>';
                    }
                    ?>
				</div>
				<center>
					<a href="<?php echo base_url().'middle/detail/'.$project[0]->projectID;?>"><i class="material-icons">play_for_work</i>Edit Project</a>
				</center>
			</div>
			<div class="card-reveal orange lighten-4">
				<span class="card-title black-text"><i class="material-icons right">close</i></span>
					<p><i class="material-icons">loop</i>LastModified : <?php echo $project[0]->modified;?></p>
					<p><i class="material-icons">album</i>ProjectID : <?php echo $project[0]->projectID;?></p>
					<p><i class="material-icons">assignment</i>Description : <?php echo $project[0]->description;?></p>
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
