<?php
if (isset($_GET["xmakereq"])){
	switch ($_GET["xmakereq"]){
		case "baiviet":
			include "wrappers/baiviet.php";
			break;
		case "giaodien":
			echo "Giao diện";
			break;
		case "tienich":
			echo "Tiện ích";
			break;
		case "logout":
			session_start();
			session_destroy();
			header("Location: .");
			break;
		default:
			echo "Quýt muôn năm";
	}
}
else{
	echo "Quýt muôn năm";
}
?>