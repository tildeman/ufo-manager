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
	<div class="gditem">
		<img src="images/sec_icn/thanhdoc.svg" onclick="location='?xmakereq=giaodien&muc=thanhdoc'">Thanh dọc
	</div>
	<div class="gditem" onclick="console.log('thanh ngang')">
		<img src="images/sec_icn/thanhngang.svg" onclick="location='?xmakereq=giaodien&muc=thanhngang'">Thanh ngang
	</div>
	<div class="gditem">
		<img src="images/sec_icn/ttinchung.svg" onclick="location='?xmakereq=giaodien&muc=ttinchung'">Thông tin chung
	</div>
	<div class="gditem">
		<img src="images/sec_icn/trangchu.svg" onclick="location='?xmakereq=giaodien&muc=trangchu'">Trang chủ
	</div>
	<script>
	let b=document.getElementsByClassName("gditem");
	for (let i=0;i<b.length;i++){
		b[i].style.cursor="pointer";
	}
	</script>
	<?php
}
?>