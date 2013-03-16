<?php
/*
 * Created on 05/11/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
session_start();
if(!isset($_SESSION["autorizado"]) or $_SESSION["autorizado"] != "SI"){
	header("Location: index.php");
}
include("functions/functions.php");
include("classes/connectionMySQL.class.php");
include("classes/pre_rental.class.php");
$connectionMySQL = new connectionMySQL();
if(isset($_POST['action']) and $_POST['action']=="proceed"){

if(!file_exists("idBackup.txt")){
	$fileNumeration = fopen("idBackup.txt","w");
	$newID = 10001;
	$newDate = date("Y-m-d",time());
	$fileNumeration = fopen("idBackup.txt","w");
	fwrite($fileNumeration,$newID.";".$newDate);
	fclose($fileNumeration);
}else{
	$fileNumeration = fopen("idBackup.txt","r");
	$dataFile = explode(";",fgets($fileNumeration));
	$lastID = $dataFile[0];
	$lastDate = $dataFile[1];
	fclose($fileNumeration);

	$fileNumeration = fopen("idBackup.txt","w");
	$newID = $lastID + 1;
	$newDate = date("Y-m-d",time());
	$fileNumeration = fopen("idBackup.txt","w");
	fwrite($fileNumeration,$newID.";".$newDate);
	fclose($fileNumeration);
}

	$filename = $newID."__backup__".date("d_m_Y__H_i_s__",time()).".sql";
	$file = fopen("backups/".$filename,"w");
	$queryClient = "select * from client order by id";
	$resultClient = $connectionMySQL->request($queryClient);
	while($row = mysql_fetch_array($resultClient)){
		$linea = "insert into client (id, passport, name, nationality, email, telephone, comments, num_rent) values ('".$row['id']."','".$row['passport']."','".$row['name']."','".$row['nationality']."','".$row['email']."','".$row['telephone']."','".str_replace("\n"," ",$row['comments'])."','".$row['num_rent']."'); \n";
		fwrite($file,$linea);
	}

	$queryRental = "select * from rental order by id_client, id_rental";
	$resultRental = $connectionMySQL->request($queryRental);
	while($row = mysql_fetch_array($resultRental)){
		$linea = "insert into rental (id_client, id_rental, date_start, date_end, appartment, num_pers, deposit, price, comments) values ('".$row['id_client']."','".$row['id_rental']."','".$row['date_start']."','".$row['date_end']."','".$row['appartment']."','".$row['num_pers']."','".$row['deposit']."','".$row['price']."','".str_replace("\n"," ",$row['comments'])."'); \n";
		fwrite($file,$linea);
	}

	$queryPreRental = "select * from pre_rental";
	$resultPreRental = $connectionMySQL->request($queryPreRental);
	while($row = mysql_fetch_array($resultPreRental)){
		$linea = "insert into pre_rental (id_pre_rental, name, email, telephone, nationality, date_start, date_end, appartment, num_pers, price, deposit, status, date_pre_rental, date_wait_deposit, date_deposit, date_cancelled, activate) values ('".$row['id_pre_rental']."', '".$row['name']."', '".$row['email']."', '".$row['telephone']."', '".$row['nationality']."', '".$row['date_start']."', '".$row['date_end']."', '".$row['appartment']."', '".$row['num_pers']."', '".$row['price']."', '".$row['deposit']."', '".$row['status']."', '".$row['date_pre_rental']."', '".$row['date_wait_deposit']."', '".$row['date_deposit']."', '".$row['date_cancelled']."', '".$row['activate']."'); \n";
		fwrite($file,$linea);
	}

	fclose($file);
	header("location: home.php?msg=backuped");
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
	<title>Backup del sistema</title>


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
				<h1>Backup de la base de datos</h1>
				<table summary="opciones de backup">
					<tr>
						<td>
							<form method="post" action="backup.php"/>
							<input type="hidden" name="action" value="proceed"/>
							<input type="submit" value="realizar backup"/>
						</td>
					</tr>
				</table>
			</div>

		</div>

		<div class="sidenav">

			<?php include("menuBackOffice.php"); ?>

		</div>

		<div class="clearer"><span></span></div>
		</div>

		<div class="footer">&copy; 2007 <a href="../index.php">lunadesevilla.es</a>.Valid <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>&amp; <a href="http://validator.w3.org/check?uri=referer">XHTML</a>.Template design by Alfonso Luna
		</div>

	</div>

</body></html>
