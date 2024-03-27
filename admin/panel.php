<?php

session_start();
if (!isset($_SESSION['userid'])) { header('Location: /admin'); exit(); }
include('inc/config.php');
include('inc/lib.php');
$user = new Account($db, $_SESSION['userid']);

$reqs = $db->prepare("SELECT * FROM requests;");
$reqs->execute();

include('inc/header.php');
?>
<div class="row-fluid" style="height:100%">
  <div class="col-sm-4 col-lg-3 well">
    <div class="progress">
      <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
    </div>           
    <img id="curAlbumArt" style="float:right;width:120px;height:120px;" src=""/>
    <b>Søng:</b> <span id="curSong">LOADING...</span><br>
    <b>Artist:</b> <span id="curArtist">LOADING...</span><br>
    <b>Album:</b> <span id="curAlbum">LOADING...</span><br>
    <b>Requested by:</b> <span id="curRequestor">LOADING...</span><br>
    <b>Listeners:</b> <span id="listeners">LOADING...</span> <a><br> 
    <b>Notice:</b><br>
    <div class="alert-section" style="visibility:hidden;"></div><br>
    <a class="btn btn-default">Edit Metadata</a> <button type="button" class="btn btn-default" data-toggle="modal" data-target="#skipSongConfirm">Skip Song</a>
  </div>
  <div class="col-sm-8 col-lg-9">
    <iframe id="theIframe" src="//radio.skaia.net/api/recent.php" style="width:100%;height:800px"></iframe>
  </div>
</div>
<div class="modal fade" id="skipSongConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        Are you sure that you want to skip the current song?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button id="skipSongButton" type="button" class="btn btn-primary" onclick="$('#skipSongConfirm').modal('hide');">Skip Song</button>
      </div>
    </div>
  </div>
</div>
<?php include('inc/footer.php'); ?>
