<?php 
/* ----------------------------------------------------------------------------
	ADJUST DATABASE CONFIGURATION HERE
---------------------------------------------------------------------------- */
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "db_blogg");

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$stmt = $conn->stmt_init();
?>