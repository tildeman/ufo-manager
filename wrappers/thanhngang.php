<?php
include $config["docroot"]."/classes/thanhngang.php";
$bv=new Tngang();
/*
Phần liệt kê các nội dung tĩnh
*/
?>
<h1>Danh sách mục thanh ngang</h1>
<table class="std_table">
	<tr>
		<th>Tên</th>
		<th>Link</th>
		<th></th>
	</tr>
	<?php
	$kq=$bv->get_list_tngang();
	foreach ($kq as $kq_item){
		?>
		<tr>
			<td><?=htmlspecialchars($kq_item["ten"])?></td>
			<td><?=$kq_item["link"]?></td>
			<td><a href="?xmakereq=giaodien&muc=thanhngang&tngang=<?=$kq_item["id"]?>">Sửa</a> <a href="?xmakereq=giaodien&muc=thanhngang&tngang=<?=$kq_item["id"]?>">Xóa</a></td>
		</tr>
		<?php
	}
	?>
	<tr>
		<td colspan="3" style="background-color: #ddffdd;"><a href="?xmakereq=giaodien&muc=thanhngang&tngang=0">Mới</a></td>
	</tr>
</table>
<?php
/*
Phần chỉnh sửa bài viết
*/
if (isset($_GET["deltngang"])){
	$bv->delete_tngang($_GET["deltngang"]);
	header("Location: ?xmakereq=giaodien&muc=thanhngang");
}
if (isset($_GET["tngang"])){
	if ($_GET["tngang"]){
		$prefill_result=$conn->query("SELECT * from thanh_ngang where id=".$conn->real_escape_string($_GET["tngang"]))->fetch_array();
	}
	else{
		$prefill_result=array(
			"ten" => "",
			"link" => ""
		);
	}

	$edit_mode=0;
	$user=$conn->query("SELECT * FROM ten_nguoi_dung WHERE ten='".$conn->real_escape_string($_SESSION["username"])."'")->fetch_array();
	$uid=$user["id"];
	// Kiểm tra chế độ chỉnh sửa bài viết
	if (in_array("4",explode(" ",$user["in_group"]))) $edit_mode=1;

	if (isset($_POST["submit_tngang"])){
		$bv->insert_tngang($_GET["tngang"],$_POST["uri"],$_POST["name"],$_POST["content"]);
		$prefill_result=$conn->query("SELECT * from thanh_ngang where id=".$conn->real_escape_string($_GET["tngang"]))->fetch_array();
	}
	?>
	<h1>Chỉnh sửa nội dung tĩnh</h1>
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
				<td>Link</td>
				<td><input type="text" required class="std_tbl_input" name="content" <?=$edit_mode?"":"readonly"?> value="<?=htmlspecialchars($prefill_result["link"])?>"></td>
			</tr>
		</table>
		<input class="form_submit" type="submit" name="submit_tngang" value="OK" <?=$edit_mode?"":"disabled"?>>
	</form>
	<script src="js/main.js"></script>
	<script src="ckeditor/build/ckeditor.js"></script>
	<script>
	document.getElementById("name").addEventListener("keyup",modifyuri);
	</script>
	<?php
}
?>