<div align="center">
<img src="img/top.jpg" width="767" height="230" alt="">
</div>

<h2>Today's HotCode!</h2>

<?php
$cur_page = 0;
$projects = $ranking['projects'];

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
		else echo '<img class="activator" src="http://localhost/haxeon/img/project.jpg">';
	echo '</div>';

	echo '<div class="card-content">';
	echo '<span class="card-title activator black-text text-darken-4">'.$project->proID.'<i class="material-icons right">more_vert</i></span>';
	echo '<p>User : '.$project->usrID.'</p>';
	echo '<p>pv : '.$project->pv.'</p>';
	echo '<p><a href=http://localhost/haxeon/try-haxe/index.html#'.$project->proID.'>Edit Code</a></p>';
	echo '</div>';

	echo '<div class="card-reveal">';
	echo '<span class="card-title grey-text text-darken-4">'.$project->proID.'<i class="material-icons right">close</i></span>';
	echo '<p>Project ID : '.$project->proID.'</p>';
	echo '<p>pv : '.$project->pv.'</p>';
	echo '<p>User : '.$project->usrID.'</p>';
	echo '</div>';

	echo '</div>';
	echo '</div>';
	$i++;
}
echo '</div>';

if($i==0) {
	echo "<p>現在、ランキングに関する情報がありません。</p>";
}

?>
