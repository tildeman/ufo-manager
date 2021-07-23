<?php
class Tngang{
	function get_list_tngang(){
		global $conn;
		return $conn->query("SELECT * FROM thanh_ngang");
	}
	function insert_tngang($id, $uri, $t, $nd){
		global $conn;
		if ($id){
			$conn->query("UPDATE thanh_ngang SET uri='".$conn->real_escape_string($uri)."', ten='".$conn->real_escape_string($t)."', link='".$conn->real_escape_string($nd)."' WHERE id='".$conn->real_escape_string($id)."'");
		}
		else{
			$conn->query("INSERT INTO thanh_ngang (id, uri, ten, link) values (NULL,'".$conn->real_escape_string($uri)."','".$conn->real_escape_string($t)."','".$conn->real_escape_string($nd)."')");
			header("Location: ?xmakereq=giaodien&muc=thanhngang&tngang=".urlencode($conn->query("SELECT id FROM thanh_ngang WHERE uri='".$conn->real_escape_string($uri)."'")->fetch_array()["id"]));
		}
	}
	function delete_tngang($id){
		global $conn;
		$conn->query("DELETE FROM thanh_ngang WHERE id='".$conn->real_escape_string($id)."'");
	}
}
?>