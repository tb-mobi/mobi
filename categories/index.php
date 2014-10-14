<?php
ob_start();
include("../config.php");
require(TYM_PATH."core.php");
$srv=new MobiService();
$response=$srv->dorequest();
echo $response;
file_put_contents("../out-".date("Y-m-d").".log",ob_get_clean()."\n",FILE_APPEND);
echo $srv;
?>