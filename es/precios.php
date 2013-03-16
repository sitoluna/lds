<?php
include("../backoffice/functions/functions.php");
include("../backoffice/precios.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<meta name="description" content="description">
	<meta name="keywords" content="keywords">
	<meta name="author" content="author">
	<link rel="stylesheet" type="text/css" href="../default.css" media="screen">

	<title>LunaDeSevilla - Precios</title>
</head>
<body>

<div class="container">

	<div class="main">

		<?php include("header.php"); ?>

		<div class="content">

			<div class="item">
				<h1>Precios (en euros)</h1>
				<ul>El alquiler m&iacute;nimo es de 1 semana.</ul>
				<ul>Si desea realizar un alquiler de menor duraci&oacute;n tendr&aacute; que pagar la semana completa.</ul>
				<ul>Si desea m&aacute;s informaci&oacute;n, o quiere comentarnos su caso no dude en ponerse en contacto con nosotros.</ul>
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
						<td bgcolor="#FAFAFA"><?php echo $price1Week_1 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $price2Weeks_1 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $price3Weeks_1 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $priceMonths_1 ?></td>
					</tr>

					<tr>
						<td bgcolor="#EEEEEE">3 personas</td>
						<td bgcolor="#FAFAFA"><?php echo $price1Week_2 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $price2Weeks_2 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $price3Weeks_2 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $priceMonths_2 ?></td>
					</tr>

					<tr>
						<td bgcolor="#EEEEEE">4 personas</td>
						<td bgcolor="#FAFAFA"><?php echo $price1Week_3 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $price2Weeks_3 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $price3Weeks_3 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $priceMonths_3 ?></td>
					</tr>

					<tr>
						<td bgcolor="#EEEEEE">D&iacute;a extra (1-2 p.)</td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus1Week_1 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus2Weeks_1 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus3Weeks_1 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlusMonths_1 ?></td>
					</tr>

					<tr>
						<td bgcolor="#EEEEEE">D&iacute;a extra (3 pax)</td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus1Week_2 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus2Weeks_2 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus3Weeks_2 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlusMonths_2 ?></td>
					</tr>

					<tr>
						<td bgcolor="#EEEEEE">D&iacute;a extra (4 pax)</td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus1Week_3 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus2Weeks_3 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus3Weeks_3 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlusMonths_3 ?></td>
					</tr>

				</table>
			</div>

			<div class="item">

				<h1>Suplemento diario para Semana Santa y Feria</h1>

				<table>

					<tr>
						<td bgcolor="#EEEEEE">< 3 Meses</td>
						<td bgcolor="#EEEEEE"> 3 Meses</td>
						<td bgcolor="#EEEEEE"> 4 Meses</td>
						<td bgcolor="#EEEEEE"> 5 Meses</td>
						<td bgcolor="#EEEEEE"> 6 Meses o +</td>
					</tr>
					<tr>
						<td bgcolor="#FAFAFA"><?php echo $priceSSyF; ?></td>
						<td bgcolor="#FAFAFA"><?php echo $priceSSyF*0.9; ?></td>
						<td bgcolor="#FAFAFA"><?php echo $priceSSyF*0.8; ?></td>
						<td bgcolor="#FAFAFA"><?php echo $priceSSyF*0.7; ?></td>
						<td bgcolor="#FAFAFA"><?php echo $priceSSyF*0.5; ?></td>
					</tr>

				</table>
			</div>

			<div class="item">

				<h1>Agua y electricidad</h1>
				<ul>Los alquileres inferiores a 1 mes tienen el consumo de agua y electricidad incluido en el precio.</ul
				<ul>Para aquellos alquileres de mayor duraci&oacute;n, estos gastos se cobrar&aacute;n aparte seg&uacute;n el consumo.</ul>
			</div>

		</div>

		<div class="sidenav">

		<?php include("menu.php"); ?>

		</div>

		<div class="clearer"><span></span></div>
		</div>

		<div class="footer">&copy; 2007 <a href="index.php">lunadesevilla.es</a>.Valid <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>&amp; <a href="http://validator.w3.org/check?uri=referer">XHTML</a>.Template design by Alfonso Luna
		</div>

	</div>
</body>
</html>