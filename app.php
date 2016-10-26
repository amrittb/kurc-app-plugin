<?php

$router = null;

add_action('rest_api_init','registerResponseTransformers');
add_action('rest_api_init','registerRoutes');

/**
 * Registers response transformers.
 */
function registerResponseTransformers() {
	$transformers = require_once __DIR__."/src/transformers.php";

    $registrar = new \Kurc\Transformers\Registrar();

    $registrar->registerTransformers($transformers);
    $registrar->registerTransformersToWP();
}

/**
 * Registers routes.
 */
function registerRoutes() {
    $baseNamespace = KURC_API_VENDOR."/v".KURC_API_VERSION;

    $controllerNamespace = KURC_API_CONTROLLER_NAMESPACE;

    $router = new \Kurc\Router($baseNamespace,$controllerNamespace);

    require_once __DIR__."/src/routes.php";
}
