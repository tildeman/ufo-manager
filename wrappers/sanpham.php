<?php
include $config["docroot"]."/classes/sanpham.php";
$bv=new Sanpham();
/*
Phần liệt kê các bài viết trong phân loại
*/
if (isset($_GET["cat"])){
	?>
	<h1>Danh sách sản phẩm trong phân loại</h1>
	<table class="std_table">
		<tr>
			<th>Ảnh đại diện</th>
			<th>Tên</th>
			<th>Mô tả</th>
			<th>Giá</th>
			<th>Hãng</th>
			<th>Tác giả</th>
		</tr>
		<?php
		$kq=$bv->get_list_sanpham($_GET["cat"]);
		foreach ($kq as $kq_item){
			?>
			<tr>
				<td><img src="<?=htmlspecialchars($config["upload_path"]."san_pham/".$kq_item["phan_loai"]."-".$kq_item["uri"].".".$kq_item["ftype"])?>" class="repimg"></td>
				<td><a href="?xmakereq=noidung&subreq=san_pham&sanpham=<?=$kq_item["id"]?>"><?=$kq_item["ten"]?></a></td>
				<td><?=$kq_item["mota"]?></td>
				<td><?=$kq_item["gia"]?></td>
				<td><?=$kq_item["hang"]?></td>
				<td><?=$conn->query("SELECT * FROM ten_nguoi_dung WHERE id=".$conn->real_escape_string($kq_item["tac_gia"]))->fetch_array()["ten"]?></td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td colspan="6" style="background-color: #ddffdd;"><a href="?xmakereq=noidung&subreq=san_pham&sanpham=0">Mới</a></td>
		</tr>
	</table>
	<?php
}
/*
Phần chỉnh sửa bài viết
*/
if (isset($_GET["sanpham"])){
	if ($_GET["sanpham"]){
		$prefill_result=$conn->query("SELECT * from san_pham where id=".$conn->real_escape_string($_GET["sanpham"]))->fetch_array();
	}
	else{
		$prefill_result=array(
			"tieu_de" => "",
			"noi_dung" => "",
			"phan_loai" => "",
			"quyen" => "4"
		);
	}

	$edit_mode=0;
	$user=$conn->query("SELECT * FROM ten_nguoi_dung WHERE ten='".$conn->real_escape_string($_SESSION["username"])."'")->fetch_array();
	$uid=$user["id"];
	// Kiểm tra chế độ chỉnh sửa bài viết
	if (in_array("1",explode(" ",$user["in_group"]))) $edit_mode=1;

	if (isset($_POST["submit_sanpham"])){
		$category=implode(" ",$_POST["category"]);
		$bv->insert_sanpham($_GET["sanpham"],$_POST["uri"],$_POST["name"],$_POST["desc"],$_FILES["img_upload"],$_POST["price"],$_POST["hang"],$category);
		$prefill_result=$conn->query("SELECT * from san_pham where id=".$conn->real_escape_string($_GET["sanpham"]))->fetch_array();
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
				<td>Ảnh</td>
				<td><input type="file" name="img_upload" required></td>
			</tr>
			<tr>
				<td>Mô tả</td>
				<td><textarea name="desc"><?=$prefill_result["mota"]?></textarea></td>
			</tr>
			<tr>
				<td>Giá</td>
				<td><input type="number" required class="std_tbl_input" name="price" <?=$edit_mode?"":"readonly"?> value="<?=htmlspecialchars($prefill_result["gia"])?>"></td>
			</tr>
			<tr>
				<td>Hãng</td>
				<td><input type="text" required class="std_tbl_input" id="hang" name="hang" <?=$edit_mode?"":"readonly"?> value="<?=htmlspecialchars($prefill_result["hang"])?>"></td>
			</tr>
			<tr>
				<td>Phân loại</td>
				<td>
					<?php
						$arr_pl=array_flip(explode(" ",$prefill_result["phan_loai"]));
						$list_pl=$conn->query("SELECT * FROM phan_loai WHERE loai='san_pham'");
						foreach ($list_pl as $pl_item){
							?>
							<input type="checkbox" name="category[]" value="<?=$pl_item["id"]?>" <?=isset($arr_pl[$pl_item["id"]])?"checked":""?> <?=$edit_mode?"":"disabled"?>><?=$pl_item["ten"]?><br>
							<?php
						}
					?>
				</td>
			</tr>
		</table>
		<input class="form_submit" type="submit" name="submit_sanpham" value="OK" <?=$edit_mode?"":"disabled"?>>
	</form>
	<script src="js/main.js"></script>
	<script src="ckeditor/build/ckeditor.js"></script>
	<script>
	document.getElementById("name").addEventListener("keyup",modifyuri);
	</script>
	<?php
}
?>