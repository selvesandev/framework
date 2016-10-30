<?php

define('VIRTUAL_SET', '');

if (($_SERVER['HTTP_HOST'] == "localhost" && $_SERVER['REMOTE_ADDR'] === "::1") || $_SERVER['HTTP_HOST'] == VIRTUAL_SET) {
    $serverPort = $_SERVER['SERVER_PORT'];
    define('ENV', 'dev');
} else {
    define('ENV', 'pro');
}


//setting configuration as per the application mode(dev/pro)
switch (ENV) {
    case "dev": {
        error_reporting(-1);
        ini_set('display_errors', 1);
        define('HTTP', "http://localhost:{$serverPort}/framework/");
        define('ROOT', $_SERVER['DOCUMENT_ROOT'] . 'framework/');
        define('APP_PATH',ROOT.'application/');
        define('CONFIG_PATH',APP_PATH.'configs/');
        define('PUBLIC_PATH',HTTP.'public/');
        define('SYSTEM',ROOT.'system/');
        define('HELPER_PATH',APP_PATH.'Helpers/');
        error_reporting(E_ALL & ~E_NOTICE);
        break;
    }
    case "pro": {
        error_reporting(0);
        ini_set('display_errors', 0);
        define('HTTP', 'changeme');
        define('ROOT', 'changeme');
        break;
    }
    default: {
    }
}



//Time zone
$configs['time_zone'] = 'Asia/Dubai';
//Debug (hide/show error messages): Value = 0 or 1
$configs['debug'] = 1;
//Default Language (check langs folder for more Languages)
//$configs['lang'] = 'en';
//SSL (Disable/Enable https): Value = 0 or 1
$configs['ssl'] = 0;
//WWW (Force redirect to www): Value = 0 or 1
$configs['www'] = 0;


