<?php
    header('Content-Type: application/json');
    require_once('../config.php');
    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME .';charset=utf8', DB_USER , DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    function submit_request($reqid, $reqname, $reqsrc) {
        global $db;
        $cur = $db->prepare("SELECT id, title FROM library WHERE id = :sid and requestable = 1");
        $cur->execute(array(':sid' => $reqid));
        if ($cur->rowCount() < 1)
            return array('success' => 0, 'message' => 'Not a requestable song' . $reqid);
        $song = $cur->fetch(PDO::FETCH_ASSOC);
        $cur = $db->prepare("INSERT INTO requests (reqid, reqname, reqsrc) VALUES (:reqid, :reqname, :reqsrc)");
        $status = $cur->execute(array(':reqid' => $reqid, ':reqname' => $reqname, ':reqsrc' => $reqsrc));
        if ($status)
            return array('success' => 1, 'message' => 'song request queued', 'reqid' => $reqid, 'title' => $song['title']);
        else
            return array('success' => 0, 'message' => 'db insert failed');
    }

    $cur = $db->prepare("SELECT sum(1) from requests where reqsrc = :reqsrc");
    $cur->execute(array(':reqsrc' => $_SERVER['REMOTE_ADDR']));
    $your_queue_length = (int)$cur->fetch(PDO::FETCH_COLUMN, 0);
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $cur = $db->prepare("SELECT songid from recent where time > date_sub(now(), interval 1 hour) UNION select reqid as songid from requests;");
        $cur->execute();
        $frozen_songids = $cur->fetchAll(PDO::FETCH_COLUMN, 0);
        sort($frozen_songids);
        $cur = $db->prepare("SELECT sum(1) from requests");
        $cur->execute();
        $queue_length = (int)$cur->fetch(PDO::FETCH_COLUMN, 0);
        $answer = array('req_count' => $queue_length, 'your_req_count' => $your_queue_length, 'on_cooldown' => $frozen_songids);
    }
    else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (! (isset($_POST['song']) && isset($_POST['name'])))
            $answer = array('success' => 0, 'message' => 'missing input');
        else if ($your_queue_length > REQUEST_LIMIT)
            $answer = array('success' => 0, 'message' => 'Too many pending requests');
        else if ($queue_length > (REQUEST_LIMIT * 5))
            $answer = array('success' => 0, 'message' => 'Too many pending requests');
        else if (in_array($_POST['song'], $frozen_songids))
            $answer = array('success' => 0, 'message' => 'Requested song is on cooldown');
        else
            $answer = submit_request($_POST['song'], $_POST['name'], $_SERVER['REMOTE_ADDR']);
    }
    else {
        $answer = array('success' => 0, 'message' => 'Unknown request type');
    }
    echo json_encode($answer);
?>
