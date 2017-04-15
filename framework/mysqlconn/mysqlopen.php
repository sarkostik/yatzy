<?php

//LOOPIA
$sqluser = "user";
$sqlpw = "pw";
$database = "db";
$connect = "host";

mysql_connect($connect,$sqluser,$sqlpw);
@mysql_select_db($database) or die( "Unable to select database");

?>
