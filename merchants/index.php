<?php
ob_start();
include("../config.php");
$srv=new MobiService();
$response=$srv->dorequest();
$logger->warn(ob_get_clean());
echo $response;
?>