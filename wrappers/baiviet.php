<?php
include $config["docroot"]."/classes/baiviet.php";
$bv=new Baiviet();
/*
Phần chỉnh sửa bài viết
*/
if (isset($_GET["baiviet"])){
	if ($_GET["baiviet"]){
		$prefill_result=$conn->query("SELECT * from bai_viet where id=".$conn->real_escape_string($_GET["baiviet"]))->fetch_array();
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

	if (isset($_POST["submit_baiviet"])){
		$category=implode(" ",$_POST["category"]);
		$bv->insert_baiviet($_GET["baiviet"],$_POST["uri"],$_POST["name"],$_FILES["img_upload"],$_POST["content"],$category);
		$prefill_result=$conn->query("SELECT * from bai_viet where id=".$conn->real_escape_string($_GET["baiviet"]))->fetch_array();
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
				<td><input type="text" required class="std_tbl_input" id="name" name="name" <?=$edit_mode?"":"readonly"?> value="<?=htmlspecialchars($prefill_result["tieu_de"])?>"></td>
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
				<td>Nội dung</td>
				<td><textarea name="content" class="editor"><?=$prefill_result["noi_dung"]?></textarea></td>
			</tr>
			<tr>
				<td>Phân loại</td>
				<td>
					<?php
						$arr_pl=array_flip(explode(" ",$prefill_result["phan_loai"]));
						$list_pl=$conn->query("SELECT * FROM phan_loai WHERE loai='bai_viet'");
						foreach ($list_pl as $pl_item){
							?>
							<input type="checkbox" name="category[]" value="<?=$pl_item["id"]?>" <?=isset($arr_pl[$pl_item["id"]])?"checked":""?> <?=$edit_mode?"":"disabled"?>><?=$pl_item["ten"]?><br>
							<?php
						}
					?>
				</td>
			</tr>
		</table>
		<input class="form_submit" type="submit" name="submit_baiviet" value="OK" <?=$edit_mode?"":"disabled"?>>
	</form>
	<script src="js/main.js"></script>
	<script src="ckeditor/build/ckeditor.js"></script>
	<script>
	ClassicEditor.create(
		document.querySelector( '.editor' ), {	
			toolbar: {
				items: [
					'heading',
					'|',
					'undo',
					'redo',
					'|',
					'fontFamily',
					'fontSize',
					'|',
					'bold',
					'italic',
					'underline',
					'strikethrough',
					'link',
					'fontColor',
					'|',
					'bulletedList',
					'numberedList',
					'|',
					'outdent',
					'indent',
					'-',
					'superscript',
					'subscript',
					'specialCharacters',
					'|',
					'imageInsert',
					'blockQuote',
					'insertTable',
					'mediaEmbed',
					'|',
					'fontBackgroundColor',
					'removeFormat',
					'htmlEmbed'
				],
			},
			language: 'vi',
			simpleUpload: {
				uploadUrl: "raw_upload.php"
			}
		}
	)
	.then(
		editor => {
			editor.isReadOnly=<?=$edit_mode?"false":"true"?>;
		}
	)
	.catch(
		error => {
			console.error( error );
		}
	);

	document.getElementById("name").addEventListener("keyup",modifyuri);
	</script>
	<?php
}
/*
Phần liệt kê các bài viết trong phân loại
*/
else if (isset($_GET["cat"])){
	?>
	<h1>Danh sách bài viết trong phân loại</h1>
	<table class="std_table">
		<tr>
			<th>Ảnh đại diện</th>
			<th>Tên</th>
			<th>Tác giả</th>
		</tr>
		<?php
		$kq=$bv->get_list_baiviet($_GET["cat"]);
		foreach ($kq as $kq_item){
			?>
			<tr>
				<td><img src="<?=htmlspecialchars($config["upload_path"]."bai_viet/".$kq_item["phan_loai"]."-".$kq_item["uri"].".".$kq_item["ftype"])?>" class="repimg"></td>
				<td><a href="?xmakereq=noidung&subreq=bai_viet&baiviet=<?=$kq_item["id"]?>"><?=$kq_item["tieu_de"]?></a></td>
				<td><?=$conn->query("SELECT * FROM ten_nguoi_dung WHERE id=".$conn->real_escape_string($kq_item["tac_gia"]))->fetch_array()["ten"]?></td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td colspan="3" style="background-color: #ddffdd;"><a href="?xmakereq=noidung&subreq=bai_viet&baiviet=0">Mới</a></td>
		</tr>
	</table>
	<?php
}
?>