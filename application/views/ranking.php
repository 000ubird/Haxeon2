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
	echo '<div class="col s4">';
	echo '<div class="card">';

	//1,2,3位のプロジェクトには特別な画像を表示する
	echo '<div class="card-image waves-effect waves-block waves-light">';
		if ($i == 0 && $cur_page == 0) echo '<img class="activator" src="http://localhost/haxeon/img/1st_pro.jpg">';
		else if ($i == 1 && $cur_page == 0) echo '<img class="activator" src="http://localhost/haxeon/img/2nd_pro.jpg">';
		else if ($i == 2 && $cur_page == 0) echo '<img class="activator" src="http://localhost/haxeon/img/3rd_pro.jpg">';
		else echo '<img class="activator" src="'.$base_url.'img/project.jpg">';
	echo '</div>';

	echo '<div class="card-content">';
	echo '<span class="card-title activator black-text text-darken-4">'.$project->projectName.'<i class="material-icons right">more_vert</i></span>';

        $isfavorite = false;
        $i = 0;
        //print_r($favorites);

        foreach($favorites as $favorite){
            $favo_id = $favorite->projectID;
            $pro_id = $project->projectID;

            if($favo_id == $pro_id) {
                $isfavorite = true;
                break;
            }
        }

        if($isfavorite) {
			$this->load->model('Model_favorite');
			$this->Model_favorite->updateFavoriteNum($project->projectID);
            echo '<p><a href="'.$base_url.'favorite/release_favorite/' .$project->projectID. '"><img src="'.$base_url.'img/star.png" width=30px height=30px></a></p>';
        }else{
			$this->load->model('Model_favorite');
			$this->Model_favorite->updateFavoriteNum($project->projectID);
            echo '<p><a href="'.$base_url.'favorite/regist_favorite/' .$project->projectID. '"><img src="'.$base_url.'img/unstar.png" width=30px height=30px></a></p>';
        }

	echo '<p>User : <a href="'.base_url().'profile/information/'.$project->ownerUserID.'">@'.$project->ownerUserID.'</p>';
	echo '<p>pv : '.$project->pv.'</p>';
	echo '<p>forked : '.$project->fork.'</p>';
	echo '<p><a href='.$base_url.'try-haxe/index.html#'.$project->projectID.'>Edit Code</a></p>';
	echo '</div>';

	echo '<div class="card-reveal">';
	echo '<span class="card-title grey-text text-darken-4">'.$project->projectName.'<i class="material-icons right">close</i></span>';
	echo '<p>Project ID : '.$project->projectID.'</p>';
	echo '<p>pv : '.$project->pv.'</p>';
	echo '<p>forked : '.$project->fork.'</p>';
	echo '<p>User : '.$project->ownerUserID.'</p>';
	echo '<p>Last Modified : '.$project->modified.'</p>';
	echo '</div>';

	echo '</div>';
	echo '</div>';
	$i++;
}
echo '</div>';

if($i==0) {
	echo "<p>検索に一致するプロジェクトはありません。</p>";
}

echo '<br>';
echo '<div>'.$this->pagination->create_links().'</div>';

?>
