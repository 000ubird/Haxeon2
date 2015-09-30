<h1>ランキング</h1>

<?php

echo $this->pagination->create_links();
$days = $ranking['days'];
$order = $ranking['order'];
$num = $ranking['num'];
//$cur_page = $ranking['cur_page'];
$cur_page = 0;
$projects = $ranking['projects'];
$favorites = $ranking['favorites'];
echo '<ul id="dropdown2" class="dropdown-content">';
echo '<li><a href="http://localhost/haxeon/ranking/index/day/'.$order.'/'.$num.'/'.$cur_page.'/">1日</a></li>';
echo '<li><a href="http://localhost/haxeon/ranking/index/week/'.$order.'/'.$num.'/'.$cur_page.'/">1週間</a></li>';
echo '<li><a href="http://localhost/haxeon/ranking/index/all/'.$order.'/'.$num.'/'.$cur_page.'/">すべて</a></li>';
echo '</ul>';
echo '<a class="btn dropdown-button" href="#!" data-activates="dropdown2">表示範囲<i class="mdi-navigation-arrow-drop-down right"></i></a>';

echo '<ul id="dropdown3" class="dropdown-content">';
echo '<li><a href="http://localhost/haxeon/ranking/index/'.$days.'/pv/'.$num.'/'.$cur_page.'/">閲覧数</a></li>';
echo '<li><a href="http://localhost/haxeon/ranking/index/'.$days.'/fork/'.$num.'/'.$cur_page.'/">フォーク数</a></li>';
echo '<li><a href="http://localhost/haxeon/ranking/index/'.$days.'/pv/'.$num.'/'.$cur_page.'/">お気に入り数</a></li>';
echo '</ul>';
echo '<a class="btn dropdown-button" href="#!" data-activates="dropdown3">並び替え<i class="mdi-navigation-arrow-drop-down right"></i></a>';

echo '<ul id="dropdown4" class="dropdown-content">';
echo '<li><a href="http://localhost/haxeon/ranking/index/'.$days.'/pv/15/'.$cur_page.'/">15個</a></li>';
echo '<li><a href="http://localhost/haxeon/ranking/index/'.$days.'/fork/30/'.$cur_page.'/">30個</a></li>';
echo '<li><a href="http://localhost/haxeon/ranking/index/'.$days.'/fork/60/'.$cur_page.'/">60個</a></li>';
echo '<li><a href="http://localhost/haxeon/ranking/index/'.$days.'/pv/100/'.$cur_page.'/">100個</a></li>';
echo '</ul>';
echo '<a class="btn dropdown-button" href="#!" data-activates="dropdown4">表示数<i class="mdi-navigation-arrow-drop-down right"></i></a>';

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
	echo '<span class="card-title activator black-text text-darken-4">'.$project->projectName.'<i class="material-icons right">more_vert</i></span>';

    if($this->session->userdata('userID') != $project->ownerUserID){
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
            echo '<p><a href="' .base_url(). 'favorite/release_favorite/' .$project->projectID. '"><img src="'.base_url().'img/star.png" width=30px height=30px></a></p>';
        }else{
            echo '<p><a href="' .base_url(). 'favorite/regist_favorite/' .$project->projectID. '"><img src="'.base_url().'img/unstar.png" width=30px height=30px></a></p>';
        }
    }else{
        echo '<p><a href="' . base_url() . 'profile/profilesettings/' . $this->session->userdata('userID') . '"><i class="material-icons">settings</i></a></p>';
    }

	echo '<p>User : '.$project->ownerUserID.'</p>';
	echo '<p>pv : '.$project->pv.'</p>';
	echo '<p>forked : '.$project->fork.'</p>';
	echo '<p><a href=http://localhost/haxeon/try-haxe/index.html#'.$project->projectID.'>Edit Code</a></p>';
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

?>
