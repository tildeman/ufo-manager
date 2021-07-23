<?php
class Baiviet{
	function get_list_baiviet($rq){
		global $conn;
		return $conn->query("SELECT * FROM bai_viet WHERE phan_loai LIKE '".$conn->real_escape_string($rq)."' OR phan_loai LIKE '".$conn->real_escape_string($rq)." %' OR phan_loai LIKE '% ".$conn->real_escape_string($rq)." %' OR phan_loai LIKE '% ".$conn->real_escape_string($rq)."'");
	}
	function insert_baiviet($id, $uri, $td, $img, $nd, $phanloai){
		global $conn;
		global $config;
		$getext=explode(".",$img["name"]);
		$getext=$getext[count($getext)-1];
		if ($img){
			$filename=$config["upload_path"]."bai_viet/".$phanloai."-".$uri.".".$getext;
			if ($img["error"]){
				return 0;
			}
			file_put_contents($config["docroot"]."/".$filename,file_get_contents($img["tmp_name"]));
		}
		if ($id){
			$conn->query("UPDATE bai_viet SET uri='".$conn->real_escape_string($uri)."', tieu_de='".$conn->real_escape_string($td)."', noi_dung='".$conn->real_escape_string($nd)."', phan_loai='".$conn->real_escape_string($phanloai)."', ftype='".$conn->real_escape_string($getext)."' WHERE id='".$conn->real_escape_string($id)."'");
		}
		else{
			$userinfo=$conn->query("SELECT * FROM ten_nguoi_dung WHERE ten='".$conn->real_escape_string($_SESSION["username"])."'")->fetch_array();
			$conn->query("INSERT into bai_viet (id, uri, tieu_de, noi_dung, tac_gia, phan_loai, ftype) values (NULL,'".$conn->real_escape_string($uri)."','".$conn->real_escape_string($td)."','".$conn->real_escape_string($nd)."','".$conn->real_escape_string($userinfo["id"])."','".$conn->real_escape_string($phanloai)."','".$conn->real_escape_string($getext)."')");
			header("Location: ?xmakereq=noidung&subreq=bai_viet&baiviet=".urlencode($conn->query("SELECT id FROM bai_viet WHERE uri='".$conn->real_escape_string($uri)."'")->fetch_array()["id"]));
		}
	}
}
?>