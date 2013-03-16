<?php
include("../backoffice/classes/connectionMySQL.class.php");
include("../backoffice/classes/appartment.class.php");
include("../backoffice/classes/pre_rental.class.php");
include("../backoffice/classes/email.class.php");
include("../backoffice/functions/functions.php");

$language = "es";

$error = "";
$name = "";
$email = "";
$telephone = "";
$nationality = "";
$date_start = date("Y-m-d",time());
$date_end = date("Y-m-d",time());;
$appartment = "";
$num_pers = "";
$selected = "";
$selected2 = "";

if(isset($_POST['action']) and $_POST['action']=="proceed"){
	if(isset($_POST['nombre']) and $_POST['nombre']!=""){
		$name = strtolower($_POST['nombre']);
	}else{
		$error .= "<p>Nombre incorrecto.</p>";
	}
	if(isset($_POST['email']) and $_POST['email']!="" and validateEmail($_POST['email'])){
		$email = strtolower($_POST['email']);
	}else{
		$error .= "<p>Email incorrecto.</p>";
	}
	if(isset($_POST['telefono']) and $_POST['telefono']!=""){
		$telephone = $_POST['telefono'];
	}else{
		$telephone = "";
	}
	if(isset($_POST['nacionalidad']) and $_POST['nacionalidad']!=""){
		$nationality = strtolower($_POST['nacionalidad']);
	}else{
		$nationality = "";
	}
	if(isset($_POST['date_start']) and $_POST['date_start']!=""){
		$date_start = convertDate($_POST['date_start'],"en");
	}else{
		$error .= "<p>Fecha entrada incorrecta.</p>";
	}
	if(isset($_POST['date_end']) and $_POST['date_end']!=""){
		$date_end = convertDate($_POST['date_end'],"en");
	}else{
		$error .= "<p>Fecha salida incorrecta.</p>";
	}
	if(isset($_POST['apartamento']) and $_POST['apartamento']!=""){
		$appartment = $_POST['apartamento'];
		$selected = $appartment;
	}else{
		$error .= "<p>Apartamento incorrecto.</p>";
	}
	if(isset($_POST['num_pers']) and $_POST['num_pers']!=""){
		$num_pers = $_POST['num_pers'];
		$selected2 = $num_pers;
	}else{
		$error .= "<p>N&uacute;mero de personas incorrecto.</p>";
	}

	if($error == ""){
		$overlapedAppartments = overlapedDates($date_start,$date_end,$appartment);
		if(validDates($date_start, $date_end)){
			if($overlapedAppartments['status']){
				$error = "<p>El apartamento seleccionado est&aacute; ocupado por esas fechas.</p>";
				$error .= "<p>Puede consultar la disponibilidad en el apartado 'Disponibilidad' del menu.</p>";
			}else{
				$prices = calculatePrice($date_start, $date_end, $num_pers,"../backoffice/precios.php");
				$price = $prices['price'];
				$deposit = $prices['deposit'];
				$pre_rental = new pre_rental($name, $email, $telephone, $nationality, $date_start, $date_end, $appartment, $num_pers, $price, $deposit, $language);
				$id_pre_rental = $pre_rental->insert();
				header("location: pre_reserva_guardada.php?id_pre_rental=".$id_pre_rental);
			}
		}else{
			$error = "Fechas incorrectas";
		}
	}
}
$appartments = new appartment();
$arrayAppartment = $appartments->getArrayAppartment();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<meta name="description" content="description">
	<meta name="keywords" content="keywords">
	<meta name="author" content="author">
	<link rel="stylesheet" type="text/css" href="../default.css" media="screen">
	<link rel="stylesheet" type="text/css" media="all" href="../backoffice/jscalendar/calendar-green.css" title="win2k-cold-1" />
	<script type="text/javascript" src="../backoffice/jscalendar/calendar.js"></script>
	<script type="text/javascript" src="../backoffice/jscalendar/lang/calendar-es.js"></script>
	<script type="text/javascript" src="../backoffice/jscalendar/calendar-setup.js"></script>

	<title>LunaDeSevilla - Petici&oacute;n de reserva</title>
</head>
<body>

