<?php

if ( ! defined( 'WDM_TT_TD' ) ) {
	define( 'WDM_TT_TD', 'wd-market-test' );
}

// Load the composer autoloader to use WP Mock
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

// Bootstrap WP_Mock to initialize built-in features
WP_Mock::bootstrap();
