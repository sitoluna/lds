<?php

class pre_rental {

	var $id_pre_rental;
	var $name;
	var $email;
	var $telephone;
	var $nationality;
	var $date_start;
	var $date_end;
	var $appartment;
	var $num_pers;
	var $price;
	var $deposit;
	var $status;
	var $date_pre_rental;
	var $date_wait_deposit;
	var $date_deposit;
	var $date_cancelled;
	var $language;

    function pre_rental($name = NULL, $email = NULL, $telephone = NULL, $nationality = NULL, $date_start = NULL, $date_end = NULL, $appartment = NULL, $num_pers = NULL, $price = NULL, $deposit = NULL, $language = "es") {
		$this->name = strtolower($name);
		$this->email = strtolower($email);
		$this->telephone = $telephone;
		$this->nationality = strtolower($nationality);
		$this->date_start = $date_start;
		$this->date_end = $date_end;
		$this->appartment = strtolower($appartment);
		$this->num_pers = $num_pers;
		$this->price = $price;
		$this->deposit = $deposit;
		$this->language = $language;
    }


		function insert(){
		if($this->name != "" and $this->email != "" and $this->date_start != "" and $this->date_end != "" and $this->appartment != "" and $this->num_pers != "" and $this->price != "" and $this->deposit != ""){
			$connectionMySQL = new connectionMySQL();
			$connectionMySQL->connect();
			$dateTime = date("Y-m-d H:i:s",time());
			$query = sprintf("insert into pre_rental (name, email, telephone, nationality, date_start, date_end, appartment, num_pers, price, deposit, date_pre_rental, language) " .
					"values ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					GetSQLValueString($this->name,"text"),
					GetSQLValueString($this->email,"text"),
					GetSQLValueString($this->telephone,"text"),
					GetSQLValueString($this->nationality,"text"),
					GetSQLValueString($this->date_start,"date"),
					GetSQLValueString($this->date_end,"date"),
					GetSQLValueString($this->appartment,"text"),
					GetSQLValueString($this->num_pers,"int"),
					GetSQLValueString($this->price,"int"),
					GetSQLValueString($this->deposit,"double"),
					GetSQLValueString($dateTime,"text"),
					GetSQLValueString($this->language,"text"));
			$connectionMySQL->massive_insert($query);
			$id_pre_rental = mysql_insert_id();
			$connectionMySQL->disconnect();
			$this->id_pre_rental = $id_pre_rental;
			$email = new email($this,"requestConfirmation", $this->language);
			$email->send();
			return $id_pre_rental;
		}else{
			echo "<br/>Error insertando la pre-reserva, los campos marcados con (*) son obligatorios.";
		}
	}


	function getPreRental($id_pre_rental){
		$connectionMySQL = new connectionMySQL();
		$query = "select * from pre_rental where id_pre_rental = '".$id_pre_rental."'";
		$result = $connectionMySQL->request($query);
		if(mysql_num_rows($result) < 1){
			"<br/>Error, no se ha encontrado ninguna pre-reserva con ese identificador.";
		}else{
			$row = mysql_fetch_array($result);
			$this->id_pre_rental = $row['id_pre_rental'];
			$this->name = $row['name'];
			$this->email = $row['email'];
			$this->telephone = $row['telephone'];
			$this->nationality = $row['nationality'];
			$this->date_start = $row['date_start'];
			$this->date_end = $row['date_end'];
			$this->appartment = $row['appartment'];
			$this->num_pers = $row['num_pers'];
			$this->price = $row['price'];
			$this->deposit = $row['deposit'];
			$this->date_pre_rental = $row['date_pre_rental'];
			$this->date_wait_deposit = $row['date_wait_deposit'];
			$this->date_deposit = $row['date_deposit'];
			$this->date_cancelled = $row['date_cancelled'];
			$this->status = $row['status'];
			$this->language = $row['language'];
		}
	}

