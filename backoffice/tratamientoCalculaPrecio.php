<?php
/*
 * Created on 25/11/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

include("functions/functions.php");
include("classes/connectionMySQL.class.php");

$date_start = convertDate($_POST['date_start'],"en");
$date_end = convertDate($_POST['date_end'],"en");
$num_pers = $_POST['num_pers'];
$arrayPrice = calculatePrice($date_start, $date_end, $num_pers,"precios.php");
echo $arrayPrice['price'];
?>
