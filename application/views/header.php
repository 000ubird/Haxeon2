<html>

<head>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/materialize.min.css"  media="screen,projection"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/footerFixed.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/materialize.min.js"></script>

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
                <li><a href="<?php echo base_url() ?>signup">Sign up</a></li>
                <li><a href="<?php echo base_url() ?>createproject">Create Code</a></li>
                <li><a href="<?php echo base_url() ?>ranking/index/day/pv/30/0">Ranking</a></li>
                <li><a href=<?php echo base_url() ?>profile/information/<?php echo $this->session->userdata('userID');?>>Profile</a></li>
                <li><a href="<?php echo base_url() ?>logout">Logout</a></li>
            </ul>
            <!--      スマホサイズでの表示      -->
            <ul class="side-nav" id="mobile-demo">
                <li><a href="<?php echo base_url() ?>signup">Sign up</a></li>
                <li><a href="<?php echo base_url() ?>createproject">Create Code</a></li>
                <li><a href="<?php echo base_url() ?>ranking/index/day/pv/30/0">Ranking</a></li>
                <li><a href=<?php echo base_url() ?>profile/information/<?php echo $this->session->userdata('userID');?>>Profile</a></li>
                <li><a href="<?php echo base_url() ?>logout">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>

<div class="container">
