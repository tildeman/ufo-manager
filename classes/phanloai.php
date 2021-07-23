<?php
class Phanloai{
	function get_list_cat_c1(){
		global $conn;
		return $conn->query("SELECT * FROM phan_loai WHERE cap=1");
	}
	function get_list_cat_by_cha($cha){
		global $conn;
		return $conn->query("SELECT * FROM phan_loai WHERE cha='".$conn->real_escape_string($cha)."'");
	}
	function get_hex_by_cap($cap){
		if ($cap>=7) return "ff";
		else return dechex(255-pow(2,7-$cap));
	}
	function phan_loai_with_blacklist($id){
		/*
		Hàm này ko liên quan đến chức năng kiểm tra CAPTCHA.
		*/
		$ds_cha=$this->get_list_cat_by_cha($id);
		foreach ($ds_cha as $dsci){
			$this->plwb[]=$dsci["id"];
			$this->phan_loai_with_blacklist($dsci["id"]);
		}
	}
	function phan_loai_with_blacklist_wrapper($id){
		$this->plwb=array();
		$this->plwb[]=$id;
		$this->phan_loai_with_blacklist($id);
		return $this->plwb;
	}
	function captcha($cha){
		/*
		Hàm này ko liên quan đến chức năng kiểm tra CAPTCHA.
		*/
		$ds_cha=$this->get_list_cat_by_cha($cha);
		foreach ($ds_cha as $dsci){
			$hex=$this->get_hex_by_cap($dsci["cap"]);
			?>
			<tr>
				<td style=';background-color: #ffff<?=$hex?>;'><?=$dsci["id"]?></td>
				<td style='padding-left: <?=10+(($dsci["cap"]-1)*50)?>px;background-color: #ffff<?=$hex?>;'><a href="?xmakereq=noidung&subreq=<?=$dsci["loai"]?>&cat=<?=$dsci["id"]?>"><?=$dsci["ten"]?></a></td>
				<td style=';background-color: #ffff<?=$hex?>;'><?=$dsci["loai"]?></td>
				<td style=';background-color: #ffff<?=$hex?>;'><?=$dsci["hien_thi"]?"Có":"Không"?></td>
				<td><a href="?xmakereq=noidung&editcat=<?=$dsci["id"]?>">Sửa</a> <a href="?xmakereq=noidung&deletecat=<?=$dsci["id"]?>">Xóa</a></td>
			</tr>
			<?php
			$this->captcha($dsci["id"]);
		}
	}
	function insert_cat($id, $uri, $ten, $hien_thi, $loai, $cap, $cha){
		global $conn;
		if ($id){
			$conn->query("UPDATE phan_loai SET ten='".$conn->real_escape_string($ten)."', uri='".$conn->real_escape_string($uri)."', hien_thi='".$conn->real_escape_string($hien_thi)."', loai='".$conn->real_escape_string($loai)."', cap='".$conn->real_escape_string($cap)."', cha='".$conn->real_escape_string($cha)."' WHERE id='".$conn->real_escape_string($id)."'");
		}
		else{
			$conn->query("INSERT into phan_loai (id, uri, ten, hien_thi, loai, cap, cha) VALUES (NULL,'".$conn->real_escape_string($uri)."','".$conn->real_escape_string($ten)."','".$conn->real_escape_string($hien_thi)."','".$conn->real_escape_string($loai)."','".$conn->real_escape_string($cap)."','".$conn->real_escape_string($cha)."')");
			header("Location: ?xmakereq=noidung&editcat=".urlencode($conn->query("SELECT id FROM phan_loai WHERE ten='".$conn->real_escape_string($ten)."'")->fetch_array()["id"]));
		}
	}
	function delete_cat($id){
		global $conn;
		$data=$conn->query("SELECT * FROM phan_loai WHERE id=".$conn->real_escape_string($id))->fetch_array();

		$list=$this->get_list_cat_by_cha($id);
		foreach ($list as $list_item){
			$conn->query("UPDATE phan_loai SET cap='".$conn->real_escape_string($list_item["cap"]-1)."', cha='".$conn->real_escape_string($data["cha"])."' WHERE id='".$conn->real_escape_string($list_item["id"])."'");
			$this->update_cap_and_loai($list_item["id"],$list_item["cap"]-1,$list_item["loai"]);
		}
		$conn->query("DELETE FROM phan_loai WHERE id='".$conn->real_escape_string($id)."'");
	}
	function update_cap_and_loai($id,$cap,$loai){
		/*
		Hàm này ko liên quan đến chức năng kiểm tra CAPTCHA.
		*/
		global $conn;
		$ds_cha=$this->get_list_cat_by_cha($id);
		foreach ($ds_cha as $dsci){
			$conn->query("UPDATE phan_loai SET cap='".$conn->real_escape_string($cap+1)."', loai='".$conn->real_escape_string($loai)."' WHERE id='".$conn->real_escape_string($dsci["id"])."'");
			$this->update_cap_and_loai($dsci["id"],$cap+1,$loai);
		}
	}
}
?>