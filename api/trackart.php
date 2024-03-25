<?php
/* serve album art */
// in case I don't want to use a folder full of static files

if(! isset($_GET["id"]) or (! is_numeric($_GET["id"]))){ http_response_code(400); die(); }
require_once("config.php");
$cur = $DB->prepare("SELECT albumart from library where id = :id");
$cur->execute(["id" => $_GET["id"]]); 
if ($cur->rowCount() != 1) { http_response_code(404); die(); }

$row = $cur->fetch(PDO::FETCH_ASSOC);
if($row['albumart'] == "") {
  $row['albumart'] = ALBUMART_NONE;
} 
#header("Content-Type: text/plain"); print_r($row); die();

if( substr($row['albumart'], 0, 2) == '//' or substr($current['albumart'], 0, 4) == 'http') {
  header("Location: " . $row['albumart']);
}
else {
  // I would rather serve from here but php readfile() mangles the HTTP headers into a file-attachment!
  header("Location: " . ALBUMART_URL . "/" . $row['albumart']);

  #$fname = ALBUMART_PATH . "/" . $current['albumart'];
  #if(! file_exists($fname)) {
  #  $fname = ALBUMART_PATH . "/" . ALBUMART_NONE;
  #}
  #$mimetype = mime_content_type($fname);
  #header("Content-Type: " . $mimetype);
  #readfile($fname);
}

