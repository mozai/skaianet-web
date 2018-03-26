<?php
require_once('../config.php');
header('Content-Type: application/json');
$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME .';charset=utf8', DB_USER , DB_PASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$cur = $db->prepare("SELECT songid, title, artist, album, length, reqname, " .
                    "time FROM recent ORDER BY id DESC LIMIT 1");
$cur->execute();
if ($cur->rowCount() != 1) {
    $answer = array('success' => 0, 'title' => "failed to get recent
    song", 'artist' => 'unknown', 'album' => 'unknown', 'length' => -1,
    'reqname' => '');
}
else {
    $recent=$cur->fetch(PDO::FETCH_ASSOC);
    $recent["success"] = 1;
    $answer = $recent;
}
$answer["time"] = strtotime($recent["time"]);
echo json_encode($answer);

