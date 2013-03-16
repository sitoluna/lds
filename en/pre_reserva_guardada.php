<?php

include("../backoffice/classes/connectionMySQL.class.php");
include("../backoffice/classes/pre_rental.class.php");
include("../backoffice/functions/functions.php");
$error = "";
if(isset($_GET['id_pre_rental']) and $_GET['id_pre_rental'] != ""){
	$id_pre_rental = $_GET['id_pre_rental'];
	$pre_rental = new pre_rental();
	$pre_rental->getPreRental($id_pre_rental);
}else{
	$error = "Error id";
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

	<title>LunaDeSevilla - Request Successfully Registered.</title>
</head>
<body>

<div class="container">

	<div class="main">

		<?php include("header.php"); ?>

		<div class="content">

			<?php
				if($error == ""){
			?>
			<div class="item">
				<h1>The request has been successfully registered. (*)</h1>
				<ul>
					<li><?php echo ucwords($pre_rental->name);?></li>
					<li><?php echo $pre_rental->email;?></li>

					<?php if($pre_rental->telephone != "") echo "<li>".$pre_rental->telephone."</li>\n";?>
					<?php if($pre_rental->nationality != "") echo "<li>".$pre_rental->nationality."</li>\n";?>
					<li>From <?php echo convertDate($pre_rental->date_start,'es');?> to <?php echo convertDate($pre_rental->date_end,'es');?></li>
					<li><?php echo ucfirst($pre_rental->appartment);?> apartment </li>
					<li><?php echo $pre_rental->num_pers;?> person/people</li>
					<li>Total amount to pay: <?php echo $pre_rental->price;?> euros</li>
					<li>Deposit: <?php echo $pre_rental->deposit;?> euros</li>
				</ul>
				(*)You will receive an email to activate the reservation request.
			</div>
			<?php }else{
				echo "Se ha producido un error inesperado.";
				echo "<br/>Si el error persiste consulte con el administrador (<a href='mailto:admin@lunadesevilla.eu'>admin@lunadesevilla.eu</a>).";
			}?>

		</div>

		<div class="sidenav">

		<?php include("menu.php"); ?>

		</div>

		<div class="clearer"><span></span></div>
		</div>

		<div class="footer">&copy; 2007 <a href="index.php">lunadesevilla.es</a>.Valid <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>&amp; <a href="http://validator.w3.org/check?uri=referer">XHTML</a>.Template design by Alfonso Luna
		</div>

	</div>
	<?php
		if($error != ""){
	?>
	<div class="error" id="divError" style="display: block">
		<table width="400px" height="300px" summary="errores">
			<tr align="right" height="4px"><td><a href="#" onclick="javascript:getElementById('divError').style.display = 'none';"><img src="../images/delete.gif" border="0"></a></td></tr>
			<tr valign="top">
				<td>
					<font color="black"><b><?php echo $error;?></b></font>
				</td>
			</tr>
		</table>
	</div>
	<?php
		}
	?>
</body>
</html>