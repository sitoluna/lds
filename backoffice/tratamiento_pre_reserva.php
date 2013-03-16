<?php
/*
 * Created on 14/11/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

include("classes/connectionMySQL.class.php");
include("classes/pre_rental.class.php");
include("classes/rental.class.php");
include("classes/client.class.php");
include("classes/appartment.class.php");
include("classes/email.class.php");
include("functions/functions.php");

$id_pre_rental = $_GET['id_pre_rental'];
$pre_rental = new pre_rental();
$pre_rental->getPreRental($id_pre_rental);
$currentStatus = $pre_rental->status;
$newStatus = "";
$action = $_GET['action'];
global $msgErr;
switch($currentStatus){
	case "0":
		if($action == "accept"){
			$arrayOverlapedDates = overlapedDates($pre_rental->date_start, $pre_rental->date_end, $pre_rental->appartment);
			$arrayOverlapedDatesPR = overlapedDatesPR($pre_rental->date_start, $pre_rental->date_end, $pre_rental->appartment);
			if(!$arrayOverlapedDates['status'] and !$arrayOverlapedDatesPR['status']){
				$newStatus = '1';
			}else{
				$msgErr .= "<p>Se han encontrado los siguientes alquileres o pre-reservas que solapan la petici&oacute;n de pre-reserva:</p>".$arrayOverlapedDates['errors'].$arrayOverlapedDatesPR['errors'];
			}
		}else if($action == "cancel"){
			$newStatus = '3';
		}else{
			$msgErr .= "<p>Esta posibilidad no est&aacute; contemplada ( ".$currentStatus." -> ".$action." )</p>";
		}
	break;
	case "1":
		if($action == "accept"){
			$arrayOverlapedDates = overlapedDates($pre_rental->date_start, $pre_rental->date_end, $pre_rental->appartment);
			if(!$arrayOverlapedDates['status']){
				$newStatus = '2';
			}else{
				$msgErr .= "<p>Se han encontrado los siguientes alquileres que solapan la pre-reserva:</p>".$arrayOverlapedDates['errors'];
			}
		}else if($action == "cancel"){
			$newStatus = '4';
		}else{
			$msgErr .= "<p>Esta posibilidad no est&aacute; contemplada ( ".$currentStatus." -> ".$action." )</p>";
		}
	break;
	case "2":
	case "3":
	case "4":
		$msgErr .= "<p>Esta posibilidad no est&aacute; contemplada ( ".$currentStatus." -> ".$action." )</p>";
	break;
}
if($msgErr == ""){
	$pre_rental->changeStatus($newStatus);
	header("location: pre_reservas.php");
}else{
	header("location: pre_reservas.php?msg=".urlencode($msgErr));
}
?>
