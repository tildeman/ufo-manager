<?php
if (isset($_GET["muc"])){
	switch($_GET["muc"]){
		case "thanhngang":
			include "thanhngang.php";
			break;
		case "noidungtinh":
			include "noidungtinh.php";
			break;
		default:
			echo "aaa";
	}
}
else{
	?>
	<a href="?xmakereq=giaodien&muc=thanhngang">
		<div class="gditem" onclick="console.log('thanh ngang')">
			<img src="images/sec_icn/thanhngang.svg">Thanh ngang
		</div>
	</a>
	<a href="?xmakereq=giaodien&muc=noidungtinh">
		<div class="gditem">
			<img src="images/sec_icn/trangchu.svg">Nội dung tĩnh
		</div>
	</a>
	<?php
}
?>