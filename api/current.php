<?php
    header('Content-Type: application/json');
    require_once('../config.php');
    $defaultalbumart = ALBUMART_URL . 'none.png';

    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME .';charset=utf8', DB_USER , DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // what's currently playing
    $recent = $db->prepare("
        SELECT l.title as title, l.artist as artist, l.album as album,
        l.length as length, l.albumart as albumart, l.website as website,
        r.reqname as reqname, r.time as time FROM library l, recent r
        WHERE r.songid = l.id ORDER BY r.id DESC LIMIT 1; ");
    $recent->execute();
    if ($recent->rowCount() != 1) die("broke");
    $current=$recent->fetchAll(PDO::FETCH_ASSOC);
    $current=$current[0];
    $current["time"] = strtotime($current["time"]);
    if($current['albumart'] == "") {
        $current["albumart"] = $defaultalbumart;
    } 
    else if( substr($current['albumart'], 0, 4) != 'http') {
        $current['albumart'] = ALBUMART_URL . $current['albumart'];
    }

    // get notify text
    $settns = $db->prepare("SELECT notifytype,notifytext FROM settings WHERE id=1");
    $settns->execute();
    if ($settns->rowCount() != 1) die("broke");
    $settns=$settns->fetchAll(PDO::FETCH_ASSOC);
    $settns=$settns[0];
    $current['notifytype'] = $settns['notifytype'];
    $current['notifytext'] = $settns['notifytext'];
    
    // get listener count
    /* $icedata = file_get_contents('http://radio.skaia.net:8000/7.xsl?mount=/radio.mp3');
       $icedata = explode(',', $icedata);
       $current["listeners"] = preg_replace('/\\n/', '', explode('>', $icedata[0])[1]);
    */
    $icedata = file_get_contents(ICECAST_STATUS);
    if(preg_match('/"listeners":(\d+)/', $icedata, $preg_matches)) {
        $current["listeners"] = $preg_matches[1];
    }
    else {
        $current["listeners"] = '-1';
    } 

    // do the windy thing
    echo json_encode($current);
?>
