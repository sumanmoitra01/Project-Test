<?php

include "includes/frontend_common.php";
/*print_r($_COOKIE);
echo COOKIE_EXPIRE;*/
?>

<!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Welcome to Crowdsync</title>

	<!-- Fonts -->

	<link rel="stylesheet" href="css/font-awesome.css">

  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400" rel="stylesheet"> 

	<!-- Bootstrap -->

	<link rel="stylesheet" href="<?php echo Site_Url;?>css/bootstrap.min.css" >

  <!-- jasney -->

  <link rel="stylesheet" href="<?php echo Site_Url;?>css/jasny-bootstrap.css" >

  <!-- Range slider -->

  <link rel="stylesheet" href="<?php echo Site_Url;?>css/rangeslider.css" >

  <!-- Datepicker -->
  
  <link rel="stylesheet" type="text/css" href="<?php echo Site_Url;?>css/dncalendar-skin.css">
  
  <link rel="stylesheet" href="<?php echo Site_Url;?>css/bootstrap-datepicker3.css" >

	<!-- Custom CSS -->

	<link rel="stylesheet" href="<?php echo Site_Url;?>style.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>

      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

      <![endif]-->

    </head>

    <body>

      <header>

        <div class="header-top">

          <div class="container">

            <div class="col-md-8">

              <div class="h-contact">

                <ul>

                  <li><img src="<?php echo Site_Url;?>images/phone_icon.png">+1.631.838.6087</li>

                  <li><img src="<?php echo Site_Url;?>images/mail_icon.png"><a href="mailto:info@crowdsynctechnology.com">info@crowdsynctechnology.com</a></li>

                </ul>

              </div>

              <div class="social">

                <ul>

                  <li><a href="https://www.facebook.com/crowdsynctechnology" target="_blank"><img src="<?php echo Site_Url;?>images/h_fb.png"></a></li>

                  <li><a href="http://twitter.com/crowdsyncled" target="_blank"><img src="<?php echo Site_Url;?>images/h_tweet.png"></a></li>

                </ul>

              </div>

            </div>

            <div class="col-md-4">

              <div class="h-right">
              <?php
              if($_SESSION['user_login']=='success')
              {
                $user_array1=$user->user_display($db->tbl_pre."users_tbl",array(),"where id='".$_SESSION['user_id']."'");
                ?>
                <a href="<?php echo Site_Url;?>profile.php">My Account</a>
                <a href="<?php echo Site_Url;?>logout-process.php">Logout</a>

                <input type="hidden" id="isLogin" value="1">
                <?php
              }
              else
              {
              ?>
                <a href="#" data-toggle="modal" data-target="#loginModal">Login</a>
                <input type="hidden" id="isLogin" value="0">
              <?php
              }
              ?>
              </div>

            </div>

          </div>

        </div>

        <div class="main-header">

          <div class="container">

            <div class="main-menu">

              <nav class="navbar-default" role="navigation">

                <div class="navbar-header">                 

                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">

                      <span class="icon-bar"></span>

                      <span class="icon-bar"></span>

                      <span class="icon-bar"></span>

                    </button>

                    <div class="site-logo"><a href="<?php echo Site_Url;?>"><img src="<?php echo Site_Url;?>images/CrowdSync-Logo-Main.png" alt="LJE_Sports" width="245"></a></div>                 

                </div>

                        

                <div class="collapse navbar-collapse" id="navbar-collapse-1">

                  <ul class="menu">

                    <li><a href="#">LED WRISTBANDS</a></li>

                    <li>

                      <a href="#">INFO</a>

                      <ul>

                        <li class="active"><a href="#">How it Works</a></li>

                        <li class="active"><a href="#">Faqs</a></li>

                        <li><a href="#">RFID Social Activation & Ticketing Technology</a></li>

                      </ul>

                    </li>

                    <li><a href="#">ABOUT</a></li>

                    <li><a href="#">CONTACT</a></li>

                    <li><a href="#">EVENT QUOTE</a></li>

                  </ul>

                </div><!-- /.navbar-collapse -->

              </nav>

            </div>

          </div>

        </div>

      </header>