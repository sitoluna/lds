<?php
session_start();
if(!isset($_SESSION["autorizado"]) or $_SESSION["autorizado"] != "SI"){
	header("Location: index.php");
}
include("classes/connectionMySQL.class.php");
include("functions/functions.php");
include("classes/rental.class.php");
include("classes/client.class.php");
include("classes/appartment.class.php");
include("classes/pre_rental.class.php");

$rental = new rental();
$formularioEnviado = false;
$appartment = "";
$num_pers = "";
$time_entry = "08:00";
$time_exit = "08:00";
$errors = "";

if(isset($_POST['action']) and $_POST['action'] == "modify"){

	if(isset($_POST['id_client']) and $_POST['id_client'] != ""){
		$id_client = $_POST['id_client'];
	}else{
		$id_client = "";
		$errors .= "<p>Id Cliente</p>";
	}

	if(isset($_POST['id_rental']) and $_POST['id_rental'] != ""){
		$id_rental = $_POST['id_rental'];
	}else{
		$id_rental = "";
		$errors .= "<p>Id Alquiler</p>";
	}

	$formularioEnviado = true;

	if(isset($_POST['date_start']) and $_POST['date_start'] != ""){
		$date_start = $_POST['date_start'];
	}else{
		$date_start = "";
		$errors .= "<p>Fecha de Entrada</p>";
	}

	if(isset($_POST['date_end']) and $_POST['date_end'] != ""){
		$date_end = $_POST['date_end'];
	}else{
		$date_end = "";
		$errors .= "<p>Fecha de Salida</p>";
	}

	if(!validDates(convertDate($date_start,"en"), convertDate($date_end,"en"), true)){
		$errors .= "<p>Las fechas de Entrada y Salida no son correctas</p>";
	}

	if(isset($_POST['appartment']) and $_POST['appartment'] != ""){
		$appartment = strtolower($_POST['appartment']);
	}else{
		$appartment = "";
		$errors .= "<p>Apartamento</p>";
	}

	if(isset($_POST['num_pers']) and $_POST['num_pers'] != ""){
		$num_pers = $_POST['num_pers'];
	}else{
		$num_pers = "";
		$errors .= "<p>N&uacute;mero de personas</p>";
	}

	if(isset($_POST['time_entry']) and $_POST['time_entry'] != ""){
		$time_entry = $_POST['time_entry'];
	}else{
		$time_entry = "";
		$errors .= "<p>Hora de entrada</p>";
	}

	if(isset($_POST['time_exit']) and $_POST['time_exit'] != ""){
		$time_exit = $_POST['time_exit'];
	}else{
		$time_exit = "";
		$errors .= "<p>Hora de salida</p>";
	}

	if(isset($_POST['deposit']) and $_POST['deposit'] != ""){
		$deposit = $_POST['deposit'];
	}else{
		$deposit = "";
	}

	if(isset($_POST['price']) and $_POST['price'] != ""){
		$price = $_POST['price'];
	}else{
		$price = "";
		$errors .= "<p>Precio</p>";
	}

	if(isset($_POST['comments']) and $_POST['comments'] != ""){
		$comments = $_POST['comments'];
	}else{
		$comments = null;
	}

	if(isset($_POST['electricity_start']) and $_POST['electricity_start'] != ""){
		$electricity_start = $_POST['electricity_start'];
	}else{
		$electricity_start = null;
	}

	if(isset($_POST['electricity_end']) and $_POST['electricity_end'] != ""){
		$electricity_end = $_POST['electricity_end'];
	}else{
		$electricity_end = null;
	}

	if(isset($_POST['water_start']) and $_POST['water_start'] != ""){
		$water_start = $_POST['water_start'];
	}else{
		$water_start = null;
	}

	if(isset($_POST['water_end']) and $_POST['water_end'] != ""){
		$water_end = $_POST['water_end'];
	}else{
		$water_end = null;
	}


	if($errors == ""){
		$overlaped = overlapedDates(convertDate($date_start,"en"),convertDate($date_end,"en"), $appartment, $id_client, $id_rental);
		$arrayOverlapedDatesPR = overlapedDatesPR(convertDate($date_start,"en"), convertDate($date_end,"en"), $appartment);
		if(!($overlaped["status"])){
			if(!($arrayOverlapedDatesPR["status"])){
				$date_start = convertDate($date_start,"en");
				$date_end = convertDate($date_end,"en");
				$rental = new rental($id_client,$id_rental,$date_start,$date_end,$appartment,$num_pers,$time_entry,$time_exit,$deposit,$price,$comments,$electricity_start,$electricity_end,$water_start,$water_end);
				$rental->modify();
				header("location: fichaCliente.php?id=".$id_client."&msg=newRentalModified");
			}else{
				$overlapedErrors = $arrayOverlapedDatesPR["errors"];
			}
		}else{
			$overlapedErrors = $overlaped["errors"];
		}
	}
}else if(isset($_GET['action']) and $_GET['action'] == "delete"){
	if(isset($_GET['id_client']) and $_GET['id_client'] != ""){
		$id_client = $_GET['id_client'];
	}else{
		$id_client = "";
		$errors .= "<p>Id Cliente</p>";
	}

	if(isset($_GET['id_rental']) and $_GET['id_rental'] != ""){
		$id_rental = $_GET['id_rental'];
	}else{
		$id_rental = "";
		$errors .= "<p>Id Alquiler</p>";
	}
	if($errors != ""){
		header("location: error.php?id_error=101");
	}else{
		$rental = new rental($id_client, $id_rental);
		$rental->delete();
		header("location: fichaCliente.php?id=".$id_client."&msg=newRentalDeleted");
	}
}
if(!isset($id_client)){
	$id_client = $_GET['id_client'];
	$id_rental = $_GET['id_rental'];
}

