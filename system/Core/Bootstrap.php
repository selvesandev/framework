<?php


class Bootstrap
{
    private $viewHelperPath = null;

    public function __construct()
    {
        $this->viewHelperPath=HELPER_PATH.'System/view.php';
        $this->initialize();
    }

    public function initialize()
    {
        require_once $this->viewHelperPath;
    }

}