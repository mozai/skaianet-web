<?php
    require_once('config.php');
    $defaultalbumart = ALBUMART_URL . 'none.png';
    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME .';charset=utf8', DB_USER , DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $songs = $db->prepare("SELECT * FROM library WHERE autoplay='1' OR requestable='1' ORDER BY album, id");
    $songs->execute();
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
        <meta name="theme-color" content="#2196F3">
        <title>Skaianet Radio :: Songlist</title>

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
            
            th {
                cursor: pointer;
            }
            
            .link-material-blue {
                color: #2196f3;
            }
            
            .link-material-blue:hover {
                color: #2196f3;
            }
        </style>
        
        <!-- Mondernizer JS and Respond JS -->
        <script src="js/vendor/modernizr.min.js"></script>
        <script src="js/vendor/respond.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="panel panel-material-blue" id="panel">
                <div class="panel-heading">
                    <h3 class="panel-title" style="font-size:18pt;"><span class="mdi-av-my-library-music"></span> Songlist</h3>
                </div>
                <div class="panel-body">
                    <p>
                        <h4><b>Total:</b> <?php echo $songs->rowCount(); ?></h4>
                        Press <code>Ctrl+F</code> on your keyboard to search through the list. <a href="http://skaia.net/submit" class="link-material-blue">Click here</a> to send us more music.
                    </p>
                    <table class="table table-striped table-hover sortable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Album</th>
                                <th>Artist</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                foreach ($songs as $song) {
                                    if ($i == 1)
                                        echo "<tr id=\"" . $song["id"] . "\">\n";
                                    else
                                        echo "                            <tr id=\"" . $song["id"] . "\">\n";
                                    echo "                                <td>" . $i . "</td>\n";
                                    echo "                                <td>" . $song["title"] . "</td>\n";
                                    echo "                                <td>" . $song["album"] . "</td>\n";
                                    echo "                                <td>" . $song["artist"] . "</td>\n";
                                    echo "                            </tr>\n";
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

    </body>
</html>

