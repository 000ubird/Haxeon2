
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
    if ($i == 0 && $cur_page == 0) echo '<img class="activator" src="'.base_url().'img/1st_pro.jpg">';
    else if ($i == 1 && $cur_page == 0) echo '<img class="activator" src="'.base_url().'img/2nd_pro.jpg">';
    else if ($i == 2 && $cur_page == 0) echo '<img class="activator" src="'.base_url().'img/3rd_pro.jpg">';
    else echo '<img class="activator" src="'.base_url().'img/project.jpg">';
    echo '</div>';

	echo '<div class="card-content">';
    echo '<span class="card-title activator black-text text-darken-4">' . $project[0]->projectName;
    if($project[0]->ownerUserID == $this->session->userdata('userID')) echo '<a href="'.base_url() . 'profile/projectsettings/' . $project[0]->projectID . '"><i class="material-icons">settings</i></a>';
    echo '</span>';
	echo '<p>User : <a href="'.base_url().'profile/information/'.$project[0]->ownerUserID.'">@'.$project[0]->ownerUserID.'</p>';
	echo '<p>PV : '.$project[0]->pv.'</p>';
	echo '<p>Fork : '.$project[0]->fork.'</p>';
	echo '<p><a href="'.base_url().'try-haxe/index.html#'.$project[0]->projectID.'">Edit Code</a></p>';
	echo '</div>';

	echo '<div class="card-reveal">';
	echo '<span class="card-title grey-text text-darken-4">'.$project[0]->projectName.'<i class="material-icons right">close</i></span>';
	echo '<p>Project ID : '.$project[0]->projectID.'</p>';
	echo '<p>pv : '.$project[0]->pv.'</p>';
	echo '<p>User : '.$project[0]->ownerUserID.'</p>';
	echo '</div>';

	echo '</div>';
	echo '</div>';
	$i++;
}
echo '</div>';

if($i==0) {
	echo "<p>現在、ランキングに関する情報がありません。</p>";
}

echo '<Div Align="right"><p><a href="'.base_url().'ranking/index/day/pv/30/0">show more...</a></p></Div>';

?>
