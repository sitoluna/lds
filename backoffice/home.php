<?php
/*
 * Created on 11/10/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
session_start();
if(!isset($_SESSION["autorizado"]) or $_SESSION["autorizado"] != "SI"){
	header("Location: index.php");
}
include ("functions/functions.php");
include ("classes/connectionMySQL.class.php");
include("classes/appartment.class.php");
include("classes/pre_rental.class.php");

makeBackup();
$msg = "";
if(isset($_GET['msg']) and $_GET['msg'] != ""){
	switch($_GET['msg']){
		case "newClientDeleted":
			$msg = "<b><i><font color='red'>Cliente eliminado</font></i></b>";
		break;
		case "adminModified":
			$msg = "<b><i><font color='red'>Contrase&ntilde;a de Administrador Modificada</font></i></b>";
		break;
		case "bdRestored":
			$msg = "<b><i><font color='red'>Base de datos restaurada</font></i></b>";
		break;
		case "backuped":
			$msg = "<b><i><font color='red'>Backup finalizado</font></i></b>";
		break;

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
	<title>P&aacute;gina Principal</title>


</head>
<body>

<div class="container">

	<div class="main">

		<div class="header">

			<div class="title">
				<h1>&nbsp;</h1>
			</div>
			<table summary="Saludo y desconexion">
				<tr>
					<td align="left" width="40px"><a href="home.php"><img src="images/home.jpg" border="0" alt=""/></a></td>
					<td align="left" width="250px">Bienvenido Manuel, hoy es <?php echo convertDate(getDateToday(),"es"); ?></td>
					<td width="*">&nbsp;<?php if($msg != "") echo " ( ".$msg." ) "; ?></td>
					<td align="right" width="90px">[<a href="index.php">Desconectarme</a>]</td>
				</tr>
			</table>
		</div>

		<div class="content">

			<div class="item">
				<h1>Clientes en este momento</h1>
				<table summary="clientes en este momento">
					<?php
						$appartment = new appartment();
						$arrayAppartment = $appartment->getArrayAppartment();
						for($i=(count($arrayAppartment)-1);$i>=0;$i--){
					?>
					<tr>
						<?php
							if($i == (count($arrayAppartment)-1))
								echo "<td rowspan='".count($arrayAppartment)."'><img src='images/fachada.jpg'/></td>";
						?>
						<td><?php echo ucwords($arrayAppartment[$i])?> :</td><td> <?php echo currentClient($arrayAppartment[$i]); ?> </td>
					</tr>
					<?php
						}
					?>
				</table>
			</div>

			<div class="item">
				<h1>Hoy</h1>
				<table summary="Hoy">
					<tr align="center">
						<td width="50%"><b>Entradas</b></td><td><b>Salidas</b></td>
					</tr>
					<tr align="center" width="50%">
						<td><?php entryClientToday(); ?></td><td><?php exitClient(); ?></td>
					</tr>
				</table>
			</div>

			<div class="item">
				<h1>Pr&oacute;ximas</h1>
				<table summary="Hoy">
					<tr align="center">
						<td width="50%"><b>Entradas</b></td><td><b>Salidas</b></td>
					</tr>
					<tr align="center">
						<td>
							<?php nextClientEntry(); ?>
						</td>
						<td>
							<?php nextClientExit(); ?>
						</td>
					</tr>
				</table>
			</div>

		</div>

		<div class="sidenav">

			<?php include("menuBackOffice.php"); ?>

		</div>

		<div class="clearer"><span></span></div>
		</div>

		<div class="footer">&copy; 2007 <a href="../es/index.php">lunadesevilla.es</a>.Valid <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>&amp; <a href="http://validator.w3.org/check?uri=referer">XHTML</a>.Template design by Alfonso Luna
		</div>

	</div>

</body></html>
