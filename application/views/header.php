<!-- <!DOCTYPE html> -->
<link rel="stylesheet" href="../css/header.css" type="text/css" />

<html lang="ja">
	
<head>
	<a href=<?php echo base_url();?>>haxeon</a>
	<a href=<?php echo base_url();?>create>Create Project</a>
	<a href=<?php echo base_url();?>question>Questions</a>
	<a href=<?php echo base_url();?>ranking>Ranking</a>
	
	<?php if($isLogin) { ?>
		<a href=<?php echo base_url();?>account>Account</a>
		<a href=<?php echo $url; ?>>icon</a>
	<?php } else { ?>
		<a href=<?php echo base_url();?>login>Login</a>
		<a href=<?php echo base_url();?>signup>Signup</a>
	<?php } ?>
	<a href=<?php echo base_url();?>about>About</a>
</head>
