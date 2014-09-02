<?php
/**
 * Created by PhpStorm.
 * User: canto87
 * Date: 2014/07/17
 * Time: 15:02
 */
foreach(glob("./modules/*",GLOB_ONLYDIR) as $value){
	$classname = explode("/",$value);
	$class = "./modules/".$classname[2]."/".$classname[2].".class.php";
	require_once $class;
}
