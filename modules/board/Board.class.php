<?php
class Board{
	private $cid;
	private $conn;
	private $board;
	private $spam;
	private $op;
	private $notice;
	private $skin;

	function select($cid='',$conn=''){
		$this->cid = $cid;
		$this->conn = $conn;

		if(empty($this->cid)==true){
			$sql = "SELECT * FROM `chibi_admin`";
		}else{
			$sql = "SELECT * FROM `chibi_admin` where `cid`='".mysql_real_escape_string($this->cid)."'";
		}
		$query = mysql_query($sql,$this->conn);
		$this->board = (object) mysql_fetch_assoc($query);
		$this->board_set();
		return $this->gets_board();
	}
	function skin($cid='',$conn=''){
		$this->cid = $cid;
		$this->conn = $conn;

		if(empty($this->cid)==false){
			$sql = "SELECT * FROM `chibi_skin` where `cid`='".mysql_real_escape_string($this->cid)."'";
		}else{
			return false;
		}
		$query = mysql_query($sql,$this->conn);
		$this->skin = (object) mysql_fetch_assoc($query);
		$this->skin_set();
		return $this->gets_skin();
	}
	function board_set(){
		$this->spam = (object) unserialize($this->board->spam);
		$this->notice = (object) unserialize($this->board->notice);
		$this->op = (object) unserialize($this->board->op);
	}
	function skin_set(){
		$this->skin->op = (object) unserialize($this->skin->op);
	}
	function get($key){
		if(!isset($this->{$key})){
			return null;
		}else{
			return $this->{$key};
		}
	}
	function gets_board(){
		$key = new stdClass();
		$key = $this->board;
		$key->spam = $this->spam;
		$key->notice = $this->notice;
		$key->op = $this->op;
		return $key;
	}
	function gets_skin(){
		$key = new stdClass();
		$key = $this->skin;
		$key->op = $this->op;
		return $key;
	}
	function ip_check(){
		if(empty($this->spam->ip)==false){ // SAPM IP check and Block
			$chk_ip = explode(',',$this->spam->ip);
			if(is_array($chk_ip)){
				foreach($chk_ip as $ban){
					$ban = "/".$ban."/";
					if(preg_match($ban,$_SERVER["REMOTE_ADDR"])){
						echo '<script>alert(\'해당 IP는 접근 금지된 IP입니다.\');<script>';
						exit;
					}
				}
			}
		}
	}
	function secret_check($member_id,$type){
		if($member_id){
			if($type=="board"){
				if($this->op->secret == "secret"){
					$permission = explode(",",$this->user_permission);
					foreach($permission as $id){
						if($member_id == $id){
							return true;
						}
					}
					if($_SESSION["permission"] == md5($this->cid.session_id())){
						return true;
					}else{
						return "not_login";
					}
				}
			}else if($type=="pic"){

			}else if($type=="comment"){

			}
		}
	}
	function count_up($cid='',$conn=''){
		$session = session_id();
		$date = data("YmdHD");
		if(empty($cid)==false){
			$chk_sql = "SELECT * FROM `chibi_log` where `cid`='".mysql_real_escape_string($cid)."' AND `ip`='".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."' AND `date`='".mysql_real_escape_string($date)."'";
			$chk_query = mysql_query($chk_sql,$conn);
			$chk = (object) mysql_fetch_assoc($chk_query);
			if(empty($chk->cid)==true){
				$sql = "INSERT INTO `chibi_log` (`cid` ,`ip` ,`session` ,`date` ) VALUES ('".mysql_real_escape_string($cid)."',  '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."',  '".mysql_real_escape_string($session)."',  '".mysql_real_escape_string($date)."')";
				$query = mysql_query($sql,$conn);
				return $query;
			}
		}
	}
	function check($cid,$userinfo)
	{
		if($userinfo->is_admin == "Y")
		{
			return true;
		}
		else if($cid)
		{
			$sql = "SELECT * FROM `chibi_admin` where `cid`='".mysql_real_escape_string($cid)."'";
			$query = mysql_query($sql,$this->conn);
			$admin = (object) mysql_fetch_assoc($query);
			$admin->permmission = explode(",",$admin->permission);
			if($admin->permission[0])
			{
				for($i=0;$i<count($admin->permission);$i++)
				{
					if($admin->permisssion[$i]==$userinfo->userid)
					{
						return true;
					}
				}
			}else
			{
				return false;
			}
		}
		else
		{
			return false;
		}

	}
}
?>