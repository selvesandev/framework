<?php

class DemoController
{

    public function __construct()
    {

    }

    public function index()
    {
        $data=['name'=>'ram','age'=>20,'gender'=>'male','title'=>'Welcome'];
        return view('home',$data);
    }

    public function about($arguments)
    {
        $data=['a'=>$arguments->a,'b'=>$arguments->b,'msg'=>'MVC Framework that will keep progressing &'];
        return view('contact',$data)->testChain();
    }


}

