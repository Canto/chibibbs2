<?php
/**
 * Created by PhpStorm.
 * User: canto87
 * Date: 2014/02/19
 * Time: 14:27
 */
class Display{
	private $device;

	function device(){
		if (strstr($_SERVER['HTTP_USER_AGENT'], "iPod") || strstr($_SERVER['HTTP_USER_AGENT'], "iPhone") || strstr($_SERVER['HTTP_USER_AGENT'], "iPad") || strstr($_SERVER['HTTP_USER_AGENT'], "Android")|| strstr($_SERVER['HTTP_USER_AGENT'], "Mobile") || strstr($_SERVER['HTTP_USER_AGENT'], "Windows Phone")){
			$this->device = "mobile";
		}else{
			$this->device = "pc";
		}
		return $this->device;
	}
}