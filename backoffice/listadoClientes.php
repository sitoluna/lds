<?php
session_start();
if(!isset($_SESSION["autorizado"]) or $_SESSION["autorizado"] != "SI"){
	header("Location: index.php");
}
include ("classes/connectionMySQL.class.php");
include("functions/functions.php");
include("classes/pre_rental.class.php");

$connectionMySQL = new connectionMySQL();
if(!isset($_POST['name']) or $_POST['name']==""){
	$modo = 0;
	if(isset($_GET['order']) and $_GET['order'] != "")
		$order = $_GET['order'];
	else
		$order = "";
	switch($order){
		case "nameAsc":
			$orderBy = "order by name asc";
		break;
		case "nameDesc":
			$orderBy = "order by name desc";
		break;
		default:
			$orderBy = "order by id";
		break;
	}
	$query = "select * from client ".$orderBy;
	$result = $connectionMySQL->request($query);
}
else{
	$modo = 1;
	$query = "select * from client where name like '%".$_POST['name']."%' order by name";
	$result = $connectionMySQL->request($query);
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
	<title>Listado de clientes</title>
	<script type="text/javascript" src="functions/funciones.js"></script>
	<script type="text/javascript">
		var foco = 0;
		function init(){
			buscarDato();
		}
		function changeOrder(value){
			document.getElementById('order').value = value;
			buscarDato();
		}
	</script>
</head>
<body onload="init()">

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
					<td width="*">&nbsp;</td>
					<td align="right" width="90px">[<a href="index.php">Desconectarme</a>]</td>
				</tr>
			</table>
		</div>

		<div class="content">

			<div class="item">

				<h1>Listado de clientes</h1>

				<br>
				<form name="frmbusqueda" action="" onkeyup="buscarDato(); return false">
			    	<input type="hidden" name="order" id="order" />
					<table>
						<tr>
							<td width="180px"><input class="styled" type="text" id="dato" name="dato"></td>
							<td><input class="button" onclick=""></td>
						</tr>
					</table>
				</form>
				<div id="resultado" align="center"></div>
				<br>
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
