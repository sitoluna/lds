<?php
include("../backoffice/functions/functions.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<meta name="description" content="description">
	<meta name="keywords" content="keywords">
	<meta name="author" content="author">
	<link rel="stylesheet" type="text/css" href="../default.css" media="screen">

    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAgiSVMgv7J5bkz3vQCBHxpBSyH-JF5RdhWuH8g5pWJHphzmFpzhSkOa0XrMnVj0Cu-2yw8kgJC6Sv5Q"
      type="text/javascript"></script>

    <script type="text/javascript">

	function initialize() {

	image_1 = new Image();
	image_1.src = '../images/apartamentos.jpg';

	image_2 = new Image();
	image_2.src = '../images/alcazar.jpg';

	image_3 = new Image();
	image_3.src = '../images/archivo_indias.jpg';

	image_4 = new Image();
	image_4.src = '../images/arco_macarena.jpg';

	image_5 = new Image();
	image_5.src = '../images/catedral.jpg';

	image_6 = new Image();
	image_6.src = '../images/maestranza.jpg';

	image_7 = new Image();
	image_7.src = '../images/torre_oro.jpg';

	image_8 = new Image();
	image_8.src = '../images/parlamento.jpg';

	image_9 = new Image();
	image_9.src = '../images/palacio_duenas.jpg';

	image_10 = new Image();
	image_10.src = '../images/casa_pilatos.jpg';

	image_11 = new Image();
	image_11.src = '../images/plaza_nueva.jpg';


      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(37.393891307773984, -5.993556976318359), 14);
        map.addControl(new GMapTypeControl());
		map.addControl(new GLargeMapControl());

        // Create a base icon for all of our markers that specifies the
        // shadow, icon dimensions, etc.
        var baseIcon = new GIcon();
        baseIcon.iconSize = new GSize(22, 22);
        baseIcon.iconAnchor = new GPoint(11, 11);
        baseIcon.infoWindowAnchor = new GPoint(9, 2);

        // Creates a marker whose info window displays the letter corresponding
        // to the given index.
        function createMarker(point, titulo, image, ancho, alto, flag) {
          // Create a lettered icon for this point using our icon class
          var viewIcon = new GIcon(baseIcon);
          if(flag)
          	viewIcon.image = "../images/camera.png";
		  else
          	viewIcon.image = "../images/home.png";

          // Set up our GMarkerOptions object
          markerOptions = { icon:viewIcon };
          var marker = new GMarker(point, markerOptions);

          GEvent.addListener(marker, "click", function() {
            marker.openInfoWindowHtml("<div><h3>"+titulo+"</h3><img src=\""+image+"\"/></div>");
          });
          return marker;
        }

        // Add 1 marker to the map

        var latlng1 = new GLatLng(37.39822129288199, -5.990370512008667);
        map.addOverlay(createMarker(latlng1, 'Apartamentos', image_1.src, image_1.width, image_1.height, 0));

        var latlng2 = new GLatLng(37.384164976600424, -5.991625785827637);
        map.addOverlay(createMarker(latlng2, 'Alcazar', image_2.src, image_2.width, image_2.height, 1));

        var latlng3 = new GLatLng(37.383833, -5.991556);
        map.addOverlay(createMarker(latlng3, 'Archivo de Indias', image_3.src, image_3.width, image_3.height, 1));

        var latlng4 = new GLatLng(37.40282375867029, -5.989136695861816);
        map.addOverlay(createMarker(latlng4, 'Arco de la Macarena', image_4.src, image_4.width, image_4.height, 1));

        var latlng5 = new GLatLng(37.38586142143849, -5.993020534515381);
        map.addOverlay(createMarker(latlng5, 'Catedral', image_5.src, image_5.width, image_5.height, 1));

        var latlng6 = new GLatLng(37.386031916284516, -5.998406410217285);
        map.addOverlay(createMarker(latlng6, 'Maestranza', image_6.src, image_6.width, image_6.height, 1));

        var latlng7 = new GLatLng(37.38243439282155, -5.996185541152954);
        map.addOverlay(createMarker(latlng7, 'Torre del Oro', image_7.src, image_7.width, image_7.height, 1));

        var latlng8 = new GLatLng(37.40484364051082, -5.988321304321289);
        map.addOverlay(createMarker(latlng8, 'Parlamento', image_8.src, image_8.width, image_8.height, 1));

        var latlng9 = new GLatLng(37.395468201390514, -5.9892332553863525);
        map.addOverlay(createMarker(latlng9, 'Palacio de las Due&ntilde;as', image_9.src, image_9.width, image_9.height, 1));

        var latlng10 = new GLatLng(37.38967188874778, -5.987699031829834);
        map.addOverlay(createMarker(latlng10, 'Casa Pilatos', image_10.src, image_10.width, image_10.height, 1));

        var latlng11 = new GLatLng(37.388674536821256, -5.995520353317261);
        map.addOverlay(createMarker(latlng11, 'Plaza Nueva', image_11.src, image_11.width, image_11.height, 1));

       }
    }
    </script>
	<title>LunaDeSevilla - Location Apartments</title>
</head>
<body onload="initialize()" onunload="GUnload()">

<div class="container">

	<div class="main">

		<?php include("header.php"); ?>

		<div class="content">

			<div class="item">
				<h1>Location Apartments</h1>
				<p>Apartments located in Pedro Miguel street, zip code 41003, Seville.</p>
				<div id="map_canvas" style="width: 500px; height: 400px"></div>
			</div>

		</div>

		<div class="sidenav">

		<?php include("menu.php"); ?>

		<br/>
		<h1>Leyenda:</h1>

		<table>
			<tr valign="middle">
				<td><img src="../images/home.png"/></td><td>: Apartments LunaDeSevilla</td>
			</tr>
			<tr valign="middle">
				<td><img src="../images/camera.png"/></td><td>: Monuments and places to visit</td>
			</tr>
		</table>

		</div>

		<div class="clearer"><span></span></div>
		</div>

		<div class="footer">&copy; 2007 <a href="index.php">lunadesevilla.es</a>.Valid <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>&amp; <a href="http://validator.w3.org/check?uri=referer">XHTML</a>.Template design by Alfonso Luna
		</div>

	</div>
</body>
</html>
