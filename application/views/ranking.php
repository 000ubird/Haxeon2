<h1>ランキング</h1>

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
			<option VALUE=<?php echo '"'.$base_url.'ranking/index/'.$days.'/'.$order.'/15/'.$cur_page.'/"'; 	if($num == 15) echo "selected";?>  >15個</option>
			<option VALUE=<?php echo '"'.$base_url.'ranking/index/'.$days.'/'.$order.'/30/'.$cur_page.'/"';		if($num == 30) echo "selected";?>  >30個</option>
			<option VALUE=<?php echo '"'.$base_url.'ranking/index/'.$days.'/'.$order.'/60/'.$cur_page.'/"'; 	if($num == 60) echo "selected";?>  >60個</option>
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
					                <p class="truncate"><a href="<?php echo base_url().'middle/detail/'.$project->projectID;?>"><?php echo $project->projectName; ?></a></p>
                                </span>

            <span class="card-title activator black-text"><i class="material-icons right">info</i></span>
            <div class="card-action">
                <p><i class="material-icons">visibility</i>PV : <?php echo $project->pv;?></p>
                <p><i class="material-icons">trending_down</i>Forked : <?php echo $project->fork;?></p>
                <p><i class="material-icons">grade</i>Favorite : <?php echo $project->favorite;?></p>
                <p class="truncate"><i class="material-icons">perm_identity</i>
                    <a href="<?php echo base_url().'profile/information/'.$project->ownerUserID;?>">
                        <?php echo "@".$project->ownerUserID;?>
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

                if($isfavorite){
                    $this->load->model('Model_favorite');
                    $this->Model_favorite->updateFavoriteNum($project->projectID);
                    echo '<p><a href="' . base_url() . 'favorite/release_favorite/' . $favorite->projectID . '"><span><i class="material-icons">grade</i></span></a></p>';
                }else {
                    $this->load->model('Model_favorite');
                    $this->Model_favorite->updateFavoriteNum($project->projectID);
                    echo '<p><a href="'.base_url().'favorite/regist_favorite/' .$project->projectID. '"><span><i class="material-icons">stars</i></span></a></p>';
                }
                ?>
            </div>

            <center>
                <a href="<?php echo base_url().'middle/detail/'.$project->projectID;?>"><i class="material-icons">play_for_work</i>Edit Project</a>
            </center>
        </div>
        <div class="card-reveal orange lighten-4">
            <span class="card-title black-text"><i class="material-icons right">close</i></span>
            <p><i class="material-icons">loop</i>LastModified : <?php echo $project->modified;?></p>
            <p><i class="material-icons">album</i>ProjectID : <?php echo $project->projectID;?></p>
            <p><i class="material-icons">assignment</i>Description : <?php echo $project->description;?></p>
        </div>

    </div>
</div>

<?php
$i++;
}
echo '</div>';

if($i==0) {
	echo "<p>検索に一致するプロジェクトはありません。</p>";
}

echo '<br>';
echo '<div>'.$this->pagination->create_links().'</div>';

?>
