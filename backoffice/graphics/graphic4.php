<?php
/*
 * Created on 15/04/2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

	$array_b = array();
	$array_p = array();
	$array_s = array();

	for($i=2004;$i<=$lastYear;$i++){

		$array_dias_b = array();
		$array_dias_p = array();
		$array_dias_s = array();

		$num_ocup_b = 0;
		$num_ocup_p = 0;
		$num_ocup_s = 0;

		$dias_totales = 0;

		for($j=1;$j<=12;$j++){

			if($j<10){
				$archivo1 = fopen($dir_b.$i."/"."0".$j.".txt","r");
				$archivo2 = fopen($dir_p.$i."/"."0".$j.".txt","r");
				$archivo3 = fopen($dir_s.$i."/"."0".$j.".txt","r");
			}else{
				$archivo1 = fopen($dir_b.$i."/".$j.".txt","r");
				$archivo2 = fopen($dir_p.$i."/".$j.".txt","r");
				$archivo3 = fopen($dir_s.$i."/".$j.".txt","r");
			}

			$array_dias_b = fgetcsv ($archivo1,1000,",");
			$array_dias_p = fgetcsv ($archivo2,1000,",");
			$array_dias_s = fgetcsv ($archivo3,1000,",");

			$dias_totales += count($array_dias_b);

			$dias_totales_mes = count($array_dias_b);

			for($k=0;$k<$dias_totales_mes;$k++){
				if(substr($array_dias_b[$k],0,1) == "o")
					$num_ocup_b ++;
				if(substr($array_dias_p[$k],0,1) == "o")
					$num_ocup_p ++;
				if(substr($array_dias_s[$k],0,1) == "o")
					$num_ocup_s ++;
			}
		}

		array_push($array_b,floor(($num_ocup_b/$dias_totales)*99.999));
		array_push($array_p,floor(($num_ocup_p/$dias_totales)*99.999));
		array_push($array_s,floor(($num_ocup_s/$dias_totales)*99.999));

	}

	$chart = new LineChart(1500, 500);

	$serie1 = new XYDataSet();
	$serie2 = new XYDataSet();
	$serie3 = new XYDataSet();

	for($i=2004;$i<=$lastYear;$i++){
		if($array_anyos[$i]) $serie1->addPoint(new Point($i, $array_b[($i-2004)]));
		if($array_anyos[$i]) $serie2->addPoint(new Point($i, $array_p[($i-2004)]));
		if($array_anyos[$i]) $serie3->addPoint(new Point($i, $array_s[($i-2004)]));
	}

	$dataSet = new XYSeriesDataSet();
	if($pisos['bajo']) $dataSet->addSerie("Bajo", $serie1);
	if($pisos['primero']) $dataSet->addSerie("Primero", $serie2);
	if($pisos['segundo']) $dataSet->addSerie("Segundo", $serie3);
	$chart->setDataSet($dataSet);

	$chart->setTitle("Ocupación por piso y año");
	$chart->render();

?>
