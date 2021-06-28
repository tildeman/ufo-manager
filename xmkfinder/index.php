<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="main.css">
	<title>XMake Finder File Manager</title>
</head>
<body>
	<?php
	include "config.php";
	function is_valid($base,$extra){
		$extraploded=explode("/",$extra);
		$res="";
		foreach ($extraploded as $e_item){
			if ($e_item!="."&&$e_item!=".."&&in_array($e_item,scandir($base.$res))){
				$res=$res."/".$e_item;
			}
			else if ($e_item==""){
				continue;
			}
			else{
				return "";
			}
		}
		return ($res?$res:"/");
	}
	if (isset($_GET["path"])) $append=urldecode($_GET["path"]);
	else $append="";
	$proc_append=is_valid($fdcfg["upload"],$append);
	?>
	<div class="bg-container">
		<div class="toolbar">
			<button class="new">Tải tệp lên</button>
			<button class="new">Tạo thư mục mới</button>
		</div>
		<?php
		if ($proc_append){
			//echo $fdcfg["med_pref"];
			if (is_dir($fdcfg["upload"].$proc_append)){
				$sd=scandir($fdcfg["upload"].$proc_append);
				if (count($sd)>2){
					foreach($sd as $o => $dname){
						if ($dname!="."&&$dname!=".."){
							?>
							<div class="fd-item" onclick="location='?path=<?=$append.'/'.$dname?>'">
								<img src="images/<?=is_dir($fdcfg["upload"].$proc_append."/".$dname)?"folder":"file"?>.svg">
								<span><?=$dname?></span>
							</div>
							<?php
						}
					}
				}
				else{
					?>
					<div id="empty_folder">
						Thư mục trống
					</div>
					<?php
				}
			}
			else{
				//var_dump(explode(".",$proc_append));
				?>
				<img src="<?=$fdcfg["med_pref"].$proc_append?>">
				<?php
			}
		}
		else{
			?>
			no
			<?php
		}
		?>
	</div>
</body>
</html>