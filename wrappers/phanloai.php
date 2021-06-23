<?php
include $config["docroot"]."/classes/phanloai.php";
$pl=new Phanloai();
//Mặc định: hiển thị danh sách tất cả các phân loại bài viết
if (isset($_POST["submit_cat"])){
	$hienthi=0;
	if (isset($_POST["hien_thi"])) $hienthi=1;
	if ($_POST["cha"]==0){
		$cap=1;
	}
	else{
		$cap=$conn->query("SELECT cap FROM phan_loai WHERE id='".$conn->real_escape_string($_POST["cha"])."'")->fetch_array()["cap"]+1;
	}
	if ($cap==1) $loai=$_POST["loai"];
	else $loai=$conn->query("SELECT loai FROM phan_loai WHERE id='".$conn->real_escape_string($_POST["cha"])."'")->fetch_array()["loai"];
	$pl->insert_cat($_GET["editcat"],$_POST["ten"],$hienthi,$loai,$cap,$_POST["cha"]);
	$pl->update_cap_and_loai($_GET["editcat"],$cap,$loai);
}
?>
<h1>Quản lí phân loại bài viết</h1>
<table class="std_table">
	<tr>
		<th>ID</th>
		<th>Tên</th>
		<th>Hiển thị</th>
	</tr>
	<?php
	$pl->captcha(0);
	?>
	<tr>
		<td colspan="3" style="background-color: #ddffdd;"><a href="?xmakereq=noidung&editcat=0">Mới</a></td>
	</tr>
</table>
<?php
/*
Phần chỉnh sửa phân loại
*/
if (isset($_GET["editcat"])){
	if ($_GET["editcat"]==0){
		$prefill_result_cat=array(
			"ten" => "",
			"loai" => "",
			"hien_thi" => 1,
			"cap" => 1,
			"cha" => 0
		);
	}
	else{
		$prefill_result_cat=$conn->query("SELECT * FROM phan_loai WHERE id='".$conn->real_escape_string($_GET["editcat"])."'")->fetch_array();
	}
	?>
	<h1>Chỉnh sửa phân loại</h1>
	<form method="post">
		<table class="std_table">
			<tr>
				<th>Thuộc tính</th>
				<th>Giá trị</th>
			</tr>
			<tr>
				<td>Tên</td>
				<td><textarea name="ten"><?=$prefill_result_cat["ten"]?></textarea></td>
			</tr>
			<tr>
				<td>Hiển thị</td>
				<td><input type="checkbox" name="hien_thi" <?=$prefill_result_cat["hien_thi"]?"checked":""?>></td>
			</tr>
			<tr>
				<td>Loại</td>
				<td>
					<select name="loai">
						<option <?=$prefill_result_cat["loai"]=="bai_viet"?"selected":""?> value="bai_viet">Bài viết</option>
						<option <?=$prefill_result_cat["loai"]=="tin_tuc"?"selected":""?> value="tin_tuc">Tin tức</option>
						<option <?=$prefill_result_cat["loai"]=="album_anh"?"selected":""?> value="album_anh">Album ảnh</option>
						<option <?=$prefill_result_cat["loai"]=="san_pham"?"selected":""?> value="san_pham">Sản phẩm</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Phân loại cha</td>
				<td>
					<select name="cha">
						<option value="0">(Không có)</option>
						<?php
						echo "SELECT * FROM phan_loai WHERE id <> '".implode("' AND id <> '",$pl->phan_loai_with_blacklist_wrapper($_GET["editcat"]))."'";
						$kq_all=$conn->query("SELECT * FROM phan_loai WHERE id <> '".implode("' AND id <> '",$pl->phan_loai_with_blacklist_wrapper($_GET["editcat"]))."'");
						foreach($kq_all as $kq_item){
							?>
							<option value="<?=$kq_item["id"]?>" <?=$prefill_result_cat["cha"]==$kq_item["id"]?"selected":""?>><?=$kq_item["ten"]?></option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="background-color: #ddffdd;"><input type="submit" name="submit_cat" value="OK"></td>
			</tr>
		</table>
	</form>
	<?php
}
/*
Phần rẽ nhánh subreq
*/
if (isset($_GET["subreq"])){
	switch($_GET["subreq"]){
		case "bai_viet":
			include "baiviet.php";
			break;
		default:
			echo "<br>¯\\_(ツ)_/¯";
	}
}
?>