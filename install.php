<?php
	session_start();
	if (!isset($_SESSION["stepno"])){
		$_SESSION["stepno"]=1;
	}
	if ($_POST["next_btn"]=="y") $_SESSION["stepno"]+=1;
	if ($_POST["prev_btn"]=="y") $_SESSION["stepno"]-=1;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/main.css">
	<title>XMake setup</title>
</head>
<body>
	<div class="install-bg">
		<form method="post">
			<?php
			if ($_SESSION["stepno"]==1){
				$h1="Cài đặt XMake";
				$p="Để bắt đầu phần cài đặt, hãy bấm \"Tiếp\"";
				$prev_css="display:none;";
				$prev_txt="Quay lại";
				$next_txt="Tiếp";
			}
			else if ($_SESSION["stepno"]==2){
				$h1="Thiết lập cơ sở dữ liệu";
				$p=file_get_contents("fragmented_htmls/install_1.html");
				$prev_css="";
				$prev_txt="Quay lại";
				$next_txt="Tiếp";
			}
			else if ($_SESSION["stepno"]==3){
				$h1="Thiết lập cơ sở dữ liệu";
				$p=file_get_contents("fragmented_htmls/install_2.html");
				$prev_css="";
				$prev_txt="Quay lại";
				$next_txt="Tiếp";
			}
			else if ($_SESSION["stepno"]==4){
				$h1="Vị trí cài đặt trang web";
				$p="&lt;thiết lập vt cài trang web&gt;";
				$prev_css="";
				$prev_txt="Quay lại";
				$next_txt="Tiếp";
			}
			else if ($_SESSION["stepno"]==5){
				$h1="Hoàn thành cài đặt XMake";
				$p="Để quay trở lại màn hình chính, bấm \"OK\"";
				$prev_css="";
				$prev_txt="Quay lại";
				$next_txt="OK";
			}
			?>
			<div class="install-box">
				<h1><?=$h1?></h1>
				<p><?=$p?></p>
				<button class="btn btn-next" name="prev_btn" value="y" style="<?=$prev_css?>"><?=$prev_txt?></button>
				<button class="btn btn-next" name="next_btn" value="y"><?=$next_txt?></button>
			</div>
		</form>
	</div>
</body>
</html>