<?php
/*
 * Created on 27/10/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
session_start();
if(!isset($_SESSION["autorizado"]) or $_SESSION["autorizado"]!="SI"){
	header("Location: index.php");
}
include("functions/functions.php");
include("classes/connectionMySQL.class.php");
include("classes/pre_rental.class.php");


$errors = "";
if(isset($_POST['action']) and $_POST['action'] == "modify"){

	$connectionMySQL = new connectionMySQL();

	if(isset($_POST['pass']) and $_POST['pass']!=""){
		$oldPassword = $_POST['pass'];
	}else{
		$errors .= "<p>Ha de introducir la contrase&ntilde;a actual.</p>";
	}

	if(isset($_POST['npass1']) and $_POST['npass1']!=""){
		$newPassword1 = $_POST['npass1'];
	}else{
		$errors .= "<p>La nueva contrase&ntilde;a no puede estar vac&iacute;a.</p>";
	}

	if(isset($_POST['npass2']) and $_POST['npass2'] == $_POST['npass1']){
		//No hacemos nada
	}else{
		$errors .= "<p>La nueva contrase&ntilde;a no se ha escrito correctamente por segunda vez.</p>";
	}

	$query = "select * from admin";
	$result = $connectionMySQL->request($query);
	$row = mysql_fetch_array($result);
	if(isset($oldPassword) and md5($oldPassword) != $row['password']){
		$errors .= "<p>Contrase&ntilde;a actual incorrecta.</p>";
	}

	if($errors == ""){
		$query = "update admin set password = '".md5($newPassword1)."' where login = 'admin'";
		$connectionMySQL->insert($query);
		header("location: home.php?msg=adminModified");
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
	<title>Modificar Contraseña</title>


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
				<h1>Modificar contrase&ntilde;a</h1>
				<form action="modificarAdministrador.php" method="post">
				<input type="hidden" name="action" value="modify"/>
					<table summary="cambio de contrase&ntilde;a">
						<tr>
							<td>Contrase&ntilde;a actual</td><td><input name="pass" id="pass" type="password"/></td>
						</tr>
						<tr>
							<td>Nueva contrase&ntilde;a</td><td><input name="npass1" id="npass1" type="password"/></td>
						</tr>
						<tr>
							<td>Repita la nueva contrase&ntilde;a</td><td><input name="npass2" id="npass2" type="password"/></td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" value="enviar"></td>
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

	</div>
	<?php
		if($errors != "")
			include("error.php");
	?>
</body></html>
