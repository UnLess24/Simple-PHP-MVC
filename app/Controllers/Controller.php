<?php

namespace App\Controllers;


use App\Kernel\Request;

abstract class Controller
{
    public static function invoke($controllerAndMethodName = null, Request $request = null)
    {
        if (! $controllerAndMethodName) {
            http_response_code(404);
            view('errors/no-route.php');
        } else {

            list($className, $methodName) = explode('@', $controllerAndMethodName['route']);

            $className = 'App\\Controllers\\' . $className;

            if (! class_exists($className)) {
                http_response_code(404);
                view('errors/no-controller.php');
            } else if (! method_exists($className, $methodName)) {
                http_response_code(404);
                view('errors/no-method.php');
            } else {
                $class = new $className();
                $variables = array_merge([$request], $controllerAndMethodName['variables']);
                call_user_func_array([$class, $methodName], $variables);
            }
        }
    }
}
