<?php
/* on GET, report status of request queue */
/* on POST, process a play-song-next request */
  
require_once('config.php');


// req_count: how many requests are in the queue
$cur = $DB->prepare("SELECT sum(1) from requests");
$cur->execute();
$req_count = (int)$cur->fetch(PDO::FETCH_COLUMN, 0);

// your_req_count: how many songs in the queue are yours?
$cur = $DB->prepare("SELECT sum(1) from requests where reqsrc = :reqsrc");
$cur->execute(array(':reqsrc' => $_SERVER['REMOTE_ADDR']));
$your_req_count = (int)$cur->fetch(PDO::FETCH_COLUMN, 0);

// on_cooldown: list of songids that cant be requested because they were too recent
$cur = $DB->prepare("SELECT songid from recent where time > date_sub(now(), interval 1 hour) UNION select reqid as songid from requests;");
$cur->execute();
$on_cooldown = $cur->fetchAll(PDO::FETCH_COLUMN, 0);
sort($on_cooldown);


// GET: asking for status
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $answer = array('req_count' => $req_count, 'your_req_count' => $your_req_count,
                  'on_cooldown' => $on_cooldown);
}
// POST: submitting a request
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // validate input
  if (! (isset($_POST['song']) && isset($_POST['name'])))
    $answer = array('success' => 0, 'message' => 'missing input');
  else if ($your_req_count > REQUEST_LIMIT)
    $answer = array('success' => 0, 'message' => 'Too many pending requests');
  else if ($req_count > (REQUEST_LIMIT * 5))
    $answer = array('success' => 0, 'message' => 'Too many pending requests');
  else if (in_array($_POST['song'], $on_cooldown))
    $answer = array('success' => 0, 'message' => 'Requested song is on cooldown');
  else
    $reqid = $_POST['song'];
    $reqname = $_POST['name'];
    $reqsrc = $_SERVER['REMOTE_ADDR'];
    $cur = $DB->prepare("SELECT id, title FROM library WHERE id = :sid and requestable = 1");
    $cur->execute(array(':sid' => $reqid));
    if ($cur->rowCount() < 1) {
      $answer = array('success' => 0, 'message' => 'Not a requestable song' . $reqid);
    }
    else {
      $song = $cur->fetch(PDO::FETCH_ASSOC);
      $cur = $DB->prepare("INSERT INTO requests (reqid, reqname, reqsrc) VALUES (:reqid, :reqname, :reqsrc)");
      $status = $cur->execute(array(':reqid' => $reqid, ':reqname' => $reqname, ':reqsrc' => $reqsrc));
      if ($status) {
        $answer = array('success' => 1, 'message' => 'song request queued', 'reqid' => $reqid, 'title' => $song['title']);
      }
      else {
        $answer = array('success' => 0, 'message' => 'db insert failed');
      }
    }
  }
else {
  $answer = array('success' => 0, 'message' => 'Unknown request type');
}

// do the windy thing
header('Content-Type: application/json');
echo json_encode($answer);
