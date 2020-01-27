<?php
define("MSSQL_HOST","127.0.0.1");
define("MSSQL_USER","sa");
define("MSSQL_PASS","123456");
define("MSSQL_C9DB","C9Web");
define("SYSTEM_VER","1.2");

include_once("function.php");

// Don't Edit This
$sql = new PDO("sqlsrv:server=".MSSQL_HOST."; Database=".MSSQL_C9DB."",MSSQL_USER,MSSQL_PASS);
$api = new API(true);
$ip = $_SERVER['REMOTE_ADDR'];

// You can edit under this.
$auth_key	=	7;	// Account Auth that can login.
$login_fail =	3;	// Log in failed time.
$blockip_time = 600; // Block IP Time.

?>