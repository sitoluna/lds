<?php
/*
 * Created on 11/11/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
session_start();
if(!isset($_SESSION["autorizado"]) or $_SESSION["autorizado"] != "SI"){
	header("Location: index.php");
}
require("functions/functions.php");
include("classes/appartment.class.php");
include("classes/connectionMySQL.class.php");
include("classes/pre_rental.class.php");

if(isset($_POST['action']) and $_POST['action'] == "proceed"){
	$action = "proceed";
}else{
	$action = "notProceed";
}

$today = date("m-Y",time());
$arrayDate = explode("-",$today);
$month = $arrayDate[0];
$year = $arrayDate[1];

if(isset($_GET['year']) and $_GET['year']!="")
	$year = $_GET['year'];

if(isset($_GET['month']) and $_GET['month']!="")
	$month = $_GET['month'];

if(isset($_GET['appartment']) and $_GET['appartment']!="")
	$appartment = $_GET['appartment'];
else
	$appartment = "bajo";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<meta name="description" content="description">
	<meta name="keywords" content="keywords">
	<meta name="author" content="author">
	<link rel="stylesheet" type="text/css" href="../default.css" media="screen">
	<title>Calendario de disponibilidad</title>


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
					<td width="*">&nbsp;</td>
					<td align="right" width="90px">[<a href="index.php">Desconectarme</a>]</td>
				</tr>
			</table>
		</div>

		<div class="content">

			<div class="item">
				<h1>Calendario de disponibilidad</h1>
				<table width="100%" summary="menu de apartamentos">
					<tr align="center" style="background: url(images/bgul.gif) repeat-x;border: 1px solid #FAFAFA;">
						<td width="33%" <?php if($appartment == "bajo") echo "id='optSelected'"?>>
							<a href="rentalCalendar.php?appartment=bajo&month=<?php echo $month;?>&year=<?php echo $year;?>">Planta baja</a>
						</td>
						<td width="33%" <?php if($appartment == "primero") echo "id='optSelected'"?>>
							<a href="rentalCalendar.php?appartment=primero&month=<?php echo $month;?>&year=<?php echo $year;?>">Primera planta</a>
						</td>
						<td <?php if($appartment == "segundo") echo "id='optSelected'"?>>
							<a href="rentalCalendar.php?appartment=segundo&month=<?php echo $month;?>&year=<?php echo $year;?>">Segunda planta</a>
						</td>
					</tr>
				</table>
				<br/>
				<div class="calendar">
					<?php printCalendar($appartment, $year, $month, "rentalCalendar/", "es");?>
						<br/>
						<br/>
						<table summary="leyenda">
							<tr>
								<td id="libre">&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Libre</td>
								<td id="ocupado">&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Ocupado</td>
								<td id="reservado">&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Reservado</td>
							</tr>
						</table>
					</div>

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
