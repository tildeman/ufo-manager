<?php
class Albumanh{
	function get_list_albumanh($rq){
		global $conn;
		return $conn->query("SELECT * FROM album_anh WHERE phan_loai LIKE '".$conn->real_escape_string($rq)."' OR phan_loai LIKE '".$conn->real_escape_string($rq)." %' OR phan_loai LIKE '% ".$conn->real_escape_string($rq)." %' OR phan_loai LIKE '% ".$conn->real_escape_string($rq)."'");
	}
	function insert_albumanh($id, $uri, $t, $img, $mt, $phanloai){
		global $conn;
		if ($id){
			$conn->query("UPDATE album_anh SET uri='".$conn->real_escape_string($uri)."', ten='".$conn->real_escape_string($t)."', mo_ta='".$conn->real_escape_string($mt)."', phan_loai='".$conn->real_escape_string($phanloai)."' WHERE id='".$conn->real_escape_string($id)."'");
		}
		else{
			$conn->query("INSERT into album_anh (id, uri, tieu_de, noi_dung, tac_gia, phan_loai) values (NULL,'".$conn->real_escape_string($uri)."','".$conn->real_escape_string($td)."','".$conn->real_escape_string($nd)."','".$conn->real_escape_string($userinfo["id"]).$conn->real_escape_string($phanloai)."')");
			header("Location: ?xmakereq=noidung&subreq=albumanh&albumanh=".urlencode($conn->query("SELECT id FROM bai_viet WHERE uri='".$conn->real_escape_string($uri)."'")->fetch_array()["id"]));
		}
		if ($img){
			$filename=$config["upload_path"]."album_anh/".$phanloai."-".$img["name"];
			if ($img["error"]){
				return 0;
			}
			file_put_contents($filename,file_get_contents($img["tmp_name"]));
		}
	}
}
?>