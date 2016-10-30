<?php

function autoload($className)
{
    //Requiring the route file
    if ($className == "Route") {
        $path = SYSTEM . 'Core/Route.php';
        if (file_exists($path) && is_file($path)) {
            require_once $path;
        }
    } else {
        //system path
        $path=SYSTEM.'Core/'.$className.'.php';
        if(file_exists($path) && is_file($path)){
            require_once $path;
        }

    }
}

spl_autoload_register('autoload');

