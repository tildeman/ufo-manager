<?php
require("config.php");
session_start();
$conn=new mysqli($config["db_server"],$config["db_uname"],$config["db_pass"],$config["db_name"]);
if (isset($_POST["username"])&&isset($_POST["password"])){
	$uname_query=$conn->query("SELECT * FROM ten_nguoi_dung WHERE ten='".$conn->real_escape_string($_POST["username"])."'");
	if ($uname_query->num_rows==0){
		$error="Invalid username";
	}
	else{
		$row=$uname_query->fetch_array();
		$hash=$row["pass"];
		if ($hash==sha1(sha1($_POST["password"]))){
			if (!in_array("disabled",explode(" ",$row["properties"]))){
				$_SESSION["username"]=$_POST["username"];
				$_SESSION["password"]=$_POST["password"];
			}
			else{
				$error="Account is disabled";
			}
		}
		else{
			$error="Invalid password";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/main.css">
	<title>UFO Manager</title>
</head>
<body>
	<script>
		console.log("Powered by UFO Manager :)");
		function goto(l){
			location="?xmakereq="+l;
		}
	</script>
	<div class="main-bg">
		<?php
		if (isset($error)){
			?>
			<div class="notification_error notification"><span><?=$error?></span></div>
			<?php
		}
		if (isset($_SESSION["username"])&&isset($_SESSION["password"])){
			?>
			<div id="menubar">
				<a href=".">
					<img src="images/ufomgr-logo.png" id="home-btn">
				</a>
				<button class="menu-btn" onclick="goto('noidung')">
					Nội dung
				</button>
				<button class="menu-btn" onclick="goto('giaodien')">
					Giao diện
				</button>
				<button class="menu-btn" onclick="goto('tienich')">
					Tiện ích
				</button>
				<button class="menu-btn" onclick="goto('logout')">
					Đăng xuất
				</button>
			</div>
			<div id="body">
				<?php
					include $config["docroot"]."/xuli.php";
					$conn->close();
				?>
			</div>
			<div class="copyright">
				Copyright &copy; 2021 tildeman.
				<!---
				This program is free software: you can redistribute it and/or modify
				it under the terms of the GNU General Public License as published by
				the Free Software Foundation, either version 3 of the License, or
				(at your option) any later version.

				This program is distributed in the hope that it will be useful,
				but WITHOUT ANY WARRANTY; without even the implied warranty of
				MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
				GNU General Public License for more details.

				You should have received a copy of the GNU General Public License
				along with this program.  If not, see <https://www.gnu.org/licenses/>.
				--->
			</div>
			<?php
		}
		else{
			?>
			<div class="login-box">
				<form method="post">
					<h1>Đăng nhập vào UFO Manager</h1>
					<span>Tên người dùng:</span><br>
					<input type="text" name="username" class="login-expand">
					<span>Mật khẩu:</span><br>
					<input type="password" name="password" class="login-expand">
					<input type="submit" name="login-submit" value="Đăng nhập" id="login-submit">
				</form>
			</div>
			<?php
		}
		?>
	</div>
</body>
</html>