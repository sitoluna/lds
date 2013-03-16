<?php
include("../classes/connectionMySQL.class.php");
include("../functions/functions.php");
include ('class.ezpdf.php');
$connectionMySQL = new connectionMySQL();

$idClient = $_GET['id'];
$idRental = $_GET['id_rental'];

$queryCliente = "select * from client where id = '".$idClient."'";
$resultCliente = $connectionMySQL->request($queryCliente);

$rowCliente = mysql_fetch_array($resultCliente);

$queryAlquiler = "select * from rental where id_client = '".$idClient."' and id_rental = '".$idRental."'";
$resultAlquiler = $connectionMySQL->request($queryAlquiler);

$rowAlquiler = mysql_fetch_array($resultAlquiler);

$pdf =& new Cezpdf('a4');

$pdf->selectFont('fonts/courier.afm');

$datacreator = array (

                    'Title'=>'Recibo de alquiler',

                    'Author'=>'lunadesevilla',

                    'Subject'=>'Recibo de alquiler',

                    );

$pdf->addInfo($datacreator);

$pdf->ezText(utf8_decode("<b>Recibo de alquiler</b>\n"),14);


$pdf->ezText("Yo, Manuel Luna Luna, he recibido de ".ucwords($rowCliente['name'])." la cantidad de ".$rowAlquiler['price']." euros en concepto de alquiler del piso ".$rowAlquiler['appartment']." sito en la calle Pedro Miguel 43 por el periodo comprendido entre ".convertDate($rowAlquiler['date_start'],'es')." al ".convertDate($rowAlquiler['date_end'],'es').".",12);


$pdf->ezText("\n\n\n",10);

$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"),10);

$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n",10);

$pdf->ezStream();

?>
