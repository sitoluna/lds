<?php
session_start();
// session_register("autorizado");
$_SESSION["autorizado"]="NO";

$error = 0;

include("functions/functions.php");

if(isset($_POST['action']) and $_POST['action'] == "access"){
	include("classes/connectionMySQL.class.php");
	$connectionMySQL = new connectionMySQL();
	$query = "select * from admin";
	$result = $connectionMySQL->request($query);
	$row = mysql_fetch_array($result);
	$login = $row['login'];
	$password = $row['password'];
	if($_POST['login'] == $login and md5($_POST['password']) == $password){
		$_SESSION["autorizado"]="SI";
		header("location:home.php");
	}else{
		$error = 1;
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
	<title>Acceso Admin</title>
</head>
<body>

<div class="container">

	<div class="main">

		<div class="header">

			<div class="title">
				<h1>&nbsp;</h1>
			</div>
			<table summary="Saludo y conexion">
				<tr>
					<td align="left" width="40px"><a href="../es/index.php"><img src="images/home.jpg" border="0" alt=""/></a></td>
					<td align="left" width="*">Bienvenido , hoy es <?php echo convertDate(getDateToday(),"es"); ?></td>
					<td align="right" width="90px">[<a href="index.php">Administrador</a>]</td>
				</tr>
			</table>
		</div>

		<div class="content2">
			<div class="item">
				<h1>Acceso Administrador</h1>
				<form action="index.php" method="post" onsubmit="return loginPass()">
					<input type="hidden" name="action" value="access"/>
					<fieldset style="width: 60%;border:1px solid #4A91C3">
					<legend>Identificaci&oacute;n</legend>
						<table summary="identificacion">
							<tr>
								<td>&nbsp;</td><td>Usuario</td><td><input type="text" name="login" id="login"/></td>
							</tr>
							<tr>
								<td>&nbsp;</td><td>Contrase&ntilde;a</td><td><input name="password" id="password" type="password"/></td>
							</tr>
							<tr>
								<td>&nbsp;</td><td colspan="2" align="center"><input type="submit" name="userypass" value="enviar"></td>
							</tr>
						</table>
					</fieldset>
				</form>
			</div>
		</div>

		<div class="clearer"><span>&nbsp;</span></div>
		</div>

		<div class="footer">&copy; 2007 <a href="../es/index.php">lunadesevilla.es</a>.Valid <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>&amp; <a href="http://validator.w3.org/check?uri=referer">XHTML</a>.Template design by Alfonso Luna
		</div>

	</div>
	<?php
		if($error == 1){
	?>
	<div class="error" id="divError" style="display: block">
		<table width="400px" height="300px" summary="errores">
			<tr align="right" height="4px"><td><a href="#" onclick="javascript:getElementById('divError').style.display = 'none';"><img src="images/delete.gif" border="0"></a></td></tr>
			<tr valign="top">
				<td>
					<font color="black"><b>El usuario y/o la contrase&ntilde;a introducida son incorrectos.</b></font>
				</td>
			</tr>
		</table>
	</div>
	<?php
		}
	?>
</body>
</html>
