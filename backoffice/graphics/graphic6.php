<?php
/*
 * Created on 15/04/2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

	include ("classes/connectionMySQL.class.php");
	$connectionMySQL = new connectionMySQL();
	$query = "SELECT appartment, sum(price) as total_price FROM rental  group by appartment";
	$result = $connectionMySQL->request($query);

	$row = mysql_fetch_array($result);
	$ib = $row[1];
	$row = mysql_fetch_array($result);
	$ip = $row[1];
	$row = mysql_fetch_array($result);
	$is = $row[1];

	$chart = new VerticalBarChart(1200,500);
	$dataSet = new XYDataSet();

	if($pisos['bajo']) $dataSet->addPoint(new Point("Bajo",floor($ib)));
	if($pisos['primero']) $dataSet->addPoint(new Point("Primero", floor($ip)));
	if($pisos['segundo']) $dataSet->addPoint(new Point("Segundo",floor($is)));

	$chart->setDataSet($dataSet);
	$chart->setTitle("Ingresos Generales (en euros)");
	$chart->render();

?>
