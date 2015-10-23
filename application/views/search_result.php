<h2>検索結果</h2>

<?php echo form_open('search/doSearch'); ?>

<div class="row">
	<form class="col s12">
		<div class="input-field col s3">
			<input id="search" type="text" class="validate" name="search">
			<label for="search">Search</label>
		</div>
		
		<div class="input-field col s2">
			<button class="btn waves-effect waves-light" >Search!
				<i class="material-icons right">send</i>
			</button>
		</div>
		
		<div class="input-field col s6">
		<p>検索対象</p>
			<input type="checkbox" id="tag" value="0" name="chk[0]"/>
			<label for="tag">タグ</label>

			<input type="checkbox" id="projectName" value="1" name="chk[1]" checked="checked"/>
			<label for="projectName">プロジェクト名</label>

			<input type="checkbox" id="projectID" value="2" name="chk[2]" />
			<label for="projectID">プロジェクトID</label>

			<input type="checkbox" id="accountID" value="3" name="chk[3]" />
			<label for="accountID">アカウントID</label>
		</div>
	</form>
</div>

<div class="projects">
	<div class="row">
		<?php
			if (count($result) == 0) {
				echo "<p>条件に一致するプロジェクトはありませんでした。</p>";
			} else {
				foreach($result as $row){
					//echo $row['projectID'].$row['ownerUserID'];
					echo '	<div class="col s3">';
					echo '	<div class="card blue-grey darken-1">';
					echo '	<div class="card-content white-text">';
					echo '	<span class="card-title">'.$row['projectName'].'</span>';
					echo '	<p>ProjectID : '.$row['projectID'].'</p>';
					echo '	<p>PV : '.$row['pv'].'</p>';
					echo '	<p>Fork : '.$row['fork'].'</p>';
					echo '	<p>Last Modified : '.$row['modified'].'</p>';
					echo '	</div>';
					echo '	<div class="card-action">';
					echo '	<a href="'.base_url()."try-haxe/index.html#".$row['projectID'].'">Edit Code</a>';
					echo '	Owner : <a href="'.base_url()."profile/information/".$row['ownerUserID'].'">@'.$row['ownerUserID'].'</a>';
					echo '	</div>';
					echo '	</div>';
					echo '	</div>';
                }		
			}
		?>
	</div>
</div>