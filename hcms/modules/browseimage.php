<?php
#+------------------------------------------------------+
#| 		DO NOT MODIFY BELOW THIS LINE!
#+-----------------------------------------------------*/
include("dirwalk.php");

//Prints a link for copying the path to some form field
//todo - quote processing so that it won't make bad Javascript
function print_copy_link($path, $name)
	{
	  $imgsize=GetImageSize($path);
	  $width=$imgsize[0];
	  $height=$imgsize[1];
	  $path=ereg_replace("/+","/",$path);
	  $path=ereg_replace(ROOTFOLDER,SITEROOT,$path);
	  //$name=ereg_replace("\....$","",$name); // remove the extension in the name
	  //$name=ucfirst(ereg_replace("_"," ",$name)); // replace underscores by spaces and capitalize
	  echo "<a href=\"#\" onClick=\"top.document.forms[0].elements['ImgUrl'].value='$path';";
	  echo "top.document.PREVIEWPIC.src='$path';\">$name</a>";
	}
	//if(DEBUG)
	$valid_file_types=$VALID_IMAGE_FILE_TYPES;
	
	if (isset($_GET['dir']))
		{
		$dir=$_GET['dir'];
		$dir=str_replace('.','',$dir);
		$dir=str_replace('\\','',$dir);
		}
	else
		$dir=$path_dir;
	main_process($dir);
?>
