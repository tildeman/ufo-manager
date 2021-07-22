<?php
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
?>