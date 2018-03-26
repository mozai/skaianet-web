<?php
/**
 * Configuration settings
 * copy this to 'config.php' and change the settings appropriately
 *
 */

define('DB_NAME', 'skaianet');
define('DB_USER', '__user__');
define('DB_PASS', '__pass__');
define('DB_HOST', 'localhost'); // I hope 
// charset is always utf8

// should be an absolute path ending in '/'
define('LIBRARY_PATH', '/srv/radio/library/');

// omit the protocol so you need not worry about https warnings
// should also end in '/'
define('ALBUMART_URL', '//radio.skaia.net/img/artwork/');  

// for asking icecast how many listeners we have
define('ICECAST_STATUS', 'http://localhost:8000/status-json.xsl?mount=/radio.mp3');

