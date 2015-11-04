<h2>検索</h2>

<?php echo form_open('search/doSearch'); ?>

<div class="row">
	<form class="col s12">
		<div class="input-field col s2">
			<input id="search" type="text" class="validate" name="search">
			<label for="search">Search</label>
			<?php echo form_error('search'); ?>
		</div>
		
		<div class="input-field col s2">
			<button class="btn waves-effect waves-light" >Search!
				<i class="material-icons right">send</i>
			</button>
		</div>
		
		<p>並べ替え</p>
		<div class="input-field col s8">
			<input name="sort" type="radio" id="new" value="New" <?php if(set_radio('sort', 'New')) echo 'checked="checked"';?> />
			<label for="new">New</label>
			<input name="sort" type="radio" id="pv" value="PV" <?php if(set_radio('sort', 'PV')) echo 'checked="checked"';?> />
			<label for="pv">PV</label>
			<input name="sort" type="radio" id="name" value="Name" <?php if(set_radio('sort', 'Name')) echo 'checked="checked"';?> />
			<label for="name">Name</label>

		<p>検索対象</p>
			<input type="checkbox" id="tag" value="0" name="chk[0]" checked="checked"/>
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
