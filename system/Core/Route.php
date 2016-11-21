<?php

class Route
{
    private static $namespace = null;
    private static $a=0;
    private static $routeName=null;
    private static $controllerMethod=null;

    

    public function noRouteException(){

    }


    
    /**
     * Checks whether the comming request is either get or post forwards them for necessary processing..
     * @return array
     */
    public static  function __callStatic($funcName,$args){
        try{
        if(empty($funcName) || empty($args)) throw new Exception('Invalid Exception ');
            self::$namespace=null;
            if(isset($args[2])){
                self::$namespace=rtrim(ltrim($args[2],''),'/');
            }

            if(!isset($args[0])) throw new Exception('No Route Defined');
            self::$routeName=rtrim(ltrim($args[0],'/'),'/');

            if(!isset($args[1])) throw new Exception('Controller method not found');
            self::$controllerMethod=$args[1];


            if($funcName=='get' && $_SERVER['REQUEST_METHOD']=="GET"){
                self::processGetRequest(); 
            }else if($funcName=="post" && $_SERVER['REQUEST_METHOD']=="POST"){
                self::processPostRequest();
            }            
        }catch(Exception $e){
            die($e->getMessage());
        }

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


    
    private static function processGetRequest()
    {
        try {
            $routeParamUrl = array_filter(self::initiate());
            
            $argVariable = [];
            $hasArg = false;
           

            $route = explode('/', self::$routeName);


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
                $controllerAction = explode('@', self::$controllerMethod);

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


    public static function processPostRequest()
    {   

    }
    

}