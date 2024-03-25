<?php // HOLLA!

session_start();
if (!isset($_SESSION['userid'])) { header('Location: /admin'); exit(); }
include('inc/config.php');
include('inc/lib.php');
$user = new Account($db, $_SESSION['userid']);

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Skaianet - Admin</title>
  </head>
  <style type="text/css">
    html,body {
      color: #ffffff;
      background-color: #000000;
      height: 100%;
      padding: 0;
      margin: 0;
      display: -webkit-box;
      display: -moz-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .modal {
      color: #0E0;
      background-color: #030;
      box-shadow: 0px 0px 20px 20px #030;
      text-align: center;
      font-family: sans-serif;
    }
  </style>
  <body>
    <div class="modal">
      <h1 style="color:cyan;">Welcome, <?php echo($user->username); ?>!</h1>
      <h2 style="color:#ff0;">You need to change your password.</h2>
      <form action="submit.php" method="POST" autocomplete="off">
        <input name="act" type="hidden" value="changepw">
        <input name="password" type="password" placeholder="new password" style="width:200px;" autofocus autocomplete="off">
        <input type="submit">
      </form>
  </body>
</html>
