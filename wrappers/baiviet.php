<?php
include $config["docroot"]."/classes/baiviet.php";
$bv=new Baiviet();
if (isset($_GET["baiviet"])){
	if ($_GET["baiviet"]){
		$prefill_result=$conn->query("SELECT * from bai_viet where id=".$conn->real_escape_string($_GET["baiviet"]))->fetch_array();
	}
	else{
		$prefill_result=array(
			"tieu_de" => "",
			"noi_dung" => "",
			"phan_loai" => "",
		);
	}
	?>
	<?php
	if (isset($_POST["submit"])){
		
	}
	?>
	<form method="post">
		<input type="hidden" name="id" value="<?=$_GET["baiviet"]?>">
		<table class="std_table">
			<tr>
				<th>Tên thuộc tính</th>
				<th>Giá trị</th>
			</tr>
			<tr>
				<td>Tên trên URL</td>
				<td><textarea name="uri"><?=$prefill_result["uri"]?></textarea></td>
			</tr>
			<tr>
				<td>Tên</td>
				<td><textarea name="name"><?=$prefill_result["tieu_de"]?></textarea></td>
			</tr>
			<tr>
				<td>Nội dung</td>
				<td><textarea name="content" class="editor"><?=$prefill_result["noi_dung"]?></textarea></td>
			</tr>
			<tr>
				<td>Danh mục</td>
				<td><textarea name="category"><?=$prefill_result["phan_loai"]?></textarea></td>
			</tr>
			<tr>
				<td>Quyền chỉnh sửa</td>
				<td>
					<input type="checkbox" name="user" <?=floor($prefill_result["quyen"]/4)%2?"checked":""?>>Tôi
					<input type="checkbox" name="group" <?=floor($prefill_result["quyen"]/2)%2?"checked":""?>>Nhóm của tôi
					<input type="checkbox" name="other" <?=$prefill_result["quyen"]%2?"checked":""?>>Những người còn lại trên XMake
				</td>
			</tr>
		</table>
		<input class="form_submit" type="submit" name="submit" value="OK">
	</form>
	<script src="ckeditor/build/ckeditor.js"></script>
	<script>
	ClassicEditor
		.create( document.querySelector( '.editor' ), {	
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
					'|',
					'superscript',
					'subscript',
					'specialCharacters',
					'|',
					'imageUpload',
					'blockQuote',
					'insertTable',
					'mediaEmbed',
					'|',
					'fontBackgroundColor',
					'removeFormat',
					'htmlEmbed'
				]
			},
			language: 'vi',
			licenseKey: '',	
		} )
		.catch( error => {
			console.error( error );
		} );
	</script>
	<?php
}
else{
	//Mặc định: hiển thị danh sách tất cả các bài viết
	?>
	<table class="std_table">
		<tr>
			<th>ID</th>
			<th>Tên</th>
			<th>Tác giả</th>
		</tr>
	<?php
	$kq=$bv->get_list_baiviet();
	foreach ($kq as $kq_item){
		?><tr>
			<td><?=$kq_item["id"]?></td>
			<td><a href="?xmakereq=baiviet&baiviet=<?=$kq_item["id"]?>"><?=$kq_item["tieu_de"]?></a></td>
			<td><?=$conn->query("SELECT * FROM ten_nguoi_dung WHERE id=".$conn->real_escape_string($kq_item["tac_gia"]))->fetch_array()["ten"]?></td>
		</tr><?php
	}
	?></table><?php
}
?>