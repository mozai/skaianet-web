<?php
  require_once 'MobileDetect-3.74.3.php';
  use Detection\MobileDetect;
  $detect = new MobileDetect;
  if ($detect->isMobile() || $detect->isTablet()) { header('Location: https://radio.skaia.net/m'); }
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#4CAF50">
  <!-- SEO Junk -->
  <title>Skaianet Radio</title>
  <meta name="description" content="Welcome to Skaianet Radio, the original Homestuck music site!  Playing all official, unofficial and fan-made songs 24 hours a day, 7 days a week.">
  <meta property="og:title" content="Skaianet Radio: 24/7 Homestuck Music">
  <meta property="og:image" content="https://radio.skaia.net/img/base.png">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://radio.skaia.net/">
  <meta property="og:description" content="Welcome to the newly improved Skaianet Radio, the first and original Homestuck music site!  Playing all offical, unoffical, and fan-made songs 24 hours a day, 7 days a week.">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="@Skaianet">
  <meta name="twitter:title" content="Skaianet Radio: 24/7 Homestuck Music">
  <meta name="twitter:description" content="Welcome to the newly improved Skaianet Radio, the first and original Homestuck music site!">
  <meta name="twitter:image" content="https://radio.skaia.net/img/base.png">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/vendor/bootstrap.min.css">
  <!-- Material Design CSS -->
  <link rel="stylesheet" href="css/vendor/material-wfont.min.css">
  <link rel="stylesheet" href="css/vendor/ripples.min.css">
  <link rel="stylesheet" href="css/vendor/snackbar.min.css">
  <!-- Main CSS -->
  <link rel="stylesheet" href="css/skaianet.css">
  <!-- Mondernizer JS and Respond JS -->
  <script src="js/vendor/modernizr.min.js"></script>
  <script src="js/vendor/respond.min.js"></script>
</head>
<body>
  <div id="radio-container" style="display:none;"></div>
  <div class="container-full" id="header">
    <!-- Album Art -->
    <img src="https://dl.skaia.net/images/albums/disc/3.png" width="124px" height="auto" class="album-art-section" id="album-art">
    <!-- Canvas (Spectrum) -->
    <canvas class="canvas-section" id="spectrum"></canvas>
    <!-- Metadata -->
    <div class="metadata-section">
      <img src="img/banner_light.png" width="332px" height="26px" style="margin-bottom:8px;">
      <div class="well well-sm" id="well">
        <span id="curSong">Loading...</span><br>
        <b>Artist:</b> <span id="curArtist">Loading...</span><br>
        <a id='website' target=_blank href='#'><span class="glyphicon glyphicon-link"></span></a>
        <b>Album:</b> <span id="curAlbum">Loading...</span>
      </div>
    </div>
    <!-- Play/Pause -->
    <div class="playback-control-section">
      <div class="playback-control">
        <a href="javascript:void(0);" class="btn btn-material-grey-100 btn-sq" id="playback-control"><span class="mdi-av-pause"></span></a>
      </div>
    </div>
    <!-- Volume Control -->
    <div class="volume-control-section">
      <div class="slider shor slider-material-green" id="volume-control" onchange="setVolume()"></div>
    </div>
    <!-- Listeners -->
    <div class="listener-section">
      <span id="listeners">0</span> <span class="glyphicon glyphicon-headphones">
    </div>
    <!-- Progress Bar -->
    <div class="progress progress-bar-section">
      <div class="progress-bar progress-bar-material-green" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
    </div>
    <!-- Alerts -->
    <div class="alert-section" style="visibility:hidden;"></div>
    <!-- Recent -->
    <div class="recent-section" style="visibility:hidden;"></div>
    <!-- Requests -->
    <div class="request-section" style="visibility:hidden;"></div>
  </div> <!-- ./container-full -->
  <div class="container-full" id="body">
    <!-- Webchat -->
    <!-- <iframe id="webchat" src="https://skaia.net/chat" scrolling="no" style="width:100%;height:100%;"></iframe> -->
    <iframe id="webchat" src="https://webchat.esper.net/?nick=&channels=skaianet_chat&fg_color=ededed&fg_sec_color=c7c7c7&bg_color=121212" scrolling="no" style="width:100%;height:100%;"></iframe>
  </div> <!-- ./container-full -->
  <!-- jQuery 2.x JS -->
  <script src="js/vendor/jquery-2.1.3.js"></script>
  <!-- Bootstrap JS -->
  <script src="js/vendor/bootstrap.min.js"></script>
  <!-- Material Design JS -->
  <script src="js/vendor/material.min.js"></script>
  <script src="js/vendor/ripples.min.js"></script>
  <script src="js/vendor/snackbar.min.js"></script>
  <script src="js/vendor/jquery.nouislider.all.min.js"></script>
  <!-- Main JS -->
  <script src="js/skaianet.js"></script>
</body>

