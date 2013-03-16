<?php
/*
 * Created on 05/11/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
session_start();
if(!isset($_SESSION["autorizado"]) or $_SESSION["autorizado"] != "SI"){
	header("Location: index.php");
}

include("functions/functions.php");
include("classes/connectionMySQL.class.php");
include("classes/pre_rental.class.php");

if(isset($_POST['action']) and $_POST['action']=="proceed"){

	include("classes/appartment.class.php");

	$connectionMySQL = new connectionMySQL();
	$connectionMySQL->connect();
	truncateTableBD($connectionMySQL);
	$backupFile = $_POST['bkpBD'];

	$file = fopen("backups/".$backupFile,"r");
	while(!feof($file)){
		$linea = fgets($file);
		if($linea != NULL and $linea != "")
			$connectionMySQL->massive_insert($linea);
	}
	$connectionMySQL->disconnect();
	fclose($file);
	header("location: home.php?msg=bdRestored");
}

if(isset($_GET['msg']) and $_GET['msg']!="")
	$msg = "<p><font color='red'><i>Ha de seleccionar un archivo de restauraci&oacute;n ...</i></font></p>";
else
	$msg = "";
$dir = opendir("backups");

$arrayBD = array();

$arrayFileIntoDirectory = scandir("backups",1);
for($i=0;$i<count($arrayFileIntoDirectory)-2;$i++){
	$filename = $arrayFileIntoDirectory[$i];
	$arrayFile = explode("__",$filename);
	$fechaHora = substr($arrayFile[2],0,2)."/".substr($arrayFile[2],3,2)."/".substr($arrayFile[2],6,4)." ".substr($arrayFile[3],0,2).":".substr($arrayFile[3],3,2).":".substr($arrayFile[3],6,2);
	array_push($arrayBD,array("filename"=>$filename,"fechaHora"=>$fechaHora));
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
	<title>Restaurar el sistema de datos</title>
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
					<td align="left"><a href="home.php"><img src="images/home.jpg" border="0" alt=""/></a></td>
					<td align="left">Bienvenido Manuel, hoy es 26 de Noviembre del 2007</td>
					<td align="right">[<a href="index.php">Desconectarme</a>]</td>
				</tr>
			</table>
		</div>

		<div class="content">

			<div class="item">
				<h1>Restaurar el sistema</h1>
				Seleccione una fecha y pulse en "restaurar"<br/><br/>
				<form method="post" action="restaurarBD.php">
					<input type="hidden" name="action" value="proceed"/>
					<select name="bkpBD"  id="bkpBD">
						<option value="">Seleccione fecha ...</option>
						<?php
							for($i=0;$i<count($arrayBD);$i++){
								echo "<option value='".$arrayBD[$i]['filename']."'>".$arrayBD[$i]['fechaHora']."</option>\n";
							}
						?>
					</select>
					<input type="submit" value="restaurar"/>
				</form>
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

</body>
</html>