if(!$formularioEnviado){

	$rental->getRental($id_client,$id_rental);
	$date_start = convertDate($rental->date_start,"es");
	$date_end = convertDate($rental->date_end,"es");
	$appartment = strtolower($rental->appartment);
	$num_pers = $rental->num_pers;
	$time_entry = $rental->time_entry;
	$time_exit = $rental->time_exit;
	$deposit = $rental->deposit;
	$price = $rental->price;
	$comments = $rental->comments;
	$electricity_start = $rental->electricity_start;
	$electricity_end = $rental->electricity_end;
	$water_start = $rental->water_start;
	$water_end = $rental->water_end;
}
$client = new client();
$client->getClient($id_client);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<meta name="description" content="description">
	<meta name="keywords" content="keywords">
	<meta name="author" content="author">
	<link rel="stylesheet" type="text/css" href="../default.css" media="screen">
	<title>Modificar alquiler</title>


	<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-green.css" title="win2k-cold-1" />
	<script type="text/javascript" src="jscalendar/calendar.js"></script>
	<script type="text/javascript" src="jscalendar/lang/calendar-es.js"></script>
	<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
	<script type="text/javascript" src="functions/funciones.js"></script>
	<script type="text/javascript">
		function changeOrder(){
			calcularPrecio();
			return false;
		}
	</script>
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
				<h1>Modificar alquiler de <?php echo ucwords($client->name); ?></h1>
				<br/>
				<br>
				<form action="modificarAlquiler.php" method="post" name="form01" id="form01">
					<input type="hidden" name="action" value="modify"/>
					<input type="hidden" name="id_client" value="<?php echo $id_client?>"/>
					<input type="hidden" name="id_rental" value="<?php echo $id_rental?>" />
			        <table summary="Formulario para la modificaci&oacute;n de un alquiler">
			        <tbody><tr>
			            <td>Fecha de entrada: </td><td><input type="text" id="campo_fecha" name="date_start" size="15" maxlength="10" value="<?php echo $date_start;?>"/><input type="button" id="lanzador" value="..." /> (*)</td>
			        </tr>
			        <tr>
			            <td>Fecha de salida: </td><td><input type="text" id="campo_fecha2" name="date_end" size="15" maxlength="10" value="<?php echo $date_end;?>"/><input type="button" id="lanzador2" value="..." /> (*)</td>
			        </tr>
			        <tr>
			            <td>Apartamento: </td>
			            <td><select name="appartment" size="1">
				    			<option value="" <?php if($appartment == "") echo "selected";?>>Seleccione un apartamento ...</option>
								<?php
									$appartments = new appartment();
									$arrayAppartment = $appartments->getArrayAppartment();
									for($i=0;$i<count($arrayAppartment);$i++){
										echo "<option value='".$arrayAppartment[$i]."'";
										if($arrayAppartment[$i] == $appartment) echo " selected ";
										echo ">".ucwords($arrayAppartment[$i])."</option>";
									}
								?>
							</select> (*)
						</td>
			        </tr>
			        <tr>
			            <td>N&uacute;mero de personas: </td>
			            <td><select name="num_pers" id="num_pers" size="1">
					    		<option value="" selected>Seleccione una cantidad ...</option>
								<?php
								for($i=1;$i<=4;$i++){
									echo "<option value='".$i."'";
									if($i == $num_pers) echo " selected ";
									echo ">".$i."</option>\n";
								}
								?>
							</select> (*)
						</td>
			        </tr>
			        <tr>
			            <td>Fianza: </td><td><input type="text" id="deposit" name="deposit" size="10" maxlength="4" value="<?php echo $deposit?>"/></td>
			        </tr>
			        <tr>
			            <td>Precio total: </td><td><input type="text" id="price" name="price" size="10" maxlength="5" value="<?php echo $price?>"/>(*)<a href="#"><input type="image" src="images/calcular.jpg" onclick="javascript:return changeOrder()" /></a></td>
			        </tr>
			        <tr>
			            <td>Hora de entrada: </td>
			            <td><select name="time_entry" id="time_entry" size="1">
					    		<option value="08h00"<?php if($time_entry=="" or $time_entry=="08h00") echo "selected";?>>08h00&nbsp;</option>
					    		<option value="08h30" <?php if($time_entry=="08h30") echo "selected";?>>08h30</option>
					    		<option value="09h00" <?php if($time_entry=="09h00") echo "selected";?>>09h00</option>
					    		<option value="09h30" <?php if($time_entry=="09h30") echo "selected";?>>09h30</option>
					    		<option value="10h00" <?php if($time_entry=="10h00") echo "selected";?>>10h00</option>
					    		<option value="10h30" <?php if($time_entry=="10h30") echo "selected";?>>10h30</option>
					    		<option value="11h00" <?php if($time_entry=="11h00") echo "selected";?>>11h00</option>
					    		<option value="11h30" <?php if($time_entry=="11h30") echo "selected";?>>11h30</option>
					    		<option value="12h00" <?php if($time_entry=="12h00") echo "selected";?>>12h00</option>
					    		<option value="12h30" <?php if($time_entry=="12h30") echo "selected";?>>12h30</option>
					    		<option value="13h00" <?php if($time_entry=="13h00") echo "selected";?>>13h00</option>
					    		<option value="13h30" <?php if($time_entry=="13h30") echo "selected";?>>13h30</option>
					    		<option value="14h00" <?php if($time_entry=="14h00") echo "selected";?>>14h00</option>
					    		<option value="14h30" <?php if($time_entry=="14h30") echo "selected";?>>14h30</option>
					    		<option value="15h00" <?php if($time_entry=="15h00") echo "selected";?>>15h00</option>
					    		<option value="15h30" <?php if($time_entry=="15h30") echo "selected";?>>15h30</option>
					    		<option value="16h00" <?php if($time_entry=="16h00") echo "selected";?>>16h00</option>
					    		<option value="16h30" <?php if($time_entry=="16h30") echo "selected";?>>16h30</option>
					    		<option value="17h00" <?php if($time_entry=="17h00") echo "selected";?>>17h00</option>
					    		<option value="17h30" <?php if($time_entry=="17h30") echo "selected";?>>17h30</option>
					    		<option value="18h00" <?php if($time_entry=="18h00") echo "selected";?>>18h00</option>
					    		<option value="18h30" <?php if($time_entry=="18h30") echo "selected";?>>18h30</option>
					    		<option value="19h00" <?php if($time_entry=="19h00") echo "selected";?>>19h00</option>
					    		<option value="19h30" <?php if($time_entry=="19h30") echo "selected";?>>19h30</option>
					    		<option value="20h00" <?php if($time_entry=="20h00") echo "selected";?>>20h00</option>
					    		<option value="20h30" <?php if($time_entry=="20h30") echo "selected";?>>20h30</option>
					    		<option value="21h00" <?php if($time_entry=="21h00") echo "selected";?>>21h00</option>
					    		<option value="21h30" <?php if($time_entry=="21h30") echo "selected";?>>21h30</option>
					    		<option value="22h00" <?php if($time_entry=="22h00") echo "selected";?>>22h00</option>
					    		<option value="22h30" <?php if($time_entry=="22h30") echo "selected";?>>22h30</option>
					    		<option value="23h00" <?php if($time_entry=="23h00") echo "selected";?>>23h00</option>
					    		<option value="23h30" <?php if($time_entry=="23h30") echo "selected";?>>23h30</option>
							</select>
						</td>
			        </tr>
			        <tr>
			            <td>Hora de salida: </td>
			            <td><select name="time_exit" id="time_exit" size="1">
					    		<option value="08h00" <?php if($time_exit=="" or $time_exit=="08h00") echo "selected";?>>08h00&nbsp;</option>
					    		<option value="08h30" <?php if($time_exit=="08h30") echo "selected";?>>08h30</option>
					    		<option value="09h00" <?php if($time_exit=="09h00") echo "selected";?>>09h00</option>
					    		<option value="09h30" <?php if($time_exit=="09h30") echo "selected";?>>09h30</option>
					    		<option value="10h00" <?php if($time_exit=="10h00") echo "selected";?>>10h00</option>
					    		<option value="10h30" <?php if($time_exit=="10h30") echo "selected";?>>10h30</option>
					    		<option value="11h00" <?php if($time_exit=="11h00") echo "selected";?>>11h00</option>
					    		<option value="11h30" <?php if($time_exit=="11h30") echo "selected";?>>11h30</option>
					    		<option value="12h00" <?php if($time_exit=="12h00") echo "selected";?>>12h00</option>
					    		<option value="12h30" <?php if($time_exit=="12h30") echo "selected";?>>12h30</option>
					    		<option value="13h00" <?php if($time_exit=="13h00") echo "selected";?>>13h00</option>
					    		<option value="13h30" <?php if($time_exit=="13h30") echo "selected";?>>13h30</option>
					    		<option value="14h00" <?php if($time_exit=="14h00") echo "selected";?>>14h00</option>
					    		<option value="14h30" <?php if($time_exit=="14h30") echo "selected";?>>14h30</option>
					    		<option value="15h00" <?php if($time_exit=="15h00") echo "selected";?>>15h00</option>
					    		<option value="15h30" <?php if($time_exit=="15h30") echo "selected";?>>15h30</option>
					    		<option value="16h00" <?php if($time_exit=="16h00") echo "selected";?>>16h00</option>
					    		<option value="16h30" <?php if($time_exit=="16h30") echo "selected";?>>16h30</option>
					    		<option value="17h00" <?php if($time_exit=="17h00") echo "selected";?>>17h00</option>
					    		<option value="17h30" <?php if($time_exit=="17h30") echo "selected";?>>17h30</option>
					    		<option value="18h00" <?php if($time_exit=="18h00") echo "selected";?>>18h00</option>
					    		<option value="18h30" <?php if($time_exit=="18h30") echo "selected";?>>18h30</option>
					    		<option value="19h00" <?php if($time_exit=="19h00") echo "selected";?>>19h00</option>
					    		<option value="19h30" <?php if($time_exit=="19h30") echo "selected";?>>19h30</option>
					    		<option value="20h00" <?php if($time_exit=="20h00") echo "selected";?>>20h00</option>
					    		<option value="20h30" <?php if($time_exit=="20h30") echo "selected";?>>20h30</option>
					    		<option value="21h00" <?php if($time_exit=="21h00") echo "selected";?>>21h00</option>
					    		<option value="21h30" <?php if($time_exit=="21h30") echo "selected";?>>21h30</option>
					    		<option value="22h00" <?php if($time_exit=="22h00") echo "selected";?>>22h00</option>
					    		<option value="22h30" <?php if($time_exit=="22h30") echo "selected";?>>22h30</option>
					    		<option value="23h00" <?php if($time_exit=="23h00") echo "selected";?>>23h00</option>
					    		<option value="23h30" <?php if($time_exit=="23h30") echo "selected";?>>23h30</option>
							</select>
						</td>
			        </tr>
			        <tr>
			            <td>Luz entrada: </td><td><input type="text" id="electricity_start" name="electricity_start" size="20" maxlength="20" value="<?php echo $electricity_start?>"/></td>
			        </tr>
			        <tr>
			            <td>Luz salida: </td><td><input type="text" id="electricity_end" name="electricity_end" size="20" maxlength="20" value="<?php echo $electricity_end?>"/></td>
			        </tr>
			        <tr>
			            <td>Agua entrada: </td><td><input type="text" id="water_start" name="water_start" size="20" maxlength="20" value="<?php echo $water_start?>"/></td></td>
			        </tr>
			        <tr>
			            <td>Agua salida: </td><td><input type="text" id="water_end" name="water_end" size="20" maxlength="20" value="<?php echo $water_end?>"/></td></td>
			        </tr>
			        <tr>
			            <td>Comentarios: </td><td><textarea name="comments" cols="35" rows="5" id="comments"><?php echo $comments?></textarea></td>
			        </tr>
			        <tr>
			            <td colspan="2" align="center"><input value="guardar" type="submit"></td>
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

			<?php include("menuBackOffice.php"); ?>

		</div>

		<div class="clearer"><span></span></div>
		</div>

		<div class="footer">&copy; 2007 <a href="../es/index.php">lunadesevilla.es</a>.Valid <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>&amp; <a href="http://validator.w3.org/check?uri=referer">XHTML</a>.Template design by Alfonso Luna
		</div>

	</div>
	<?php
		if(isset($overlapedErrors) and $overlapedErrors != "")
			$errors .= "<p>Alquiler(es) solapado(s):</p>".$overlapedErrors;

		if($errors != "")
			include("error.php");
	?>
</body></html>
