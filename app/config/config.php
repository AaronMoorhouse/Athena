<?php
define( 'AUTH_HOST', 'localhost' );
define( 'AUTH_USER', 'u1354494' );
define( 'AUTH_PASS', '22/07/95' );
define( 'AUTH_DATABASE', 'u1354494' );

date_default_timezone_set('Europe/London');

// Leave as empty string if not using table name prefixes
define( 'PREFIX', '' );

// Root directory of site on server
define('ROOT', 'https://selene.hud.ac.uk/u1354494/athena');

// True when not developing
define('TESTING', true);

if(TESTING) {
	error_reporting(E_ALL);
}
?>