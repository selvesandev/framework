<?php

define('index',TRUE);
require_once '../configs/app.php';

require_once SYSTEM.'initialize.php';


/**
 * Bootstrap Prepare the application components
 */
$app=new Bootstrap();

require_once APP_PATH.'routes.php';




