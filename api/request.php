<?php
    header('Content-Type: application/json');
    require_once('config.php');
    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME .';charset=utf8', DB_USER , DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $answer = array('success' => 0, 'error' => 'null');
    $client_ip = $_SERVER['REMOTE_ADDR'];
    $req_count = $db->prepare("SELECT * FROM requests WHERE reqsrc = :remoteip");
    $req_count->execute(array(':remoteip' => $client_ip));
    if ($req_count->rowCount() >= 3) {
        $answer = array('success'=> 0, 'error' => 'Too many pending requests');
    }
    else if (isset($_POST['song']) && isset($_POST['name'])) {
        $is_exists = $db->prepare("SELECT id, title FROM library WHERE id = :sid");
        $is_exists->execute(array(':sid' => $_POST['song']));
        if ($is_exists->rowCount() < 1) {
            $answer = array('success'=> 0, 'error' => 'no such songid '. $_POST['song']); 
        }
        else {
            $song = $is_exists->fetch(PDO::FETCH_ASSOC);
            $req = $db->prepare("INSERT INTO requests (reqid, reqname, reqsrc) VALUES (:reqid, :reqname:, :reqsrc)");
            $req->execute(array(':reqid' => $_POST['song'], ':reqname' => $_POST['name'], ':reqsrc' => $_SERVER['REMOTE_ADDR']));
            $answer = array('success' => 1, 'message' => "\"" . $song['title'] . "\" queued");
        }
    }
    else {
        $answer = array('success' => 0, 'error' => 'missing input');
    } 
    echo json_encode($answer);
?>
