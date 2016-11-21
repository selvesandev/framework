<?php


class Bootstrap
{
    private $viewHelperPath = null;


    public function __construct()
    {
        $this->viewHelperPath = HELPER_PATH . 'System/view.php';
        $this->initialize();
        $this->autoload();
        $this->loadHelpers();
    }


    public function autoload()
    {
        $autoloadPath = APP_PATH . 'Autoload/autoload.php';

        try {
            if (!file_exists($autoloadPath)) {
                throw new Exception('Autoload.php not found. Plese check you application directory Autoload/autoload.php');
            }
            $autoloadArray = require_once $autoloadPath;
            foreach ($autoloadArray as $loads => $loadItem) {
                $this->load($loads, $loadItem);
            }

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }



    private function load($loadType, $items)
    {
        switch ($loadType) {
            case 'helper':
                foreach ($items as $item) {
                    $path = HELPER_PATH . str_replace('helper_', '', $item) . '.php';
                    if (!file_exists($path)) {
                        throw new Exception('Helper file not found ' . $item);
                    }
                    require_once $path;
                }
                break;
            default:
                break;
        }
    }

    public function initialize()
    {
        require_once $this->viewHelperPath;
    }


    public function loadHelpers()
    {
        //file_get_contents();
    }


}