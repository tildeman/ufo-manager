<?php
//Thiết lập CSDL
$config["db_name"]="xmake_test";
$config["db_uname"]="root";
$config["db_pass"]="hinhthanglol";
$config["db_server"]=$_SERVER["HTTP_HOST"];
//Khu vực cài UFOMgr
$config["docroot"]=dirname(__FILE__);
$req_uri=$_SERVER["REQUEST_URI"];
$req_uri=explode("?",$req_uri)[0];
if (preg_match("/^(\\/.+)\\/.*\\..*(\\?.*)?$/",$req_uri)){
	$req_uri=preg_replace("/^(\\/.+)\\/.*\\..*(\\?.*)?$/","$1",$req_uri);
}
$config["httproot"]="http".(isset($_SERVER["HTTPS"])?"s":"")."://".$_SERVER["HTTP_HOST"].$req_uri;
$config["upload_path"]="upload/";
?>