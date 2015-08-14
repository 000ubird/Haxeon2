<html>
	
<link href="../css/common.css" type="text/css" rel="stylesheet" />

<!-- ヘッダー -->
<div id="header"><h1><a href=""><img src="../img/haxeon_icon.png" style="width:auto; height:75px;"></a></h1></div>

<!-- タブリスト　-->
<div class="menu">
	<ul>
		<!-- ログイン時はアカウント名とサービスを表示　-->
		<?php if($isLogin) { ?>
		<li><h3>Hello, <img src=<?php echo $iconURL ?> width=35px height=35px> {$userName}</h3>
			<ul>
				<li><a href=<?phpecho $commonURL?>profile.php?id={$id}>Profile</a></li>
				<li><a href="#">Posted Codes</a></li>
				<li><a href="#">Favorite Codes</a></li>
				<li><a href=<?phpecho$commonURL?>followlist.php>Followers</a></li>
				<li><a href=<?phpecho$commonURL?>logout.php>Logout</a></li>
			</ul>
		</li>
		<!-- 未ログイン時はログインとサインアップのリンクを表示　-->
		<?php } else { ?>
		<li>Accounts
			<ul>
				<li><a href=<?php $commonURL?>>Login</a></li>
				<li><a href=<?php $commonURL?>>SignUp</li>
			</ul>
		</li>
		<?php } ?>
		<li>Ranking
			<ul>
				<li><a href="#">Page View Ranking</a></li>
				<li><a href="#">Favorite Ranking</a></li>
				<li><a href="#">Forked Count Ranking</a></li>
			</ul>
		</li>

		<li>Code
			<ul>
				<li><a href={$commonURL}create_form.php>Create Project</a></li>
			</ul>
		</li>

		<li>Q＆A
			<ul>
				<li><a href="#">New Question</a></li>
				<li><a href="#">Hot Questions</a></li>
			</ul>
		</li>

		<li>About Haxe
			<ul>
				<li><a href="http://api.haxe.org/">Api</a></li>
				<li><a href="https://github.com/HaxeFoundation/haxe">Github</a></li>
				<li><a href="http://sipo.jp/blog/2014/01/25.html">enumのすごさ</a></li>
			</ul>
		</li>
	</ul>
</div>

</html>