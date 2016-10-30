<?php
define('VIEW', APP_PATH . 'Views/');
if (!function_exists('view')) {

    function view($loadViewPath = '', $data = array())
    {
        return new Render($loadViewPath,$data);
    }

}
