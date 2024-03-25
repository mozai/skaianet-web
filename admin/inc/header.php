<?php if (!isset($_SESSION['userid'])) { header('Location: /'); exit(); } ?>
<!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <title>Skaianet - Admin</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <style type="text/css">
      html, body { height:100%; width: 100%; }
      body {
        padding-top: 70px;
        padding-bottom: 30px;
      }
    </style>
  </head>
  <body role="document">
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Skaianet Admin</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#recent" onclick="changeIframe('//radio.skaia.net/recent.php');">Recent</a></li>
            <li class="active"><a href="#songlist" onclick="changeIframe('//radio.skaia.net/songlist.php');">SongList</a></li>
            <li class="active"><a href="#request" onclick="changeIframe('//radio.skaia.net/request.php');">Request</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo($user->username); ?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li class="dropdown-header">Level <?php echo($user->userlevel); ?> access</li>
                  <li><a href="/chpw.php">Change Password</a></li>
                  <li><a href="/logout.php">Log Out</a></li>
                </ul>
              </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container-fluid" role="main">
