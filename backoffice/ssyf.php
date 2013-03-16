<?php
session_start();
if(!isset($_SESSION["autorizado"]) or $_SESSION["autorizado"] != "SI"){
	header("Location: index.php");
}
include ("functions/functions.php");
include ("classes/connectionMySQL.class.php");
include("classes/pre_rental.class.php");

$connectionMySQL = new connectionMySQL();
$msg = "";
if(isset($_GET['msg']) and $_GET['msg'] != ""){
	$msg = "<font color='red'><b><i>Nuevas Fechas insertadas</i></b></font>";
}
if(isset($_POST['action']) and $_POST['action']!=""){
	$connectionMySQL = new connectionMySQL();
	$errors = "";
	switch($_POST['action']){
		case "insert":
			if(isset($_POST['year']) and !empty($_POST['year'])){
				$year = $_POST['year'];
			}else{
				$errors = "A&ntilde;o<br/>";
			}
			//Fechas de la semana santa
			if(isset($_POST['dssi']) and !empty($_POST['dssi'])){
				$dssi = $_POST['dssi'];
			}else{
				$errors = "Dia inicio semana santa<br/>";
			}
			if(isset($_POST['mssi']) and !empty($_POST['mssi'])){
				$mssi = $_POST['mssi'];
			}else{
				$errors = "Mes inicio semana santa<br/>";
			}
			if(isset($_POST['dssf']) and !empty($_POST['dssf'])){
				$dssf = $_POST['dssf'];
			}else{
				$errors = "Dia fin semana santa<br/>";
			}
			if(isset($_POST['mssf']) and !empty($_POST['mssf'])){
				$mssf = $_POST['mssf'];
			}else{
				$errors = "Mes fin semana santa<br/>";
			}
			//Fechas de la feria
			if(isset($_POST['dfi']) and !empty($_POST['dfi'])){
				$dfi = $_POST['dfi'];
			}else{
				$errors = "Dia inicio feria<br/>";
			}
			if(isset($_POST['mfi']) and !empty($_POST['mfi'])){
				$mfi = $_POST['mfi'];
			}else{
				$errors = "Mes inicio feria<br/>";
			}
			if(isset($_POST['dff']) and !empty($_POST['dff'])){
				$dff = $_POST['dff'];
			}else{
				$errors = "Dia fin feria<br/>";
			}
			if(isset($_POST['mff']) and !empty($_POST['mff'])){
				$mff = $_POST['mff'];
			}else{
				$errors = "Mes fin feria<br/>";
			}

			$date_start_ss = $year."-".$mssi."-".$dssi;
			$date_end_ss = $year."-".$mssf."-".$dssf;

			$date_start_f = $year."-".$mfi."-".$dfi;
			$date_end_f = $year."-".$mff."-".$dff;

			if(!validDates($date_start_ss,$date_end_ss) or !validDates($date_start_f,$date_end_f)){
				$errors .= "Fechas invalidas<br/>";
			}

			if($errors == ""){
				$query_check_year = "select * from ssyf where year = '".$year."'";
				$result = $connectionMySQL->request($query_check_year);
				if(mysql_num_rows($result) == 0){
					$query_insert = "insert into ssyf (" .
									"year" .
									", date_start_ss" .
									", date_end_ss" .
									", date_start_f" .
									", date_end_f)" .
									" values (" .
									"'".$year."'" .
									",'".$date_start_ss."'" .
									",'".$date_end_ss."'" .
									",'".$date_start_f."'" .
									",'".$date_end_f."')";
					$connectionMySQL->request($query_insert);
					header("location: ssyf.php?msg=newInsert");
				}else{
					$errors = "Ese a&ntilde;o ya posee fechas de Semana Santa y Feria.";
				}
			}
		break;

		case "delete":
			$query_delete = "delete from ssyf where year = '".$_POST['year']."'";
			$connectionMySQL->request($query_delete);
			$msg = "<font color='red'><b><i>Fechas eliminadas</i></b></font>";
		break;
	}
}


$query = "select * from ssyf where year >= '".date("Y",time())."' order by year asc";
$result = $connectionMySQL->request($query);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<meta name="description" content="description">
	<meta name="keywords" content="keywords">
	<meta name="author" content="author">
	<link rel="stylesheet" type="text/css" href="../default.css" media="screen">
	<title>Fechas de Semana Santa y Feria de Sevilla</title>


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
					<td width="*">&nbsp;<?php if($msg != "") echo " ( ".$msg." ) "; ?></td>
					<td align="right" width="90px">[<a href="index.php">Desconectarme</a>]</td>
				</tr>
			</table>
		</div>

		<div class="content">

			<div class="item">

				<h1>Fechas de Semana Santa y Feria de Sevilla</h1>

				<?php
					if(mysql_num_rows($result) > 0){
						echo "<table>" .
								"<tr style='background: #EEEEEE'>" .
								"	<td>A&Ntilde;O</td>" .
								"	<td>Inicio S.S.</td>" .
								"	<td>Fin S.S.</td>" .
								"	<td>Inicio Feria</td>" .
								"	<td>Fin Feria</td>" .
								"	<td>&nbsp;</td>" .
								"</tr>";
						while($row = mysql_fetch_array($result)){
							echo "<tr style='background: #EEEEEE'>" .
									"<td>".$row['year']."</td>" .
									"<td>".date('d/m',strtotime($row['date_start_ss']))."</td>" .
									"<td>".date('d/m',strtotime($row['date_end_ss']))."</td>" .
									"<td>".date('d/m',strtotime($row['date_start_f']))."</td>" .
									"<td>".date('d/m',strtotime($row['date_end_f']))."</td>" .
									"<td>" .
										"<form action='ssyf.php' method='post'>" .
											"<input type='hidden' name='action' value='delete'/>" .
											"<input type='hidden' name='year' value='".$row['year']."'/>" .
											"<input type='image' src='images/eliminar.jpg' onClick='javascript:return confirm(\"&iquest;Est&aacute; seguro de que desea eliminar estas fechas?\");'>" .
										"</form>" .
									"</td>" .
								"</tr>";
						}
						echo "</table>";
					}else{
						echo "No se encontraron datos";
					}
				?>

			</div>

			<div class="item">

				<h1>Insertar nuevas fechas</h1>
				<form method="post" action="ssyf.php">
				<input type="hidden" name="action" value="insert"/>
				<table>
					<tr>
						<td>A&ntilde;o: </td><td colspan="5"><input type="text" size="5" name="year"/></td>
					</tr>
					<tr>
						<td>Fiestas</td>
						<td>Dia inicio</td>
						<td>Mes inicio</td>
						<td>&nbsp;</td>
						<td>Dia fin</td>
						<td>Mes fin</td>
					</tr>
					<tr>
						<td>Semana Santa</td>
						<td><input type="text" size="3" name="dssi"/></td>
						<td><input type="text" size="3" name="mssi"/></td>
						<td> - </td>
						<td><input type="text" size="3" name="dssf"/></td>
						<td><input type="text" size="3" name="mssf"/></td>
					</tr>
					<tr>
						<td>Feria</td>
						<td><input type="text" size="3" name="dfi"/></td>
						<td><input type="text" size="3" name="mfi"/></td>
						<td> - </td>
						<td><input type="text" size="3" name="dff"/></td>
						<td><input type="text" size="3" name="mff"/></td>
					</tr>
					<tr>
						<td colspan="6">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="6"><input type="submit" value="Aceptar"/></td>
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
		if(isset($errors) and $errors != "")
			include("error.php");
	?>
</body>
</html>
