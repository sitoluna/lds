<?php
/*
 * Created on 11/10/2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


if (!function_exists("creaLog")) {
	function creaLog($texto){
		$fd_log = fopen(date("Ymd").".txt","a+");
		fwrite($fd_log,date("H:i:s")." - ".$texto."\r\n");
		fclose($fd_log);
	}
}

//Funcion que devuelve TRUE si date1 es posterior a date2, y FALSE en caso contrario
function dateAfter($date1,$date2){
	$strtotime_date1 = strtotime($date1);
	$strtotime_date2 = strtotime($date2);

	if($strtotime_date1 >= $strtotime_date2)
		return true;
	else
		return false;
}

//Funcion que devuelve TRUE si date1 es anterior a date2, y FALSE en caso contrario
function dateBefore($date1,$date2){
	$strtotime_date1 = strtotime($date1);
	$strtotime_date2 = strtotime($date2);

	if($strtotime_date1 < $strtotime_date2)
		return true;
	else
		return false;
}

//Funcion que imprime por pantalla el actual inquilino de un apartamento dado.
function currentClient($appartment){
	$connectionMySQL = new connectionMySQL();
	$date_today = getDateToday();
	$query = "select name, c.id
				from rental r, client c
				where r.id_client = c.id
				and appartment='".$appartment."'
				and r.date_start <= '".$date_today."'
				and r.date_end > '".$date_today."'";
	$result = $connectionMySQL->request($query);
	if(mysql_num_rows($result) < 1){
			echo "<p>[<b> VACIO </b>]</p>";
	}else{
		while($row = mysql_fetch_array($result)){
			echo "<p>[<b><a href='fichaCliente.php?id=".$row['id']."'> ".ucwords($row['name'])." </a></b>]</p>";
		}
	}
}

//Funcion que devuelve la fecha actual en formato ingles (YYYY-mm-dd)
function getDateToday(){
	return date("Y-m-d",time());
}

//Funcion que imprime por pantalla la lista de clientes que entran hoy.
function entryClientToday(){
	$connectionMySQL = new connectionMySQL();
	$date_today = getDateToday();
	$query = "select id, name, appartment from client c, rental r
			where c.id = r.id_client
			and date_start='".$date_today."'
			order by appartment";
	$result = $connectionMySQL->request($query);
	if(mysql_num_rows($result) < 1)
		echo "<p><b>Hoy no entra ning&uacute;n cliente</b></p>";
	else{
		while($row = mysql_fetch_array($result))
			echo "<p><b><font color='red'><a href='fichaCliente.php?id=".$row['id']."'>".ucwords($row['name'])."</a> (".ucfirst($row['appartment'])." )</font></b></p>";
	}
}

//Funcion que imprime por pantalla la lista de clientes que salen hoy.
function exitClient(){
	$connectionMySQL = new connectionMySQL();
	$date_today = getDateToday();
	$query = "select id, name, appartment
				from client c, rental r
				where c.id = r.id_client
				and date_end = '".$date_today."'
				order by appartment";
	$result = $connectionMySQL->request($query);
	if(mysql_num_rows($result) < 1)
		echo "<p><b>Hoy no sale ning&uacute;n cliente</b></p>";
	else{
		while($row = mysql_fetch_array($result)){
			echo "<p><b><font color='red'><a href='fichaCliente.php?id=".$row['id']."'>".ucwords($row['name'])."</a> (".ucfirst($row['appartment'])." )</font></b></p>";
		}
	}
}

//Funcion que imprime por pantalla el proximo cliente a entrar.
function nextClientEntry(){
	$connectionMySQL = new connectionMySQL();
	$date_today = getDateToday();
	//Buscamos la fecha mas proxima de entrada
	$query = "select date_start
				from client c, rental r
				where r.id_client = c.id
				and date_start > '".$date_today."'
				order by date_start asc limit 0,1";
	$result = $connectionMySQL->request($query);
	if(mysql_num_rows($result) < 1){
		echo "<p><b>NO HAY PROXIMA ENTRADA</b></p>";
	}
	else{
		//Buscamos todos los alquileres que tengan esa fecha de entrada y recuperamos los datos de los clientes
		$row = mysql_fetch_array($result);
		$nextEntryDate = $row['date_start'];
		$query = "select name, appartment, date_start, date_end, id
					from client c, rental r
					where r.id_client = c.id
					and date_start = '".$nextEntryDate."'
					order by appartment";
		$result = $connectionMySQL->request($query);
		while($row = mysql_fetch_array($result)){
			echo "<p><b><a href='fichaCliente.php?id=".$row['id']."'>".ucwords($row['name'])."</a></b><br/>Apartamento:  ".ucfirst($row['appartment'])."<br/>Fecha:  ".convertDate($nextEntryDate,"es")."</p>";
		}
	}
}

//Funcion que imprime por pantalla el proximo cliente a salir.
function nextClientExit(){
	$connectionMySQL = new connectionMySQL();
	$date_today = getDateToday();
	$query = "select date_end
					from client c, rental r
					where r.id_client = c.id
					and date_start <= '".$date_today."'
					and date_end > '".$date_today."'
					order by date_end asc limit 0,1";
	$result = $connectionMySQL->request($query);
	if(mysql_num_rows($result) < 1){
		echo "<p><b>NO HAY PROXIMA SALIDA</b></p>";
	}
	else{
		$row = mysql_fetch_array($result);
		$nextExitDate = $row["date_end"];
		$query = "select name, appartment, date_start, date_end
					from client c, rental r
					where r.id_client = c.id
					and date_end = '".$nextExitDate."'
					order by appartment";
		$result = $connectionMySQL->request($query);
		while($row = mysql_fetch_array($result)){
			echo "<p><b>".ucwords($row['name'])."</b><br/>Apartamento: ".ucfirst($row['appartment'])."<br/>Fecha: ".convertDate($nextExitDate,"es")."</p>";
		}
	}
}

//Funcion que verifica que dos fechas dadas como parametros de entrada sean correctas y no se solapen.
function validDates($date1, $date2, $modifyRental = false){
	$res = true;
	$day = date("d",strtotime($date1));
	$month = date("m",strtotime($date1));
	$year = date("Y",strtotime($date1));
	$day2 = date("d",strtotime($date2));
	$month2 = date("m",strtotime($date2));
	$year2 = date("Y",strtotime($date2));
	$dateToday = getDateToday();


	$date1_ok = checkdate($month, $day, $year);
	$date2_ok = checkdate($month2, $day2, $year2);
	if($modifyRental)
		$dates_arranged = !dateBefore($date2,$date1);
	else
		$dates_arranged = !dateBefore($date2,$date1)&&!dateBefore($date1,$dateToday);

	if(!$date1_ok or !$date2_ok or !$dates_arranged)
		$res = false;
	return $res;
}

//Funcion que devuelve TRUE si las fechas pasadas por parametros estan solapadas.
function overlapedDates($date1, $date2, $appartment, $id_client = NULL, $id_rental = NULL){
	$connectionMySQL = new connectionMySQL();
	$overlaped = array();
	$overlaped["status"] = false;
	$overlaped["errors"] = "";
	if($id_client == NULL and $id_rental == NULL)
		$query = "select * from rental r, client c where r.id_client = c.id and appartment = '".$appartment."'";
	else
		$query = "select * from rental r, client c where (r.id_client = c.id and appartment = '".$appartment."' and not(c.id = '".$id_client."' and r.id_rental = '".$id_rental."'))";
	$result = $connectionMySQL->request($query);
	if(mysql_num_rows($result) > 0){
		while($row = mysql_fetch_array($result)){
			if(dateAfter($date1,$row['date_end']) or dateAfter($row['date_start'],$date2)){

			}else{
				$overlaped["status"] = true;
				$overlaped["errors"] .= "<p> ".ucwords($row['name'])." del ".convertDate($row['date_start'],"es")." hasta el ".convertDate($row['date_end'],"es")."</p>";
			}
		}
	}
	return $overlaped;
}

function overlapedDatesPR($date1, $date2, $appartment){
	$connectionMySQL = new connectionMySQL();
	$overlaped = array();
	$overlaped["status"] = false;
	$overlaped["errors"] = "";
	$query = "select * from pre_rental where appartment = '".$appartment."' and status = '1'";
	$result = $connectionMySQL->request($query);
	if(mysql_num_rows($result) > 0){
		while($row = mysql_fetch_array($result)){
			if(dateAfter($date1,$row['date_end']) or dateBefore($date2,$row['date_start'])){

			}else{
				$overlaped["status"] = true;
				$overlaped["errors"] .= "<p> ".ucwords($row['name'])." del ".convertDate($row['date_start'],"es")." hasta el ".convertDate($row['date_end'],"es")."</p>";
			}
		}
	}
	return $overlaped;
}

function convertDate($date,$to_format){
	switch($to_format){
		case "es":
			$newFormatDate = date("d-m-Y",strtotime($date));
		break;

		case "en":
			$newFormatDate = substr($date,6,4);
			$newFormatDate .= "-".substr($date,3,2);
			$newFormatDate .= "-".substr($date,0,2);
		break;
	}
	return $newFormatDate;
}

function writelog($msg){
	$fileLog = fopen("c:/Proyectos/gestionLuna_en/log.txt","a+");
	fwrite($fileLog,$msg."\n");
	fclose($fileLog);
}

function truncateTableBD( $connectionMySQL = NULL){
	$disconnect = false;
	if($connectionMySQL == NULL){
		$connectionMySQL = new connectionMySQL();
		$connectionMySQL->connect();
		$disconnect = true;
	}
	$query = "truncate client";
	$connectionMySQL->massive_request($query);
	$query = "truncate rental";
	$connectionMySQL->massive_request($query);
	$query = "truncate pre_rental";
	$connectionMySQL->massive_request($query);

	if($disconnect){
		$connectionMySQL->disconnect();
	}
}

function makeBackup(){
	$makebackup = false;
	if(!file_exists("idBackup.txt")){
		$fileNumeration = fopen("idBackup.txt","w");
		$newID = 10001;
		$newDate = date("Y-m-d",time());
		$fileNumeration = fopen("idBackup.txt","w");
		fwrite($fileNumeration,$newID.";".$newDate);
		fclose($fileNumeration);
		$makebackup = true;
	}else{
		$fileNumeration = fopen("idBackup.txt","r");
		$dataFile = explode(";",fgets($fileNumeration));
		$lastID = $dataFile[0];
		$lastDate = $dataFile[1];
		fclose($fileNumeration);
		if(strtotime($lastDate) < strtotime(date("Y-m-d",time()))){
			$fileNumeration = fopen("idBackup.txt","w");
			$newID = $lastID + 1;
			$newDate = date("Y-m-d",time());
			$fileNumeration = fopen("idBackup.txt","w");
			fwrite($fileNumeration,$newID.";".$newDate);
			fclose($fileNumeration);
			$makebackup = true;
		}
	}

	if($makebackup){
		$filename = $newID."__backup_Clientes_y_Alquileres__".date("d_m_Y__H_i_s__",time()).".sql";
		$file = fopen("backups/".$filename,"w");

		$connectionMySQL = new connectionMySQL();
		$queryClient = "select * from client order by id";
		$resultClient = $connectionMySQL->request($queryClient);

		while($row = mysql_fetch_array($resultClient)){
			$linea = "insert into client (id, passport, name, nationality, email, telephone, comments, num_rent) values ('".$row['id']."','".$row['passport']."','".$row['name']."','".$row['nationality']."','".$row['email']."','".$row['telephone']."','".str_replace("\n"," ",$row['comments'])."','".$row['num_rent']."') \n";
			fwrite($file,$linea);
		}

		$queryRental = "select * from rental order by id_client, id_rental";
		$resultRental = $connectionMySQL->request($queryRental);

		while($row = mysql_fetch_array($resultRental)){
			$linea = "insert into rental (id_client, id_rental, date_start, date_end, appartment, num_pers, time_entry, time_exit, deposit, price, comments) values ('".$row['id_client']."','".$row['id_rental']."','".$row['date_start']."','".$row['date_end']."','".$row['appartment']."','".$row['num_pers']."','".$row['time_entry']."','".$row['time_exit']."','".$row['deposit']."','".$row['price']."','".str_replace("\n"," ",$row['comments'])."') \n";
			fwrite($file,$linea);
		}
		fclose($file);
	}
}

function modifyCalendar($dirRentalCalendar,$appartment,$dateStart,$dateEnd,$action,$id_client = NULL, $id_rental = NULL){
	switch($action){
		case "insert":
			$appartments = new appartment();
			$arrayAppartment = $appartments->getArrayAppartment();
			$firstAppartment = $arrayAppartment[0];
			if(!file_exists($dirRentalCalendar.$firstAppartment."/".date("Y",strtotime($dateEnd)))){
				createCalendar(date("Y",strtotime($dateEnd)));
			}
			$color = "ocupado-".$id_client;
		break;
		case "insertPreRental":
			$appartments = new appartment();
			$arrayAppartment = $appartments->getArrayAppartment();
			$firstAppartment = $arrayAppartment[0];
			if(!file_exists($dirRentalCalendar.$firstAppartment."/".date("Y",strtotime($dateEnd)))){
				createCalendar(date("Y",strtotime($dateEnd)));
			}
			$color = "reservado-0";
		break;
		case "acceptPreRental":
			$color = "ocupado-".$id_client;
		break;
		case "deletePreRental":
		case "delete":
			$color = "libre-0";
		break;
		case "deleteAll":
			$oldRental = new rental();
			$arrayRentals = $oldRental->getRental($id_client);
			for($i=0; $i<count($arrayRentals); $i++){
				modifyCalendar($dirRentalCalendar, $arrayRentals[$i]['appartment'], $arrayRentals[$i]['date_start'], $arrayRentals[$i]['date_end'],"delete");
			}
			return(0);
		break;
		case "modify":
			$oldRental = new rental();
			$oldRental->getRental($id_client, $id_rental);
			modifyCalendar($dirRentalCalendar, $oldRental->appartment, $oldRental->date_start, $oldRental->date_end,"delete");
			modifyCalendar($dirRentalCalendar, $appartment, $dateStart, $dateEnd, "insert",$id_client);
			return(0);
		break;

	}
	$yearStart = date("Y",strtotime($dateStart));
	$yearEnd = date("Y",strtotime($dateEnd));
	$monthStart = (int)date("m",strtotime($dateStart));
	$monthEnd = (int)date("m",strtotime($dateEnd));
	$dayStart = (int)date("d",strtotime($dateStart));
	$dayEnd = (int)date("d",strtotime($dateEnd));
	$finish = false;

	while(!$finish){
		if(($monthStart != $monthEnd) or ($yearStart != $yearEnd)){
			$dateEnd2 = $yearStart."-".$monthStart."-31";

			if($monthStart < 10)
				$fileColors = fopen($dirRentalCalendar.$appartment."/".$yearStart."/0".$monthStart.".txt","r");
			else
				$fileColors = fopen($dirRentalCalendar.$appartment."/".$yearStart."/".$monthStart.".txt","r");

			$arrayColors = fgetcsv ($fileColors,1000,",");
			fclose($fileColors);

			for($i=$dayStart-1;$i<31;$i++){
				$arrayColors[$i] = $color;
			}

			if($monthStart < 10)
				$fileColors = fopen($dirRentalCalendar.$appartment."/".$yearStart."/0".$monthStart.".txt","w");
			else
				$fileColors = fopen($dirRentalCalendar.$appartment."/".$yearStart."/".$monthStart.".txt","w");
//			Si no podemos usar fputcsv usamos este metodo
//			*********************************************
			$linea = $arrayColors[0];
			for($i=1;$i<count($arrayColors);$i++){
				$linea .= ",".$arrayColors[$i];
			}
			fwrite($fileColors,$linea);
//			*********************************************
//			fputcsv($fileColors,$arrayColors);
//			*********************************************
			fclose($fileColors);

			$dayStart = 1;

			if($monthStart < 12){
				$monthStart++;

			}else{
				$yearStart++;
				$monthStart = 1;
			}
		}else{
			$finish = true;

			if($monthStart < 10)
				$fileColors = fopen($dirRentalCalendar.$appartment."/".$yearStart."/0".$monthStart.".txt","r");
			else
				$fileColors = fopen($dirRentalCalendar.$appartment."/".$yearStart."/".$monthStart.".txt","r");

			$arrayColors = fgetcsv ($fileColors,1000,",");
			fclose($fileColors);

			for($i=$dayStart-1;$i<$dayEnd-1;$i++){
				$arrayColors[$i] = $color;
			}

			if($monthStart < 10)
				$fileColors = fopen($dirRentalCalendar.$appartment."/".$yearStart."/0".$monthStart.".txt","w");
			else
				$fileColors = fopen($dirRentalCalendar.$appartment."/".$yearStart."/".$monthStart.".txt","w");
//			Si no podemos usar fputcsv usamos este metodo
//			*********************************************
			$linea = $arrayColors[0];
			for($i=1;$i<count($arrayColors);$i++){
				$linea .= ",".$arrayColors[$i];
			}
			fwrite($fileColors,$linea);
//			*********************************************
//			fputcsv($fileColors,$arrayColors);
//			*********************************************

			fclose($fileColors);
		}
	}
	return 0;
}

function lastDay($year,$month){
   if (((fmod($year,4)==0) and (fmod($year,100)!=0)) or (fmod($year,400)==0)) {
       $february = 29;
   } else {
       $february = 28;
   }
   switch($month) {
       case "01": return 31; break;
       case "02": return $february; break;
       case "03": return 31; break;
       case "04": return 30; break;
       case "05": return 31; break;
       case "06": return 30; break;
       case "07": return 31; break;
       case "08": return 31; break;
       case "09": return 30; break;
       case "10": return 31; break;
       case "11": return 30; break;
       case "12": return 31; break;
   }
}

function printCalendar($appartment, $year, $month, $dirRentalCalendar = "rentalCalendar/", $lang = "es"){

	if(isset($_SESSION['autorizado']) and $_SESSION['autorizado']=="SI")
		$autorizado = true;
	else
		$autorizado = false;

	$diaSemana = getdate(strtotime($year."-".$month."-01"));
	$nextYear = $year;
	$previousYear = $year;
	switch($month){
		case "01":
			$nextMonth = "02";
			$previousMonth = "12";
			$previousYear = $year-1;
		break;
		case "12":
			$nextMonth = "01";
			$previousMonth = "11";
			$nextYear = $year+1;
		break;
		default:
			if($month < 9)
				$nextMonth = "0".($month+1);
			else
				$nextMonth = $month+1;
			if($month < 11)
				$previousMonth = "0".($month-1);
			else
				$previousMonth = $month-1;
		break;
	}
	if($diaSemana['wday'] == 0)
		$diaSemana = 6;
	else
		$diaSemana = $diaSemana['wday']-1;
	$lastDay = lastDay($year,$month);

	switch($lang){

		case "en":
			$arrayMonths = array("01"=>"January","02"=>"February","03"=>"Mars","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December");
		break;

		case "fr":
			$arrayMonths = array("01"=>"Janvier","02"=>"Fevrier","03"=>"Mars","04"=>"Avril","05"=>"May","06"=>"Juin","07"=>"Julio","08"=>"Agost","09"=>"Septembre","10"=>"Octobre","11"=>"Novembre","12"=>"Decembre");
		break;

		case "it":
			$arrayMonths = array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");
		break;

		case "es":
		default:

			$arrayMonths = array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");
		break;
	}

	if(file_exists($dirRentalCalendar.$appartment."/".$year."/".$month.".txt")){
		$fileColors = fopen($dirRentalCalendar.$appartment."/".$year."/".$month.".txt","r");
	}else{
		$fileColors = fopen($dirRentalCalendar."monthNotCreated.txt","r");
	}
	$arrayColors = fgetcsv ($fileColors,1000,",");
	fclose($fileColors);
	for($i=0;$i<count($arrayColors);$i++){
		$arrayColors[$i] = explode("-",$arrayColors[$i]);
	}
	echo "<table><caption>".$arrayMonths[$month]." ".$year."</caption>";

	switch($lang){
		case "en":
			echo "<thead><tr>" .
					"<th>Mon</th>".
					"<th>Tue</th>".
					"<th>Wed</th>".
					"<th>Thu</th>".
					"<th>Fri</th>".
					"<th>Sat</th>".
					"<th>Sun</th>".
			"</tr></thead>";
		break;

		case "es":
		default:
			echo "<thead><tr>" .
					"<th>Lun</th>".
					"<th>Mar</th>".
					"<th>Mie</th>".
					"<th>Jue</th>".
					"<th>Vie</th>".
					"<th>Sab</th>".
					"<th>Dom</th>".
			"</tr></thead>";
		break;
	}

	echo "<tfoot><tr>";
				if(($autorizado) or ($year > date("Y",time())) or ($year == date("Y",time()) and ($month > date("m",time()))))
					echo "<td abbr='".$arrayMonths[$month]."' colspan='3' id='prev'><a href='rentalCalendar.php?appartment=".$appartment."&month=".$previousMonth."&year=".$previousYear."'>&laquo; ".$arrayMonths[$previousMonth]."</a></td>";
				else
					echo "<td abbr='".$arrayMonths[$month]."' colspan='3' id='prev'>&nbsp;</td>";

					echo "<td class='pad'>&nbsp;</td>" .
					"<td abbr='Septiembre' colspan='3' id='next' class='pad'><a href='rentalCalendar.php?appartment=".$appartment."&month=".$nextMonth."&year=".$nextYear."'>".$arrayMonths[$nextMonth]." &raquo;</a></td>" .
		"</tr></tfoot>";
	echo "<tbody>" .
			"<tr>";
	if($diaSemana != 0)
		echo "<td colspan='".$diaSemana."' class='pad'>&nbsp;</td>";

	$pos = $diaSemana+1;
	$col = 1;
	for($j=0;$j<$lastDay;$j++){

		if($arrayColors[$j][1] != 0){
			if($dirRentalCalendar == "rentalCalendar/")
				echo "<td id='".$arrayColors[$j][0]."'><a href='fichaCliente.php?id=".$arrayColors[$j][1]."'>".($j+1)."</a></td>\n";
			else
				echo "<td id='".$arrayColors[$j][0]."'>".($j+1)."</td>\n";
		}else{
			echo "<td id='".$arrayColors[$j][0]."'>".($j+1)."</td>\n";
		}

		if($pos == 7){
			echo "</tr>";
			$pos = 1;
			$col ++;
		}else{
			$pos++;
		}
	}
	if($pos < 8){
		echo "<td colspan='".(8 - $pos)."' class='pad'>&nbsp;</td>";
	}
	echo "</tr>";
	for($k=$col;$k<6;$k++)
		echo "<tr><td colspan='7' class='pad'>&nbsp;</td></tr>";
	echo "</tbody>" .
		"</table>";

}

function createCalendar($year){
	$dirCalendar = "rentalCalendar/";
	$nameFile = $dirCalendar."lastYear.txt";
	if(file_exists($nameFile)){
		$fileYear = fopen($nameFile,"r");
		$lastYear = (int) fgets($fileYear);
		fclose($fileYear);
	}else{
		$lastYear = 2003;
	}

	for($i=($lastYear+1);$i<=$year;$i++){
		createYear($i);
	}

	$fileYear = fopen($nameFile,"w");
	fwrite($fileYear,$year);
	fclose($fileYear);
}

function createYear($year){
	$dirCalendar = "rentalCalendar/";
	$appartment = new appartment();
	$arrayAppartment = $appartment->getArrayAppartment();
	for($i=0;$i<count($arrayAppartment);$i++){
		if(!file_exists($dirCalendar.$arrayAppartment[$i]."/".$year))
			mkdir($dirCalendar.$arrayAppartment[$i]."/".$year);
	}
	for($i=1;$i<=12;$i++){
		for($j=0;$j<count($arrayAppartment);$j++){
			createMonth($arrayAppartment[$j],$year,$i);
		}
	}
}

function createMonth($appartment,$year, $month){
	$dirCalendar = "rentalCalendar/";
	$lastDay = lastDay($year, $month);
	$linea = "libre-0";
	for($i=1;$i<$lastDay;$i++)
		$linea .= ",libre-0";
	if($month < 10)
		$month = "0".$month;
	if(file_exists($dirCalendar.$appartment."/".$year)){
		$file = fopen($dirCalendar.$appartment."/".$year."/".$month.".txt","w");
		fwrite($file,$linea);
		fclose($file);
	}else{
		echo "La carpeta no existe";
	}
}

function deleteRentalFolderTree(){
	$appartment = new appartment();
	$arrayAppartment = $appartment->getArrayAppartment();
	for($i=0;$i<count($arrayAppartment);$i++){
		recursiveFolderDelete("rentalCalendar/".$arrayAppartment[$i]);
		mkdir("rentalCalendar/".$arrayAppartment[$i]);
	}
	$file = fopen("rentalCalendar/lastYear.txt","w");
	fwrite($file,"2003");
	fclose($file);
}

function recursiveFolderDelete ( $folderPath )
{
    if ( is_dir ( $folderPath ) )
    {
        foreach ( scandir ( $folderPath )  as $value )
        {
            if ( $value != "." && $value != ".." )
            {
                $value = $folderPath . "/" . $value;

                if ( is_dir ( $value ) )
                {
                    recursiveFolderDelete ( $value );
                }
                elseif ( is_file ( $value ) )
                {
                    @unlink ( $value );
                }
            }
        }

        return rmdir ( $folderPath );
    }
    else
    {
        return false;
    }
}

function restoreRentalFolderTree(){
	$dirRentalCalendar = "./rentalCalendar/";
	$connectionMySQL = new connectionMySQL();
	$query = "select * from rental";
	$result = $connectionMySQL->request($query);
	while($row = mysql_fetch_array($result)){
		$action = "insert";
		$appartment = strtolower($row['appartment']);
		$date_start = $row['date_start'];
		$date_end = $row['date_end'];
		$id_client = $row['id_client'];
		modifyCalendar($dirRentalCalendar,$appartment,$date_start,$date_end,$action,$id_client);
	}
	$query = "select * from pre_rental where status='1'";
	$result = $connectionMySQL->request($query);
	while($row = mysql_fetch_array($result)){
		$action = "insertPreRental";
		$appartment = strtolower($row['appartment']);
		$date_start = $row['date_start'];
		$date_end = $row['date_end'];
		modifyCalendar($dirRentalCalendar,$appartment,$date_start,$date_end,$action);
	}
}

/*
 function scandir($dir,$order = NULL){
	$dh  = opendir($dir);
	while (false !== ($filename = readdir($dh))) {
	    $files[] = $filename;
	}
	if($order == NULL)
		$order = 0;
	switch($order){
		case "0":
			sort($files);
		break;
		case "1":
			rsort($files);
		break;
	}
	return $files;
}
*/

 function calculatePrice($date_start, $date_end, $num_pers,$dirPrecios){
 	$strtotime_date_start = strtotime($date_start);
 	$day1 = date("d",$strtotime_date_start);
 	$month1 = date("m",$strtotime_date_start);
 	$year1 = date("Y",$strtotime_date_start);

 	$strtotime_date_end = strtotime($date_end);
 	$day2 = date("d",$strtotime_date_end);
 	$month2 = date("m",$strtotime_date_end);
 	$year2 = date("Y",$strtotime_date_end);

	$daysSSyF = calculateTimeSSyF($day1, $month1, $year1, $day2, $month2, $year2);
	$times = calculateTime($day1, $month1, $year1, $day2, $month2, $year2);

	$numMonths = $times['months'] + $times['years']*12;
	$numDays = $times['days'];

	include($dirPrecios);

	switch($num_pers){
		case "1":
		case "2":
			if($numMonths > 0){
				$price = $priceMonths_1*$numMonths + $pricePlusMonths_1*$numDays;
			}else{
				$numWeeks = floor($numDays/7);
				$restDays = $numDays - $numWeeks*7;
				switch($numWeeks){
					case "4":
						$price = $price4Weeks_1 + $pricePlus4Weeks_1*$restDays;
					break;
					case "3":
						$price = $price3Weeks_1 + $pricePlus3Weeks_1*$restDays;
					break;
					case "2":
						$price = $price2Weeks_1 + $pricePlus2Weeks_1*$restDays;
					break;
					case "1":
						$price = $price1Week_1 + $pricePlus1Week_1*$restDays;//
					break;
					case "0":
						$price = $price1Week_1;
					break;
				}
			}
		break;

		case "3":

			if($numMonths > 0){
				$price = $priceMonths_2*$numMonths + $pricePlusMonths_2*$numDays;
			}else{
				$numWeeks = floor($numDays/7);
				$restDays = $numDays - $numWeeks*7;
				switch($numWeeks){
					case "4":
						$price = $price4Weeks_2 + $pricePlusMonths_2*$restDays;
					break;
					case "3":
						$price = $price3Weeks_2 + $pricePlus3Weeks_2*$restDays;
					break;
					case "2":
						$price = $price2Weeks_2 + $pricePlus3Weeks_2*$restDays;
					break;
					case "1":
						$price = $price1Week_2 + $pricePlus1Week_2*$restDays;
					break;
					case "0":
						$price = $price1Week_2;
					break;
				}
			}

		break;

		case "4":

			if($numMonths > 0){
				$price = $priceMonths_3*$numMonths + $pricePlusMonths_3*$numDays;
			}else{
				$numWeeks = floor($numDays/7);
				$restDays = $numDays - $numWeeks*7;
				switch($numWeeks){
					case "4":
						$price = $price4Weeks_3 + $pricePlusMonths_3*$restDays;
					break;
					case "3":
						$price = $price3Weeks_3 + $pricePlus3Weeks_3*$restDays;
					break;
					case "2":
						$price = $price2Weeks_3 + $pricePlus3Weeks_3*$restDays;
					break;
					case "1":
						$price = $price1Week_3 + $pricePlus1Week_3*$restDays;
					break;
					case "0":
						$price = $price1Week_3;
					break;
				}
			}

		break;
	}
	switch($numMonths){
		case "0":
		case "1":
		case "2":

			$price += $daysSSyF*$priceSSyF;

		break;

		case "3":

			$price += $daysSSyF*$priceSSyF*(0.9);

		break;

		case "4":

			$price += $daysSSyF*$priceSSyF*(0.8);

		break;

		case "5":

			$price += $daysSSyF*$priceSSyF*(0.7);

		break;

		default:

			$price += $daysSSyF*$priceSSyF*(0.5);

		break;


	}
	return (array("price"=>$price,"deposit"=>($price*0.2)));
 }

 function calculateTime($day1, $month1, $year1, $day2, $month2, $year2){
	$b = 0;
	$month = $month1 - 1;
	if($month==2){
		if(($year2%4==0 && $year2%100!=0) || $year2%400==0){
			$b = 29;
		}else{
			$b = 28;
		}
	}else if($month<=7){
		if($month==0){
			$b = 31;
		}else if($month%2==0){
			$b = 30;
		}else{
			$b = 31;
		}
	}else if($month>7){
	if($month%2==0){
			$b = 31;
		}else{
			$b = 30;
		}
	}if(($year1>$year2) || ($year1==$year2 && $month1>$month2) ||
	($year1==$year2 && $month1 == $month2 && $day1>$day2)){
		echo "La fecha de inicio ha de ser anterior a la fecha actual";
	}else{
		if($month1 <= $month2){
			$years = $year2 - $year1;
			if($day1 <= $day2){
				$months = $month2 - $month1;
				$days = $day2 - $day1;
			}else{
				if($month2 == $month1){
					$years = $years - 1;
				}
				$months = ($month2 - $month1 - 1 + 12) % 12;
				$days = $b-($day1-$day2);
			}
		}else{
			$years = $year2 - $year1 - 1;
			if($day1 > $day2){
				$months = $month2 - $month1 -1 +12;
				$days = $b - ($day1-$day2);
			}else{
			$months = $month2 - $month1 + 12;
				$days = $day2 - $day1;
			}
		}
		return (array("years"=>$years,"months"=>$months,"days"=>$days));
	}
 }

 function calculateTimeSSyF($day1, $month1, $year1, $day2, $month2, $year2){
	$daysSSyF = 0;
	if($year1 == $year2){
		$daysSSyF = calculateOverlapedDaysSSyF($year1, $day1, $month1, $day2, $month2);
	}else{
		$daysSSyF = calculateTimeSSyF($day1, $month1, $year1,'31','12',$year1);
		$daysSSyF += calculateTimeSSyF('1','1',($year1+1),$day2, $month2, $year2);
	}
	return $daysSSyF;
 }

 function calculateOverlapedDaysSSyF($year,$day1,$month1,$day2,$month2){
	$connectionMySQL = new connectionMySQL();
	$query = "select * from ssyf where year = '".$year."'";
	$result = $connectionMySQL->request($query);
	$row = mysql_fetch_array($result);
	$dateStartSS = $row['date_start_ss'];
	$dateEndSS = $row['date_end_ss'];
	$dateStartF = $row['date_start_f'];
	$dateEndF = $row['date_end_f'];

	$dateStart = $year."-".$month1."-".$day1;
	$dateEnd = $year."-".$month2."-".$day2;

	$overlapedDaysSSyF = calculateOverlapedDays($dateStartSS,$dateEndSS,$dateStart,$dateEnd);
	$overlapedDaysSSyF += calculateOverlapedDays($dateStartF,$dateEndF,$dateStart,$dateEnd);
	return $overlapedDaysSSyF;
 }

 function calculateOverlapedDays($dateStart1, $dateEnd1, $dateStart2, $dateEnd2){

 	$strtotimeDateStart1 = strtotime($dateStart1);
 	$strtotimeDateEnd1 = strtotime($dateEnd1);
 	$strtotimeDateStart2 = strtotime($dateStart2);
 	$strtotimeDateEnd2 = strtotime($dateEnd2);

 	$dayStart1 = date("d",$strtotimeDateStart1);
 	$dayEnd1 = date("d",$strtotimeDateEnd1);
 	$monthStart1 = date("m",$strtotimeDateStart1);
 	$monthEnd1 = date("m",$strtotimeDateEnd1);

 	$dayStart2 = date("d",$strtotimeDateStart2);
 	$dayEnd2 = date("d",$strtotimeDateEnd2);
 	$monthStart2 = date("m",$strtotimeDateStart2);
 	$monthEnd2 = date("m",$strtotimeDateEnd2);

 	$year = date("Y",$strtotimeDateStart1);

 	if(($strtotimeDateStart1 < $strtotimeDateStart2) and ($strtotimeDateEnd1 >= $strtotimeDateEnd2)){
 		$od =  calculateTime($dayStart2, $monthStart2, $year, $dayEnd2, $monthEnd2, $year);
 	}else if(($strtotimeDateStart1 > $strtotimeDateStart2) and ($strtotimeDateEnd1 < $strtotimeDateEnd2)){
 		$od =  calculateTime($dayStart1, $monthStart1, $year, $dayEnd1, $monthEnd1, $year);
 		$od['days']++;
 	}else if(($strtotimeDateStart1 >= $strtotimeDateStart2) and ($strtotimeDateEnd1 >= $strtotimeDateEnd2) and ($strtotimeDateStart1 < $strtotimeDateEnd2)){
 		$od = calculateTime($dayStart1, $monthStart1, $year, $dayEnd2, $monthEnd2, $year);
 	}else if(($strtotimeDateEnd1 >= $strtotimeDateStart2) and ($strtotimeDateEnd1 < $strtotimeDateEnd2) and ($strtotimeDateEnd1 > $strtotimeDateStart2)){
 		$od = calculateTime($dayStart2, $monthStart2, $year, $dayEnd1, $monthEnd1, $year);
 		$od['days']++;
 	}else{
 		return 0;
 	}

 	return $od['days'];
  }

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
	$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
	$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

	switch ($theType) {
		case "text":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		break;
		case "long":
		case "int":
			$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		break;
		case "double":
			$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
		break;
		case "date":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		break;
		case "defined":
			$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
		break;
	}
	return $theValue;
}

function validateEmail($email){
	if (1){//preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email)){
		return true;
	}else{
		return false;
	}
}
?>
