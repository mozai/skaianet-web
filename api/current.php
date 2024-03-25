<?php
    /* this builds a JSON object for the radio staion's "current" status */
    /*
    /* {"title":"Sbroban Jungle","artist":"MyUsernamesMud","album":"Brostuck","length":219,"albumart":"\/\/radio.skaia.net\/img\/artwork\/brostuck-00.jpg","website":"https:\/\/brostuck.bandcamp.com\/album\/brostuck","reqname":"","time":1711331651,"notifytype":"1","notifytext":"CG: LISTEN WITH YOUR SKULLHOLES O:B","req_count":1,"listeners":"3"} */

    require_once('config.php');

    // title:  song title
    // artist: song artist
    // album:  song album
    // length: song length (seconds)
    // albumart: url to fetch track art
    // website: url for "click to find more" 
    // reqname: who requested this song (if applicable)
    // time: when did this song start (for progressbar)
    $recent = $DB->prepare("
      SELECT l.title as title, l.artist as artist, l.album as album,
      l.length as length, l.albumart as albumart, l.website as website,
      r.reqname as reqname, r.time as time FROM library l, recent r
      WHERE r.songid = l.id ORDER BY r.id DESC LIMIT 1; ");
    $recent->execute();
    if ($recent->rowCount() != 1) die("broke");
    $current=$recent->fetchAll(PDO::FETCH_ASSOC);
    $current=$current[0];
    /* when did this song start playing */
    $current["time"] = strtotime($current["time"]);
    /* albumart; or the default if missing from the library */
    if($current['albumart'] == "") {
      $current["albumart"] = ALBUMART_URL_NONE;
    } 
    else if( substr($current['albumart'], 0, 2) != '//' and substr($current['albumart'], 0, 4) != 'http') {
      $current['albumart'] = ALBUMART_URL . $current['albumart'];
    }

    // notifytype: 0/1/2/3 for notify colour
    // notifytext: the status message, I use it for embelishment
    $cur = $DB->prepare("SELECT name,value FROM settings;");
    $cur->execute();
    if ($cur->rowCount() < 1) { 
      $current['notifytype'] = 0;
      $current['notifytext'] = "SS: Stab";
    }
    else {
      $row = $cur->fetchAll(PDO::FETCH_KEY_PAIR);
      $current['notifytype'] = $row['notifytype'];
      $current['notifytext'] = $row['notifytext'];
    }
    
    // req_count: number to put in the 'requests:' button for queue length
    $cur = $DB->prepare("SELECT sum(1) from requests");
    $cur->execute();
    $queue_length = (int)$cur->fetch(PDO::FETCH_COLUMN, 0);
    $current['req_count'] = $queue_length;

    // listeners: how many people are here listening 
    //   faster to use file on disk, but "better" to ask icecast via TCP
    $icedata = file_get_contents(ICECAST_STATUS);
    if(preg_match('/"listeners":(\d+)/', $icedata, $preg_matches)) {
      $current["listeners"] = $preg_matches[1];
    }
    else {
      $current["listeners"] = '-1';
    } 

    // do the windy thing
    header('Content-Type: application/json');
    echo json_encode($current);
