<?php
header('Content-Type: application/json');
$values['time']  = time();
echo(json_encode($values));
