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
		array_push($array_mes_b,floor(($num_ocup_b/$dias_totales)*100)-0.1);
		array_push($array_mes_p,floor(($num_ocup_p/$dias_totales)*100)-0.1);
		array_push($array_mes_s,floor(($num_ocup_s/$dias_totales)*100)-0.1);
	}

	$chart = new VerticalBarChart(1200,500);
	$dataSet = new XYDataSet();

	for($i=0;$i<count($array_mes_b);$i++){
		if($array_meses[$i])
			$dataSet->addPoint(new Point($meses[$i], floor(($array_mes_b[$i]+$array_mes_p[$i]+$array_mes_s[$i])/3)));
	}

	$chart->setDataSet($dataSet);
	$chart->setTitle("Ocupación General (en %) para el año ".$mes_anyo."");
	$chart->render();

?>
