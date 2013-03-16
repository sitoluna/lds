<?php
/*
 * Created on 22/10/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

	session_start();
	if(!isset($_SESSION["autorizado"]) || $_SESSION["autorizado"]!="SI"){
		header("Location: index.php");
	}
	include("classes/appartment.class.php");
	include("classes/connectionMySQL.class.php");
	include("functions/functions.php");
	include("classes/pre_rental.class.php");

	$array_months = array("Enero","Febrero","Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	$resultSearch = "";
	$errors = "";

	if(isset($_GET['err']) and $_GET['err']!=""){
				$errors = "  ( Ha de seleccionar el mes y el a&ntilde;o ... ) ";
	}

	if(isset($_POST['mes_gen']) and $_POST['mes_gen']!="")
		$mes_gen = $_POST['mes_gen'];
	else
		$mes_gen = "";

	if(isset($_POST['anyo_gen']) and $_POST['anyo_gen']!="")
		$anyo_gen = $_POST['anyo_gen'];
	else
		$anyo_gen = "";

	if(isset($_POST['appartment']) and $_POST['appartment']!="")
		$piso = $_POST['appartment'];
	else
		$piso = "";

	if(isset($_POST['action']) and $_POST['action'] == "proceed"){
		$connectionMySQL = new connectionMySQL();
		$resultSearch = "";
		if(isset($_POST['mes_gen']) and ($_POST['mes_gen']=="" or $_POST['anyo_gen']=="")){
			header("location:busquedaAlquiler.php?err=gen");
		}else{
			if(isset($_POST['appartment']) and $_POST['appartment']!="")
				$andAppartment = " and appartment='".$_POST['appartment']."' ";
			else
				$andAppartment = "";
			$query = "select * from client c, rental r where c.id = r.id_client ".$andAppartment." order by appartment, date_start";
			$result = $connectionMySQL->request($query);

			while($row = mysql_fetch_array($result)){
				$month_start = date("m",strtotime($row['date_start']));
				$month_end = date("m",strtotime($row['date_end']));
				$year_start = date("Y",strtotime($row['date_start']));
				$year_end = date("Y",strtotime($row['date_end']));
				if($year_end < $_POST['anyo_gen'] or $year_start > $_POST['anyo_gen'] or ($year_end == $_POST['anyo_gen'] and $month_end < $_POST['mes_gen']) or ($year_start == $_POST['anyo_gen'] and $month_start > $_POST['mes_gen']) ){
					//no hacemos nada
				}else{
					$resultSearch .= "<tr><td><a href='fichaCliente.php?id=".$row['id']."'>".ucwords($row['name'])."</a></td><td>".ucfirst($row['appartment'])."</td><td>".convertDate($row['date_start'],'es')."</td><td>".convertDate($row['date_end'],'es')."</td></tr>";
				}
			}
			if($resultSearch == "")
				$resultSearch = "<tr><td>No se han encontrado coincidencias.</td></tr>";
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
	<title>B&uacute;squeda de alquiler</title>

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

				<h1>B&uacute;squeda de alquiler</h1>

				<br>

					<form name="busquedaAlquiler" method="post" action="busquedaAlquiler.php">
					<input type="hidden" name="action" value="proceed"/>
						<table summary="busqueda de alquiler">
							<tr>
								<td>Mes y a&ntilde;o del alquiler: </td>
								<td>
									<select name="mes_gen">
										<option value="" <?php if($mes_gen == "") echo "selected='selected'";?>>Seleccione un mes ...</option>
										<?php
											for($i=0;$i<count($array_months);$i++){
												echo "<option value='".($i+1)."' ";
												if($mes_gen == ($i+1)) echo "selected='selected'";
												echo ">".$array_months[$i]."</option>\n";
											}
										?>
									</select>
								</td>
								<td>
									<select name="anyo_gen">
										<option value="" <?php if($anyo_gen == "") echo "selected='selected'";?>>Seleccione un a&ntilde;o ...</option>
										<?php
											for($i=2001;$i<2051;$i++){
												echo "<option value='".$i."' ";
												if($anyo_gen == $i) echo "selected='selected'";
												echo "> ".$i." </option>\n";
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>Apartamento</td>
								<td colspan="2">
									<select name="appartment">
										<option value="" <?php if($piso == "") echo "selected='selected'";?>>Seleccione un apartamento ...</option>
										<?php
											$appartment = new appartment();
											$arrayAppartment = $appartment->getArrayAppartment();
											for($i=0;$i<count($arrayAppartment);$i++){
												echo "<option value='".$arrayAppartment[$i]."' ";
												if($piso == $arrayAppartment[$i]) echo "selected='selected'";
												echo ">".ucwords($arrayAppartment[$i])."</option>";
											 }
										 ?>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="3"><input type="submit" value="" class="button"></td>
							</tr>
						</table>
					</form>

				<br>

			</div>

			<div class="item">

				<h1>Resultado</h1>

				<br>

				<table>
					<?php echo $resultSearch;?>
				</table>

				<br>

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
