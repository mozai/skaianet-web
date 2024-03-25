<?php

$conn_user = [redacted];
$conn_pass = [redacted];
$conn_host = "localhost";
$conn_db = "skaianet";

try {
  $db = new PDO('mysql:host=' . $conn_host . ';dbname=' . $conn_db . ';', $conn_user, $conn_pass);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
  exit("Could not connect to database: " . $e->getMessage() . "<br/>");
}
