<?php
header('Content-Type: application/json');
session_start();
require("config.php");
function append_tmpnumber($filename,$dig){
	return preg_replace("/(.*)\\.(.*)/","$1-".$dig.".$2",$filename);
}
if (isset($_SESSION["username"])&&isset($_SESSION["password"])){
	if (!isset($_FILES["upload"])){
		echo "{\"error\":{\"message\": \"Tham số không hợp lệ.\"}}";	
	}
	else{
		if ($_FILES["upload"]["error"]){
			echo "{\"error\":{\"message\": \"Lỗi tải ảnh lên (".$_FILES["upload"]["error"].")\"}}";
		}
		else{
			if (file_exists($config["upload_path"].$_FILES["upload"]["name"])){
				$i=0;
				while (file_exists($config["upload_path"].append_tmpnumber($_FILES["upload"]["name"],$i))){
					$i++;
				}
				file_put_contents($config["upload_path"].append_tmpnumber($_FILES["upload"]["name"],$i),file_get_contents($_FILES["upload"]["tmp_name"]));
				echo "{\"url\": \"".str_replace("\"","\\\"",$config["httproot"]."/".$config["upload_path"].append_tmpnumber($_FILES["upload"]["name"],$i))."\"}";
			}
			else{
				file_put_contents($config["upload_path"].$_FILES["upload"]["name"],file_get_contents($_FILES["upload"]["tmp_name"]));
				echo "{\"url\": \"".str_replace("\"","\\\"",$config["httproot"]."/".$config["upload_path"].$_FILES["upload"]["name"])."\"}";
			}
		}
	}
}
else{
	echo "{\"error\":{\"message\": \"Hình như bạn bị đăng xuất tự động. Hãy thử đăng nhập lại.\"}}";
}
?>