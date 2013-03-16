<?php

// #################################################################//
// #  script by WingNut                        www.wingnut.net.ms  #//
// #                                                               #//
// #  this script has been published under the gnu public license  #//
// #  you may edit the script but never delete this comment! thx.  #//
// #################################################################//
// --begin editable region

// Root directory
$root_dir = "../easyGallery/";

// Thumbnail Columns
$columns = 4;

// Maximal size of thumbnails in pixel
$thumbwidth = 100;

// Slideshow 0=no 1=yes
$slideshow = 0;

// --end editable region
//##################################################################//
// Do not change anything by now unless you know what you are doing!

// --begin preprocessing
$phpself = $_SERVER['PHP_SELF'];
extract($_POST);

// filetypes
$filetypes = array("jpg", "jpeg");
$k = sizeof($filetypes);
for ($i=0; $i<$k; $i++)
{
  $filetypes[] = strtoupper($filetypes[$i]);
}

// extract local image folders
if (strpos($root_dir,'www')===0)
{
  $root_dir = 'http://'.$root_dir;
}
$local = parse_url($root_dir);
if (strpos($root_dir,'http://')===0)
{
  foreach (count_chars($phpself,1) as $i=>$val)
  {
    if (chr($i)=='/')
    {
	  $root_dir = substr($local['path'],1);
      for ($j=1;$j<$val;$j++)
        $root_dir='../'.$root_dir;
    }
  }
  if (strpos($root_dir,$local['path'])===0)
  {
    $root_dir = ".";
  }
}

// scanning directory for folders and check if they contain image files
if (!is_dir($root_dir))
{
  echo "<div class=\"error\">";
  echo "<span class=\"content\"><br>ERROR: folder not found.</span>";
  echo "</div>";
  exit();
}
$root_handle = opendir($root_dir);
while ($dirname = readdir($root_handle))
{
  $var1 = strcmp($dirname,'.');
  $var2 = strcmp($dirname,'..');
  $var3 = is_dir($root_dir.'/'.$dirname);
  if (($var1!=0) && ($var2!=0) && ($var3==1))
  {
	$dir_handle = opendir($root_dir.'/'.$dirname);
	$postmp = 0;
	while ($filename = readdir($dir_handle))
	{
  	  for ($i=0;$i<sizeof($filetypes);$i++)
  	  {
    	$postmp = strpos($filename, $filetypes[$i]);
		if ($postmp>0)
		{
		  $folders[] = $root_dir.'/'.$dirname;
		  break 2;
		}
  	  }
   	}
	closedir($dir_handle);
  }
}
if (!$folders)
{
  echo "<div class=\"error\">";
  echo "<span class=\"content\"><br>ERROR: Searched folders don't contain any image! Please change the \$root_dir.</span>";
  echo "</div>";
  exit();
}

// !!! if you dont want your folders in reverse order change rsort() to sort()
rsort($folders);

// set initial variable $ordner
if (!isset($ordner))
  $ordner = $folders[0];

// scanning directories for image files
if (is_dir($ordner)){
  $dir_handle = opendir($ordner);
  while ($filename = readdir($dir_handle))
  {
    for ($i=0; $i<sizeof($filetypes); $i++)
    {
      $pos = strpos($filename, $filetypes[$i]);
	  $var1 = strcmp($filename,'.');
      $var2 = strcmp($filename,'..');
      $var3 = is_file($ordner.'/'.$filename);
      if (($var1 != 0) && ($var2 != 0) && ($var3 == 1) && ($pos > 0))
   	  {
  	    $files[] = $filename;
   	  }
	  if ($filename=="thumbnails")
	  {
	    $thumbs = 1;
	  }
    }
  }
  sort($files);
  $size = sizeof($files);
  closedir($dir_handle);
  closedir($root_handle);
}
else
{
  echo "<div class=\"error\">";
  echo "<span class=\"content\"><br>ERROR: folder not found.</span>";
  echo "</div>";
  exit();
}
// --end preprocessing



// --begin print images
$xpos=8;
$ypos=6;
$count = 0;
$newthumbs = false;
$divheight = ceil(count($files)/$columns) * ($thumbwidth+6) + 6;
echo "<table height=$divheight width=100% cellspacing=0 cellpadding=0><tr valign=top><td>\n";
for ($y=0;$y<count($files);$y++)
{
  $tn_src = $ordner."/thumbnails/tn_".$files[$count];
  if (file_exists($tn_src))
  {
    $image = GetImageSize($tn_src);
	if ($image[0]==$image[1]){}
	elseif ($image[0]<$image[1]) $xpos += intval(($image[1]-$image[0])/2);
	else $ypos += intval(($image[0]-$image[1])/2);
    echo "<div id=\"livethumbnail\" style=\"left:".$xpos."px; top:".$ypos."px; position:relative; zindex:1;\">";
    if($slideshow!=1){
	  echo "<a href=\"".$ordner."/".$files[$count]."\" rel=lytebox[".$ordner."]>";
	}
	else{
	  echo "<a href=\"".$ordner."/".$files[$count]."\" rel=lyteshow[".$ordner."]>";
	}
    echo "<img src=\"$tn_src\" class=\"thumbnails\" alt=\"$files[$count]\" style=\"width:$image[0]; height:$image[1]; left:0px; top:0px; position:absolute;\"></a></div>\n";
	if ($image[0]==$image[1]){}
	elseif ($image[0]<$image[1]) $xpos -= intval(($image[1]-$image[0])/2);
	else $ypos -= intval(($image[0]-$image[1])/2);
  }
  else
  {
  	$modules = get_loaded_extensions();
	if(!in_array("gd", $modules)){
	  echo "<div class=\"error\">";
      echo "<span class=\"content\"><br>Your Webserver doesn't provide the GD library, which is required to create thumbnails. Please create and add your thumbnails manually.</span>";
      echo "</div>";
      exit();
	}
	if(createthumb($ordner,$files[$count],$thumbwidth))
	{
	  echo "tn_$files[$count] created.<br>";
	  $newthumbs = true;
    }
	else
	{
	  echo "<div class=\"error\">";
      echo "<span class=\"content\"><br>Thumbnail Creation failed.</span>";
      echo "</div>";
      exit();
	}
  }
  $count++;
  if($count%$columns==0)
  {
    $ypos += $thumbwidth+6;
    $xpos = 8;
  }
  else
  {
    $xpos += $thumbwidth+6;
  }
}
if($newthumbs)
{
  echo "<script>location.reload()</script>";
}
echo "</td></tr></table>\n";
// dont even think about removing this link!


function createthumb($name,$file,$maxsize)
{
  list($width, $height) = getimagesize("$name/$file");
  $width = min($width, $height);
  $tn = imagecreatetruecolor($maxsize, $maxsize);
  $image = imagecreatefromjpeg("$name/$file");
  imagecopyresampled($tn, $image, 0, 0, 0, 0, $maxsize, $maxsize, $width, $width);
  imagejpeg($tn, "$name/thumbnails/tn_$file", 70);
  return true;
}
?>
