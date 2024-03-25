<?php
/* I don't know what this is used for */

// time: current clock time on the server, I guess?
$values['time']  = time();

// do the windy thing
header('Content-Type: application/json');
echo(json_encode($values));
