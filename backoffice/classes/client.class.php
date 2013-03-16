<?php

class client {

   	var $id;
   	var $passport;
	var $name;
	var $nationality;
	var $email;
	var $telephone;
	var $comments;
	var $num_rent;

    function client($id = NULL, $passport = NULL,$name = NULL,$nationality = NULL,$email = NULL,$telephone = NULL,$comments = NULL,$num_rent = NULL) {
    	$this->id = $id;
    	$this->passport = $passport;
		$this->name = strtolower(strtolower($name));
		$this->nationality = strtolower($nationality);
		$this->email = strtolower($email);
		$this->telephone = $telephone;
		$this->comments = strtolower($comments);
		$this->num_rent = $num_rent;
    }

    function insert(){
		$connection = new connectionMySQL();
		$query_insert = "insert into client (passport,name,nationality,email,telephone,comments,num_rent) values ('".$this->passport."','".$this->name."','".$this->nationality."','".$this->email."','".$this->telephone."','".$this->comments."',0)";
		$connection->connect();
		$connection->massive_insert($query_insert);
		$id = mysql_insert_id();
		$connection->disconnect();
		return $id;
	}

	function modify(){
		if($this->id != NULL){
			$query_modify = "update client set passport = '".$this->passport."', name='".$this->name."', nationality='".$this->nationality."', email='".$this->email."', telephone='".$this->telephone."', comments='".$this->comments."' where id = '".$this->id."'";
			$connection = new connectionMySQL();
			$connection->insert($query_modify);
		}
		else
			echo "<br>Error al modificar los datos del cliente (ID NULL)";
	}

	function delete(){
		if($this->id != NULL){
			$rentals = new rental($this->id);
			$rentals->deleteAll();
			$query_delete = "delete from client where id = '".$this->id."'";
			$connection = new connectionMySQL();
			$connection->insert($query_delete);
		}
		else
			echo "<br>Error al eliminar el cliente (ID NULL)";
	}

	function getClient($id){
		if($id != NULL){
		    $connection = new connectionMySQL();

			$query_get = "select * from client where id = '".$id."'";
			$result = $connection->request($query_get);
			$row = mysql_fetch_array($result);

			$this->id = $row['id'];
			$this->passport = $row['passport'];
			$this->name = $row['name'];
			$this->nationality = $row['nationality'];
			$this->email = $row['email'];
			$this->telephone = $row['telephone'];
			$this->comments = $row['comments'];
			$this->num_rent = $row['num_rent'];
		}
		else
			echo "<br>Error al recuperar los datos del cliente (ID NULL)";
	}

	function addRental(){
		if($this->id != NULL){
		    $connection = new connectionMySQL();
		    $query = "update client set num_rent = (num_rent + 1) where id = '".$this->id."'";
		    $connection->insert($query);
		}else{
			echo "<br>Error al aumentar el n&uacute;mero de alquileres del cliente (ID CLIENT NULL)";
		}
	}

	function deleteRental(){
		if($this->id != NULL){
		    $connection = new connectionMySQL();
		    $query = "update client set num_rent = (num_rent - 1) where id = '".$this->id."'";
		    $connection->insert($query);
		}else{
			echo "<br>Error al disminuir el n&uacute;mero de alquileres del cliente (ID CLIENT NULL)";
		}
	}
}
?>