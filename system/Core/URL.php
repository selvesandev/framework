<?php 

class URL{

	public static function to($path){
		try{
			if(!isset($path)){
				throw new Exception('Please Provide PATH');
			}
			return HTTP.$path;
		}catch(Exception $e){
			die($e->getMessage());
		}
	}

}

?>