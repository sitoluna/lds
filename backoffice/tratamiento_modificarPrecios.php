<?php
/*
 * Created on 17/12/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 //comprueba si todos las casillas tienen un valor valido
$error = 0;
$errorMsg = "";

	if($_POST['priceMonths_1'] != ""){
		$priceMonths_1 = $_POST['priceMonths_1'];
	}else{
		$error = 1;
		$errorMsg .= "priceMonths_1<br/>";
	}
	if($_POST['pricePlusMonths_1'] != ""){
		$pricePlusMonths_1 = $_POST['pricePlusMonths_1'];
	}else{
		$error = 1;
		$error .= "pricePlusMonths_1<br/>";
	}
//	if($_POST['price4Weeks_1'] != ""){
//		$price4Weeks_1 = $_POST['price4Weeks_1'];
//	}else{
//		$error = 1;
//		$errorMsg .= "price4Weeks_1<br/>";
//	}
//	if($_POST['pricePlus4Weeks_1'] != ""){
//		$pricePlus4Weeks_1 = $_POST['pricePlus4Weeks_1'];
//	}else{
//		$error = 1;
//		$errorMsg .= "pricePlus4Weeks_1<br/>";
//	}
	if($_POST['price3Weeks_1'] != ""){
		$price3Weeks_1 = $_POST['price3Weeks_1'];
	}else{
		$error = 1;
		$errorMsg .= "price3Weeks_1<br/>";
	}
	if($_POST['pricePlus3Weeks_1'] != ""){
		$pricePlus3Weeks_1 = $_POST['pricePlus3Weeks_1'];
	}else{
		$error = 1;
		$errorMsg .= "pricePlus3Weeks_1<br/>";
	}
	if($_POST['price2Weeks_1'] != ""){
		$price2Weeks_1 = $_POST['price2Weeks_1'];
	}else{
		$error = 1;
		$errorMsg .= "price2Weeks_1<br/>";
	}
	if($_POST['pricePlus2Weeks_1'] != ""){
		$pricePlus2Weeks_1 = $_POST['pricePlus2Weeks_1'];
	}else{
		$error = 1;
		$errorMsg .= "pricePlus2Weeks_1<br/>";
	}
	if($_POST['price1Week_1'] != ""){
		$price1Week_1 = $_POST['price1Week_1'];
	}else{
		$error = 1;
		$errorMsg .= "price1Week_1<br/>";
	}
	if($_POST['pricePlus1Week_1'] != ""){
		$pricePlus1Week_1 = $_POST['pricePlus1Week_1'];
	}else{
		$error = 1;
		$errorMsg .= "pricePlus1Week_1<br/>";
	}
//	if($_POST['priceDays_1'] != ""){
//		$priceDays_1 = $_POST['priceDays_1'];
//	}else{
//		$error = 1;
//		$errorMsg .= "priceDays_1<br/>";
//	}
	if($_POST['priceMonths_2'] != ""){
		$priceMonths_2 = $_POST['priceMonths_2'];
	}else{
		$error = 1;
		$errorMsg .= "priceMonths_2<br/>";
	}
	if($_POST['pricePlusMonths_2'] != ""){
		$pricePlusMonths_2 = $_POST['pricePlusMonths_2'];
	}else{
		$error = 1;
		$errorMsg .= "pricePlusMonths_2<br/>";
	}
//	if($_POST['price4Weeks_2'] != ""){
//		$price4Weeks_2 = $_POST['price4Weeks_2'];
//	}else{
//		$error = 1;
//		$errorMsg .= "price4Weeks_2<br/>";
//	}
//	if($_POST['pricePlus4Weeks_2'] != ""){
//		$pricePlus4Weeks_2 = $_POST['pricePlus4Weeks_2'];
//	}else{
//		$error = 1;
//		$errorMsg .= "pricePlus4Weeks_2<br/>";
//	}
	if($_POST['price3Weeks_2'] != ""){
		$price3Weeks_2 = $_POST['price3Weeks_2'];
	}else{
		$error = 1;
		$errorMsg .= "price3Weeks_2<br/>";
	}
	if($_POST['pricePlus3Weeks_2'] != ""){
		$pricePlus3Weeks_2 = $_POST['pricePlus3Weeks_2'];
	}else{
		$error = 1;
		$errorMsg .= "pricePlus3Weeks_2<br/>";
	}
	if($_POST['price2Weeks_2'] != ""){
		$price2Weeks_2 = $_POST['price2Weeks_2'];
	}else{
		$error = 1;
		$errorMsg .= "price2Weeks_2<br/>";
	}
	if($_POST['pricePlus2Weeks_2'] != ""){
		$pricePlus2Weeks_2 = $_POST['pricePlus2Weeks_2'];
	}else{
		$error = 1;
		$errorMsg .= "pricePlus2Weeks_2<br/>";
	}
	if($_POST['price1Week_2'] != ""){
		$price1Week_2 = $_POST['price1Week_2'];
	}else{
		$error = 1;
		$errorMsg .= "price1Week_2<br/>";
	}
	if($_POST['pricePlus1Week_2'] != ""){
		$pricePlus1Week_2 = $_POST['pricePlus1Week_2'];
	}else{
		$error = 1;
		$errorMsg .= "pricePlus1Week_2<br/>";
	}
//	if($_POST['priceDays_2'] != ""){
//		$priceDays_2 = $_POST['priceDays_2'];
//	}else{
//		$error = 1;
//		$errorMsg .= "priceDays_2<br/>";
//	}
	if($_POST['priceMonths_3'] != ""){
		$priceMonths_3 = $_POST['priceMonths_3'];
	}else{
		$error = 1;
		$errorMsg .= "priceMonths_3<br/>";
	}
	if($_POST['pricePlusMonths_3'] != ""){
		$pricePlusMonths_3 = $_POST['pricePlusMonths_3'];
	}else{
		$error = 1;
		$errorMsg .= "pricePlusMonths_3<br/>";
	}
//	if($_POST['price4Weeks_3'] != ""){
//		$price4Weeks_3 = $_POST['price4Weeks_3'];
//	}else{
//		$error = 1;
//		$errorMsg .= "price4Weeks_3<br/>";
//	}
//	if($_POST['pricePlus4Weeks_3'] != ""){
//		$pricePlus4Weeks_3 = $_POST['pricePlus4Weeks_3'];
//	}else{
//		$error = 1;
//		$errorMsg .= "pricePlus4Weeks_3<br/>";
//	}
	if($_POST['price3Weeks_3'] != ""){
		$price3Weeks_3 = $_POST['price3Weeks_3'];
	}else{
		$error = 1;
		$errorMsg .= "price3Weeks_3<br/>";
	}
	if($_POST['pricePlus3Weeks_3'] != ""){
		$pricePlus3Weeks_3 = $_POST['pricePlus3Weeks_3'];
	}else{
		$error = 1;
		$errorMsg .= "pricePlus3Weeks_3<br/>";
	}
	if($_POST['price2Weeks_3'] != ""){
		$price2Weeks_3 = $_POST['price2Weeks_3'];
	}else{
		$error = 1;
		$errorMsg .= "price2Weeks_3<br/>";
	}
	if($_POST['pricePlus2Weeks_3'] != ""){
		$pricePlus2Weeks_3 = $_POST['pricePlus2Weeks_3'];
	}else{
		$error = 1;
		$errorMsg .= "pricePlus2Weeks_3<br/>";
	}
	if($_POST['price1Week_3'] != ""){
		$price1Week_3 = $_POST['price1Week_3'];
	}else{
		$error = 1;
		$errorMsg .= "price1Week_3<br/>";
	}
	if($_POST['pricePlus1Week_3'] != ""){
		$pricePlus1Week_3 = $_POST['pricePlus1Week_3'];
	}else{
		$error = 1;
		$errorMsg .= "pricePlus1Week_3<br/>";
	}
//	if($_POST['priceDays_3'] != ""){
//		$priceDays_3 = $_POST['priceDays_3'];
//	}else{
//		$error = 1;
//		$errorMsg .= "priceDays_3<br/>";
//	}
	if($_POST['priceSSyF'] != ""){
		$priceSSyF = $_POST['priceSSyF'];
	}else{
		$error = 1;
		$errorMsg .= "priceSSyF<br/>";
	}

 //modifica el fichero precios.php con los nuevos valores

if(!$errorMsg){

 $fprecios = fopen("precios.php","w");

 fwrite($fprecios,'<?php'."\n");

 fwrite($fprecios,'$priceMonths_1 = '.$_POST['priceMonths_1'].';'."\n");
 fwrite($fprecios,'$pricePlusMonths_1 = '.$_POST['pricePlusMonths_1'].';'."\n");

 fwrite($fprecios,'$price4Weeks_1 = '.$_POST['priceMonths_1'].';'."\n");
 fwrite($fprecios,'$pricePlus4Weeks_1 = 0;'."\n");

 fwrite($fprecios,'$price3Weeks_1 = '.$_POST['price3Weeks_1'].';'."\n");
 fwrite($fprecios,'$pricePlus3Weeks_1 = '.$_POST['pricePlus3Weeks_1'].';'."\n");

 fwrite($fprecios,'$price2Weeks_1 = '.$_POST['price2Weeks_1'].';'."\n");
 fwrite($fprecios,'$pricePlus2Weeks_1 = '.$_POST['pricePlus2Weeks_1'].';'."\n");

 fwrite($fprecios,'$price1Week_1 = '.$_POST['price1Week_1'].';'."\n");
 fwrite($fprecios,'$pricePlus1Week_1 = '.$_POST['pricePlus1Week_1'].';'."\n");

// fwrite($fprecios,'$priceDays_1 = '.$_POST['priceDays_1'].';'."\n");


 fwrite($fprecios,'$priceMonths_2 = '.$_POST['priceMonths_2'].';'."\n");
 fwrite($fprecios,'$pricePlusMonths_2 = '.$_POST['pricePlusMonths_2'].';'."\n");

 fwrite($fprecios,'$price4Weeks_2 = '.$_POST['priceMonths_2'].';'."\n");
 fwrite($fprecios,'$pricePlus4Weeks_2 = 0;'."\n");

 fwrite($fprecios,'$price3Weeks_2 = '.$_POST['price3Weeks_2'].';'."\n");
 fwrite($fprecios,'$pricePlus3Weeks_2 = '.$_POST['pricePlus3Weeks_2'].';'."\n");

 fwrite($fprecios,'$price2Weeks_2 = '.$_POST['price2Weeks_2'].';'."\n");
 fwrite($fprecios,'$pricePlus2Weeks_2 = '.$_POST['pricePlus2Weeks_2'].';'."\n");

 fwrite($fprecios,'$price1Week_2 = '.$_POST['price1Week_2'].';'."\n");
 fwrite($fprecios,'$pricePlus1Week_2 = '.$_POST['pricePlus1Week_2'].';'."\n");

// fwrite($fprecios,'$priceDays_2 = '.$_POST['priceDays_2'].';'."\n");

 fwrite($fprecios,'$priceMonths_3 = '.$_POST['priceMonths_3'].';'."\n");
 fwrite($fprecios,'$pricePlusMonths_3 = '.$_POST['pricePlusMonths_3'].';'."\n");

 fwrite($fprecios,'$price4Weeks_3 = '.$_POST['priceMonths_3'].';'."\n");
 fwrite($fprecios,'$pricePlus4Weeks_3 = 0;'."\n");

 fwrite($fprecios,'$price3Weeks_3 = '.$_POST['price3Weeks_3'].';'."\n");
 fwrite($fprecios,'$pricePlus3Weeks_3 = '.$_POST['pricePlus3Weeks_3'].';'."\n");

 fwrite($fprecios,'$price2Weeks_3 = '.$_POST['price2Weeks_3'].';'."\n");
 fwrite($fprecios,'$pricePlus2Weeks_3 = '.$_POST['pricePlus2Weeks_3'].';'."\n");

 fwrite($fprecios,'$price1Week_3 = '.$_POST['price1Week_3'].';'."\n");
 fwrite($fprecios,'$pricePlus1Week_3 = '.$_POST['pricePlus1Week_3'].';'."\n");

// fwrite($fprecios,'$priceDays_3 = '.$_POST['priceDays_3'].';'."\n");

 fwrite($fprecios,'$priceSSyF = '.$_POST['priceSSyF'].';'."\n");

 fwrite($fprecios,'?>');

 fclose($fprecios);

 header("location: modificarPrecios.php?msg=pricesChanged");
}else{
 header("location: modificarPrecios.php?msg=pricesError");
}
?>
