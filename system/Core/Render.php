<?php

class Render{

    private $loadViewPath=null;
    private $page=null;
    private $data=array();

    public function __construct($loadViewPath,$data)
    {
        if (strpos($loadViewPath, '.php')) {
            $page = substr($loadViewPath, 0, strlen($loadViewPath) - 4);
        }

        $this->loadViewPath = VIEW . $loadViewPath;
        $this->page=$page;
        $this->data=$data;
        $this->renderView();
    }


    private function renderView(){
        if (file_exists($this->loadViewPath) && is_file($this->loadViewPath)) {
            extract($this->data);
            ob_start();
            require_once $this->loadViewPath;
            $viewContent=ob_get_clean();
            echo $viewContent;
        } else {
            throw new Exception("View File Not found " . $this->page);
        }
    }

    public function testChain(){
        echo "chaining";
        return $this;
    }


}