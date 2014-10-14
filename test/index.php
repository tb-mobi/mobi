<?php
ob_start();
include("../config.php");
$srv=new MobiService();
$response=$srv->dorequest();
$logger->info($response->__toString());
$logger->warn(ob_get_clean());
//file_put_contents("../out-".date("Y-m-d").".log",ob_get_clean()."\n",FILE_APPEND);
?>