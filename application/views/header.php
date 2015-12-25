<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"></meta>
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>js/materialize.js"></script>
	<script src="<?php echo base_url()?>js/highlight.pack.js"></script>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/materialize.css"  media="screen,projection"></link>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"></link>
	<link rel="stylesheet" href="<?php echo base_url()?>css/monokai-sublime.css"></link>
	
	<title>Haxeon</title>
</head>

<body>
<header>
    <nav>
        <div class="nav-wrapper orange">
            <a href="<?php echo base_url() ?>" class="brand-logo">Haxeon</a>
            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
			
			<ul class="right hide-on-med-and-down">
			<?php
				//ログイン中の場合
				if($this->session->userdata('userID')) { ?>
				<li>
					<a href="<?php echo base_url();?>search">検索</a>
				</li>
				<li>
					<a href="<?php echo base_url();?>createproject">プロジェクト作成</a>
				</li>
				<li>
					<a href="<?php echo base_url();?>ranking/index/day/pv/30/0">ランキング</a>
				</li>
				<li>
					<a href="<?php echo base_url();?>profile/information/<?php echo $this->session->userdata('userID');?>"><?php echo $this->session->userdata('userID')?></a>
				</li>
				<li>
					<a href="<?php echo base_url();?>logout">ログアウト</a>
				</li>
			<?php }else{ ?>
				<li>
					<a href="<?php echo base_url();?>profile/signup">アカウント作成</a>
				</li>
				<li>
					<a href="<?php echo base_url();?>login">ログイン</a>
				</li>
		   <?php } ?>
			</ul>
			
            <!--      バーに隠れてる表示      -->
            <ul class="side-nav" id="mobile-demo">
                <?php if($this->session->userdata('userID')) { ?>
				<li>
					<a href="<?php echo base_url();?>search">検索</a>
				</li>
				<li>
					<a href="<?php echo base_url();?>createproject">プロジェクト作成</a>
				</li>
				<li>
					<a href="<?php echo base_url();?>ranking/index/day/pv/30/0">ランキング</a>
				</li>
				<li>
					<a href="<?php echo base_url();?>profile/information/<?php echo $this->session->userdata('userID');?>"><?php echo $this->session->userdata('userID')?></a>
				</li>
				<li>
					<a href="<?php echo base_url();?>logout">ログアウト</a>
				</li>
                <?php }else{ ?>
				<li>
					<a href="<?php echo base_url();?>profile/signup">アカウント作成</a>
				</li>
				<li>
					<a href="<?php echo base_url();?>login">ログイン</a>
				</li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</header>

<main>
<div class="container">
