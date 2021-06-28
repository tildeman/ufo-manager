<?php
	$fdcfg["upload"]=dirname(dirname(__FILE__))."/upload";
	$req_uri=$_SERVER["REQUEST_URI"];
	//$fdcfg["thing"]=preg_match("/^.*\\/index\\.php$/",$req_uri);
	if (preg_match("/^.*\\/+index\\.php\\/*\\?.*$/",$req_uri)){
		$req_uri=preg_replace("/^(.*)\\/+index\\.php\\/*\\?.*$/","$1",$req_uri);
	}
	$fdcfg["med_pref"]=dirname("http".(isset($_SERVER["HTTPS"])?"s":"")."://".$_SERVER["HTTP_HOST"].explode("?",$req_uri)[0])."/upload";
	$fdcfg["file_types"]["img"]=array("png","jpg","jpeg","gif","tiff","ico","icn","bmp","svg","webp");
	$fdcfg["file_types"]["vid"]=array("mp3","flac","ogg","avi","flv","mp4","mkv","webm");
	$fdcfg["file_types"]["doc"]=array("doc","docx","odt","xls","xlsx","ods","ppt","pptx","odf","pdf","txt");
	$fdcfg["file_types"]["rcv"]=array("7z","bz2","gz","lzma","rar","tar","xz","zst");
?>