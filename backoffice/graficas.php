<?php
/*
 * Created on 15/04/2008
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
	$msgError = "";

	 $f_anyo = fopen("rentalCalendar/lastYear.txt","r");
 	$lastYear = fgets($f_anyo);
 	fclose($f_anyo);

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

	<script language="JavaScript" type="text/javascript">

  		var focus;
		var meses_chks = false;
		var anyos_chks = false;

  		function init(){
			focus  = "meses";
			document.getElementById('chk1').checked = true;
			document.getElementById('meses').checked = true;
			document.getElementById('general').checked = true;
			for(var i=2004;i<=<?php echo $lastYear;?>;i++)
				document.getElementById('anyos_'+i).disabled = true;
  		}

  		function activate(chk){
  			switch(chk){
  				case "ocupacion":
					focus  = "meses";
					document.getElementById('meses').disabled = false;
					document.getElementById('mes_anyo').disabled = false;
					document.getElementById('anyos').disabled = false;
					document.getElementById('meses').checked = true;
					for(var i=0;i<12;i++)
						document.getElementById('mes_'+i).disabled = false;
					for(var i=2004;i<=<?php echo $lastYear;?>;i++)
						document.getElementById('anyos_'+i).disabled = true;
  				break;

  				case "ingresos":
					focus  = "ingresos";
					document.getElementById('meses').disabled = true;
					document.getElementById('mes_anyo').disabled = true;
					document.getElementById('anyos').disabled = true;
					for(var i=0;i<12;i++)
						document.getElementById('mes_'+i).disabled = true;
					for(var i=2004;i<=<?php echo $lastYear;?>;i++)
						document.getElementById('anyos_'+i).disabled = true;
  				break;

  				case "meses":
					focus  = "meses";
					document.getElementById('mes_anyo').disabled = false;
					for(var i=0;i<12;i++)
						document.getElementById('mes_'+i).disabled = false;
					for(var i=2004;i<=<?php echo $lastYear;?>;i++)
						document.getElementById('anyos_'+i).disabled = true;
  				break;

  				case "anyos":
  					focus  = "anyos";
					document.getElementById('mes_anyo').disabled = true;
  					for(var i=2004;i<=<?php echo $lastYear;?>;i++)
						document.getElementById('anyos_'+i).disabled = false;
					for(var i=0;i<12;i++)
						document.getElementById('mes_'+i).disabled = true;
  				break;

				case "todos_meses":
					if(meses_chks && focus=='meses'){
						meses_chks = false;
						for(var i=0;i<12;i++)
							document.getElementById('mes_'+i).checked = false;
					}else if(!meses_chks && focus=='meses'){
						meses_chks = true;
						for(var i=0;i<12;i++)
							document.getElementById('mes_'+i).checked = true;
					}
				break;

				case "todos_anyos":
					if(anyos_chks && focus=='anyos'){
	  					anyos_chks = false;
	  					for(var i=2004;i<=<?php echo $lastYear;?>;i++)
							document.getElementById('anyos_'+i).checked = false;
					}else if(!anyos_chks && focus=='anyos'){
						anyos_chks = true;
						for(var i=2004;i<=<?php echo $lastYear;?>;i++)
							document.getElementById('anyos_'+i).checked = true;
					}
				break;

				case "general":
					document.getElementById('bajo').checked = false;
					document.getElementById('primero').checked = false;
					document.getElementById('segundo').checked = false;
				break;

				case "piso":
					document.getElementById('general').checked = false;
				break;
  			}
  		}
	</script>


</head>
<body onLoad="javascript:init();">

<div class="container">

	<div class="main">

		<div class="header">

			<div class="title">
				<h1>Gesti&oacute;n LunaDeSevilla</h1>
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

				<h1>Generaci&oacute;n de gr&aacute;ficas</h1>

				<form target="_blank" method="get" action="tratamientoGraficas.php">

					<table cellspacing="15">
						<tr><td colspan="4">Seleccione una o varias opciones:</td></tr>
						<tr>
							<td><input type="checkbox" id="general" name="general" onclick="javascript:activate('general');"/>&nbsp;General</td>
							<td><input type="checkbox" id="bajo" name="bajo" onclick="javascript:activate('piso');"/>&nbsp;Bajo</td>
							<td><input type="checkbox" id="primero" name="primero" onclick="javascript:activate('piso');"/>&nbsp;Primero</td>
							<td><input type="checkbox" id="segundo" name="segundo" onclick="javascript:activate('piso');"/>&nbsp;Segundo</td>
						</tr>
					</table>

					<table cellspacing="15">
						<tr><td colspan="5">
								<input type="radio" id="chk1" name="chk1" value="ocupacion" onclick="javascript:activate('ocupacion');">&nbsp;Ocupaci&oacute;n
							</td>
						</tr>
						<tr><td>&nbsp;</td><td colspan="2">
								<input type="radio" id="meses" name="chk2" value="mes" onclick="javascript:activate('meses');">&nbsp;Meses
								 (<a href="#" onclick="javascript:activate('todos_meses');">Todos</a>)
							</td>
							<td>
								<select name="mes_anyo" id="mes_anyo">
									<?php
									for($i=2004;$i<=$lastYear;$i++){
										echo "<option value='".$i."'>". $i."&nbsp;</option>";
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
							<td><input type="checkbox" id="mes_0" name="enero"/>&nbsp;Enero</td>
							<td><input type="checkbox" id="mes_1" name="febrero"/>&nbsp;Febrero</td>
							<td><input type="checkbox" id="mes_2" name="marzo"/>&nbsp;Marzo</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
							<td><input type="checkbox" id="mes_3" name="abril"/>&nbsp;Abril</td>
							<td><input type="checkbox" id="mes_4" name="mayo"/>&nbsp;Mayo</td>
							<td><input type="checkbox" id="mes_5" name="junio"/>&nbsp;Junio</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
							<td><input type="checkbox" id="mes_6" name="julio"/>&nbsp;Julio</td>
							<td><input type="checkbox" id="mes_7" name="agosto"/>&nbsp;Agosto</td>
							<td><input type="checkbox" id="mes_8" name="septiembre"/>&nbsp;Septiembre</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
							<td><input type="checkbox" id="mes_9" name="octubre"/>&nbsp;Octubre</td>
							<td><input type="checkbox" id="mes_10" name="noviembre"/>&nbsp;Noviembre</td>
							<td><input type="checkbox" id="mes_11" name="diciembre"/>&nbsp;Diciembre</td>
						</tr>

						<tr><td>&nbsp;</td><td colspan="4">
								<input type="radio" id="anyos" name="chk2" value="anyos" onclick="javascript:activate('anyos');">&nbsp;A&ntilde;os
								(<a href="#" onclick="javascript:activate('todos_anyos');">Todos</a>)
							</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
							<td><input type="checkbox" id="anyos_2004" name="2004"/>&nbsp;2004</td>
							<td><input type="checkbox" id="anyos_2005" name="2005"/>&nbsp;2005</td>
							<td><input type="checkbox" id="anyos_2006" name="2006"/>&nbsp;2006</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
							<td><input type="checkbox" id="anyos_2007" name="2007"/>&nbsp;2007</td>
							<td><input type="checkbox" id="anyos_2008" name="2008"/>&nbsp;2008</td>
						</tr>
						<tr>
							<td colspan="4">
								<input type="radio" id="chk2" name="chk1" value="ingresos" onclick="javascript:activate('ingresos');">&nbsp;Ingresos
							</td>
						</tr>
					</table>

					<table>
						<tr>
							<td><input type="submit" value="Crear Gr&aacute;fico"/></td>
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
		if($msgError != ""){
	?>
	<div class="error" id="divError" style="display: block">
		<table width="400px" height="300px" summary="errores">
			<tr align="right" height="4px"><td><a href="#" onclick="javascript:getElementById('divError').style.display = 'none';"><img src="images/delete.gif" border="0"></a></td></tr>
			<tr valign="top">
				<td>
					<font color="black"><b><?php echo $msgError;?></b></font>
				</td>
			</tr>
		</table>
	</div>
	<?php
		}
	?>

</body></html>