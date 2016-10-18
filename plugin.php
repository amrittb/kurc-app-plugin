<?php
/**
 * Plugin Name: KURC API
 * Description: JSON-based REST API for WordPress, developed for KURC Website.
 * Author: Amrit Twanabasu
 * Author URI: http://amrittwanabasu.com.np
 * Version: 1.0
 * Plugin URI: https://github.com/amriterry/kurc-wp-api
 * License: GPL2+
 */

define("KURC_API_VERSION",1);
define("KURC_API_VENDOR","kurc");
define("KURC_API_CONTROLLER_NAMESPACE","Kurc\\Controllers");

add_action('plugins_loaded',function() {
	require_once __DIR__."/vendor/autoload.php";

	require_once __DIR__."/app.php";
});