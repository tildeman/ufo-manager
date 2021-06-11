<?php
require("config.php");
$conn=new mysqli($config["db_server"],$config["db_uname"],$config["db_pass"],$config["db_name"]);
$qr=$conn->query("SELECT * from bai_viet");
$result=$qr->fetch_array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/main.css">
	<title>XMake - Trang chủ</title>
</head>
<body>
	<div class="main-bg">
		<div id="menubar">
			<a href=".">
				<img src="images/xmake-logo.png" id="home-btn">
			</a>
			<div class="menu-btn">
				<a href=".">Bài viết</a>
			</div>
			<div class="menu-btn">
				<a href=".">Giao diện</a>
			</div>
			<div class="menu-btn">
				<a href=".">Tiện ích</a>
			</div>
			<div class="menu-btn">
				<a href=".">Đăng xuất</a>
			</div>
		</div>
	</div>
</body>
</html>