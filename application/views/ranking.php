<h3>ランキング</h3>

<?php

$days = $ranking['days'];
$order = $ranking['order'];
$num = $ranking['num'];
//$cur_page = $ranking['cur_page'];
$cur_page = 0;
$projects = $ranking['projects'];
$favorites = $ranking['favorites'];
$base_url = base_url();
?>

<div class="row">
	<div class="input-field col s3">表示範囲
		<select onChange="location.href=this.options[this.selectedIndex].value" class="browser-default">
			<option VALUE=<?php echo '"'.$base_url.'ranking/index/day/'.$order.'/'.$num.'/'.$cur_page.'/"'; if($days == "day") echo "selected";?> >１日</option>
			<option VALUE=<?php echo '"'.$base_url.'ranking/index/week/'.$order.'/'.$num.'/'.$cur_page.'/"';if($days == "week")echo "selected";?> >１週間</option>
			<option VALUE=<?php echo '"'.$base_url.'ranking/index/all/'.$order.'/'.$num.'/'.$cur_page.'/"'; if($days == "all") echo "selected";?> >すべて</option>
		</select>
	</div>

	<div class="input-field col s3">並べ替え
		<select onChange="location.href=this.options[this.selectedIndex].value" class="browser-default">
			<option VALUE=<?php echo '"'.$base_url.'ranking/index/'.$days.'/pv/'.$num.'/'.$cur_page.'/"';		if($order == "pv") echo "selected"; ?> >閲覧数</option>
			<option VALUE=<?php echo '"'.$base_url.'ranking/index/'.$days.'/fork/'.$num.'/'.$cur_page.'/"';		if($order == "fork")echo "selected";?> >フォーク数</option>
			<option VALUE=<?php echo '"'.$base_url.'ranking/index/'.$days.'/favorite/'.$num.'/'.$cur_page.'/"';	if($order == "favorite") echo "selected"; ?> >お気に入り数</option>
		</select>
	</div>

	<div class="input-field col s3">表示数
		<select onChange="location.href=this.options[this.selectedIndex].value" class="browser-default">
			<option VALUE=<?php echo '"'.$base_url.'ranking/index/'.$days.'/'.$order.'/20/'.$cur_page.'/"'; 	if($num == 20) echo "selected";?>  >20個</option>
			<option VALUE=<?php echo '"'.$base_url.'ranking/index/'.$days.'/'.$order.'/40/'.$cur_page.'/"';		if($num == 40) echo "selected";?>  >40個</option>
            <option VALUE=<?php echo '"'.$base_url.'ranking/index/'.$days.'/'.$order.'/60/'.$cur_page.'/"'; 	if($num == 60) echo "selected";?>  >60個</option>
			<option VALUE=<?php echo '"'.$base_url.'ranking/index/'.$days.'/'.$order.'/80/'.$cur_page.'/"'; 	if($num == 80) echo "selected";?>  >80個</option>
			<option VALUE=<?php echo '"'.$base_url.'ranking/index/'.$days.'/'.$order.'/100/'.$cur_page.'/"'; 	if($num == 100) echo "selected";?> >100個</option>
		</select>
	</div>
</div>

<?php
//カードの表示
echo '<div class="row">';
$i = 0;
foreach($projects as $project) {
?>
<div class="col s3">
    <div class="card amber">
        <div class="card-content">
            <span class="card-title">
			    <p class="truncate"><?php echo $project->projectName; ?></p>
            </span>

            <span class="card-title activator black-text"><i class="material-icons right">info</i></span>
            <div class="card-action">
                <p><i class="material-icons">visibility</i>閲覧数 : <?php echo $project->pv;?></p>
                <p><i class="material-icons">trending_down</i>フォーク数 : <?php echo $project->fork;?></p>
                <p><i class="material-icons">grade</i>お気に入り数 : <?php echo $project->favorite;?></p>
                <p class="truncate"><i class="material-icons">perm_identity</i>
                    <a href="<?php echo base_url().'profile/information/'.$project->ownerUserID;?>">
                        <?php echo $project->ownerUserID;?>
                    </a></p>
                <?php
                $isfavorite = false;
                $i = 0;

                $pro_id = $project->projectID;

                foreach($favorites as $favorite){
                    $favo_id = $favorite->projectID;

                    if($favo_id == $pro_id) {
                        $isfavorite = true;
                        break;
                    }
                }

				if($this->session->userdata('userID') !=null){
					if($isfavorite){
						$this->load->model('ModelFavorite');
						$this->ModelFavorite->updateFavoriteCount($project->projectID);
						echo '<p><a href="' . base_url() . 'favorite/releaseFavorite/' . $project->projectID . '"><span><i class="material-icons">grade</i></span></a></p>';
					}else {
						$this->load->model('ModelFavorite');
						$this->ModelFavorite->updateFavoriteCount($project->projectID);
						echo '<p><a href="'.base_url().'favorite/registerFavorite/' .$project->projectID. '"><span><i class="material-icons">stars</i></span></a></p>';
					}
				}
                ?>
            </div>

            <center>
                <a href="<?php echo base_url().'middle/detail/'.$project->projectID;?>"><i class="material-icons">play_for_work</i>プロジェクトを編集</a>
            </center>
        </div>
        <div class="card-reveal orange lighten-4">
            <span class="card-title black-text"><i class="material-icons right">close</i></span>
            <p><i class="material-icons">loop</i>最終更新日 : <?php echo $project->modified;?></p>
            <p><i class="material-icons">album</i>プロジェクトID : <?php echo $project->projectID;?></p>
            <p><i class="material-icons">assignment</i>説明 : <?php echo $project->description;?></p>
        </div>

    </div>
</div>

<?php
$i++;
}
echo '</div>';

if($i==0) {
	echo "<p>プロジェクトはありません。</p>";
}

echo '<br>';
echo '<div>'.$this->pagination->create_links().'</div>';

?>
