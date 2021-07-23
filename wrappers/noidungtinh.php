<?php
include $config["docroot"]."/classes/noidungtinh.php";
$bv=new Ndtinh();
/*
Phần liệt kê các nội dung tĩnh
*/
?>
<h1>Danh sách nội dung tĩnh</h1>
<table class="std_table">
	<tr>
		<th>Tên</th>
		<th>Nội dung</th>
		<th></th>
	</tr>
	<?php
	$kq=$bv->get_list_ndtinh();
	foreach ($kq as $kq_item){
		?>
		<tr>
			<td><?=htmlspecialchars($kq_item["ten"])?></td>
			<td><?=$kq_item["noi_dung"]?></td>
			<td><a href="?xmakereq=giaodien&muc=noidungtinh&ndtinh=<?=$kq_item["id"]?>">Sửa</a> <a href="?xmakereq=giaodien&muc=noidungtinh&delndtinh=<?=$kq_item["id"]?>">Xóa</a></td>
		</tr>
		<?php
	}
	?>
	<tr>
		<td colspan="3" style="background-color: #ddffdd;"><a href="?xmakereq=giaodien&muc=noidungtinh&ndtinh=0">Mới</a></td>
	</tr>
</table>
<?php
/*
Phần chỉnh sửa bài viết
*/
if (isset($_GET["delndtinh"])){
	$bv->delete_ndtinh($_GET["delndtinh"]);
	header("Location: ?xmakereq=giaodien&muc=noidungtinh");
}
if (isset($_GET["ndtinh"])){
	if ($_GET["ndtinh"]){
		$prefill_result=$conn->query("SELECT * from noi_dung_tinh where id=".$conn->real_escape_string($_GET["ndtinh"]))->fetch_array();
	}
	else{
		$prefill_result=array(
			"ten" => "",
			"noi_dung" => ""
		);
	}

	$edit_mode=0;
	$user=$conn->query("SELECT * FROM ten_nguoi_dung WHERE ten='".$conn->real_escape_string($_SESSION["username"])."'")->fetch_array();
	$uid=$user["id"];
	// Kiểm tra chế độ chỉnh sửa bài viết
	if (in_array("4",explode(" ",$user["in_group"]))) $edit_mode=1;

	if (isset($_POST["submit_ndtinh"])){
		$bv->insert_ndtinh($_GET["ndtinh"],$_POST["uri"],$_POST["name"],$_POST["content"]);
		$prefill_result=$conn->query("SELECT * from noi_dung_tinh where id=".$conn->real_escape_string($_GET["ndtinh"]))->fetch_array();
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
				<td>Nội dung</td>
				<td><textarea name="content" class="editor"><?=$prefill_result["noi_dung"]?></textarea></td>
			</tr>
		</table>
		<input class="form_submit" type="submit" name="submit_ndtinh" value="OK" <?=$edit_mode?"":"disabled"?>>
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
?>