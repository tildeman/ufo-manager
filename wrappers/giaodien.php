<?php
if (isset($_GET["muc"])){
	switch($_GET["muc"]){
		case "thanhdoc":
			echo "thanhdoc";
			break;
		default:
			echo "aaa";
	}
}
else{
	?>
	<a href="?xmakereq=giaodien&muc=thanhdoc">
		<div class="gditem">
			<img src="images/sec_icn/thanhdoc.svg">Thanh dọc
		</div>
	</a>
	<a href="?xmakereq=giaodien&muc=thanhngang">
		<div class="gditem" onclick="console.log('thanh ngang')">
			<img src="images/sec_icn/thanhngang.svg">Thanh ngang
		</div>
	</a>
	<a href="?xmakereq=giaodien&muc=ttinchung">
		<div class="gditem">
			<img src="images/sec_icn/ttinchung.svg">Thông tin chung
		</div>
	</a>
	<a href="?xmakereq=giaodien&muc=trangchu">
		<div class="gditem">
			<img src="images/sec_icn/trangchu.svg">Trang chủ
		</div>
	</a>
	<?php
}
?>