<?php // HOLLA!

session_start();
include('inc/config.php');
include('inc/lib.php');

if (isset($_SESSION['userid'])) {
    $user = new Account($db, $_SESSION['userid']);
} else {
    $user = new Account($db);
}
function ajaxfalse() {
    echo json_encode(array('status' => false));
}
function needauth() {
    if (isset($user)) { header('Location: /admin/login.php'); }
}

switch($_REQUEST['act']) {

    case "login":
        if ($user->auth($_REQUEST['username'], $_REQUEST['password'])) {
            $_SESSION['userid'] = $user->userid;
            if ($user->needreset != 0) { header('Location: /admin/chpw.php'); } 
            else { header('Location: /admin/panel.php'); }
        } else {
            $_SESSION['loginerror'] = 'invalid username or password';
            header('Location: /admin/login.php');
        }
        break;

    case "changepw":
        needauth();
        if (!empty($_REQUEST['password'])) {
            $user->setpw($_REQUEST['password']);
        }
        header('Location: /admin/panel.php');
        break;

    case "skipsong":
        needauth();
        if (true) {
            echo json_encode(array('status' => true));
        } else {
            ajaxfalse();
        }
        break;

    default:
        ajaxfalse();
        break;

}
