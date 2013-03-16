<?php
/*
 * Created on 17/12/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 //comprueba si todos las casillas tienen un valor valido
if(isset($_POST['action']) and $_POST['action']=="proceed"){

	include("classes/connectionMySQL.class.php");

	$error = 0;
	$errorMsg = "";

		if($_POST['c_entidad'] != ""){
			$c_entidad = $_POST['c_entidad'];
		}else{
			$error = 1;
			$errorMsg .= "codigo entidad<br/>";
		}

		if($_POST['c_oficina'] != ""){
			$c_oficina = $_POST['c_oficina'];
		}else{
			$error = 1;
			$errorMsg .= "codigo oficina<br/>";
		}

		if($_POST['c_control'] != ""){
			$c_control = $_POST['c_control'];
		}else{
			$error = 1;
			$errorMsg .= "codigo control<br/>";
		}

		if($_POST['c_cuenta'] != ""){
			$c_cuenta = $_POST['c_cuenta'];
		}else{
			$error = 1;
			$errorMsg .= "codigo cuenta<br/>";
		}

		if($_POST['c_iban'] != ""){
			$c_iban = $_POST['c_iban'];
		}else{
			$error = 1;
			$errorMsg .= "codigo iban<br/>";
		}

		if($_POST['c_bic'] != ""){
			$c_bic = $_POST['c_bic'];
		}else{
			$error = 1;
			$errorMsg .= "codigo bic<br/>";
		}

	 //modifica el fichero CB.php con los nuevos valores

	if(!$errorMsg){

		$connectionMySQL = new connectionMySQL();
		$query = "update cb set c_entidad = '".$_POST['c_entidad']."'," .
				" c_oficina = '".$_POST['c_oficina']."'," .
				" c_control = '".$_POST['c_control']."'," .
				" c_cuenta = '".$_POST['c_cuenta']."'," .
				" c_iban = '".$_POST['c_iban']."'," .
				" c_bic = '".$_POST['c_bic']."'," .
				" entidad = '".$_POST['entidad']."'," .
				" titular = '".$_POST['titular']."'";

		$connectionMySQL->request($query);

		header("location: modificarCuentaBancaria.php?msg=CBChanged");
	}else{
		 header("location: modificarCuentaBancaria.php?msg=CBError");
	}
}else{
	header("location: ../es/index.php");
}
?>
