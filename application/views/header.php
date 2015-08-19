<!-- <!DOCTYPE html> -->
<link rel="stylesheet" href="../css/header.css" type="text/css" />

<html lang="ja">

<head>
	<a href=<?php echo base_url();?>>haxeon</a>
	<a href=<?php echo base_url();?>createproject>Create Project</a>
	<a href=<?php echo base_url();?>question>Questions</a>
	<a href=<?php echo base_url();?>ranking>Ranking</a>

	<?php if($this->session->userdata('userID') != "") { ?>
		ログイン済みです。
		<a href=<?php echo base_url();?>account>Account</a>
        <a href=<?php echo base_url();?>logout>Logout</a>
        <a href=<?php echo base_url();?>profile><img src=<?php echo "icon_URL"?></a>
	<?php } else { ?>
		未ログイン状態です。
		<a href=<?php echo base_url();?>login>Login</a>
		<a href=<?php echo base_url();?>signup>Signup</a>
	<?php } ?>
	<a href=<?php echo base_url();?>about>About</a>
</head>
