<?php
/* what's the most recent song */
// I forget what this was for; /api/current should give the same info

require_once('config.php');

$cur = $DB->prepare("SELECT songid, title, artist, album, length, reqname, " .
                    "time FROM recent ORDER BY id DESC LIMIT 1");
$cur->execute();

if ($cur->rowCount() != 1) {
    $answer = array('success' => 0, 'title' => "failed to get recent song",
    'artist' => 'unknown', 'album' => 'unknown', 'length' => -1, 'reqname' => '');
}
else {
    $answer = $cur->fetch(PDO::FETCH_ASSOC);
    $answer["success"] = 1;
}
$answer["time"] = strtotime($recent["time"]);

// do the windy thing
header('Content-Type: application/json');
echo json_encode($answer);

