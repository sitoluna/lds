<?php
session_start();
if(!isset($_SESSION["autorizado"]) or $_SESSION["autorizado"] != "SI"){
	header("Location: index.php");
}
include ("functions/functions.php");
include ("classes/connectionMySQL.class.php");
include("classes/pre_rental.class.php");
include("precios.php");

$msg = "";
if(isset($_GET['msg']) and $_GET['msg'] != ""){
	switch($_GET['msg']){
		case "pricesChanged":
			$msg = "Precios cambiados";
		break;

		case "pricesError":
			$msg = "Error precios";
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
	<title>Modificar Precios</title>


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
					<td width="*"><?php if ($msg != "") echo "( <font color='red'><i>".$msg."</i></font> )";?></td>
					<td align="right" width="90px">[<a href="index.php">Desconectarme</a>]</td>
				</tr>
			</table>
		</div>

		<div class="content">

			<div class="item">
				<h1>Modificar Precios</h1>
				<form method="post" action="tratamiento_modificarPrecios.php">
					<table>
						<tr>
							<td></td>
							<td bgcolor="#EEEEEE">1 semana</td>
							<td bgcolor="#EEEEEE">2 semanas</td>
							<td bgcolor="#EEEEEE">3 semanas</td>
							<td bgcolor="#EEEEEE">1 mes</td>
						</tr>

						<tr>
							<td bgcolor="#EEEEEE">1-2 personas</td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="price1Week_1" value="<?php echo $price1Week_1 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="price2Weeks_1" value="<?php echo $price2Weeks_1 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="price3Weeks_1" value="<?php echo $price3Weeks_1 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="priceMonths_1" value="<?php echo $priceMonths_1 ?>"/></td>
						</tr>

						<tr>
							<td bgcolor="#EEEEEE">3 personas</td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="price1Week_2" value="<?php echo $price1Week_2 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="price2Weeks_2" value="<?php echo $price2Weeks_2 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="price3Weeks_2" value="<?php echo $price3Weeks_2 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="priceMonths_2" value="<?php echo $priceMonths_2 ?>"/></td>
						</tr>

						<tr>
							<td bgcolor="#EEEEEE">4 personas</td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="price1Week_3" value="<?php echo $price1Week_3 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="price2Weeks_3" value="<?php echo $price2Weeks_3 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="price3Weeks_3" value="<?php echo $price3Weeks_3 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="priceMonths_3" value="<?php echo $priceMonths_3 ?>"/></td>
						</tr>

						<tr>
							<td bgcolor="#EEEEEE">D&iacute;a extra (1-2 pax)</td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="pricePlus1Week_1" value="<?php echo $pricePlus1Week_1 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="pricePlus2Weeks_1" value="<?php echo $pricePlus2Weeks_1 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="pricePlus3Weeks_1" value="<?php echo $pricePlus3Weeks_1 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="pricePlusMonths_1" value="<?php echo $pricePlusMonths_1 ?>"/></td>
						</tr>

						<tr>
							<td bgcolor="#EEEEEE">D&iacute;a extra (3 pax)</td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="pricePlus1Week_2" value="<?php echo $pricePlus1Week_2 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="pricePlus2Weeks_2" value="<?php echo $pricePlus2Weeks_2 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="pricePlus3Weeks_2" value="<?php echo $pricePlus3Weeks_2 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="pricePlusMonths_2" value="<?php echo $pricePlusMonths_2 ?>"/></td>
						</tr>

						<tr>
							<td bgcolor="#EEEEEE">D&iacute;a extra (4 pax)</td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="pricePlus1Week_3" value="<?php echo $pricePlus1Week_3 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="pricePlus2Weeks_3" value="<?php echo $pricePlus2Weeks_3 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="pricePlus3Weeks_3" value="<?php echo $pricePlus3Weeks_3 ?>"/></td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="pricePlusMonths_3" value="<?php echo $pricePlusMonths_3 ?>"/></td>
						</tr>

						<tr>
							<td bgcolor="#FAFAFA">&nbsp;</td>
						</tr>
						<tr>
							<td bgcolor="#EEEEEE">Semama Santa y Feria</td>
							<td bgcolor="#FAFAFA"><input size="3"  type="text" name="priceSSyF" value="<?php echo $priceSSyF ?>"/></td>
							<td bgcolor="#FAFAFA"></td>
							<td bgcolor="#FAFAFA"></td>
							<td bgcolor="#FAFAFA"></td>
							<td bgcolor="#FAFAFA"></td>
						</tr>
						<tr>
							<td bgcolor="#FAFAFA">&nbsp;</td>
						</tr>
						<tr>
							<td bgcolor="#EEEEEE" colspan="6"><input type="submit" value="modificar"/></td>
						</tr>
					</table>
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

	<?php
		if(isset($errors) and $errors != "")
			include("error.php");
	?>
	</div>

</body>
</html>
