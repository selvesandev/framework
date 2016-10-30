<?php

class DemoController
{
    public function __construct()
    {

    }

    public function index()
    {
        echo "You are at index successfully";
    }

    public function about($arguments)
    {
        $data=['a'=>$arguments->a,'b'=>$arguments->b,'msg'=>'MVC Framework that will keep progressing &'];
        return view('contact.php',$data)->testChain();
    }


}

