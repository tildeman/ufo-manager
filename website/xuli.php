<?php
if (isset($_GET["xmakereq"])){
	switch($_GET["xmakereq"]){
		case "bai_viet":
			$cid=$conn->query("SELECT id FROM phan_loai WHERE uri='".$conn->real_escape_string($_GET["cat"])."' AND hien_thi='1'")->fetch_array()["id"];
			$bvlist=$conn->query("SELECT * FROM bai_viet WHERE phan_loai LIKE '".$conn->real_escape_string($cid)."' OR phan_loai LIKE '".$conn->real_escape_string($cid)." %' OR phan_loai LIKE '% ".$conn->real_escape_string($cid)." %' OR phan_loai LIKE '% ".$conn->real_escape_string($cid)."'");
			foreach ($bvlist as $bvitem){
				?>
				<div class="bvitem">
					<img src="../<?=urlencode($config["upload_path"]."bai_viet/".$bvitem["phan_loai"]."-".$bvitem["uri"].".".$bvitem["ftype"])?>">
					<a style="font-size: 24pt;font-weight: bold;" href="?xmakereq=bvread&bv=<?=urlencode($bvitem["uri"])?>"><?=$bvitem["tieu_de"]?></a><br>
					<?=substr(htmlspecialchars($bvitem["noi_dung"]),0,75)?>
				</div>
				<?php
			}
			break;
		case "bvread":
			$bvcontent=$conn->query("SELECT * FROM bai_viet WHERE uri='".$conn->real_escape_string($_GET["bv"])."'")->fetch_array();
			?>
			<h1><?=$bvcontent["tieu_de"]?></h1><br>
			<?=$bvcontent["noi_dung"]?>
			<?php
		case "album_anh":
			$cid=$conn->query("SELECT id FROM phan_loai WHERE uri='".$conn->real_escape_string($_GET["cat"])."' AND hien_thi='1'")->fetch_array()["id"];
			$bvlist=$conn->query("SELECT * FROM album_anh WHERE phan_loai LIKE '".$conn->real_escape_string($cid)."' OR phan_loai LIKE '".$conn->real_escape_string($cid)." %' OR phan_loai LIKE '% ".$conn->real_escape_string($cid)." %' OR phan_loai LIKE '% ".$conn->real_escape_string($cid)."'");
			foreach ($bvlist as $bvitem){
				?>
				<img src="../<?=urlencode($config["upload_path"]."album_anh/".$bvitem["phan_loai"]."-".$bvitem["uri"].".".$bvitem["ftype"])?>" style="float:left;">
				<?php
			}
			break;
		case "san_pham":
			$cid=$conn->query("SELECT id FROM phan_loai WHERE uri='".$conn->real_escape_string($_GET["cat"])."' AND hien_thi='1'")->fetch_array()["id"];
			$bvlist=$conn->query("SELECT * FROM san_pham WHERE phan_loai LIKE '".$conn->real_escape_string($cid)."' OR phan_loai LIKE '".$conn->real_escape_string($cid)." %' OR phan_loai LIKE '% ".$conn->real_escape_string($cid)." %' OR phan_loai LIKE '% ".$conn->real_escape_string($cid)."'");
			foreach ($bvlist as $bvitem){
				?>
				<div class="spitem">
					<img src="../<?=urlencode($config["upload_path"]."san_pham/".$bvitem["phan_loai"]."-".$bvitem["uri"].".".$bvitem["ftype"])?>">
					<span style="font-size: 24pt;font-weight: bold;"><?=htmlspecialchars($bvitem["ten"])?></span><br>
					Giá: <?=htmlspecialchars($bvitem["gia"])?>đ<br>
					Hãng: <?=htmlspecialchars($bvitem["hang"])?>đ<br>
				</div>
				<?php
			}
			break;
	}
}
?>