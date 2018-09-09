<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 08.09.18
 * Time: 15:08
 */

namespace Library;


class Router
{
    const ROUTES_PATH = CONFIG_PATH . 'routes.php';

    private $routes = [];
    /** @var $request Request */
    private $request;

    public function __construct(Request $request)
    {
        $this->routes = require self::ROUTES_PATH;
        $this->request = $request;
    }

    public static function redirect($to)
    {
        header("Location: {$to}");
    }

    /**
     * @throws \Exception
     */
    public function init()
    {
        $uri = $this->request->getUri();
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $route = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $route);
                $controllerName = sprintf(
                    "%sController",
                    ucfirst(array_shift($segments))
                );
                $actionName = sprintf(
                    "action%s",
                     ucfirst(array_shift($segments))
                );
                $controllerNamespace = sprintf("Controller\%s", $controllerName);
                $params = $segments;

                if (class_exists($controllerNamespace)) {
                    try {
                        $reflection = new \ReflectionClass($controllerNamespace);
                        $controller = $reflection->newInstance($controllerNamespace);
                        $controller->setRequest($this->request);
                        if (method_exists($controller, $actionName)) {
                           $result =  call_user_func_array([$controller, $actionName], $params);
                           return $result;
                        }
                    } catch (\ReflectionException $reflectionException) {
                        throw new \Exception($reflectionException->getMessage());
                    }
                }
            }
        }
    }
}