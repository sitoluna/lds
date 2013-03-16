<?php
/*
 * Created on 21/10/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require('classes/connectionMySQL.class.php');
$connectionMySQL = new connectionMySQL();
$busqueda=$_POST['search'];
$order=$_POST['order'];
switch($order){
	case "asc":
		$orderSQL = " order by name asc";
	break;
	case "desc":
		$orderSQL = " order by name desc";
	break;
	case "rAsc":
		$orderSQL = " order by id asc";
	break;
	case "rDesc":
		$orderSQL = " order by id desc";
	break;
	default:
		$orderSQL = " order by id desc";
	break;
}
if ($busqueda != ""){
	$cadenas = explode(' ',$busqueda);
	$cadenasResaltadas = explode(' ',$busqueda);
	for($i=0;$i<count($cadenasResaltadas);$i++){
		$cadenasResaltadas[$i] = "<b><font color='red'>".$cadenasResaltadas[$i]."</font></b>";
	}

	if(count($cadenas) == 1)
		$busqueda2 = "%".$busqueda."%";
	else{
		$busqueda2 = "%";
		foreach($cadenas as $palabra){
			$busqueda2 .= $palabra."%";
		}
	}

	$cadbusca = "SELECT * FROM client WHERE name LIKE '$busqueda2' ".$orderSQL;
}else{
	$cadbusca = "SELECT * FROM client ".$orderSQL;
	$cadenas = "";
	$cadenasResaltadas = "";
}
?>

<?php
	$result = $connectionMySQL->request($cadbusca);
	$total_rows = mysql_num_rows($result);
	if($total_rows > 0){
		$num_rows = 10;
		$current_num_rows = 0;
		$div_id = 0;
		$pos = 0;
		while ($row = mysql_fetch_array($result)){
			if($current_num_rows%$num_rows == 0){
				echo "<div id='div_".$div_id."' ";
				if($div_id == 0) echo "style='display:block'>";
				else echo "style='display:none'>";
				echo "<table summary='listado de clientes'>";
			}
			$current_num_rows ++;
			echo "
				<tr>
					<td ";
			if($pos%2 == 0) echo " id='resultado1' ";
			else echo " id='resultado2' ";
			$acentos = array('á','é','í','ó','ú','ñ');
			$sin_acentos = array('&aacute;','&eacute;','&iacute;','&oacute;','&uacute;','&ntilde;');
			echo "><a href='fichaCliente.php?id=".$row['id']."'>".utf8_encode(str_replace($acentos,$sin_acentos,str_replace($cadenas,$cadenasResaltadas,$row['name'])))."</a></td>
				</tr>";
			if($current_num_rows == $num_rows){
				echo "</table>";
				echo "</div>";
				$current_num_rows = 0;
				$div_id ++;
			}
		$pos++;
		}
		if($current_num_rows > 0){
			echo "</table>";
			echo "</div>";
		}
	}else{
		echo "
			<table><tr>
				<td class=\"titulo\">No se han encontrado coincidencias con la cadena buscada.</td>
			</tr></table>";
	}

?>
	<table>
		<tr>
			<td align="left"><a href="#" onclick="javascript:muestraAnterior(foco)"><img id="img_ant" src=""/></a></td>
			<td align="right"><a href="#" onclick="javascript:muestraSiguiente(foco,<?php echo $total_rows;?>,<?php echo $num_rows;?>)"><img id="img_sig" src="<?php if($total_rows > $num_rows) echo "images/siguiente.jpg"; ?>"/></a></td>
		</tr>
	</table>
