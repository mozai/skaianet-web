<?php

session_start();

if (isset($_SESSION['userid'])) {
    header('Location: ./panel.php');
} else {
    header('Location: ./login.php');
}
