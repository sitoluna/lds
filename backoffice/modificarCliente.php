<?php
session_start();
if(!isset($_SESSION["autorizado"]) or $_SESSION["autorizado"]!="SI"){
	header("Location: index.php");
}
include("classes/connectionMySQL.class.php");
include("functions/functions.php");
include("classes/client.class.php");
include("classes/rental.class.php");
include("classes/appartment.class.php");
include("classes/pre_rental.class.php");

if(isset($_POST['id_client']) and $_POST['id_client'] != ""){
	$id_client = $_POST['id_client'];
}else if(isset($_GET['id_client']) and $_GET['id_client'] != ""){
	$id_client = $_GET['id_client'];
}else{
	header("location: error.php?");
}

if(isset($_POST['action']) and $_POST['action'] == "modify"){
	$passport = $_POST['pasaporte'];
	$name = $_POST['nombre'];
	$nationality = $_POST['nacionalidad'];
	$email = $_POST['email'];
	$telephone = $_POST['telefono'];
	$comments = $_POST['comentarios'];
	$num_rent = $_POST['num_alquileres'];

	$client = new client($id_client, $passport, $name, $nationality, $email, $telephone, $comments, $num_rent);
	$client->modify();
	header("location: fichaCliente.php?id=".$id_client."&msg=newClientModified");
}else if(isset($_GET['action']) and $_GET['action'] == "modify"){
	$client = new client();
	$client->getClient($id_client);
}else if(isset($_GET['action']) and $_GET['action'] == "delete"){
	$client = new client();
	$client->getClient($id_client);
	$client->delete();
	header("location: home.php?msg=newClientDeleted");
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
	<title>Modificar cliente</title>


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

				<h1>Modificar datos de <?php echo ucwords($client->name);?></h1>

				<br>
				<form action="modificarCliente.php" method="post" name="form01" id="form01">
					<input type="hidden" name="action" value="modify"/>
					<input type="hidden" name="id_client" value="<?php echo $id_client;?>" />
					<input type="hidden" name="num_alquileres" value="<?php echo $client->num_rent;?>" />
			        <table summary="Formulario para la inserci&oacute;n de un nuevo cliente">
			        <tbody><tr>
			            <td>Nombre: </td><td><input type="text" id="nombre" name="nombre" size="25" maxlength="50" value="<?php echo ucwords($client->name);?>"/> (*)</td>
			        </tr>
			        <tr>
			            <td>Pasaporte: </td><td><input type="text" id="pasaporte" name="pasaporte" size="15" maxlength="20" value="<?php echo $client->passport;?>"/></td>
			        </tr>
			        <tr>
			            <td>Email: </td><td><input type="text" id="email" name="email" size="40" maxlength="50" value="<?php echo $client->email;?>"/></td>
			        </tr>
			        <tr>
			            <td>Tel&eacute;fono: </td><td><input type="text" id="telefono" name="telefono" size="15" maxlength="20" value="<?php echo $client->telephone;?>"/></td>
			        </tr>
			        <tr>
			            <td>Nacionalidad: </td><td><input type="text" id="nacionalidad" name="nacionalidad" size="15" maxlength="20" value="<?php echo ucwords($client->nationality);?>"/></td>
			        </tr>
			        <tr>
			            <td>Comentarios: </td><td><textarea id="comentarios" name="comentarios"><?php echo $client->comments;?></textarea></td>
			        </tr>
			        <tr>
			            <td colspan="2" align="center"><input value="guardar" type="submit"></td>
			        </tr>

				    </tbody></table>
				</form>
				<br>
				<div class="descr">rellene todos los campos marcados con (*)</div>
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
		if(isset($error) and $error != "")
			include("error.php");
	?>

</body></html>
