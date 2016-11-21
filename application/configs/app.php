<?php
if (($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['REMOTE_ADDR'] === "::1" || strpos($_SERVER['REMOTE_ADDR'],'192.168')!==false)) {
    $serverPort = (int)$_SERVER['SERVER_PORT'];
    $http=$_SERVER['HTTP_HOST'];
    $requestType=$_SERVER['REQUEST_SCHEME'];
    
    if($_SERVER['HTTP_HOST']=="localhost"){
        $rootDir=explode('/',$_SERVER['REQUEST_URI'])[1];
    }else{
        $rootDir=explode('/',$_SERVER['DOCUMENT_ROOT']);
        $rootDir=$rootDir[count($rootDir)-2];
    }
    define('ENV', 'dev');
} else {
    define('ENV', 'pro');
}


//setting configuration as per the application mode(dev/pro)
switch (ENV) {
    case "dev": {
        error_reporting(-1);
        ini_set('display_errors', 1);
        if($serverPort!=80){
            $appHTTP=$requestType.'://'.$http.':'.$serverPort;
        }else{
            $appHTTP=$requestType.'://'.$http;
        }

        if($http=="localhost"){
            $appHTTP.="/".$rootDir;
        }
        define('APP_ROOT',$rootDir);
        define('HTTP',$appHTTP.'/');
        $docRoot = dirname(dirname(dirname(__FILE__)));
        
        //define('ROOT', $docRoot . "/{$rootDir}/");
        define('ROOT',$docRoot.'/');
        
        define('APP_PATH',ROOT.'application/');
        define('CONFIG_PATH',APP_PATH.'configs/');
        define('PUBLIC_PATH',HTTP.'public/');
        
        define('SYSTEM',ROOT.'system/');
        define('HELPER_PATH',APP_PATH.'Helpers/');
        //error_reporting(E_ALL & ~E_NOTICE);
        error_reporting(E_ALL);
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


