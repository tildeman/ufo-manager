<?php
	$fdcfg["upload"]=dirname(__FILE__,3)."/upload";
	$req_uri=$_SERVER["REQUEST_URI"];
	if (preg_match("/^.*\\/+index\\.php\\/*\\?.*$/",$req_uri)){
		$req_uri=preg_replace("/^(.*)\\/+index\\.php\\/*\\?.*$/","$1",$req_uri);
	}
	$fdcfg["med_pref"]=dirname("http".(isset($_SERVER["HTTPS"])?"s":"")."://".$_SERVER["HTTP_HOST"].explode("?",$req_uri)[0])."/upload";
	$fdcfg["file_types"]["img"]=array(".png",".jpg",".jpeg",".gif",".tiff",".ico",".icn",".bmp",".svg",".webp");
	$fdcfg["file_types"]["aud"]=array(".mp3",".flac",".ogg",".wav",".wma",".midi");
	$fdcfg["file_types"]["vid"]=array(".avi",".flv",".mp4",".mkv",".webm",".wmv");
	$fdcfg["file_types"]["doc"]=array(".doc",".docx",".odt",".xls",".xlsx",".ods",".ppt",".pptx",".odf",".pdf",".txt");
	$fdcfg["file_types"]["rcv"]=array(".7z",".bz2",".gz",".lzma",".rar",".tar",".xz",".zst");
?>