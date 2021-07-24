<?php
$user=$conn->query("SELECT * FROM ten_nguoi_dung WHERE ten='".$conn->real_escape_string($_SESSION["username"])."'")->fetch_array();
$uid=$user["id"];
// Kiểm tra chế độ chỉnh sửa bài viết
if (in_array("3",explode(" ",$user["in_group"]))){
	$scd=scandir($config["docroot"]."/extensions");
	foreach ($scd as $ext){
		if ($ext!="."&&$ext!=".."){
			?>
			<a href="extensions/<?=urlencode($ext)?>">
				<div class="gditem">
					<?php
					if (file_exists($config["docroot"]."/extensions/".$ext."/icon.svg")){
						?>
						<img src="extensions/<?=urlencode($ext)?>/icon.svg"><?=htmlspecialchars($ext)?>
						<?php
					}
					else{
						?>
						<img src="extensions/<?=urlencode($ext)?>/icon.svg"><?=htmlspecialchars($ext)?>
						<?php
					}
					?>
				</div>
			</a>
			<?php
		}
	}
}
?>