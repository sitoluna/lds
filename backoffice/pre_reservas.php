<?php
/*
 * Created on 14/11/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

session_start();
if(!isset($_SESSION["autorizado"]) or $_SESSION["autorizado"] != "SI"){
	header("Location: index.php");
}
if(isset($_GET['msg']) and $_GET['msg'] != "")
	$errors =html_entity_decode($_GET['msg']);
else
	$errors = "";
include("classes/connectionMySQL.class.php");
include("classes/pre_rental.class.php");
include("functions/functions.php");

$plazo = (48*60*60);
$pre_rental = new pre_rental();

if(isset($_GET['status']) and $_GET['status']!="")
	$status = $_GET['status'];
else
	$status = 0;

$num_rows = 8;

if(isset($_GET['ini']) and $_GET['ini'] >= $num_rows){
	$ini = $_GET['ini'];
	$next_ini = $ini + $num_rows;
	$prev_ini = $ini - $num_rows;
}else{
	$ini = 0;
	$next_ini = $num_rows;
	$prev_ini = 0;
}

$arrayPreRental = $pre_rental->getArrayPreRental($status,$ini,$num_rows);
$msg = "";
if(count($arrayPreRental)==0){
	switch($status){
		case "0":
			$msg = "No hay ninguna petici&oacute;n de pre-reserva";
		break;
		case "1":
			$msg = "No hay ninguna pre-reserva en espera de ingreso";
		break;
		case "2":
			$msg = "No hay ninguna pre-reserva con ingreso hecho";
		break;
		case "3":
		case "4":
			$msg = "No hay ninguna pre-reserva que haya sido cancelada o anulada";
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
	<title>Gesti&oacute;n de pre-reservas</title>

	<script language="JavaScript" type="text/javascript">
	  	function onOffDiv(i){
	  		estado = document.getElementById('mas_info'+i).style.display;
	  		if(estado == "none"){
	  			document.getElementById('mas_info'+i).style.display = "block";
	  		}else{
	  			document.getElementById('mas_info'+i).style.display = "none";
	  		}
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
				<h1>Gesti&oacute;n de pre-reservas</h1>
				<table width="100%" summary="menu de pre-reservas">
					<tr align="center" style="background: url(images/bgul.gif) repeat-x;border: 1px solid #FAFAFA;">
						<td width="25%" <?php if($status == 0) echo "id='optSelected'";?>>
							<a href="pre_reservas.php?status=0">Nuevas</a>
						</td>
						<td width="25%" <?php if($status == 1) echo "id='optSelected'";?>>
							<a href="pre_reservas.php?status=1">En espera</a>
						</td>
						<td width="25%" <?php if($status == 2) echo "id='optSelected'";?>>
							<a href="pre_reservas.php?status=2">Aceptadas</a>
						</td>
						<td width="25%" <?php if($status == 3 or $status == 4) echo "id='optSelected'";?>>
							<a href="pre_reservas.php?status=3">Anuladas</a>
						</td>
					</tr>
				</table>
				<table summary="listado de pre-reservas">
					<tr style="background: #EEEEEE">
						<td>Nombre</td>
						<td>Fecha ini</td>
						<td>Fecha fin</td>
						<td>Piso</td>
						<?php if($status == '0' or $status == '1'){?>
						<td>Tiempo</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<?php }?>
					</tr>
					<tr>
						<?php
							if($status == '0' or $status == '1'){
								echo "<td colspan='7'><font color='red'><i>".$msg."</i></font></td>";
							}else{
								echo "<td colspan='4'><font color='red'><i>".$msg."</i></font></td>";
							}
						?>
					</tr>
					<?php
						$i=0;
						foreach($arrayPreRental as $preRental){
							echo "<tr bgcolor='#EEEEEE'>";
							echo "<td>".ucwords($preRental['name'])."</td>";
							echo "<td>".convertDate($preRental['date_start'],'es')."</td>";
							echo "<td>".convertDate($preRental['date_end'],'es')."</td>";
							echo "<td>".ucfirst($preRental['appartment'])."</td>";
							if($status == '0'){
								$diferencia_tiempo = ((strtotime($preRental['date_pre_rental'])+$plazo) - time());
								if($diferencia_tiempo > 0){
									$num_horas = floor($diferencia_tiempo/3600);
									$num_minutos = floor(($diferencia_tiempo - ($num_horas*3600))/60);
									$tiempo_restante = "";
									if($num_horas > 0)
										$tiempo_restante .= $num_horas."h ";
									if($num_minutos > 0)
										$tiempo_restante .= $num_minutos."min";
								}else{
									$tiempo_restante = "<font color='red'><b>Agotado</b></font>";
								}
								echo "<td>".$tiempo_restante."</td>";
								echo "<td><a href='tratamiento_pre_reserva.php?id_pre_rental=".$preRental['id_pre_rental']."&action=accept'><img src='images/aceptar.jpg' alt='aceptar'/></a></td>";
								echo "<td><a href='tratamiento_pre_reserva.php?id_pre_rental=".$preRental['id_pre_rental']."&action=cancel'><img src='images/eliminar.jpg' alt='eliminar'/></a></td>";
								echo "<td><a href='#' onClick='javascript:onOffDiv(".$i.");'><img src='images/ver_mas.jpg' alt='ver mas'/></a></td>";
								echo "</tr><tr bgcolor='#EEEEEE'>";
								
							?>
									<td colspan="8">
										<div id="mas_info<?php echo $i;?>" style="display:none">
											<ul>
												<li>Email: <?php echo $preRental['email'];?></li>
												<li>Tel&eacute;fono: <?php echo $preRental['telephone'];?></li>
												<li>Num. personas: <?php echo $preRental['num_pers'];?></li>
												<li>Precio: <?php echo $preRental['price'];?></li>
												<li>Dep&oacute;sito: <?php echo $preRental['deposit'];?></li>
											</ul>
										</div>
									</td>
							<?php
							}else if($status == '1'){
								$diferencia_tiempo = ((strtotime($preRental['date_wait_deposit'])+$plazo) - time());
								if($diferencia_tiempo > 0){
									$num_horas = floor($diferencia_tiempo/3600);
									$num_minutos = floor(($diferencia_tiempo - ($num_horas*3600))/60);
									$tiempo_restante = "";
									if($num_horas > 0)
										$tiempo_restante .= $num_horas."h ";
									if($num_minutos > 0)
										$tiempo_restante .= $num_minutos."min";
								}else{
									$tiempo_restante = "<font color='red'><b>Agotado</b></font>";
								}
								echo "<td>".$tiempo_restante."</td>";
								echo "<td><a href='tratamiento_pre_reserva.php?id_pre_rental=".$preRental['id_pre_rental']."&action=accept'><img src='images/aceptar.jpg' alt='aceptar'/></a></td>";
								echo "<td><a href='tratamiento_pre_reserva.php?id_pre_rental=".$preRental['id_pre_rental']."&action=cancel'><img src='images/eliminar.jpg' alt='eliminar'/></a></td>";
								echo "<td><a href='#' onClick='javascript:onOffDiv(".$i.");'><img src='images/ver_mas.jpg' alt='ver mas'/></a></td>";								
								echo "</tr><tr bgcolor='#EEEEEE'>";
								
							?>
									<td colspan="8">
										<div id="mas_info<?php echo $i;?>" style="display:none">
											<ul>
												<li>Email: <?php echo $preRental['email'];?></li>
												<li>Tel&eacute;fono: <?php echo $preRental['telephone'];?></li>
												<li>Num. personas: <?php echo $preRental['num_pers'];?></li>
												<li>Precio: <?php echo $preRental['price'];?></li>
												<li>Dep&oacute;sito: <?php echo $preRental['deposit'];?></li>
											</ul>
										</div>
									</td>
							<?php
							}
							echo "</tr>";
							$i++;
						}
					?>
				</table>

				<table>
					<tr>
						<?php
							if($ini >= $num_rows){?>
						<td align="left"><a href="<?php echo "pre_reservas.php?status=".$status."&ini=".$prev_ini;?>"><img src="images/anterior.jpg" border="0"/></a></td>
						<?php }
							if(count($arrayPreRental) == $num_rows){?>
						<td align="right"><a href="<?php echo "pre_reservas.php?status=".$status."&ini=".$next_ini;?>"><img src="images/siguiente.jpg" border="0"/></a></td>
						<?php }?>
					</tr>
				</table>

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
