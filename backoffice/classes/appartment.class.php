<?php

class appartment {

	var $id_ap;
	var $name_ap;

    function appartment() {

    }

    function getArrayAppartment(){
    	$connectionMySQL = new connectionMySQL();
    	$query = "select * from appartment";
    	$result = $connectionMySQL->request($query);
    	$arrayAppartment = array();
    	while($row = mysql_fetch_array($result)){
    		array_push($arrayAppartment,$row['name_ap']);
    	}
    	return $arrayAppartment;
    }
}
?>