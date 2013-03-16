<?php

class rental {

    var $id_client;
	var $id_rental;
	var $date_start;
	var $date_end;
	var $appartment;
	var $num_pers;
	var $time_entry;
	var $time_exit;
	var $deposit;
	var $price;
	var $comments;
	var $electricity_start;
	var $electricity_end;
	var $water_start;
	var $water_end;

    function rental($id_client = NULL, $id_rental = NULL, $date_start = NULL, $date_end = NULL, $appartment = NULL, $num_pers = NULL, $time_entry = NULL, $time_exit = NULL, $deposit = NULL, $price = NULL, $comments = NULL, $electricity_start = NULL, $electricity_end = NULL, $water_start = NULL, $water_end = NULL) {
		$this->id_client = $id_client;
		$this->id_rental = $id_rental;
		$this->date_start = $date_start;
		$this->date_end = $date_end;
		$this->appartment = $appartment;
		$this->num_pers = $num_pers;
		$this->time_entry = $time_entry;
		$this->time_exit = $time_exit;
		$this->deposit = $deposit;
		$this->price = $price;
		$this->comments = strtolower($comments);
		$this->electricity_start = $electricity_start;
		$this->electricity_end = $electricity_end;
		$this->water_start = $water_start;
		$this->water_end = $water_end;

    }

    function insert(){
		$connection = new connectionMySQL();
		if($this->id_client != NULL and $this->date_start != NULL){
			$query = "select max(id_rental)as max_id_rental from rental where id_client = '".$this->id_client."'";
			$result = $connection->request($query);
			$row = mysql_fetch_array($result);
			if($row['max_id_rental'] == NULL)
				$this->id_rental = 1;
			else
				$this->id_rental = $row['max_id_rental']+1;
			$query2 = "insert into rental (id_client,id_rental,date_start,date_end,appartment,num_pers,time_entry,time_exit,deposit,price,comments,electricity_start,electricity_end,water_start,water_end) values ('".$this->id_client."','".$this->id_rental."','".$this->date_start."','".$this->date_end."','".$this->appartment."','".$this->num_pers."','".$this->time_entry."','".$this->time_exit."','".$this->deposit."','".$this->price."','".$this->comments."','".$this->electricity_start."','".$this->electricity_end."','".$this->water_start."','".$this->water_end."')";
			$connection->insert($query2);
			$client_insert = new client($this->id_client);
			$client_insert->addRental();
			modifyCalendar("rentalCalendar/",$this->appartment,$this->date_start,$this->date_end,"insert",$this->id_client);
		}
		else
			echo "<br>Para insertar un alquiler se ha de tener el id del cliente y la fecha de entrada";
	}

	function modify(){
		if($this->id_client != NULL and $this->id_rental != NULL){
			modifyCalendar("rentalCalendar/",$this->appartment,$this->date_start,$this->date_end,"modify",$this->id_client,$this->id_rental);
			$query = "update rental set date_start='".$this->date_start."', date_end='".$this->date_end."', appartment='".$this->appartment."', num_pers='".$this->num_pers."', time_entry='".$this->time_entry."', time_exit='".$this->time_exit."', deposit='".$this->deposit."', price='".$this->price."', comments='".$this->comments."', electricity_start='".$this->electricity_start."', electricity_end='".$this->electricity_end."', water_start='".$this->water_start."', water_end='".$this->water_end."' where id_client = '".$this->id_client."' and id_rental = '".$this->id_rental."'";
			$connection = new connectionMySQL();
			$connection->insert($query);
		}
		else
			echo "<br>Para modificar un alquiler se ha de tener el id del cliente y el id de alquiler";
	}

	function delete(){
		if($this->id_client != NULL and $this->id_rental != NULL){
			$this->getRental($this->id_client,$this->id_rental);
			$query = "delete from rental where id_client ='".$this->id_client."' and id_rental = '".$this->id_rental."'";
			$connection = new connectionMySQL();
			$connection->insert($query);
			$client_delete = new client($this->id_client);
			$client_delete->deleteRental();
			modifyCalendar("rentalCalendar/",$this->appartment,$this->date_start,$this->date_end,"delete");
		}
		else
			echo "<br>Para eliminar un alquiler se ha de tener el id del cliente y el id de alquiler";
	}

	function deleteAll(){
		if($this->id_client != NULL){
			modifyCalendar("rentalCalendar/","","","","deleteAll",$this->id_client);
			$query = "delete from rental where id_client ='".$this->id_client."'";
			$connection = new connectionMySQL();
			$connection->insert($query);
		}
		else
			echo "<br>Para eliminar todos los alquileres se ha de tener el id del cliente";
	}

	function getRental($id_client, $id_rental = NULL){
		if($id_client != NULL and $id_rental == NULL){
			$query = "select * from rental where id_client = '".$id_client."'";
			$connection = new connectionMySQL();
			$result = $connection->request($query);
			$array_rental = array();
			while($row = mysql_fetch_array($result)){
				array_push($array_rental, array("id_client"=>$row['id_client'], "id_rental"=>$row['id_rental'],"date_start"=>$row['date_start'],"date_end"=>$row['date_end'],"appartment"=>$row['appartment'],"num_pers"=>$row['num_pers'],"time_entry"=>$row['time_entry'],"time_exit"=>$row['time_exit'],"deposit"=>$row['deposit'],"price"=>$row['price'],"comments"=>$row['comments'],"electricity_start"=>$row['electricity_start'],"electricity_end"=>$row['electricity_end'],"water_start"=>$row['water_start'],"water_end"=>$row['water_end']));
			}
			return $array_rental;
		}else if($id_client != NULL and $id_rental != NULL){
			$query = "select * from rental where id_client = '".$id_client."' and id_rental='".$id_rental."'";
			$connection = new connectionMySQL();
			$result = $connection->request($query);
			$row = mysql_fetch_array($result);

			$this->id_client = $row['id_client'];
			$this->id_rental = $row['id_rental'];
			$this->date_start = $row['date_start'];
			$this->date_end = $row['date_end'];
			$this->appartment = $row['appartment'];
			$this->num_pers = $row['num_pers'];
			$this->time_entry = $row['time_entry'];
			$this->time_exit = $row['time_exit'];
			$this->deposit = $row['deposit'];
			$this->price = $row['price'];
			$this->comments = $row['comments'];
			$this->electricity_start = $row['electricity_start'];
			$this->electricity_end = $row['electricity_end'];
			$this->water_start = $row['water_start'];
			$this->water_end = $row['water_end'];
		}
		else
			echo "<br>Para recuperar un alquiler se ha de tener al menos el id del cliente";
	}

	function getNextIdRental($id_client){
		$query = "select max(id_rental) as maxIdRental from rental where id_client = '".$id_client."'";
		$connection = new connectionMySQL();
		$result = $connection->request($query);
		$row = mysql_fetch_array($result);
		if($row['maxIdRental'] == NULL)
			return 1;
		else
			return $row['maxIdRental']+1;
	}
}
?>