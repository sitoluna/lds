<?php
/*
 * Created on 15/04/2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

	include ("classes/connectionMySQL.class.php");

	$connectionMySQL = new connectionMySQL();
	$query = "SELECT sum(price) as total_price FROM rental";
	$result = $connectionMySQL->request($query);

	$row = mysql_fetch_array($result);
	$i_total = $row[0];

	$chart = new VerticalBarChart(1200,500);
	$dataSet = new XYDataSet();

	$dataSet->addPoint(new Point("Total",floor($i_total)));

	$chart->setDataSet($dataSet);
	$chart->setTitle("Ingresos Totales (en euros)");
	$chart->render();

?>
