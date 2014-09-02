<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate');
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
$cid = $_POST['cid'];
/* DB정보취득 */
require_once "../../data/config/db.config.php";
require_once "../cdb/cdb.class.php";
/* Set DB */
$db = new CDB();
$db->set($DBINFO);

if($cid){
	$sql = "select count(*) from `chibi_admin` where cid='".mysql_real_escape_string($cid)."'";
	$Result = mysql_query($sql,$db->conn());
	$rows = mysql_num_rows($Result);
	if($rows > 0){
		$data = mysql_fetch_array($Result);
	}
	if($data[0] == 0){
		$chk = true;
		echo $chk;
	}else{
		$chk = false;
		echo $chk;
	}
}
?>