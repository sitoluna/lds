<?php
	$pre_rental = new pre_rental();
	$numberNewsPR = $pre_rental->getNumberNews();
?>
			<h1>Gestion de clientes</h1>
			<ul>
				<li><a href="nuevoCliente.php">Nuevo cliente</a></li>
				<li><a href="listadoClientes.php">Listado de clientes</a></li>
			</ul>

			<h1>Gestion de alquileres</h1>
			<ul>
				<li><a href="busquedaAlquiler.php">B&uacute;squeda de alquileres</a></li>
				<li><a href="rentalCalendar.php">Calendario disponibilidad</a></li>
				<li><a href="pre_reservas.php">Gesti&oacute;n de reservas <?php if($numberNewsPR > 0) echo "<font color='red'><b>(".$numberNewsPR.")</b></font>";?></a></li>
				<li><a href="modificarPrecios.php">Modificar precios</a></li>
				<li><a href="modificarCuentaBancaria.php">Modificar datos bancarios</a></li>
				<li><a href="ssyf.php">Fechas Semana Santa y Feria</a></li>

			</ul>

			<h1>Estad&iacute;sticas</h1>
			<ul>
				<li><a href="#">Estad&iacute;sticas de la p&aacute;gina</a></li>
				<li><a href="#">Gr&aacute;ficas</a></li>
			</ul>

			<h1>Gestion del sistema</h1>
			<ul>
				<li><a href="https://webmail.1and1.es" target="_blank">Email</a></li>
				<li><a href="modificarAdministrador.php">Modificar contrase&ntilde;a</a></li>
				<li><a href="backup.php">Backup de la base de datos</a></li>
				<li><a href="restaurarBD.php">Restaurar el sistema</a></li>
			</ul>
