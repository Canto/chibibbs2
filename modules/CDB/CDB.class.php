<?php
//if(!defined("__CHIBI__")) exit();

class CDB{
	private  $hostname;
	private  $username;
	private  $dbpasswd;
	private  $dbname;
	private  $conn;

	public function set($DBINFO=array()){
		$this->hostname = $DBINFO["HOSTNAME"];
		$this->username = $DBINFO["USERNAME"];
		$this->dbpasswd = $DBINFO["DBPASSWD"];
		$this->dbname = $DBINFO["DBNAME"];
		$this->conn = $this->conn();
	}
	public function conn(){
		$connect = mysql_connect($this->hostname,$this->username,$this->dbpasswd); //데이터베이스 접속
		mysql_select_db($this->dbname,$connect); //데이터베이스 선택
		mysql_query("set names utf8");
		return $connect;
	}
	public function query($sql=''){
		if($sql){
			return mysql_query($sql,$this->conn);
		}
	}
	public function row($query='',$table='',$arr_where='',$order='',$desc='DESC'){

		if($query){
			$row = mysql_fetch_row($query);
			return $row[0];
		}else{
			if($table){
				$sql = 'SELECT count(*) FROM `'.mysql_real_escape_string($table).'`';
				if($arr_where){
					$where = '';
					for($i=0;$i<count($arr_where);$i++)
					{
						$where = "`".$arr_where[$i][0]."`='".mysql_real_escape_string($arr_where[$i][1])."'";
						if($i!=0 || $i!=count($arr_where)-1) $where = $where." ".$arr_where[$i][2];
					}
					$sql = $sql.' WHERE '.$where;
				}
				if($order){
					$sql = $sql.' ORDER BY '.mysql_real_escape_string($order).' '.mysql_real_escape_string($desc);
				}
				$query = mysql_query($sql,$this->conn);
				$row = mysql_fetch_row($query);
				return $row[0];
			}
		}
	}
	public function arry($query='',$table='',$arr_where='',$order='',$desc='DESC'){

		if($query){
			$row = mysql_fetch_array($query,$this->conn);
			return $row[0];
		}else{
			if($table){
				$sql = 'SELECT count(*) FROM `'.mysql_real_escape_string($table).'`';
				if($arr_where){
					$where = '';
					for($i=0;$i<count($arr_where);$i++)
					{
						$where = "`".$arr_where[$i][0]."`='".mysql_real_escape_string($arr_where[$i][1])."'";
						if($i!=0 || $i!=count($arr_where)-1) $where = $where." ".$arr_where[$i][2];
					}
					$sql = $sql.' WHERE '.$where;
				}
				if($order){
					$sql = $sql.' ORDER BY '.mysql_real_escape_string($order).' '.mysql_real_escape_string($desc);
				}
				$query = mysql_query($sql,$this->conn);
				$array = mysql_fetch_array($query);
				return $array;
			}
		}
	}
}
?>