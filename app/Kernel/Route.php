<?php

namespace App\Kernel;

class Route
{
    private static $routes = [];

    /**
     * Route constructor.
     */
    private function __construct() {}

    private static function addRoute($method, $route, $controllerMethod)
    {
        self::$routes[$method][self::firstCharRoute($route)] = $controllerMethod;
    }

    private static function firstCharRoute($route)
    {
        if ($route[0] !== '/') {
            $route = '/' . $route;
        }
        return $route;
    }

    public static function get($route, $controllerMethod)
    {
        self::addRoute('get', $route, $controllerMethod);
    }

    public static function post($route, $controllerMethod)
    {
        self::addRoute('post', $route, $controllerMethod);
    }

    public static function put($route, $controllerMethod)
    {
        self::addRoute('put', $route, $controllerMethod);
    }

    public static function delete($route, $controllerMethod)
    {
        self::addRoute('delete', $route, $controllerMethod);
    }

    public static function getRoute($method, $route)
    {
        $routes = self::$routes[strtolower($method)];

        $routeHasVariables = preg_match_all("/[0-9]+/", $route, $matches);

        if ($routeHasVariables) {
            foreach ($routes as $key => $findedRoute) {
                $routeMatch = preg_match_all("/{[a-zA-Z]+}/", $key, $keyMatches);

                if ($routeMatch && count($matches[0]) === count($keyMatches[0])) {
                    $variables = [];
                    foreach ($matches[0] as $keyMatch => $match) {
                        $variableName = $keyMatches[0][$keyMatch];
                        $variableName = substr($variableName, 1, strlen($variableName) - 2);
                        $variables[$variableName] = (int) $match;
                    }
                    return ['route' => $routes[$key], 'variables' => $variables];
                }
            }
        }

        if (array_key_exists($route, $routes)) {
            return ['route' => $routes[$route], 'variables' => []];
        }

        return null;
    }

    public static function getRoutes()
    {
        return self::$routes;
    }
}
