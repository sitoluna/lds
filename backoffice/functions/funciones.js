// JavaScript Document

function nuevoAjax(){
	var xmlhttp=false;
	try{
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}catch(e){
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}catch(E){
			xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function buscarDato(){
	foco = 0;
	resul = document.getElementById('resultado');
	bus = document.frmbusqueda.dato.value;
	order = document.getElementById('order').value;
	ajax=nuevoAjax();
	ajax.open("POST", "tratamientoBusquedaCliente.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			resul.innerHTML = ajax.responseText
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("search="+bus+"&order="+order);
}

function calcularPrecio(){
	price = document.getElementById('price');
	deposit = document.getElementById('deposit');
	date_start = document.getElementById('campo_fecha').value;
	date_end = document.getElementById('campo_fecha2').value;
	num_pers = document.getElementById('num_pers').value;
	ajax=nuevoAjax();
	ajax.open("POST", "tratamientoCalculaPrecio.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			price.value = ajax.responseText;
			deposit.value = (price.value*0.2);
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("date_start="+date_start+"&date_end="+date_end+"&num_pers="+num_pers);
}

function verifyPassword(){
	var res=false;
	var npass1=document.getElementById("npass1").value;
	var npass2=document.getElementById("npass2").value;
	var pass=document.getElementById("pass").value;

	var er=/([a-z]|[A-Z]|[0-9])+/;
	var f1= er.exec(npass1);
	var f2= er.exec(npass2);
	var f3= er.exec(pass);

	if(f1 && f2 && f3 && (npass1==npass2))
		res=true;
	else
		alert("Debe rellenar todos los campos y la nueva clave ha de introducirla 2 veces ...");
	return res;
}

function muestraSiguiente(focus, total_rows, num_rows){

	if((num_rows*(focus+2)) >= total_rows){
		document.getElementById('img_sig').src = "";
	}

	document.getElementById('div_'+(foco)).style.display = 'none';
	document.getElementById('div_'+(foco+1)).style.display = 'block';
	foco = foco+1;
	document.getElementById('img_ant').src = "images/anterior.jpg";


}

function muestraAnterior(focus){

	if(focus == 1){
		document.getElementById('img_ant').src = "";
	}

	document.getElementById('div_'+(foco)).style.display = 'none';
	document.getElementById('div_'+(foco-1)).style.display = 'block';
	foco = foco-1;
	document.getElementById('img_sig').src = "images/siguiente.jpg";


}