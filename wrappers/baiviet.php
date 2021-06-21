<?php
include $config["docroot"]."/classes/baiviet.php";
$bv=new Baiviet();
/*
Hàm cấp/cha
*/
function captcha($cha){
	global $bv;
	$ds_cha=$bv->get_list_cat_by_cha($cha);
	if ($ds_cha->num_rows!=0){
		foreach ($ds_cha as $dsci){
			?>
			<tr>
				<td <?=$dsci["cap"]>=2?"style='background-color: #ffffff;'":""?>><?=$dsci["id"]?></td>
				<td <?=$dsci["cap"]>=2?"style='background-color: #ffffff;'":""?>><a href="?xmakereq=baiviet&cat=<?=$dsci["id"]?>"><?=$dsci["ten"]?></a></td>
				<td <?=$dsci["cap"]>=2?"style='background-color: #ffffff;'":""?>><?=$dsci["hien_thi"]?"Có":"Không"?></td>
			</tr>
			<?php
			captcha($dsci["id"]);
		}
	}
}
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

	/*
	Kiểm tra quyền người dùng:
	-	Cho phép tất cả nếu người dùng thuộc nhóm hệ thống (id=1)
	-	Kiểm tra quyền chỉnh sửa bằng hàm floor($quyen/4)%2 khi là chủ sở hữu
		-	Nếu có, cho phép chỉnh sửa toàn bộ
		-	Nếu không, kiểm tra trong nhóm và quyền của nhóm
	-	Kiểm tra quyền chỉnh sửa bằng hàm floor($quyen/2)%2 khi người dùng thuộc nhóm
		-	Nếu có, cho phép chỉnh sửa toàn bộ ngoài quyền
		-	Nếu không, bật chế độ chỉ đọc
	-	Kiểm tra quyền chỉnh sửa bằng hàm $quyen%2 trong trường hợp còn lại
		-	Nếu có, cho phép chỉnh sửa toàn bộ ngoài quyền
	-	Nếu tất cả các trường hợp trên không thỏa mãn, bật ở chế độ chỉ đọc
	*/

	$edit_mode=0;
	$user=$conn->query("SELECT * FROM ten_nguoi_dung WHERE ten='".$conn->real_escape_string($_SESSION["username"])."'")->fetch_array();
	$uid=$user["id"];
	if ($uid==$prefill_result["tac_gia"]) $user_priv="yes";
	if (in_array($prefill_result["groupid"],explode(" ",$user["in_group"]))) $group_priv="yes";
	// Kiểm tra chế độ chỉnh sửa bài viết
	if (in_array("1",explode(" ",$user["in_group"]))) $edit_mode=2;
	else{
		if (isset($user_priv) && floor($prefill_result["quyen"]/4)%2) $edit_mode=2;
		if (isset($group_priv) && floor($prefill_result["quyen"]/2)%2 && !floor($prefill_result["quyen"]/4)%2) $edit_mode=1;
		if (!isset($user_priv) && !isset($group_priv) && $prefill_result["quyen"]%2) $edit_mode=1;
	}

	if (isset($_POST["submit"])){
		$quyen=0;
		if ($edit_mode==2){
			if (isset($_POST["user"])) $quyen+=4;
			if (isset($_POST["group"])) $quyen+=2;
			if (isset($_POST["other"])) $quyen+=1;
		}
		else{
			$quyen=$prefill_result["quyen"];
		}
		$bv->insert_baiviet($_GET["baiviet"],$_POST["uri"],$_POST["name"],$_POST["content"],0,$_POST["category"],$quyen);
		$prefill_result=$conn->query("SELECT * from bai_viet where id=".$conn->real_escape_string($_GET["baiviet"]))->fetch_array();
	}
	?>
	<form method="post">
		<table class="std_table">
			<tr>
				<th>Tên thuộc tính</th>
				<th>Giá trị</th>
			</tr>
			<tr>
				<td>Tên trên URL</td>
				<td><textarea name="uri" <?=$edit_mode?"":"readonly"?>><?=$prefill_result["uri"]?></textarea></td>
			</tr>
			<tr>
				<td>Tên</td>
				<td><textarea name="name" <?=$edit_mode?"":"readonly"?>><?=$prefill_result["tieu_de"]?></textarea></td>
			</tr>
			<tr>
				<td>Nội dung</td>
				<td><textarea name="content" class="editor"><?=$prefill_result["noi_dung"]?></textarea></td>
			</tr>
			<tr>
				<td>Danh mục</td>
				<td><textarea name="category" <?=$edit_mode?"":"readonly"?>></textarea></td>
			</tr>
			<tr>
				<td>Quyền chỉnh sửa</td>
				<td>
					<input type="checkbox" name="user" value="y" <?=$edit_mode==2?"":"disabled"?> <?=floor($prefill_result["quyen"]/4)%2?"checked":""?>>Tôi
					<input type="checkbox" name="group" value="y" <?=$edit_mode==2?"":"disabled"?> <?=floor($prefill_result["quyen"]/2)%2?"checked":""?>>Nhóm của tôi
					<input type="checkbox" name="other" value="y" <?=$edit_mode==2?"":"disabled"?> <?=$prefill_result["quyen"]%2?"checked":""?>>Những người còn lại trên XMake
				</td>
			</tr>
		</table>
		<input class="form_submit" type="submit" name="submit" value="OK" <?=$edit_mode?"":"disabled"?>>
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
					'-',
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
				],
			},
			language: 'vi',
		} )
		.then( editor => {
			editor.isReadOnly=<?=$edit_mode?"false":"true"?>;
		} )
		.catch( error => {
			console.error( error );
		} );
	</script>
	<?php
}
else{
	//Mặc định: hiển thị danh sách tất cả các phân loại bài viết
	if (isset($_POST["submit_cat"])){
		$hienthi=0;
		if (isset($_POST["hien_thi"])) $hienthi=1;
		if ($_POST["cha"]==0){
			$cap=1;
		}
		else{
			$cap=$conn->query("SELECT cap FROM phan_loai WHERE id= '".$conn->real_escape_string($_POST["cha"])."'")->fetch_array()["cap"]+1;
		}
		$bv->insert_cat($_GET["editcat"],$_POST["ten"],$hienthi,$cap,$_POST["cha"]);
	}
	?>
	<table class="std_table">
		<tr>
			<th>ID</th>
			<th>Tên</th>
			<th>Hiển thị</th>
		</tr>
		<?php
		captcha(0);
		?>
		<tr>
			<td colspan="3" style="background-color: #ddffdd;"><a href="?xmakereq=baiviet&editcat=0">Mới</a></td>
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
				"hien_thi" => 1
			);
		}
		else{
			$prefill_result_cat=$conn->query("SELECT * FROM phan_loai WHERE id='".$conn->real_escape_string($_GET["editcat"])."'")->fetch_array();
		}
		?>
		<br>
		<form method="post">
			<table class="std_table">
				<tr>
					<th>Tên</th>
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
					<td>Phân loại cha</td>
					<td>
						<select name="cha">
							<option value="0">(Không có)</option>
							<?php
							$kq_all=$conn->query("SELECT * FROM phan_loai WHERE id<>'".$_GET["editcat"]."'");
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
	Phần liệt kê các bài viết trong phân loại
	*/
	if (isset($_GET["cat"])){
		?>
		<br>
		<table class="std_table">
			<tr>
				<th>ID</th>
				<th>Tên</th>
				<th>Tác giả</th>
			</tr>
			<?php
			$kq=$bv->get_list_baiviet($_GET["cat"]);
			foreach ($kq as $kq_item){
				?>
				<tr>
					<td><?=$kq_item["id"]?></td>
					<td><a href="?xmakereq=baiviet&baiviet=<?=$kq_item["id"]?>"><?=$kq_item["tieu_de"]?></a></td>
					<td><?=$conn->query("SELECT * FROM ten_nguoi_dung WHERE id=".$conn->real_escape_string($kq_item["tac_gia"]))->fetch_array()["ten"]?></td>
				</tr>
				<?php
			}
			?>
			<tr>
				<td colspan="3" style="background-color: #ddffdd;"><a href="?xmakereq=baiviet&baiviet=0">Mới</a></td>
			</tr>
		</table>
		<?php
	}
}
?>