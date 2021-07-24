<?php
if (isset($_GET["xmakereq"])){
	switch ($_GET["xmakereq"]){
		case "noidung":
			include "wrappers/phanloai.php";
			break;
		case "giaodien":
			include "wrappers/giaodien.php";
			break;
		case "tienich":
			include "wrappers/tienich.php";
			break;
		case "chpwd":
			include "wrappers/changepwd.php";
			break;
		case "logout":
			session_start();
			session_destroy();
			header("Location: .");
			break;
	}
}
else{
	?>
	<h1>Xin chào, <?=$_SESSION["username"]?></h1><br>
	<a href="?xmakereq=chpwd">Đổi mật khẩu</a>
	<?php
}
?>