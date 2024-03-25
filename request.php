<?php
    require_once('config.php');
    # TODO: mouseover of halflings-picture to get a pop-in of the album art
    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME .';charset=utf8', DB_USER , DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $songs = $db->prepare("SELECT * FROM library WHERE autoplay='1' OR requestable='1' ORDER BY album");
    $songs->execute();
    
    $client_ip = $_SERVER['REMOTE_ADDR'];
    $req_count = $db->prepare("SELECT * FROM requests WHERE reqsrc='" . $client_ip ."'");
    $req_count->execute();
    $disabled = ($req_count->rowCount() >= 3)
?>
<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js"><!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Skaianet Radio (BETA)</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/vendor/bootstrap.min.css">
        
        <!-- Material Design CSS -->
        <link rel="stylesheet" href="css/vendor/material.min.css">
        <link rel="stylesheet" href="css/vendor/ripples.min.css">
        <link rel="stylesheet" href="css/vendor/snackbar.min.css">

        <!-- Roboto Font -->
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:500,300,700,400">
        
        <style>
            body { padding-top: 20px; padding-bottom: 20px; font-family: Roboto; }
            th { cursor: pointer; }
            .link-material-blue { color: #2196f3; }
            .link-material-blue:hover { color: #2196f3; }
            table#songlist tbody tr td { vertical-align: middle; }
            .albumicon { position:relative; display:inline-block; margin:0; padding:0; }
            .albumicon a { text-decoration: none; }
            .albumicon .tooltip { visibility:hidden; opacity:0;
              text-align:center; padding: 5px 0; position: absolute;
              z-index: 1; bottom: 125%; left: 50%; 
              height: 150px; width: 150px; }
            .albumicon:hover .tooltip { visibility: visible; opacity: 1; }
        </style>
        
        <!-- Mondernizer JS and Respond JS -->
        <script src="js/vendor/modernizr.min.js"></script>
        <script src="js/vendor/respond.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="panel panel-material-red" id="panel">
                <div class="panel-heading">
                    <h3 class="panel-title" style="font-size:18pt;"><span class="mdi-av-my-library-music"></span> Request</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group has-warning col-sm-4">
                        <label class="control-label" for="inputLarge">Nickname</label>
                        <input class="form-control" type="text" id="request-name" placeholder="Anonymous" />
                    </div> 
                    <div class="form-group has-warning col-sm-4">
                        <label class="control-label" for="inputLarge">&#x1f50e;</label>
                        <input class="form-control " type="text" id="search-text" placeholder="search" />
                    </div> 
                    <div class=form-group" id="queue_status">
                        Requests Queue: 0<br>Your Requests: 0
                    </div>   
                    <table id="songlist" class="table table-striped table-hover sortable">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>&#x1F3A8;</th>
                                <th>Album</th>
                                <th>Artist</th>
                                <th>Request</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($songs as $song) {
                                echo "<tr>";
                                echo "<td>" . $song["title"] . "</td>";
                                if($song["albumart"]) {
                                    $i = $song["albumart"];
                                    if(strpos($i, '/') === false) {
                                        $i = "//radio.skaia.net/img/artwork/$i";
                                    }
                                    echo "<td><p class=albumicon><a href=\"$i\" target=_blank>&#x1F3A8;</a><img loading=lazy class=tooltip src=\"$i\"></p></td>";
                                }
                                else {
                                    echo "<td>&nbsp;</td>";
                                }
                                echo "<td>" . $song["album"] . "</td>";
                                echo "<td>" . $song["artist"] . "</td>";
                                echo "<td><button type=submit name=request-button-" . $song["id"] . " ";
                                echo " value=" . $song["id"] . " id=request-button-" . $song["id"] ." ";
                                echo " class=\"btn btn-material-red request-button btn-block\">Request</button></td>";
                                echo "</tr>\n";
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- ./container-fluid -->
        
        <!-- jQuery 2.x JS -->
        <script src="//code.jquery.com/jquery-2.1.3.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-2.1.3.js"><\/script>')</script>
        
        <!-- Bootstrap JS -->
        <script src="js/vendor/bootstrap.min.js"></script>
        
        <!-- Material Design JS -->
        <script src="js/vendor/material.min.js"></script>
        <script src="js/vendor/ripples.min.js"></script>
        <script src="js/vendor/snackbar.min.js"></script>
        <script src="js/vendor/jquery.nouislider.all.min.js"></script>
        
        <!-- SortTable -->
        <script src="js/vendor/sorttable.js"></script>

        <!-- Main JS -->
        <script src="js/request.js"></script>

    </body>
</html>
