<?php

class Route
{
    private static $namespace = null;
    private static $a=0;

    public function noRouteException(){

    }

    /**
     * Prepares the url string for further route processing
     * @return array
     */
    private static function initiate()
    {

        $requestPath = $_SERVER['REQUEST_URI'];

        if (!empty($requestPath)) {
        
            $requestPath = array_filter(explode('/', $requestPath));
            if(in_array(APP_ROOT,$requestPath)){
                if(($requestPath[1]==APP_ROOT) && (strtolower($requestPath[2])=='public')){
                    unset($requestPath[1]);
                    unset($requestPath[2]);
                }
            }
            return array_values($requestPath);
        }
    }




    public static function get($route = '', $controllerAction = '', $namespace = '')
    {
        try {
            if (empty($route)) {
                throw new Exception('Route Arg 1 seems empty');
            }
            if (empty($controllerAction)) {
                throw new Exception('Route Arg 2 seem empty');
            }
            self::$namespace=null;
            if (!empty($namespace)) {
                self::$namespace = rtrim(ltrim($namespace, '/'), '/');
            }

            $routeParamUrl = array_filter(self::initiate());
            $argVariable = [];
            $hasArg = false;
            $route = rtrim(ltrim($route, '/'), '/');

            $route = explode('/', $route);

            foreach ($route as $routeArgs) {
                if (preg_match('/^\{{1}[a-z0-9]*\}{1}$/', $routeArgs, $match)) {
                    $hasArg = true;
                    array_pop($route);
                    $argVariable[] = preg_replace('/{|}/', '', $match[0]); //str_replace('}','',str_replace('{','',$match[0]));
                }
            }
            $argValue = [];

            if (count($argVariable) && $hasArg === true) {
                $argVariable = array_reverse($argVariable);
                foreach ($argVariable as $i => $arg) {
                    $argValue[$arg] = array_pop($routeParamUrl);
                }
            }

            if ($route == $routeParamUrl) {
                $controllerAction = explode('@', $controllerAction);

                if (count($controllerAction) !== 2) return false;

                $controller = $controllerAction[0];
                $action = $controllerAction[1];


                $ctrlObj = self::controllerInstance($controller);

                if (!method_exists($ctrlObj, $action)) {
                    throw new Exception('Controller\'s method not found ' . $controller . '@' . $action);
                }


                if ($hasArg == true) {
                    $stdClass = new stdClass();
                    foreach ($argValue as $key => $value) {
                        $stdClass->$key = $value;
                    }
                    $ctrlObj->$action($stdClass);
                } else {
                    $ctrlObj->$action();
                }
                return true;
            }

        } catch (Exception $e) {
            die($e->getMessage());
        }

    }


    private static function controllerInstance($controller)
    {
        if (empty(self::$namespace))
            $controllerPath = APP_PATH . 'Controllers/' . $controller . '.php';
        else
            $controllerPath = APP_PATH . 'Controllers/' . self::$namespace . '/' . $controller . '.php';


        if (file_exists($controllerPath) && is_file($controllerPath)) {
            require_once $controllerPath;
            return new $controller();
        } else {
            throw new Exception('Controller Not Found ' . $controller . '.php');
        }
    }


    public static function post($routeName)
    {   
        if(empty($_POST) || $_SERVER['REQUEST_METHOD']!=="POST")
            return false;
        
    }

}