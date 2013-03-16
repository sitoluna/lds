<?php
include("classes/rental.class.php");

$rental = new rental();
$arrayAlquileres = $rental->getRental($id_client);
if(count($arrayAlquileres) > 0){
	for($i = 0; $i < count($arrayAlquileres); $i++){
		if($i%2==0)
			$color =  "style='background: #EEEEEE'";
		else
			$color = " style='background: #FAFAFA'";

		echo "<tr ".$color.">";
		echo "<td>".ucfirst($arrayAlquileres[$i]['appartment'])."</td>";
		echo "<td>".convertDate($arrayAlquileres[$i]['date_start'],'es')."</td>";
		echo "<td>".convertDate($arrayAlquileres[$i]['date_end'],'es')."</td>";
		echo "<td>".$arrayAlquileres[$i]['num_pers']."</td>";
		echo "<td>".$arrayAlquileres[$i]['deposit']."</td>";
		echo "<td>".$arrayAlquileres[$i]['price']."</td>";
		echo "<td><a href='modificarAlquiler.php?id_client=".$id_client."&id_rental=".$arrayAlquileres[$i]['id_rental']."'><img src='images/modificar.jpg' alt='modificar'></a></td>";
		echo "<td><a href='modificarAlquiler.php?id_client=".$id_client."&id_rental=".$arrayAlquileres[$i]['id_rental']."&action=delete' onClick='javascript:return confirm(\"&iquest;Est&aacute; seguro de que desea eliminar este Alquiler?\");'><img src='images/eliminar.jpg' alt='eliminar'></a></td>";
		echo "<td><a href='#' onClick='javascript:onOffDiv(".$i.");'><img src='images/ver_mas.jpg' alt='ver más'/></a></td>";
		echo "<td><a target='_blank' href='PDF/test.php?id=".$id_client."&id_rental=".$arrayAlquileres[$i]['id_rental']."'><img src='images/pdf.png' alt='recibo'/></a></td>";
		echo "</tr>";

		echo "<tr ".$color.">";
		?>
			<td colspan="10">
				<div id="mas_info<?php echo $i;?>" style="display:none">
					<ul>
						<li>Hora de entrada: <?php echo $arrayAlquileres[$i]['time_entry'];?></li>
						<li>Hora de salida: <?php echo $arrayAlquileres[$i]['time_exit'];?></li>
						<li>Luz entrada: <?php echo $arrayAlquileres[$i]['electricity_start'];?></li>
						<li>Luz salida: <?php echo $arrayAlquileres[$i]['electricity_end'];?></li>
						<li>Agua entrada: <?php echo $arrayAlquileres[$i]['water_start'];?></li>
						<li>Agua salida: <?php echo $arrayAlquileres[$i]['water_end'];?></li>
						<li>Comentarios: <?php echo $arrayAlquileres[$i]['comments'];?></li>
					</ul>
				</div>
			</td>
		</tr>
		<?php
	}
}
?>