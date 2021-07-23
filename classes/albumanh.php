<?php
class Albumanh{
	function get_list_albumanh($rq){
		global $conn;
		return $conn->query("SELECT * FROM album_anh WHERE phan_loai LIKE '".$conn->real_escape_string($rq)."' OR phan_loai LIKE '".$conn->real_escape_string($rq)." %' OR phan_loai LIKE '% ".$conn->real_escape_string($rq)." %' OR phan_loai LIKE '% ".$conn->real_escape_string($rq)."'");
	}
	function insert_albumanh($id, $uri, $t, $img, $mt, $phanloai){
		global $conn;
		global $config;
		$getext=explode(".",$img["name"]);
		$getext=$getext[count($getext)-1];
		if ($img){
			$filename=$config["upload_path"]."album_anh/".$phanloai."-".$t.".".$getext;
			if ($img["error"]){
				return 0;
			}
			file_put_contents($config["docroot"]."/".$filename,file_get_contents($img["tmp_name"]));
		}
		if ($id){
			$conn->query("UPDATE album_anh SET uri='".$conn->real_escape_string($uri)."', ten='".$conn->real_escape_string($t)."', mo_ta='".$conn->real_escape_string($mt)."', phan_loai='".$conn->real_escape_string($phanloai)."', ftype='".$conn->real_escape_string($getext)."' WHERE id='".$conn->real_escape_string($id)."'");
		}
		else{
			$conn->query("INSERT into album_anh (id, uri, ten, mo_ta, phan_loai, ftype) values (NULL,'".$conn->real_escape_string($uri)."','".$conn->real_escape_string($t)."','".$conn->real_escape_string($mt)."','".$conn->real_escape_string($phanloai)."','".$conn->real_escape_string($getext)."')");
			header("Location: ?xmakereq=noidung&subreq=album_anh&anh=".urlencode($conn->query("SELECT id FROM album_anh WHERE uri='".$conn->real_escape_string($uri)."'")->fetch_array()["id"]));
		}
	}
	function delete_albumanh($id){
		global $conn;
		$conn->query("DELETE FROM album_anh WHERE id='".$conn->real_escape_string($id)."'");
	}
}
?>