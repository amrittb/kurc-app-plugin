# KURC Wordpress API plugin

This wordpress plugin is built on top of [WP REST API](http://v2.wp-api.org/) plugin. Install this plugin first then install this.

## Installation

1. Clone this repo to <wp-dir>/wp-content/plugins.
``` sh
git clone https://github.com/amriterry/kurc-wp-api.git
```

2. Run dump autoload files via composer.
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

> Controllers should be placed inside **src/Controllers** directory and must extend **WP_REST_Controller** class of the WP REST API Plugin.

Available Request Methods:
* get
* post
* put
* patch
* delete

These methods are directly converted to WP_REST_Server::***** Constants.