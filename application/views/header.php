<html>

<head>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/materialize.css"  media="screen,projection"/>
<!--<link href="http://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet" type="text/css">-->
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/footerFixed.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/materialize.js"></script>

<!-- ハイライト用 -->
<link rel="stylesheet" href="<?php echo base_url()?>css/monokai-sublime.css">
    <script src="<?php echo base_url()?>js/highlight.pack.js"></script>

    <title>haxeon</title>
</head>

<body>
<header>
    <nav>
        <div class="nav-wrapper orange">
            <a href="<?php echo base_url() ?>" class="brand-logo">Haxeon</a>
            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>

            <!--     PCサイズでの表示       -->
            <ul class="right hide-on-med-and-down">

                <?php if($this->session->userdata('userID')) {
					echo '<li><a href="'.base_url().'search">検索</a></li>';
                    echo '<li><a href="'.base_url().'createproject">プロジェクト作成</a></li>';
                    echo '<li><a href="'.base_url().'ranking/index/day/pv/30/0">ランキング</a></li>';
                    echo '<li><a href="'.base_url().'profile/information/'.$this->session->userdata('userID').'">@'.$this->session->userdata('userID').'</a></li>';
                    echo '<li><a href="'.base_url().'logout">ログアウト</a></li>';
                }else{
                    echo '<li><a href="'.base_url().'profile/signup">アカウント作成</a></li>';
                    echo '<li><a href="'.base_url().'login">ログイン</a></li>';
                }
                ?>

            </ul>

            <!--      バーに隠れてる表示      -->
            <ul class="side-nav" id="mobile-demo">

                <?php if($this->session->userdata('userID')) {
					echo '<li><a href="'.base_url().'search">検索</a></li>';
                    echo '<li><a href="'.base_url().'createproject">プロジェクト作成</a></li>';
                    echo '<li><a href="'.base_url().'ranking/index/day/pv/30/0">ランキング</a></li>';
                    echo '<li><a href="'.base_url().'profile/information/'.$this->session->userdata('userID').'">@'.$this->session->userdata('userID').'</a></li>';
                    echo '<li><a href="'.base_url().'logout">ログアウト</a></li>';
                }else{
                    echo '<li><a href="'.base_url().'profile/signup">アカウント作成</a></li>';
                    echo '<li><a href="'.base_url().'login">ログイン</a></li>';
                }
                ?>

            </ul>
        </div>
    </nav>
</header>

<div class="container">
