<?php
include $config["docroot"]."/classes/baiviet.php";
$bv=new Baiviet();
if (isset($_GET["baiviet"])){
	?>
	<form method="post">
		<table class="std_table">
			<tr>
				<th>Tên thuộc tính</th>
				<th>Giá trị</th>
			</tr>
			<tr>
				<td>Tên</td>
				<td><textarea name="name"></textarea></td>
			</tr>
			<tr>
				<td>Nội dung</td>
				<td><textarea name="content" class="editor"></textarea></td>
			</tr>
			<tr>
				<td>Danh mục</td>
				<td><textarea name="category"></textarea></td>
			</tr>
		</table>
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