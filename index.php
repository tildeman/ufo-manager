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
	<title>XMake</title>
</head>
<body>
	<script>
		console.log("Powered by XMake :)");
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
					<img src="images/xmake-logo.png" id="home-btn">
				</a>
				<div class="menu-btn">
					<a href="?xmakereq=baiviet">Bài viết</a>
				</div>
				<div class="menu-btn">
					<a href="?xmakereq=giaodien">Giao diện</a>
				</div>
				<div class="menu-btn">
					<a href="?xmakereq=tienich">Tiện ích</a>
				</div>
				<div class="menu-btn">
					<a href="?xmakereq=logout">Đăng xuất</a>
				</div>
			</div>
			<div id="body">
				<?php
					include $config["docroot"]."/xuli.php";
					$conn->close();
				?>
			</div>
			<?php
		}
		else{
			?>
			<div class="login-box">
				<form method="post">
					<h1>Đăng nhập vào XMake</h1>
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