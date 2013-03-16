<?php
/*
 * Created on 15/04/2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 header("Content-type: image/png");

 include "libchart/classes/libchart.php";

 $dir_b = "rentalCalendar/bajo/";
 $dir_p = "rentalCalendar/primero/";
 $dir_s = "rentalCalendar/segundo/";

 $errors = "";
 $pisos = null;

 if(isset($_GET['chk1'])){
 	$chk1 = $_GET['chk1'];
 }else{
 	$chk1 = false;
 }

 if(isset($_GET['chk2'])){
 	$chk2 = $_GET['chk2'];
 }else{
 	$chk2 = false;
 }

 if(isset($_GET['general']) and $_GET['general']=="on"){
 	$general = true;
 }else{
 	$general = false;
 	$pisos = array("bajo"=>false,"primero"=>false,"segundo"=>false);
 }

 if(isset($_GET['bajo']) and $_GET['bajo']=="on"){
 	$pisos['bajo'] = true;
 }

 if(isset($_GET['primero']) and $_GET['primero']=="on"){
 	$pisos['primero'] = true;
 }

 if(isset($_GET['segundo']) and $_GET['segundo']=="on"){
 	$pisos['segundo'] = true;
 }

$meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
$array_meses = array();
$array_anyos = array();

for($i=0;$i<12;$i++){
	if(isset($_GET[$meses[$i]]) and $_GET[$meses[$i]]=="on")
		$array_meses[$i]=true;
	else
		$array_meses[$i]=false;
}

if(isset($_GET['mes_anyo']) and !empty($_GET['mes_anyo'])){
	$mes_anyo = $_GET['mes_anyo'];
}else{
	$mes_anyo = false;
}

 $f_anyo = fopen("rentalCalendar/lastYear.txt","r");
 $lastYear = fgets($f_anyo);
 fclose($f_anyo);

for($i=2004;$i<=$lastYear;$i++){
	if(isset($_GET[$i]) and $_GET[$i]=="on")
		$array_anyos[$i]=true;
	else
		$array_anyos[$i]=false;
}

switch($chk1){
	case "ocupacion":
		switch($chk2){
			case "mes":
				if($general){
					include("graphics/graphic1.php");
				}else{
					include("graphics/graphic2.php");
				}
			break;

			case "anyos":
				if($general){
					include("graphics/graphic3.php");
				}else{
					include("graphics/graphic4.php");
				}
			break;
		}
	break;

	case "ingresos":
		if($general){
			include("graphics/graphic5.php");
		}else{
			include("graphics/graphic6.php");
		}

	break;
}

?>
