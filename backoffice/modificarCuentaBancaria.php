<?php
session_start();
if(!isset($_SESSION["autorizado"]) or $_SESSION["autorizado"] != "SI"){
	header("Location: index.php");
}
include ("functions/functions.php");
include ("classes/connectionMySQL.class.php");
include("classes/pre_rental.class.php");

$connectionMySQL = new connectionMySQL();
$query = "select * from cb";
$result = $connectionMySQL->request($query);
$row = mysql_fetch_array($result);

$msg = "";
if(isset($_GET['msg']) and $_GET['msg'] != ""){
	switch($_GET['msg']){
		case "CBChanged":
			$msg = "Cuenta Bancaria cambiada";
		break;

		case "CBError":
			$msg = "Error en los datos bancarios";
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
				<h1>Modificar Datos Bancarios</h1>
				<form method="post" action="tratamiento_modificarCB.php">
					<input type="hidden" name="action" value="proceed"/>
					<table>
						<tr>
							<td bgcolor="#EEEEEE">Entidad</td>
							<td bgcolor="#EEEEEE">Oficina</td>
							<td bgcolor="#EEEEEE">Control</td>
							<td bgcolor="#EEEEEE">Cuenta</td>
						</tr>

						<tr>
							<td bgcolor="#EEEEEE"><input type="text" name="c_entidad" value="<?php echo $row['c_entidad'];?>" size="4"/></td>
							<td bgcolor="#EEEEEE"><input type="text" name="c_oficina" value="<?php echo $row['c_oficina'];?>" size="4"/></td>
							<td bgcolor="#EEEEEE"><input type="text" name="c_control" value="<?php echo $row['c_control'];?>" size="2"/></td>
							<td bgcolor="#EEEEEE"><input type="text" name="c_cuenta" value="<?php echo $row['c_cuenta'];?>" size="10"/></td>
						</tr>

						<tr>
							<td bgcolor="#EEEEEE" colspan="4">&nbsp;</td>
						</tr>

						<tr>
							<td bgcolor="#EEEEEE" colspan="2">IBAN (swift)</td>
							<td bgcolor="#EEEEEE" colspan="2">BIC</td>
						</tr>

						<tr>
							<td bgcolor="#EEEEEE" colspan="2"><input type="text" name="c_iban" value="<?php echo $row['c_iban'];?>" size="10"/></td>
							<td bgcolor="#EEEEEE" colspan="2"><input type="text" name="c_bic" value="<?php echo $row['c_bic'];?>" size="15"/></td>
						</tr>

						<tr>
							<td bgcolor="#EEEEEE" colspan="4">&nbsp;</td>
						</tr>

						<tr>
							<td bgcolor="#EEEEEE"  colspan="2">Entidad Bancaria</td>
							<td bgcolor="#EEEEEE"  colspan="2">Titular de la cuenta</td>
						</tr>

						<tr>
							<td bgcolor="#EEEEEE"  colspan="2"><input type="text" name="entidad" value="<?php echo $row['entidad'];?>" size="15"/></td>
							<td bgcolor="#EEEEEE"  colspan="2"><input type="text" name="titular" value="<?php echo $row['titular'];?>" size="25"/></td>
						</tr>

						<tr>
							<td bgcolor="#EEEEEE" colspan="4">&nbsp;</td>
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
