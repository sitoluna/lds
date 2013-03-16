<?php
session_start();
if(!isset($_SESSION["autorizado"]) or $_SESSION["autorizado"] != "SI"){
	header("Location: index.php");
}
include ("classes/connectionMySQL.class.php");
include ("functions/functions.php");
include ("classes/client.class.php");
include("classes/pre_rental.class.php");

$id_client = $_GET['id'];
$connectionMySQL = new connectionMySQL();
$client = new client();
$client->getClient($id_client);
$msg = "";
if(isset($_GET['msg']) and $_GET['msg'] != ""){
	switch($_GET['msg']){
		case "newRentalInsered":
			$msg = "<font color='red'><b><i>Nuevo Alquiler Insertado</i></b></font>";
		break;
		case "newRentalModified":
			$msg = "<font color='red'><b><i>Alquiler Modificado</i></b></font>";
		break;
		case "newRentalDeleted":
			$msg = "<font color='red'><b><i>Alquiler Eliminado</i></b></font>";
		break;
		case "newClientModified":
			$msg = "<font color='red'><b><i>Datos Cliente Modificados</i></b></font>";
		break;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<meta name="description" content="description">
	<meta name="keywords" content="keywords">
	<meta name="author" content="author">
	<link rel="stylesheet" type="text/css" href="../default.css" media="screen">
	<title>Ficha del cliente</title>

	<script language="JavaScript" type="text/javascript">
  	function onOffDiv(i){
  		estado = document.getElementById('mas_info'+i).style.display;
  		if(estado == "none"){
  			document.getElementById('mas_info'+i).style.display = "block";
  		}else{
  			document.getElementById('mas_info'+i).style.display = "none";
  		}
  	}
	</script>

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
				<h1>Ficha de <font style="color:red"><?php echo ucwords($client->name);?></font></h1>
			</div>
			<div class="item">
				<h1>Datos Personales</h1>
				<table summary="datos del cliente">
					<tr style="background: #EEEEEE">
						<td>Pasaporte</td><td>Nacionalidad</td><td>Email</td><td>Tel&eacute;fono</td><td>&nbsp;</td><td>&nbsp;</td>
					</tr>
					<tr style="background: #FAFAFA">
						<td><?php echo $client->passport;?></td>
						<td><?php echo ucwords($client->nationality);?></td>
						<td><?php echo strtolower($client->email);?></td>
						<td><?php echo $client->telephone;?></td>
						<td><a href="modificarCliente.php?id_client=<?php echo $id_client;?>&action=modify"><img src="images/modificar.jpg" alt="modificar" onmouseover="showComments()" onmouseout="hideComments()"></a></td>
						<td><a href="modificarCliente.php?id_client=<?php echo $id_client;?>&action=delete" onClick="javascript:return confirm('&iquest;Est&aacute; seguro de que desea eliminar a este Cliente?\nSe borrar&aacute;n los alquileres asociados a &eacute;l.')"><img src="images/eliminar.jpg" alt="eliminar"></a></td>
					</tr>
				</table>
			</div>
			<div class="item">
				<h1>Alquileres ( <a href="nuevoAlquiler.php?id_client=<?php echo $id_client?>">a&ntilde;adir</a> )</h1>
				<table summary="alquileres del cliente">
					<tr style="background: #EEEEEE">
						<td>Piso</td>
						<td>Fecha entrada</td>
						<td>Fecha salida</td>
						<td>N&ordm; pers.</td>
						<td>Fianza</td>
						<td>Precio</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<?php
						include("alquileresCliente.php");
					?>
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
