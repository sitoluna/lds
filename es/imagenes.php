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
	<script type="text/javascript" language="javascript" src="../easyGallery/lytebox/lytebox.js"></script>

	<script>
	<!--
	var zoom = 4;
	var speed = 4;
	var real = 0;
	var intervalIn;
	var divs = document.getElementsByTagName('div');
	for (var i=0; i<divs.length; i++)
	{
	  if (divs[i].id == 'livethumbnail')
	  {
		var myimg = divs[i].getElementsByTagName('img')[0];
		myimg.smallSrc = myimg.getAttribute('src');
		myimg.smallWidth = parseInt(myimg.getAttribute('width'));
		myimg.smallHeight = parseInt(myimg.getAttribute('height'));
		divs[i].onmouseover = scaleIn;
		divs[i].onmouseout = scaleOut;
		if (!myimg.smallWidth)
	    {
	    <?php
	    if (isset($image)){
		  if ($image[0] > $image[1])
		  {
	        echo "myimg.smallWidth = $image[0];\n";
	        echo "myimg.smallHeight = $image[1];\n";
	      }
	      else
		  {
	        echo "myimg.smallWidth = $image[1];\n";
	 	    echo "myimg.smallHeight = $image[0];\n";
	      }
		}
	    ?>
	      real = 0;
	    }
	    else
	    {
	  	  real = 1;
	    }
	  }
	}

	function scaleIn()
	{
	  var myimg = this.getElementsByTagName('img')[0];
	  this.style.zIndex = 20;
	  myimg.src = myimg.smallSrc;
	  var count = 0;
	  var real = 0;
	  intervalIn = window.setInterval(scaleStepIn, 1);
	  return false;

	  function scaleStepIn()
	  {
		var widthIn = parseInt(myimg.style['width']);
		var heightIn = parseInt(myimg.style['height']);
		var topIn = parseInt(myimg.style['top']);
		var leftIn = parseInt(myimg.style['left']);
		if(widthIn >= heightIn) {
		  widthIn += speed;
		  heightIn += Math.floor(speed * (3/4));
		  topIn -= (Math.floor(speed * (3/8)));
		  leftIn -= (speed/2);
		}
		else
		{
		  widthIn += Math.floor(speed * (3/4));
		  heightIn += speed;
		  topIn -= (speed/2);
		  leftIn -= (Math.floor(speed * (3/8)));
		}
		myimg.style['width'] = widthIn;
		myimg.style['height'] = heightIn;
		myimg.style['top'] = topIn;
		myimg.style['left'] = leftIn;
		count++;
		if (count >= zoom)
		  window.clearInterval(intervalIn);
	  }
	}
	function scaleOut()
	{
	  window.clearInterval(intervalIn);
	  var myimg = this.getElementsByTagName('img')[0];
	  myimg.src = myimg.smallSrc;
	  this.style.zIndex = 10;
	  var mydiv = this;
	  var interval = window.setInterval(scaleStepOut, 1);
	  return false;

	  function scaleStepOut()
	  {
		var width = parseInt(myimg.style['width']);
		var height = parseInt(myimg.style['height']);
		var top = parseInt(myimg.style['top']);
		var left = parseInt(myimg.style['left']);
		if(width >= height) {
		  width -= speed;
		  height -= Math.floor(speed * (3/4));
	  	  if(width < myimg.smallWidth + 4) {
		    myimg.style['width'] = myimg.smallWidth;
		    myimg.style['height'] = myimg.smallHeight;
		    myimg.style['top'] = 0;
		    myimg.style['left'] = 0;
			mydiv.style['zIndex'] = 1;
			window.clearInterval(interval);
		  }
		  else{
		    myimg.style['width'] = width;
		    myimg.style['height'] = height;
		    myimg.style['left'] = left + (speed/2);
		    myimg.style['top'] = top + (Math.floor(speed * (3/8)));
		  }
		}
		else
		{
		  width -= Math.floor(speed * (3/4));
		  height -= speed;
		  if(real==1)
		  {
		    if(width < myimg.smallWidth + 4)
		    {
		      myimg.style['width'] = myimg.smallWidth;
		      myimg.style['height'] = myimg.smallHeight;
			  myimg.style['top'] = 0;
		      myimg.style['left'] = 0;
			  mydiv.style['zIndex'] = 1;
		      window.clearInterval(interval);
			}
			else{
			  myimg.style['width'] = width;
		      myimg.style['height'] = height;
		      myimg.style['top'] = top + (speed/2);
		      myimg.style['left'] = left + (Math.floor(speed * (3/8)));
			}
		  }
		  else
		  {
		  	if(height < myimg.smallWidth + 4)
		    {
		      myimg.style['width'] = myimg.smallHeight;
		      myimg.style['height'] = myimg.smallWidth;
			  myimg.style['top'] = 0;
		      myimg.style['left'] = 0;
			  mydiv.style['zIndex'] = 1;
		      window.clearInterval(interval);
			}
			else{
			  myimg.style['width'] = width;
		      myimg.style['height'] = height;
		      myimg.style['top'] = top + (speed/2);
		      myimg.style['left'] = left + (Math.floor(speed * (3/8)));
			}
		  }
		}
	  }
	}
	//-->
	</script>

	<link rel="stylesheet" href="../easyGallery/lytebox/lytebox.css" type="text/css" media="screen" />
	<title>LunaDeSevilla - Im&aacute;genes de los apartamentos</title>
</head>
<body>

<div class="container">

	<div class="main">

		<?php include("header.php"); ?>

		<div class="content">

			<div class="item">
				<h1>Im&aacute;genes de los Apartamentos</h1>
				<?php include("../EasyGallery.php");?>
			</div>

		</div>

		<div class="sidenav">

		<?php include("menu.php"); ?>

		</div>

		<div class="clearer"><span></span></div>
		</div>

		<div class="footer">&copy; 2007 <a href="index.php">lunadesevilla.es</a>.Valid <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>&amp; <a href="http://validator.w3.org/check?uri=referer">XHTML</a>.Template design by Alfonso Luna
		</div>

	</div>

</body>
</html>