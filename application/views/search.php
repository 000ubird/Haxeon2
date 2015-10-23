<h2>検索</h2>

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

			<input type="checkbox" id="projectName" value="1" name="chk[1]" />
			<label for="projectName">プロジェクト名</label>

			<input type="checkbox" id="projectID" value="2" name="chk[2]" />
			<label for="projectID">プロジェクトID</label>

			<input type="checkbox" id="accountID" value="3" name="chk[3]" />
			<label for="accountID">アカウントID</label>
		</div>
	</form>
</div>
