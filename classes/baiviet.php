<?php
class Baiviet{
	function get_list_baiviet(){
		global $conn;
		return $conn->query("SELECT * FROM bai_viet");
	}
	function insert_baiviet(){
		global $conn;
	}
}
?>