	function getArrayPreRental($status, $ini = NULL, $num_rows = NULL){
		$arrayPreRental = array();
		if(!empty($num_rows)){
			$limit = " limit ".$ini.",".$num_rows;
		}else{
			$limit = "";
		}
		switch($status){
			case "0":
				$query = "select * from pre_rental where status = '0' and activate = '1' ".$limit;
			break;
			case "1":
				$query = "select * from pre_rental where status = '1' ".$limit;
			break;
			case "2":
				$query = "select * from pre_rental where status = '2' ".$limit;
			break;
			case "3":
			case "4":
				$query = "select * from pre_rental where status = '3' or status = '4' ".$limit;
			break;
		}
		$connectionMySQL = new connectionMySQL();
		$result = $connectionMySQL->request($query);
		if(mysql_num_rows($result)>0){
			while($row = mysql_fetch_array($result)){
				array_push($arrayPreRental,array("id_pre_rental"=>$row['id_pre_rental'],"name"=>$row['name'],"email"=>$row['email'],"telephone"=>$row['telephone'],"nationality"=>$row['nationality'],"date_start"=>$row['date_start'],"date_end"=>$row['date_end'],"appartment"=>$row['appartment'],"num_pers"=>$row['num_pers'],"price"=>$row['price'],"deposit"=>$row['deposit'],"status"=>$row['status'],"date_pre_rental"=>$row['date_pre_rental'],"date_wait_deposit"=>$row['date_wait_deposit'],"date_deposit"=>$row['date_deposit'],"date_cancelled"=>$row['date_cancelled']));
			}
		}
		return $arrayPreRental;
	}

	function changeStatus($newStatus){
		if($this->id_pre_rental != NULL and $this->id_pre_rental != ""){
			switch($newStatus){
				case "1":
					$update_date = ", date_wait_deposit = '".date("Y-m-d H:i:s",time())."'";
					$this->getPreRental($this->id_pre_rental);
					modifyCalendar("rentalCalendar/",$this->appartment,$this->date_start,$this->date_end,"insertPreRental");
					$email = new email($this,"insertPreRental", $this->language);
					$email->send();
				break;
				case "2":
					$update_date = ", date_deposit = '".date("Y-m-d H:i:s",time())."'";
					$this->getPreRental($this->id_pre_rental);
					$client = new client("","",$this->name,$this->nationality,$this->email,$this->telephone);
					$idClient = $client->insert();
					$rental = new rental($idClient,"",$this->date_start,$this->date_end,$this->appartment,$this->num_pers,"08h00","08h00",$this->deposit,$this->price,"");
					$rental->insert();
					modifyCalendar("rentalCalendar/",$this->appartment,$this->date_start,$this->date_end,"acceptPreRental",$idClient);
					$email = new email($this,"acceptPreRental", $this->language);
					$email->send();
				break;
				case "3":
					$update_date = ", date_cancelled = '".date("Y-m-d H:i:s",time())."'";
					$email = new email($this,"deniedPreRental", $this->language);
					$email->send();
				break;
				case "4":
					$this->getPreRental($this->id_pre_rental);
					modifyCalendar("rentalCalendar/",$this->appartment,$this->date_start,$this->date_end,"deletePreRental");
					$update_date = ", date_cancelled = '".date("Y-m-d H:i:s",time())."'";
					$email = new email($this,"deletePreRental", $this->language);
					$email->send();
				break;
			}
			$connectionMySQL = new connectionMySQL();
			$query = "update pre_rental set status = '".$newStatus."'".$update_date." where id_pre_rental = '".$this->id_pre_rental."'";
			$connectionMySQL->insert($query);

		}else{
			"<br/>Error, se necesita el identificador de la pre-reserva para cambiar su status.";
		}
	}

	function activatePreRental($id_pre_rental){
		$connectionMySQL = new connectionMySQL();
		$query = "select * from pre_rental where id_pre_rental = '".$id_pre_rental."' and activate = '0'";
		creaLog("select * from pre_rental where id_pre_rental = '".$id_pre_rental."' and activate = '0'");
		$result = $connectionMySQL->request($query);
		if(mysql_num_rows($result) == 1){
			$query = "update pre_rental set activate = '1' where id_pre_rental = '".$id_pre_rental."'";
			$connectionMySQL->insert($query);
			return true;
		}else{
			return false;
		}
	}

	function getNumberNews(){
		$connectionMySQL = new connectionMySQL();
		$query = "select count(*) from pre_rental where status = '0' and activate = '1'";
		$result = $connectionMySQL->request($query);
		$row = mysql_fetch_array($result);
		return $row[0];
	}

}
?>
