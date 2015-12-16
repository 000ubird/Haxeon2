<h3>検索</h3>

<?php echo form_open('search/doSearch'); ?>

<div class="row">
	<form class="col s12">
		<div class="input-field col s2">
			<input id="search" type="text" class="validate" name="search">
			<label for="search">検索文字列を入力</label>
			<?php echo form_error('search'); ?>
		</div>
		
		<div class="input-field col s2">
			<button class="btn waves-effect waves-light" >検索
				<i class="material-icons right">send</i>
			</button>
		</div>
		
		<p>並べ替え</p>
		<div class="input-field col s8">
			<input name="sort" type="radio" id="new" value="New" checked="checked" />
			<label for="new">新着</label>
			<input name="sort" type="radio" id="pv" value="PV" />
			<label for="pv">閲覧数</label>
			<input name="sort" type="radio" id="name" value="Name" />
			<label for="name">名前</label>

		<p>検索対象</p>
			<input type="checkbox" id="tag" value="0" name="chk[0]" checked="checked"/>
			<label for="tag">タグ</label>

			<input type="checkbox" id="projectName" value="1" name="chk[1]" />
			<label for="projectName">プロジェクト名</label>
			
			<input type="checkbox" id="accountID" value="2" name="chk[2]" checked="checked"/>
			<label for="accountID">アカウントID</label>
		</div>
	</form>
</div>
