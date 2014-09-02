<?php
class Admin {

	private $cid;
	private $conn;
	private $data = array();
	private $board;
	private $skin;
	private $spam;
	private $notice;
	private $op;
	private $total_visitors;
	private $today_visitors;
	private $total_pics;
	private $total_comments;

	function select($cid='',$conn=''){
		$this->cid = $cid;
		$this->conn = $conn;

		if(empty($this->cid)==true){
			$sql = "SELECT * FROM `chibi_admin`";
		}else{
			$sql = "SELECT * FROM `chibi_admin` where `cid`='".mysql_real_escape_string($this->cid)."'";
		}
		$query = mysql_query($sql,$this->conn);
		$i = 0;
		while($array = mysql_fetch_assoc($query)){
			$this->data[$i] = (object) $array;
			$i++;
		}
		return $this->data;
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

	function board_set($data){
		$this->board = (object) $data;
		$pic_cnt_sql = "SELECT count(`idx`) FROM `chibi_pic` where cid = '".mysql_real_escape_string($this->board->cid)."'";
		$comment_cnt_sql =  "SELECT count(`idx`) FROM `chibi_comment` where cid = '".mysql_real_escape_string($this->board->cid)."'";
		$todaylog_cnt_sql =  "SELECT count(`cid`) FROM `chibi_log` where cid = '".mysql_real_escape_string($this->board->cid)."' AND date = '".date("Ymd")."%'";
		$totallog_cnt_sql =  "SELECT count(`cid`) FROM `chibi_log` where cid = '".mysql_real_escape_string($this->board->cid)."'";

		$pic_row = mysql_fetch_row(mysql_query($pic_cnt_sql,$this->conn));
		$comment_row = mysql_fetch_row(mysql_query($comment_cnt_sql,$this->conn));
		$todaylog_row = mysql_fetch_row(mysql_query($todaylog_cnt_sql,$this->conn));
		$totallog_row = mysql_fetch_row(mysql_query($totallog_cnt_sql,$this->conn));
		$this->total_pics = $pic_row[0];
		$this->total_comments = $comment_row[0];
		$this->today_visitors = $todaylog_row[0];
		$this->total_visitors = $totallog_row[0];
		$this->spam = (object) unserialize($this->board->spam);
		$this->notice = (object) unserialize($this->board->notice);
		$this->op = (object) unserialize($this->board->op);
		return $this->gets_board();
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
		$key->total_pics = $this->total_pics;
		$key->total_comments = $this->total_comments;
		$key->total_visitors = $this->total_visitors;
		$key->today_visitors = $this->today_visitors;
		return $key;
	}
	function gets_skin(){
		$key = new stdClass();
		$key = $this->skin;
		$key->op = $this->op;
		return $key;
	}
	function count($cid){

	}
	/*
	function check($cid,$userinfo,$admin_id)
	{
		if($admin_id == $userinfo->user_id && $userinfo->login_type == "chibibbs")
		{
			$_SESSION['permission'] = true;
		}
		else if($userinfo->is_admin == "Y")
		{
			$_SESSION['permission'] = true;
		}
		else if($cid)
		{
			$sql = "SELECT * FROM `chibi_admin` where `cid`='".mysql_real_escape_string($cid)."'";
			$query = mysql_query($sql,DB::$conn);
			$admin = (object) mysql_fetch_assoc($query);
			$admin->permmission = explode(",",$admin->permission);
			if($admin->permission[0])
			{
				for($i=0;$i<count($admin->permission);$i++)
				{
					if($admin->permisssion[$i]==$userinfo->userid)
					{
						$_SESSION['permission'] = true;
					}
				}
			}else
			{
				$_SESSION['permission'] = false;
			}
		}
		else
		{
			$_SESSION['permission'] = false;
		}
		return $_SESSION['permission'];
	}*/
	function check($cid,$userinfo)
	{
		if($userinfo->last_login < date(YmdHis,time()-10800)){
			unset($_SESSION["user_info"]);
			Develop::debugPrint($_SESSION["user_info"]);
			return false;
		}else{
			$userinfo->last_login = date(YmdHis,time());
			$_SESSION["user_info"] = $userinfo;
		}

		if($userinfo->is_admin == "Y")
		{
			return true;
		}
		else if($cid)
		{
			$sql = "SELECT * FROM `chibi_admin` where `cid`='".mysql_real_escape_string($cid)."'";
			$query = mysql_query($sql,DB::$conn);
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