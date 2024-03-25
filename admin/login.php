<?php // HOLLA!
session_start();
if (isset($_SESSION['userid'])) {
  header('Location: /admin/panel.php');
  exit(); }
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
      <h1>Skaianet Admin</h1>
<?php if (isset($_SESSION['loginerror'])) {
  echo '<h2 style="color:#f00;">'.$_SESSION['loginerror'].'</h2>'."\n";
}; unset($_SESSION['loginerror']); ?>
      <form action="/admin/submit.php" method="POST">
        <input name="act" type="hidden" value="login">
        <input name="username" type="text" autofocus placeholder="username" style="width:200px;">
        <br><input name="password" type="password" placeholder="password" style="width:200px;">
        <br><input type="submit">
      </form>
  </body>
</html>
