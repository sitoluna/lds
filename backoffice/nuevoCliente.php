<?php
	session_start();
	if(!isset($_SESSION["autorizado"]) or $_SESSION["autorizado"]!="SI"){
		header("Location: index.php");
	}
	include("functions/functions.php");
	include("classes/connectionMySQL.class.php");
	include("classes/pre_rental.class.php");
	if(isset($_POST['action']) and $_POST['action'] == "insert"){


		$passport = $_POST['pasaporte'];
		$name = $_POST['nombre'];
		$nationality = $_POST['nacionalidad'];
		$email = $_POST['email'];
		$telephone = $_POST['telefono'];
		if(isset($_POST['comentarios']))
			$comments = $_POST['comentarios'];
		else
			$comments = "";

		if(!empty($name)){
			include("classes/client.class.php");
			$client = new client(NULL, $passport,$name,$nationality,$email,$telephone,$comments,0);
			$id_client = $client->insert();
			header("location: fichaCliente.php?id=".$id_client);
		}else{
			$errors = "El nombre de cliente es obligatorio.";
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
	<title>Nuevo cliente</title>


	<script type="text/javascript" language="JavaScript" src="libreria.js"></script>
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

				<h1>Nuevo cliente</h1>

				<br>
				<form action="nuevoCliente.php" method="post" name="form01" id="form01">
				<input type="hidden" name="action" value="insert"/>
			        <table summary="Formulario para la inserci&oacute;n de un nuevo cliente">
			        <tbody><tr>
			            <td>Nombre: </td><td><input type="text" id="nombre" name="nombre" size="25" maxlength="50" value="<?php if(isset($name)) echo $name;?>"/> (*)</td>
			        </tr>
			        <tr>
			            <td>Pasaporte: </td><td><input type="text" id="pasaporte" name="pasaporte" size="15" maxlength="20" value="<?php if(isset($passport)) echo $passport;?>"/></td>
			        </tr>
			        <tr>
			            <td>Email: </td><td><input type="text" id="email" name="email" size="40" maxlength="50" value="<?php if(isset($email)) echo $email;?>"/></td>
			        </tr>
			        <tr>
			            <td>Tel&eacute;fono: </td><td><input type="text" id="telefono" name="telefono" size="15" maxlength="20" value="<?php if(isset($telephone)) echo $telephone;?>"/></td>
			        </tr>
			        <tr>
			            <td>Nacionalidad: </td><td><input type="text" id="nacionalidad" name="nacionalidad" size="15" maxlength="20" value="<?php if(isset($nationality)) echo $nationality;?>"/></td>
			        </tr>
			        <tr>
			            <td>Comentarios: </td><td><textarea id="comentarios" name="comentarios"><?php if(isset($comments)) echo $comments;?></textarea></td>
			        </tr>
			        <tr>
			            <td colspan="2" align="center"><input value="guardar" type="submit"></td>
			        </tr>

				    </tbody></table>
				</form>
				<br>
				<div class="descr">Rellene todos los campos marcados con (*)</div>
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
		if(isset($errors) and $errors != "")
			include("error.php");
	?>

</body></html>
