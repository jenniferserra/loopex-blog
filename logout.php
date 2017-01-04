<?php
/* ----------------------------------------------------------------------------
		DESTROY THE SESSION
		- HEAD BACK TO INDEX
---------------------------------------------------------------------------- */

session_start();
session_destroy();

header('Location: index.php');
?>