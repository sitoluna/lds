<?php

class connectionMySQL {

    var $host;
	var $user;
	var $pass;
	var $bdd;
	var $dbb;
	var $nom_connection;

    function connectionMySQL() {
    	include ("conf.secu.php");
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->bdd = $bdd;
    }

    function request($query){
    	if($this->nom_connection = mysql_connect($this->host, $this->user, $this->pass)) {
			if($dbb = mysql_select_db($this->bdd)){
				$result = mysql_query($query)or die ( "Imposible de ejecutar la petici&oacute;n <BR>".$query."<BR>" .mysql_error());
				mysql_close($this->nom_connection);
				return $result;
			}
			else
			{
				echo "Conexi&oacute;n a la base <b>".$this->bdd."</b> imposible";
				return "Conexi&oacute;n a la base <b>".$this->bdd."</b> imposible";
			}
		}
		else
		{
			echo "Conexi&oacute;n a la base <b>".$this->bdd."</b> imposible";
			return "Conexi&oacute;n a la base <b>".$this->bdd."</b> imposible";
		}
    }

    function massive_request($query){
		$result = mysql_query($query)or die ( "Imposible de ejecutar la peticion <BR>".$query."<BR>" .mysql_error());
		return $result;
	}

	function insert($query){
    	if($this->nom_connection = mysql_connect($this->host, $this->user, $this->pass)) {
			if($dbb = mysql_select_db($this->bdd)){
				mysql_query($query) or die ( "Imposible de ejecutar la petici&oacute;n <BR>".$query."<BR>" .mysql_error());
				mysql_close($this->nom_connection);
			}
			else{
				echo "Conexi&oacute;n a la base <b>".$this->bdd."</b> imposible";
				return "Conexi&oacute;n a la base <b>".$this->bdd."</b> imposible";
			}
		}
		else{
			echo "Conexi&oacute;n a la base <b>".$this->bdd."</b> imposible";
			return "Conexi&oacute;n a la base <b>".$this->bdd."</b> imposible";
		}
	}

	function massive_insert($query){
		mysql_query($query)or die ( "Imposible de ejecutar la peticion <BR>".$query."<BR>" .mysql_error());
	}

	function connect(){
		if($this->nom_connection = mysql_connect($this->host, $this->user, $this->pass)) {
			if($this->dbb = mysql_select_db($this->bdd)){
				return true;
			}
			else{
				echo "Conexi&oacute;n a la base <b>".$this->bdd."</b> imposible";
			}
		}
		else{
			echo "Conexi&oacute;n a la base <b>".$this->bdd."</b> imposible";
		}
	}

	function disconnect(){
		mysql_close($this->nom_connection);
	}
}
?>