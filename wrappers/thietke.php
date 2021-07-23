<?php
/*
Phần liệt kê các nội dung tĩnh
*/
$prefill_result=json_decode(file_get_contents($config["webroot"]."/config.json"),1);
$edit_mode=0;
$user=$conn->query("SELECT * FROM ten_nguoi_dung WHERE ten='".$conn->real_escape_string($_SESSION["username"])."'")->fetch_array();
$uid=$user["id"];
// Kiểm tra chế độ chỉnh sửa bài viết
if (in_array("4",explode(" ",$user["in_group"]))) $edit_mode=1;
if (isset($_POST["submit_tke"])){
	foreach ($prefill_result as $k=>$v){
		$prefill_result[$k]=$_POST[$k];
	}
	file_put_contents($config["webroot"]."/config.json",json_encode($prefill_result));
}
?>
<h1>Chỉnh sửa nội dung tĩnh</h1>
<form method="post" enctype="multipart/form-data">
	<table class="std_table">
		<tr>
			<th>Tên thuộc tính</th>
			<th>Giá trị</th>
		</tr>
		<?php
		foreach ($prefill_result as $k=>$v){
			?>
			<tr>
				<td><?=$k?></td>
				<td><input type="text" class="std_tbl_input" name="<?=htmlspecialchars($k)?>" <?=$edit_mode?"":"readonly"?> value="<?=htmlspecialchars($v)?>"></td>
			</tr>
			<?php
		}
		?>
	</table>
	<input class="form_submit" type="submit" name="submit_tke" value="OK" <?=$edit_mode?"":"disabled"?>>
</form>