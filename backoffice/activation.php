<?php
/*
 * Created on 22/11/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

if(isset($_GET['id']) and $_GET['id']!="" and isset($_GET['key']) and $_GET['key']!=""){
	include("classes/connectionMySQL.class.php");
	include("classes/pre_rental.class.php");
	include("functions/functions.php");
	include("classes/email.class.php");
	$id_pre_rental = $_GET['id'];
	$key = $_GET['key'];
	if(md5($id_pre_rental.'4qu1v3ndr14l4cl4v3') == $key){
		$pre_rental = new pre_rental();
		creaLog(md5($id_pre_rental.'4qu1v3ndr14l4cl4v3'));
		if($pre_rental->activatePreRental($id_pre_rental)){
			$pre_rental->getPreRental($id_pre_rental);
			$email = new email($pre_rental, "admin", "es");
			$email->send();
			$msg = "Su pre-reserva ha sido activada. / Your pre-rental has been activated.";
		}else{
			$msg = "Esta pre-reserva ya estaba activada. / This rental was already activated.";
		}
	}else{
		$msg = "Error de identificaci&oacute;n. / ID error.";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<meta name="description" content="description">
	<meta name="keywords" content="keywords">
	<meta name="author" content="author">
	<link rel="stylesheet" type="text/css" href="../default.css" media="screen">
	<script type="text/javascript" src="libreria.js" language="javascript"></script>
	<title>Activaci&oacute;n</title>
</head>
<body>

<div class="container">

	<div class="main">

		<div class="header">

			<div class="title">
				<h1>&nbsp;</h1>
			</div>
		</div>

		<br/>
		<br/>

		<div class="content">
			<table summary="identificacion">
				<tr><td><?php echo $msg;?></td></tr>
				<tr><td>Haga <a href="../es/index.php">click aqu&iacute;</a> para volver a la p&aacute;gina principal </td></tr>
				<tr><td>Make <a href="../en/index.php">click here</a> to back homepage </td></tr>
			</table>
		</div>

		<div class="clearer"><span></span></div>
		</div>

		<div class="footer">&copy; 2007 <a href="../es/index.php">lunadesevilla.es</a>.Valid <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>&amp; <a href="http://validator.w3.org/check?uri=referer">XHTML</a>.Template design by Alfonso Luna
		</div>

	</div>
</body>
</html>
