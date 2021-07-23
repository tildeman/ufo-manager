<?php
class Sanpham{
	function get_list_sanpham($rq){
		global $conn;
		return $conn->query("SELECT * FROM san_pham WHERE phan_loai LIKE '".$conn->real_escape_string($rq)."' OR phan_loai LIKE '".$conn->real_escape_string($rq)." %' OR phan_loai LIKE '% ".$conn->real_escape_string($rq)." %' OR phan_loai LIKE '% ".$conn->real_escape_string($rq)."'");
	}
	function insert_sanpham($id, $uri, $t, $mt, $img, $gia, $h, $phanloai){
		global $conn;
		global $config;
		$getext=explode(".",$img["name"]);
		$getext=$getext[count($getext)-1];
		if ($img){
			$filename=$config["upload_path"]."san_pham/".$phanloai."-".$uri.".".$getext;
			if ($img["error"]){
				return 0;
			}
			file_put_contents($config["docroot"]."/".$filename,file_get_contents($img["tmp_name"]));
		}
		if ($id){
			$conn->query("UPDATE san_pham SET uri='".$conn->real_escape_string($uri)."', ten='".$conn->real_escape_string($t)."', mota='".$conn->real_escape_string($mt)."', gia='".$conn->real_escape_string($gia)."', hang='".$conn->real_escape_string($h)."', ftype='".$conn->real_escape_string($getext)."' WHERE id='".$conn->real_escape_string($id)."'");
		}
		else{
			$userinfo=$conn->query("SELECT * FROM ten_nguoi_dung WHERE ten='".$conn->real_escape_string($_SESSION["username"])."'")->fetch_array();
			$conn->query("INSERT into san_pham (id, uri, ten, mota, gia, hang, tac_gia, phan_loai, ftype) values (NULL,'".$conn->real_escape_string($uri)."','".$conn->real_escape_string($t)."','".$conn->real_escape_string($mt)."','".$conn->real_escape_string($gia)."','".$conn->real_escape_string($h)."','".$conn->real_escape_string($userinfo["id"])."','".$conn->real_escape_string($phanloai)."','".$conn->real_escape_string($getext)."')");
			header("Location: ?xmakereq=noidung&subreq=san_pham&sanpham=".urlencode($conn->query("SELECT id FROM san_pham WHERE uri='".$conn->real_escape_string($uri)."'")->fetch_array()["id"]));
		}
	}
	function delete_sanpham($id){
		global $conn;
		$conn->query("DELETE FROM san_pham WHERE id='".$conn->real_escape_string($id)."'");
	}
}
?>