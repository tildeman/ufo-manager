<?php
include $config["docroot"]."/classes/albumanh.php";
$bv=new Albumanh();
/*
Phần chỉnh sửa bài viết
*/
if (isset($_GET["anh"])){
	if ($_GET["anh"]){
		$prefill_result=$conn->query("SELECT * from album_anh where id=".$conn->real_escape_string($_GET["anh"]))->fetch_array();
	}
	else{
		$prefill_result=array(
			"ten" => "",
			"mo_ta" => "",
			"phan_loai" => ""
		);
	}

	$edit_mode=0;
	$user=$conn->query("SELECT * FROM ten_nguoi_dung WHERE ten='".$conn->real_escape_string($_SESSION["username"])."'")->fetch_array();
	$uid=$user["id"];
	// Kiểm tra chế độ chỉnh sửa bài viết
	if (in_array("1",explode(" ",$user["in_group"]))) $edit_mode=1;

	if (isset($_POST["submit_anh"])){
		$category=implode(" ",$_POST["category"]);
		$bv->insert_albumanh($_GET["anh"],$_POST["uri"],$_POST["name"],$_FILES["img_upload"],$_POST["desc"],$category);
		$prefill_result=$conn->query("SELECT * from album_anh where id=".$conn->real_escape_string($_GET["anh"]))->fetch_array();
	}
	?>
	<h1>Chỉnh sửa bài viết</h1>
	<form method="post" enctype="multipart/form-data">
		<table class="std_table">
			<tr>
				<th>Tên thuộc tính</th>
				<th>Giá trị</th>
			</tr>
			<tr>
				<td>Tên</td>
				<td><input type="text" required class="std_tbl_input" id="name" name="name" <?=$edit_mode?"":"readonly"?> value="<?=htmlspecialchars($prefill_result["ten"])?>"></td>
			</tr>
			<tr>
				<td>Tên trên URL</td>
				<td><input type="text" required class="std_tbl_input" id="uri" name="uri" <?=$edit_mode?"":"readonly"?> value="<?=htmlspecialchars($prefill_result["uri"])?>"></td>
			</tr>
			<tr>
				<td>Mô tả</td>
				<td><textarea name="desc"><?=$prefill_result["mo_ta"]?></textarea></td>
			</tr>
			<tr>
				<td>Ảnh</td>
				<td><input type="file" name="img_upload" required></td>
			</tr>
			<tr>
				<td>Phân loại</td>
				<td>
					<?php
						$arr_pl=array_flip(explode(" ",$prefill_result["phan_loai"]));
						$list_pl=$conn->query("SELECT * FROM phan_loai WHERE loai='album_anh'");
						foreach ($list_pl as $pl_item){
							?>
							<input type="checkbox" name="category[]" value="<?=$pl_item["id"]?>" <?=isset($arr_pl[$pl_item["id"]])?"checked":""?> <?=$edit_mode?"":"disabled"?>><?=$pl_item["ten"]?><br>
							<?php
						}
					?>
				</td>
			</tr>
		</table>
		<input class="form_submit" type="submit" name="submit_anh" value="OK" <?=$edit_mode?"":"disabled"?>>
	</form>
	<script src="js/main.js"></script>
	<script>
	document.getElementById("name").addEventListener("keyup",modifyuri);
	</script>
	<?php
}
/*
Phần liệt kê các bài viết trong phân loại
*/
else if (isset($_GET["cat"])){
	?>
	<h1>Danh sách album ảnh trong phân loại</h1>
	<table class="std_table">
		<tr>
			<th>ID</th>
			<th>Tên</th>
			<th>Ảnh</th>
		</tr>
		<?php
		$kq=$bv->get_list_albumanh($_GET["cat"]);
		foreach ($kq as $kq_item){
			?>
			<tr>
				<td><?=$kq_item["id"]?></td>
				<td><a href="?xmakereq=noidung&subreq=album_anh&anh=<?=$kq_item["id"]?>"><?=$kq_item["ten"]?></a></td>
				<td><img src="<?=htmlspecialchars($config["httproot"]."/".$config["upload_path"]."album_anh/".$kq_item["phan_loai"]."-".$kq_item["ten"].".".$kq_item["ftype"])?>"></td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td colspan="3" style="background-color: #ddffdd;"><a href="?xmakereq=noidung&subreq=album_anh&anh=0">Mới</a></td>
		</tr>
	</table>
	<?php
}
?>