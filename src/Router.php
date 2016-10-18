<?php namespace Kurc;

class Router {

    /**
     * Api Namespace.
     *
     * @var
     */
    private $apiNamespace;

    /**
     * Controller Namespace.
     *
     * @var
     */
    private $controllerNamespace;

    /**
     * Allowed route methods.
     *
     * @var array
     */
    protected $routeMethods = [
        'get' => \WP_REST_Server::READABLE,
        'post' => \WP_REST_Server::CREATABLE,
        'put' => \WP_REST_Server::EDITABLE,
        'patch' => \WP_REST_Server::EDITABLE,
        'delete' => \WP_REST_Server::DELETABLE,
    ];

    /**
     * Router constructor.
     *
     * @param $apiNamespace
     * @param $controllerNamespace
     */
    public function __construct($apiNamespace, $controllerNamespace) {
        $this->apiNamespace = $apiNamespace;
        $this->controllerNamespace = $controllerNamespace;
    }

    /**
     * Registers a route to REST API.
     *
     * @param $method
     * @param $endpoint
     * @param $controllerAction
     * @param array $args
     * @param array $permissionCallback
     * @throws \Exception
     */
    public function registerRoute($method,
                                  $endpoint,
                                  $controllerAction,
                                  $args = array(),
                                  $permissionCallback = null)
    {
        list($className, $actionName) = $this->getControllerNameAndAction($controllerAction);

        $controller = $this->getControllerObject($className);

        if( ! method_exists($controller,$actionName)) {
            throw new \Exception("Method {$actionName} not found in class {$className}");
        }

        $options = $this->getRouteOptions($method, $args, $permissionCallback, $controller, $actionName);

        register_rest_route($this->apiNamespace, $endpoint, $options);
    }

    /**
     * Returns Controller Name and Action
     *
     * @param $controllerAction
     * @return array
     *
     * @throws \Exception
     */
    protected function getControllerNameAndAction($controllerAction) {
        $actionArgs = explode('@', $controllerAction);

        $className = "\\" . $this->controllerNamespace . "\\" . $actionArgs[0];
        $actionName = $actionArgs[1];

        if (!class_exists($className)) {
            throw new \Exception("Class {$className} not found");
        }

        return array($className, $actionName);
    }

    /**
     * Returns Controller Object.
     *
     * @param $className
     * @return mixed
     */
    protected function getControllerObject($className) {
        return new $className();
    }

    /**
     * Returns parsed route options.
     *
     * @param $method
     * @param $args
     * @param $permissionCallback
     * @param $controller
     * @param $actionName
     * @return array
     */
    protected function getRouteOptions($method, $args, $permissionCallback, $controller, $actionName) {
        $options = array(
            'methods' => $method,
            'callback' => array($controller, $actionName),
            'args' => $args,
        );

        if ($permissionCallback != null) {
            $options['permission_callback'] = $permissionCallback;
        }

        return $options;
    }

    /**
     * Magic __call method.
     *
     * @param $method
     * @param $args
     * @return mixed
     *
     * @throws \Exception
     */
    public function __call($method, $args) {
        if(method_exists($this,$method)) {
            // Checks if method exists in this object.
            return call_user_func_array(array($this,$method),$args);
        } else if(in_array($method, array_keys($this->routeMethods))) {
            // Checks if the given method name is a valid route method.
            // If so get WPRestMethod Constant and populate the arguments
            // and call the registerRoute method.
            array_unshift($args, $this->getWPRestMethod($method));
            return call_user_func_array(array($this,"registerRoute"),$args);
        }

        throw new \Exception("Method {$method} not found in Router.php");
    }


    /**
     * Returns WP Rest Method Constant.
     *
     * @param $method
     * @return mixed
     */
    private function getWPRestMethod($method) {
        return $this->routeMethods[$method];
    }
}