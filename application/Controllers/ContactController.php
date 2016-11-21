<?php

class ContactController{
	public function __construct(){

	}	

	public function save(){
		$data['msg']="Hello Contact Us";
		return view('contact',$data);
	}
}

?>