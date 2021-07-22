<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="main.css">
	<title>UFOMgr Finder File Manager</title>
</head>
<body>
	<?php
	include "config.php";
	session_start();
	if (isset($_SESSION["username"])&&isset($_SESSION["password"])){
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
		function delete($base,$extra){
			if (is_dir($base."/".$extra)){
				$scd=scandir($base."/".$extra);
				foreach ($scd as $k => $iter){
					if ($iter!="."&&$iter!=".."&&$iter!=""){
						delete($base."/".$extra,$iter);
					}
				}
				rmdir($base."/".$extra);
			}
			else{
				unlink($base."/".$extra);
			}
		}
		if (isset($_GET["path"])) $append=urldecode($_GET["path"]);
		else $append="";
		$proc_append=is_valid($fdcfg["upload"],$append);
		?>
		<div class="bg-container">
			<div class="overlay">
				<div class="form_center">
					<img src="images/remove.svg" onclick="hide_all()" style="cursor: pointer;">
					<form method="post" enctype="multipart/form-data">
						<span style="font-size: 24pt; font-weight: 600;">Tải tệp lên</span>(Tối đa: 2MB)<br><br>
						<input type="file" name="upload_file" required accept="<?=implode(",",$fdcfg["file_types"]["img"]).",".implode(",",$fdcfg["file_types"]["aud"]).",".implode(",",$fdcfg["file_types"]["vid"]).",".implode(",",$fdcfg["file_types"]["doc"]).",".implode(",",$fdcfg["file_types"]["rcv"])?>"><br><br>
						<input type="submit" name="upload" value="OK" class="ok_btn">
					</form>
				</div>
			</div>
			<div class="overlay">
				<div class="form_center">
					<img src="images/remove.svg" onclick="hide_all()" style="cursor: pointer;">
					<form method="post">
						<span style="font-size: 24pt; font-weight: 600;">Tạo thư mục</span><br><br>
						<input type="text" name="folder_make" placeholder="Tên thư mục" required><br><br>
						<input type="submit" name="mkdir" value="OK" class="ok_btn">
					</form>
				</div>
			</div>
			<div class="overlay">
				<div class="form_center">
					<img src="images/remove.svg" onclick="hide_all()" style="cursor: pointer;">
					<form method="post">
						<span style="font-size: 24pt; font-weight: 600;">Đổi tên</span><br><br>
						<input type="hidden" id="oname" name="oldname">
						<input type="text" id="nname" name="rename" placeholder="Tên" required><br><br>
						<input type="submit" name="mv" value="OK" class="ok_btn">
					</form>
				</div>
			</div>
			<script>
				function showform(n){
					hide_all();
					document.getElementsByClassName("overlay")[n].style.display="block";
				}
				function hide_all(){
					let t=document.getElementsByClassName("overlay");
					t[0].style.display="none";
					t[1].style.display="none";
					t[2].style.display="none";
				}
				function rename_file(f){
					document.getElementById("oname").value=f;
					document.getElementById("nname").value=f;
					showform(2);
				}
			</script>
			<div class="toolbar">
				<button class="new" onclick="showform(0)"><img src="images/file_new.svg">Tải tệp lên</button>
				<div class="separator"></div>
				<button class="new" onclick="showform(1)"><img src="images/folder_new.svg">Tạo thư mục mới</button>
				<div class="separator"></div>
				<a href="." style="display:block;float:left;">
					<img src="images/root.svg" style="height: 100%;">
				</a>
				<div id="tree">
					<?php
					if ($proc_append){
						$xpl=explode("/",$proc_append);
						$concat="";
						foreach ($xpl as $xpl_item){
							if ($xpl_item!=""){
								$concat=$concat."/".$xpl_item;
								?>
								&gt; <a href="?path=<?=urlencode($concat)?>"><?=$xpl_item?></a>
								<?php
							}
						}
					}
					?>
				</div>
			</div>
			<?php
			if ($proc_append){
				if (isset($_POST["upload"])){
					file_put_contents($fdcfg["upload"].$proc_append."/".$_FILES["upload_file"]["name"],file_get_contents($_FILES["upload_file"]["tmp_name"]));
				}
				if (isset($_POST["mkdir"])){
					mkdir($fdcfg["upload"].$proc_append."/".$_POST["folder_make"],511);
				}
				if (isset($_POST["mv"])){
					rename($fdcfg["upload"].$proc_append."/".$_POST["oldname"],$fdcfg["upload"].$proc_append."/".$_POST["rename"]);
				}
				if (isset($_GET["delete"])){
					delete($fdcfg["upload"].$proc_append,$_GET["delete"]);
				}

				if (is_dir($fdcfg["upload"].$proc_append)){
					$sd=scandir($fdcfg["upload"].$proc_append);
					if (count($sd)>2){
						foreach($sd as $o => $dname){
							if ($dname!="."&&$dname!=".."&&$dname!=""){
								?>
								<div class="fd-item">
									<a href="?path=<?=urlencode($_GET['path'])?>&delete=<?=urlencode($dname)?>">
										<img class="action" src="images/remove.svg">
									</a>
									<img class="action" src="images/rename.svg" onclick="rename_file(&quot;<?=str_replace('"','&#92;&quot;',$dname)?>&quot;)" style="cursor:pointer;">
									<?php
									if (!is_dir($fdcfg["upload"].$proc_append."/".$dname)){
										?>
										<a href="<?=$fdcfg["med_pref"].$proc_append."/".urlencode($dname)?>" download>
											<img class="action" src="images/download.svg">
										</a>
										<?php
									}
									?>
									<a href="?path=<?=urlencode($proc_append.'/'.$dname)?>">
										<img class="type-img" src="images/<?=is_dir($fdcfg["upload"].$proc_append."/".$dname)?"folder":"file"?>.svg">
									</a>
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
					<img src="<?=htmlspecialchars($fdcfg["med_pref"].$proc_append)?>">
					<?php
				}
			}
			else{
				?>
				<div id="empty_folder">
					Vị trí không hợp lệ
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
	else{
		?>
		Access denied
		<?php
	}
	?>
</body>
</html>