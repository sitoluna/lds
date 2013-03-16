<?php
/*
 * Created on 22/10/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
if(isset($_POST['action']) and $_POST['action'] == "search"){
	$resultSearch = "";
	require("functions/functions.php");
	require("classes/connectionMySQL.class.php");
	$connectionMySQL = new connectionMySQL();
	$resultSearch = "";
	switch($_POST['modo']){
		case "general":
			if(isset($_POST['mes_gen']) and ($_POST['mes_gen']=="" or $_POST['anyo_gen']=="")){
				header("location:busquedaAlquiler.php?err=gen");
			}else{
				$query = "select * from client c, rental r where c.id = r.id_client order by appartment, date_start";
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
			}
		break;
		case "avanzada":

		break;
	}
?>

<html>
	<head>
		<meta http-equiv="Content-Language" content="en" />
		<meta name="GENERATOR" content="PHPEclipse 1.0" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Resultado de la B&uacute;squeda de Alquiler</title>
	</head>
	<body>
		<table style="width:100%">
			<tr align="center" valign="top">
				<td>
					<table style="width:700px">
						<tr>
							<td>
								<a href="home.php">Ir a la p&aacute;gina principal</a> / <a href="busquedaAlquiler.php">Nueva B&uacute;squeda</a><br/>
								<table cellpadding='10'>
									<?php
										if($resultSearch == "")
											echo "<tr><td><h4><font color='red'>No se han encontrado resultados</font></h4></td></tr>";
										else
											echo $resultSearch;
									?>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>

<?php
}
?>