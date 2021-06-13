<?php
class Baiviet{
	function get_list_baiviet(){
		global $conn;
		return $conn->query("SELECT * FROM bai_viet");
	}
	function insert_baiviet($id, $uri, $td, $nd, $gid, $phanloai, $quyen){
		global $conn;
		if ($id){
			$conn->query("UPDATE bai_viet SET uri='".$conn->real_escape_string($uri)."', tieu_de='".$conn->real_escape_string($td)."', noi_dung='".$conn->real_escape_string($nd)."', groupid='".$conn->real_escape_string($gid)."', phan_loai='".$conn->real_escape_string($phanloai)."', quyen='".$conn->real_escape_string($quyen)."' WHERE id='".$conn->real_escape_string($id)."'");
		}
		else{
			$userinfo=$conn->query("SELECT * FROM ten_nguoi_dung WHERE ten='".$conn->real_escape_string($_SESSION["username"])."'")->fetch_array();
			$conn->query("INSERT into bai_viet (id, uri, tieu_de, noi_dung, tac_gia, groupid, phan_loai, quyen) values (NULL,'".$conn->real_escape_string($uri)."','".$conn->real_escape_string($td)."','".$conn->real_escape_string($nd)."','".$conn->real_escape_string($userinfo["id"])."','".$conn->real_escape_string($gid)."','".$conn->real_escape_string($phanloai)."','".$conn->real_escape_string($quyen)."')");
			header("Location: ?xmakereq=baiviet&baiviet=".urlencode($conn->query("SELECT id FROM bai_viet WHERE uri='".$conn->real_escape_string($uri)."'")->fetch_array()["id"]));
		}
	}
}
?>