<div class="container">

	<div class="main">

		<?php include("header.php"); ?>

		<div class="content">
			<div class="item">
				<h1>Petici&oacute;n de reserva</h1>
				<table>
					<tr><td>
						Para alquilar alguno de nuestro apartamentos rellene el formulario de petici&oacute;n de reserva
						 que se encuentra a continuaci&oacute;n.<br/><br/>
						Recibir&aacute; inmediatamente un email para que active su reserva y podamos comenzar a tramitarla.<br/><br/>
						Una vez aceptada su petici&oacute;n tendr&aacute; un plazo de 48h para realizar el pago de la fianza.<br/><br/>
						Todos los datos acerca de la forma de pago le ser&aacute;n comunicados mediante correo electr&oacute;nico.<br/><br/>
						Si tiene alguna cuesti&oacute;n no dude en contactar con nosotros.
					</td></tr>
				</table>
			</div>
			<div class="item">

				<h1>Formulario de petici&oacute;n de reserva</h1>
				<br/>
				<form name="form1" method="post" action="peticion_pre_reserva.php">
					<input type="hidden" name="action" value="proceed"/>
			        <table summary="Formulario para la inserci&oacute;n de un nuevo alquiler">
			        <tbody>
			        <tr>
			            <td>Nombre: </td><td><input type="text" name="nombre" value="<?php echo $name;?>"/> (*)</td>
			        </tr>
			        <tr>
			            <td>Email: </td><td><input type="text" name="email" value="<?php echo $email;?>"/> (*)</td>
			        </tr>
			        <tr>
			            <td>Tel&eacute;fono: </td><td><input type="text" name="telefono" value="<?php echo $telephone;?>"/></td>
			        </tr>
			        <tr>
			            <td>Nacionalidad: </td><td><input type="text" name="nacionalidad" value="<?php echo $nationality;?>"/></td>
			        </tr>
			        <tr>
			            <td>Fecha de entrada: </td><td><input type="text" id="campo_fecha" name="date_start" size="15" maxlength="10" value="<?php echo convertDate($date_start,"es");?>"/><input type="button" id="lanzador" value="..." /> (*)</td>
			        </tr>
			        <tr>
			            <td>Fecha de salida: </td><td><input type="text" id="campo_fecha2" name="date_end" size="15" maxlength="10" value="<?php echo convertDate($date_end,"es");?>"/><input type="button" id="lanzador2" value="..." /> (*)</td>
			        </tr>
			        <tr>
			            <td>Apartamento: </td>
			            <td><select name="apartamento" size="1">
					    		<option value="" selected="selected">Seleccione un apartamento ...</option>
								<?php
									for($i=0;$i<count($arrayAppartment);$i++){
										echo "<option value='".$arrayAppartment[$i]."' ";
										if($arrayAppartment[$i] == $selected) echo "selected ";
										echo ">".ucwords($arrayAppartment[$i])."</option>";
									}
								?>
							</select> (*)
						</td>
			        </tr>
			        <tr>
			            <td>N&uacute;mero de personas: </td>
			            <td><select name="num_pers" size="1">
					    		<option value="" selected="selected">Seleccione una cantidad ...</option>
								<?php
									for($i=1;$i<=4;$i++){
										echo "<option value='".$i."'";
										if($i == $selected2) echo " selected ";
										echo ">".$i."</option>\n";
									}
								?>
							</select> (*)</td>
			        </tr>
			        <tr>
			            <td colspan="2" align="center"><input type="image" src="../backoffice/images/continuar.jpg" alt=""/></td>
			        </tr>
				    </tbody></table>
				</form>
				<script type="text/javascript">
				   Calendar.setup({
				    inputField : "campo_fecha",
				    ifFormat : "%d/%m/%Y",
				    button : "lanzador" });

				  Calendar.setup({
					inputField		:	"campo_fecha2",
					ifFormat		:	"%d/%m/%Y",
					button			:	"lanzador2"});
				</script>
				<br>
				<div class="descr">rellene todos los campos marcados con (*)</div>

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

	<?php
		if($error != ""){
	?>
		<div class="error" id="divError" style="display: block">
			<table width="400px" height="300px" summary="errores">
				<tr align="right" height="4px"><td><a href="#" onclick="javascript:getElementById('divError').style.display = 'none';"><img src="../backoffice/images/delete.gif" border="0"></a></td></tr>
				<tr valign="top">
					<td>
						<font color="black" align="center"><b>Se han detectado los siguientes errores:<br/><br/>
						<?php echo $error;?></b></font>
					</td>
				</tr>
			</table>
		</div>
	<?php
		}
	?>
</body>
</html>
