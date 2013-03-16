<?php
/*
 * Created on 15/04/2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

	$j = 0;
	$array_dias = array();
	$array_mes_b = array();
	$array_mes_p = array();
	$array_mes_s = array();

	for($i=1;$i<=12;$i++){
		if($i<10){
			$archivo1 = fopen($dir_b.$mes_anyo."/"."0".$i.".txt","r");
			$archivo2 = fopen($dir_p.$mes_anyo."/"."0".$i.".txt","r");
			$archivo3 = fopen($dir_s.$mes_anyo."/"."0".$i.".txt","r");
		}else{
			$archivo1 = fopen($dir_b.$mes_anyo."/".$i.".txt","r");
			$archivo2 = fopen($dir_p.$mes_anyo."/".$i.".txt","r");
			$archivo3 = fopen($dir_s.$mes_anyo."/".$i.".txt","r");
		}
		$array_dias_b = fgetcsv ($archivo1,1000,",");
		$array_dias_p = fgetcsv ($archivo2,1000,",");
		$array_dias_s = fgetcsv ($archivo3,1000,",");

		$dias_totales = count($array_dias_b);

		$num_ocup_b = 0;
		$num_ocup_p = 0;
		$num_ocup_s = 0;

		for($k=0;$k<$dias_totales;$k++){
			if(substr($array_dias_b[$k],0,1) == "o")
				$num_ocup_b ++;
			if(substr($array_dias_p[$k],0,1) == "o")
				$num_ocup_p ++;
			if(substr($array_dias_s[$k],0,1) == "o")
				$num_ocup_s ++;
		}
		array_push($array_mes_b,($num_ocup_b/$dias_totales)*99.999);
		array_push($array_mes_p,($num_ocup_p/$dias_totales)*99.999);
		array_push($array_mes_s,($num_ocup_s/$dias_totales)*99.999);
	}

	$chart = new LineChart(1500, 500);

	$serie1 = new XYDataSet();
	$serie2 = new XYDataSet();
	$serie3 = new XYDataSet();

	for($i=0;$i<12;$i++){
		if($array_meses[$i]){
			$serie1->addPoint(new Point($meses[$i], $array_mes_b[$i]));
			$serie2->addPoint(new Point($meses[$i], $array_mes_p[$i]));
			$serie3->addPoint(new Point($meses[$i], $array_mes_s[$i]));
		}
	}

	$dataSet = new XYSeriesDataSet();
	if($pisos['bajo']) $dataSet->addSerie("Bajo", $serie1);
	if($pisos['primero']) $dataSet->addSerie("Primero", $serie2);
	if($pisos['segundo']) $dataSet->addSerie("Segundo", $serie3);
	$chart->setDataSet($dataSet);

	$chart->setTitle("Ocupación por pisos en el año ".$mes_anyo);
	$chart->render();

?>
