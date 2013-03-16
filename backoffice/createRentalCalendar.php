<?php
/*
 * Created on 11/11/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

if(isset($_GET['action']) and $_GET['action']=="proceed"){
	include("classes/connectionMySQL.class.php");
	require("functions/functions.php");
	require("classes/rental.class.php");
	require("classes/client.class.php");
	require("classes/appartment.class.php");
	deleteRentalFolderTree();
	restoreRentalFolderTree();
}
?>
