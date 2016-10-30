<?php

class DemoController
{

    public function index()
    {
        echo "You are at index successfully";
    }

    public function about($arguments)
    {
        echo "<pre>";
        print_r($arguments);
    }


}

