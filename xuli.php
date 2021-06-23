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