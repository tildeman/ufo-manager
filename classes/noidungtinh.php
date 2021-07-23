<?php
class Ndtinh{
	function get_list_ndtinh(){
		global $conn;
		return $conn->query("SELECT * FROM noi_dung_tinh");
	}
	function insert_ndtinh($id, $uri, $t, $nd){
		global $conn;
		if ($id){
			$conn->query("UPDATE noi_dung_tinh SET uri='".$conn->real_escape_string($uri)."', ten='".$conn->real_escape_string($t)."', noi_dung='".$conn->real_escape_string($nd)."' WHERE id='".$conn->real_escape_string($id)."'");
		}
		else{
			$conn->query("INSERT INTO noi_dung_tinh (id, uri, ten, noi_dung) values (NULL,'".$conn->real_escape_string($uri)."','".$conn->real_escape_string($t)."','".$conn->real_escape_string($nd)."')");
			header("Location: ?xmakereq=giaodien&muc=noidungtinh&ndtinh=".urlencode($conn->query("SELECT id FROM noi_dung_tinh WHERE uri='".$conn->real_escape_string($uri)."'")->fetch_array()["id"]));
		}
	}
	function delete_ndtinh($id){
		global $conn;
		$conn->query("DELETE FROM noi_dung_tinh WHERE id='".$conn->real_escape_string($id)."'");
	}
}
?>