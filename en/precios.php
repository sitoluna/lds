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

	<title>LunaDeSevilla - Tariffs</title>
</head>
<body>

<div class="container">

	<div class="main">

		<?php include("header.php"); ?>

		<div class="content">

			<div class="item">
				<h1>Rates (euros)</h1>
				<ul>The minimum rent is a week.</ul>
				<ul>If you have a rent of shorter duration will have to pay the whole week.</ul>
				<ul>For more information, please do not hesitate to contact us.</ul>
				<table>
					<tr>
						<td></td>
						<td bgcolor="#EEEEEEE">1 week</td>
						<td bgcolor="#EEEEEEE">2 weeks</td>
						<td bgcolor="#EEEEEEE">3 weeks</td>
						<td bgcolor="#EEEEEEE">1 month</td>
					</tr>

					<tr>
						<td bgcolor="#EEEEEEE">1-2 people</td>
						<td bgcolor="#FAFAFA"><?php echo $price1Week_1 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $price2Weeks_1 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $price3Weeks_1 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $priceMonths_1 ?></td>
					</tr>

					<tr>
						<td bgcolor="#EEEEEEE">3 people</td>
						<td bgcolor="#FAFAFA"><?php echo $price1Week_2 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $price2Weeks_2 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $price3Weeks_2 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $priceMonths_2 ?></td>
					</tr>

					<tr>
						<td bgcolor="#EEEEEEE">4 people</td>
						<td bgcolor="#FAFAFA"><?php echo $price1Week_3 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $price2Weeks_3 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $price3Weeks_3 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $priceMonths_3 ?></td>
					</tr>

					<tr>
						<td bgcolor="#EEEEEEE">Extra night (1-2 p.)</td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus1Week_1 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus2Weeks_1 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus3Weeks_1 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlusMonths_1 ?></td>
					</tr>

					<tr>
						<td bgcolor="#EEEEEEE">Extra night (3 pax)</td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus1Week_2 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus2Weeks_2 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus3Weeks_2 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlusMonths_2 ?></td>
					</tr>

					<tr>
						<td bgcolor="#EEEEEEE">Extra night (4 pax)</td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus1Week_3 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus2Weeks_3 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlus3Weeks_3 ?></td>
						<td bgcolor="#FAFAFA"><?php echo $pricePlusMonths_3 ?></td>
					</tr>

				</table>
			</div>

			<div class="item">

				<h1>Supplement daily for Easter and Feria de Abril</h1>

				<table>

					<tr>
						<td bgcolor="#EEEEEEE">< 3 months</td>
						<td bgcolor="#EEEEEEE"> 3 months</td>
						<td bgcolor="#EEEEEEE"> 4 months</td>
						<td bgcolor="#EEEEEEE"> 5 months</td>
						<td bgcolor="#EEEEEEE"> 6 months or +</td>
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

				<h1>Water and electricity</h1>
				<ul>Water consumption and electricity included in the price for rents shorther than 1-month.</ul
				<ul>For those longer rentals, these costs will be charged separately depending on consumption.</ul>
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