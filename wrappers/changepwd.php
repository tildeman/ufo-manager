<?php
if (isset($_POST["pwd"])){
	$conn->query("UPDATE ten_nguoi_dung SET pass='".sha1(sha1($_POST["pwd"]))."' WHERE ten='".$_SESSION["username"]."'");
}
?>
<h1>Đổi mật khẩu</h1>
<form method="post" enctype="multipart/form-data">
	<table class="std_table">
		<tr>
			<th>Tên</th>
			<th>Mật khẩu mới</th>
		</tr>
		<tr>
			<td><?=$_SESSION["username"]?></td>
			<td><input type="text" class="std_tbl_input" name="pwd"></td>
		</tr>
	</table>
	<input class="form_submit" type="submit" name="submit_tke" value="OK">
</form>