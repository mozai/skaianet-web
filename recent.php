<?php
    require_once('config.php');
    $defaultalbumart = ALBUMART_URL . 'none.png';
    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME .';charset=utf8', DB_USER , DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $songs = $db->query("SELECT * FROM recent WHERE time > DATE_SUB(NOW(), INTERVAL 1 HOUR) ORDER BY time DESC");
    $howmany = $songs->rowCount();
?>
<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js"><!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="refresh" content="180">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#2196F3">
  <title>Skaianet Radio :: Recents</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/vendor/bootstrap.min.css">
  <!-- Material Design CSS -->
  <link rel="stylesheet" href="css/vendor/material-wfont.min.css">
  <link rel="stylesheet" href="css/vendor/ripples.min.css">
  <link rel="stylesheet" href="css/vendor/snackbar.min.css">
  <style>
    body {
      padding-top: 20px;
      padding-bottom: 20px;
      font-family: RobotoDraft, Roboto, Helvetica Neue, Helvetica, Arial, sans-serif;
    }
    th { cursor: pointer; }
    .link-material-purple { color: #9c27b0; }
    .link-material-purple:hover { color: #9c27b0; }
    .request { color:#fff; background:#009900; }
  </style>
  <!-- Mondernizer JS and Respond JS -->
  <script src="js/vendor/modernizr.min.js"></script>
  <script src="js/vendor/respond.min.js"></script>
</head>
<body>
  <div class="container-fluid">
    <div class="panel panel-material-purple" id="panel">
      <div class="panel-heading">
        <h3 class="panel-title" style="font-size:18pt;"><span class="mdi-action-restore"></span> Recents</h3>
      </div>
      <div class="panel-body">
        <p><h4>These are the last <?=$howmany?> songs that played on <a href="http://radio.skaia.net" class="link-material-purple">Skaianet Radio</a>.</h4></p>
        <table class="table table-striped table-hover sortable">
          <thead><tr>
            <th>#</th>
            <th>Title</th>
            <th>Album</th>
            <th>Artist</th>
            <th>Listeners</th>
          </tr></thead>
          <tbody>
            <?php
            $i = 1;
            foreach ($songs as $song) {
              if ($i == 1)
                echo "<tr class=\"success\" id=\"" . $song["id"] . "\">\n";
              else
                echo "<tr id=\"" . $song["id"] . "\">\n";
              echo "<td>" . $i . "</td>\n";
              if ($song['reqname'])
                echo "<td> ".$song["title"]." <span class=request title=\"". $song['reqname']."\">Request</span></td>\n";
              else
                echo "<td>" . $song["title"] . "</td>\n";
              echo "<td>" . $song["album"] . "</td>\n";
              echo "<td>" . $song["artist"] . "</td>\n";
              echo "<td>" . ($song["listeners"] ?? '--') . "</td>\n";
              echo "</tr>\n";
              $i++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div> <!-- ./container-fluid -->
  <!-- jQuery 2.x JS -->
  <script src="js/vendor/jquery-2.1.3.js"></script>
  <!-- Bootstrap JS -->
  <script src="js/vendor/bootstrap.min.js"></script>
  <!-- Material Design JS -->
  <script src="js/vendor/material.min.js"></script>
  <script src="js/vendor/ripples.min.js"></script>
  <script src="js/vendor/snackbar.min.js"></script>
  <script src="js/vendor/jquery.nouislider.all.min.js"></script>
  <!-- SortTable -->
  <script src="js/vendor/sorttable.js"></script>
  <!-- Google Analytics -->
  <script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-37431936-4', 'auto');ga('send', 'pageview');</script>
</body>
