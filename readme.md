# KURC Wordpress API plugin

This wordpress plugin is built on top of [WP REST API](http://v2.wp-api.org/) plugin. Install this plugin first then install this.

## Installation

* Clone this repo to <wp-dir>/wp-content/plugins.
``` sh
git clone https://github.com/amriterry/kurc-wp-api.git
```

* Run dump autoload files via composer.
``` sh
composer dump-autoload
```

## Adding Routes

Add all needed routes to src/routes.php.

``` php
<?php

$router->get('endpoint',
               'ControllerClassName@controlleraction',
                $args = array(),
                $permissionCallback,
                $sanitationCallback);
```

This will generate a route by default for:
*http://{wp_root}/wp-json/{vendor}/v{version_no}/endpoint*.

> Controllers should be placed inside **src/Controllers** directory and must extend **WP_REST_Controller** class of the WP REST API Plugin with a defined Class Namespace (*Kurc/Controllers* by default). 

> Controllers are PSR-4 Loaded.

### Configuring routes

Route vendor and version along with controller namespace can be configured in **plugin.php** file.

``` php
<?php 

define("KURC_API_VERSION",VERSION_NO);
define("KURC_API_VENDOR",VENDOR_NAME);
define("KURC_API_CONTROLLER_NAMESPACE",CONTROLLER_NAMESPACE);

```

### Available Request Methods:
* get
* post
* put
* patch
* delete

These methods are directly converted to WP_REST_Server::***** Constants.