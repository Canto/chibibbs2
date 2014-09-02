<?php
if(!defined("__CHIBI__")) exit();

class Install {

	private $hostname;
	private $username;
	private $dbpasswd;
	private $dbname;
	private $chibi_conn;

	public function set($hostname='', $username='', $dbpasswd='',$dbname=''){
		$this->hostname = $hostname;
		$this->username = $username;
		$this->dbname = $dbname;
		$this->dbpasswd = $dbpasswd;
	}
	public function install_check($chibi_conn=''){
		$this->chibi_conn = $chibi_conn;

		$DB_check = (object) array(
			"status"=>"",
			"admin"=>"",
			"skin"=>"",
			"pic"=>"",
			"comment"=>"",
			"member"=>"",
			"emoticon"=>"",
			"log"=>""
		);
		if(is_resource($chibi_conn)) $DB_check->status = true;
		if(is_resource(@mysql_query("DESC chibi_admin",$chibi_conn))) $DB_check->admin = true;
		if(is_resource(@mysql_query("DESC chibi_skin",$chibi_conn))) $DB_check->skin = true;
		if(is_resource(@mysql_query("DESC chibi_pic",$chibi_conn))) $DB_check->pic = true;
		if(is_resource(@mysql_query("DESC chibi_comment",$chibi_conn))) $DB_check->comment = true;
		if(is_resource(@mysql_query("DESC chibi_member",$chibi_conn))) $DB_check->member = true;
		if(is_resource(@mysql_query("DESC chibi_emoticon",$chibi_conn))) $DB_check->emoticon = true;
		if(is_resource(@mysql_query("DESC chibi_log",$chibi_conn))) $DB_check->log = true;

		if(($DB_check->status && $DB_check->admin && $DB_check->skin && $DB_check->pic && $DB_check->comment /*&& $DB_check->member && $DB_check->emoticon && $DB_check->log*/)!=true){
			return false;
		}else{
			return true;
		}
	}



}
?>