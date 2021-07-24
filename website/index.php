<?php
require "config.php";
session_start();
$conn=new mysqli($config["db_server"],$config["db_uname"],$config["db_pass"],$config["db_name"]);
$settings=json_decode(file_get_contents("config.json"),1);
$thanhngang=$conn->query("SELECT * FROM thanh_ngang");
function get_list_cat_by_cha($cha){
	global $conn;
	return $conn->query("SELECT * FROM phan_loai WHERE cha='".$conn->real_escape_string($cha)."' and hien_thi='1'");
}
function captcha($cha){
	/*
	Hàm này ko liên quan đến chức năng kiểm tra CAPTCHA.
	*/
	$ds_cha=get_list_cat_by_cha($cha);
	foreach ($ds_cha as $dsci){
		?>
		<div style='padding-left: <?=10+(($dsci["cap"]-1)*20)?>px;'>• <a href="?xmakereq=<?=$dsci["loai"]?>&cat=<?=$dsci["uri"]?>"><?=$dsci["ten"]?></a></div>
		<?php
		captcha($dsci["id"]);
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
	<style>
	.main-bg{
		background-image: linear-gradient(to bottom right,<?=$settings["mau-1"]?>,<?=$settings["mau-2"]?>);
	}
	.menu-btn{	
		width: calc(calc(100% - 200px) / <?=$thanhngang->num_rows?>);
	}
	<?=$settings["css-tuy-chinh"]?>
	</style>
	<title>UFO Manager Test Website</title>
</head>
<body>
	<script>
		console.log("Powered by UFO Manager :)");
	</script>
	<div class="main-bg">
		<div id="menubar">
			<a href=".">
				<img src="data:image;base64,<?=$settings["anh-base64"]?>" id="home-btn">
			</a>
			<?php
			foreach ($thanhngang as $ctn){
				?>
				<a href="<?=$ctn["link"]?>">
					<div class="menu-btn">
						<?=htmlspecialchars($ctn["ten"])?>
					</div>
				</a>
				<?php
			}
			?>
		</div>
		<div id="navbar">
			<?=captcha(0)?>
		</div>
		<div id="body">
			<?php
				include "xuli.php";
				$conn->close();
			?>
		</div>
		<div class="copyright">
			<?=$settings["copyright"]?>
		</div>
	</div>
</body>
</html>