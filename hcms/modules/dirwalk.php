<?php
//include ('../config.inc.php');
/**
   Get the extension of a file. You might want to see objFile.Type too
   In php4, you can use pathinfo() function for this
*/
function get_extension($filename)
	{
	$revname=strrev($filename);
	$z=explode(".",$revname);
	return strrev($z[0]);
	}
/**
  Utility function. Returns the path minus root folder path
  Also takes out the leading "/"
*/
function cut_root_folder($sub_folder){
	if (strlen($sub_folder) > strlen(ROOTFOLDER)){
		$fld=str_replace(ROOTFOLDER,'',$sub_folder);
		$fld=ereg_replace("^/+","",$fld);
		return $fld;
	} else {
		return "";
	}
}
/**
  Utility function.  check for the existence of a string in an array.
*/
function php3_in_array($str,$arr){
 // in php4, you don't need this function. use in_array instead
 $l=count($arr)-1;
 while($l>=0){
 	if(0==strcmp($str,$arr[$l])){
		return $l;
    }
    $l--;
 }
 return -1;
}
/**
 Utility function. print a file's size
*/
function print_filesize($file){
	$s=filesize($file);
	if($s>1024){
		$s=round($s/1024);
		return "$s Kb";
	}
	if($s>1024*1024){
		$s=round($s/(1024*1024));
		return "$s Mb";
	}
	return "$s b";
}

/**
 print the links at the top to navigate to parent folders
*/
function print_header_links($folder_path)
	{
	//folder path is verified against site root as mild security
	//what if someone passes / or ~?
	//global $_SERVER['PHP_SELF'];
	//if(DEBUG)
	
#		echo "$_SERVER['PHP_SELF'] : print_header_links('$folder_path')<br>\n";


    $folder_path = cut_root_folder(ereg_replace("/$","",$folder_path));
	$arr_folders = split("/",$folder_path);
	$prev_folder = "";
	if($folder_path != "")
		{
		echo '<p class="button"><a href="', $_SERVER['PHP_SELF'], '">';
		echo '<img hspace="2" src="../images/folder_w3.jpg" alt="Back to Root Folder" border="0" align="absmiddle">Root Folder</a>',"\n";
		for($i=0;$i<count($arr_folders); $i++)
			{
			//echo "$i ..$arr_folders[$i]..$prev_folder $arr_folders[$i]<br>\n";
			echo "<br>\n";
			for($x=0;$x<=$i;$x++) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				if($i==count($arr_folders)-1)
					echo '<img hspace="2" src="../images/folder_w1.jpg" border="0" alt="Current folder ..."><b>', $arr_folders[$i], "</b><br>\n";
				else
					echo '<a href="', $_SERVER['PHP_SELF'], '?dir=', urlencode(ereg_replace("^/","","$prev_folder/$arr_folders[$i]")), '"><img hspace="2" src="../images/folder_w4.jpg" border="0" alt="Go to '.$arr_folders[$i].'">', $arr_folders[$i], "</a>\n";
            $prev_folder = "$prev_folder/$arr_folders[$i]";
			}
		if (isset($arr_folders[$i]) and $i>0)
			echo '<b>', $arr_folders[$i], "</b><br></p>\n";
		}
	} // print_header_links end

/**
 display the contents of a directory
*/
function display_directory($dir)
	{
    global $upimages_dir;
	if (!isset($_SESSION['current_image_dir']))
		{
		$_SESSION['current_image_dir']=$upimages_dir;
		}
	global $valid_file_types;
	global $max;
	global $itemonrow;
	global $line;
	
	$dir = ereg_replace("/+","/","$dir/"); // squeeze extra slashes
	//if(DEBUG)
		$dirext= print_header_links($dir);
	echo $dirext;
	//Display every file in the folder, that matches
	//the extension given in valid_file_types
	if(!($d=@dir($dir)))
		{
		echo "<p class=\"bigtitle\"> \t Cannot open directory - [$dir]</p>";
		return;
		}
	$_SESSION['current_image_dir']=$dir;
	$all=array();
	$type=array();
	$dirs=array();
	$dcount=0;
	$files=array();
	$fcount=0;
	while($entry=$d->read())
		{
		$entry=trim($entry);
		if ($entry!='.' && $entry!='..')
			{
			$entry=trim($entry);
			if(is_file("$dir/$entry"))
				{
				$ext = get_extension($entry);
				if(0<=php3_in_array($ext,$valid_file_types))
					{
					$files[$fcount]=$entry;
					//echo 'Filess ('.$fcount.'): '.$files[$fcount];
					$fcount++;
					}
				}
			if (is_dir("$dir/$entry"))
				{
				$dirs[$dcount]=$entry;
				$all[$dcount]=$entry;
				$type[$dcount]='dir';
				//echo 'Dirs ('.$fcount.'): '.$dirs[$dcount];
				$dcount++;
				}
			}
		}
	//Sap xep thu muc
	asort($dirs);
	asort($files);
	
	//echo $dcount;
	//echo $fcount;
	$filenum=$fcount;
	
	$i=$dcount;
	for ($j=0;$j<$fcount;$j++)
		{
		$all[$i]=$files[$j];
		$type[$i]='file';
		$i++;
		}
	$total=$i;
	
	if ($total!=0)
		{	
		switch ($_SESSION['imgviewtype'])
			{
			case 'list':
			?>
			<tr><td align="center" valign="top" style="padding: 6 0 0 0">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
				<td bgcolor="#336699" colspan="3" style="border-right: solid 1px #DDDDDD">
				<p class="filename" style="color: #FFFFFF">Name</p></td>
				<td bgcolor="#336699" width="40" style="border-right: solid 1px #DDDDDD">
				<p class="properties" style="color: #FFFFFF">Type</p></td>
				<td bgcolor="#336699" width="50" style="border-right: solid 1px #DDDDDD">
				<p class="properties" style="color: #FFFFFF">Size</p></td>
				<td bgcolor="#336699" width="70" style="border-right: solid 1px #DDDDDD">
				<p class="properties" style="color: #FFFFFF">Dimension</p></td>
				<!--
				<td bgcolor="#CCCCCC" width="60" style="border-right: solid 1px #DDDDDD">
				<p class="properties">Permission</p></td>
				<td bgcolor="#CCCCCC" width="50" style="border-right: solid 1px #DDDDDD">
				<p class="properties">Owner</p></td>
				<td bgcolor="#CCCCCC" width="80" style="border-right: solid 1px #DDDDDD">
				<p class="properties">Creat</p></td>
				<td bgcolor="#CCCCCC"><p class="properties">Modify</p></td>
				-->
				</tr>
			<?php
			break;
			
			case 'thumb':
			?>
			<tr><td class="tdtext">
			<table width="100%" cellpadding="0" cellspacing="10" border="0">
			<?php
			break;
			}
		
		$i=0;
		while (isset($all[$i]))
			{
			//Gioi han do dai ten file
			if ($_SESSION['imgviewtype']=='thumb')
				$length=15;
			else
				$length=30;
			
			//Cat ten file neu qua dai
			if (strlen($all[$i])>=$length)
				$name=substr($all[$i],0,$length).'...';
			else
				$name=$all[$i];
			
			//Neu la file
			if($type[$i]=='file')
				{
				$ext = get_extension($all[$i]);
				if(0<=php3_in_array($ext,$valid_file_types))
					{
					@$size=getimagesize($dir.$all[$i]);
					$width=$size[0];
					$height=$size[1];
					$icon='file16.gif';
					$dsp_type=strtoupper($ext);
					$dsp_size=print_filesize("$dir/$all[$i]");
					$permission=fileperms($dir.$all[$i]);
					$dimension=$width.'x'.$height;
					$owner=@fileowner($dir.$all[$i]);
					$creattime=@filectime($dir.$all[$i]);
					$modifytime=@filemtime($dir.$all[$i]);
					//$image=displaypic( str_replace($upimages_dir,'',str_replace('/','\\',$dir)).''.$all[$i],'tiny','center" style="cursor: hand" alt="'.$all[$i].' - '.$information.'" onClick="window.open(\''.$dir.$all[$i].'\')');
					$checkbox='<input type="checkbox" name="checkbox'.($i+1).'" value="'.$all[$i].'" onClick="check_select();" style="border: none;">';
					$dsp_name ='<strong style="cursor: hand;" onClick="window.open(\''.$dir.$all[$i].'\')">';
					$dsp_name.= ucfirst($name).'</strong>';
					
					$indent='<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					//$dimension='<font size="1">'.strtoupper($ext).' ('.$width.'x'.$height.') / '.print_filesize("$dir/$all[$i]").'</font>';
					}
				}
			//Neu la thu muc
			if ($type[$i]=='dir')
				{
				$checkbox='&nbsp;';
				$icon='folder16.gif';
				$dsp_type='Folder';
				$dsp_size='...';
				$dimension='...';
				$permission=@fileperms($dir.$all[$i]);
				$owner=@fileowner($dir.$all[$i]);
				$creattime=@filectime($dir.$all[$i]);
				$modifytime=@filemtime($dir.$all[$i]);
				/*
				echo "<img hspace=\"4\" align='absmiddle' src=\"../images/artgroup.gif\" alt=\"Browse content of '".$all[$i]."'\" border=\"0\">";
				*/
				$dsp_name ="<a href=\"".$_SERVER['PHP_SELF']."?dir=".urlencode(ereg_replace("/+","/",cut_root_folder("$dir/$all[$i]")))."\">";
				$dsp_name.='<strong>'.strtoupper($name).'</strong>';
				$dsp_name.="</a>\n";
				}		
			
			//Trinh bay theo 2 kieu
			switch ($_SESSION['imgviewtype'])
				{
				//Dang Thumbnail
				case 'thumb':
				if ($line==0)
					{
					//echo '<tr><td height="25" colspan="'.$itemonrow.'">&nbsp;</td></tr>';
					echo '<tr>';
					$line=1;
					}
				
				$tdwidth=(100/$itemonrow);
				echo '<td width="'.$tdwidth.'%" valign="top">';
				echo '<table cellspacing="0" cellpadding="0" width="100%" border="0">';
				echo '<tr><td style="border: 1px solid #EEEEEE;" valign="middle" align="center" height="'.(15*$itemonrow).'" onMouseOver="changebd(this,\'#CCCCCC\')" onMouseOut="undobd(this)">';
				if($type[$i]=='file')
					{
					$information=strtoupper($ext).' ('.$width.'x'.$height.') / '.print_filesize("$dir/$all[$i]");
					displaypic( str_replace($upimages_dir,'',str_replace('/','\\',$dir)).''.$all[$i],'tiny','center" style="cursor: hand" alt="'.$all[$i].' - '.$information.'" onClick="window.open(\''.$dir.$all[$i].'\')');
					$text='<input type="checkbox" name="checkbox'.($i+1).'" value="'.$all[$i].'" onClick="check_select();">';
					$text.=$dsp_name;
					$text.='<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$text.='<font size="1">'.$dsp_type.' ('.$dimension.') / '.$dsp_size.'</font>';
					}
				if ($type[$i]=='dir')
					{
					printf("<a href=\"%s?dir=%s\">",$_SERVER['PHP_SELF'], urlencode(ereg_replace("/+","/",cut_root_folder("$dir/$all[$i]"))));
					echo "<img hspace=\"4\" align='absmiddle' src=\"../images/artgroup.gif\" alt=\"Browse content of '".$all[$i]."'\" border=\"0\">";
					echo "</a>\n";
					$text= '<strong>'.strtoupper($name).'</strong>';
					}
				echo "</td></tr>\n";
				echo '<tr><td><p class="properties">'.$text.'</p></td></tr>';
				
				echo '</table>';
				echo '</td>';
				
				$i++;
				
				if (($i%$itemonrow)==0)
					{
					echo '</tr>';
					$line=0;
					}
				break;
				
				//Dang List
				case 'list':
				?>
				<tr style="background-color: <?php if ($i%2==0) echo '#F7F7F7'; else echo '#FFFFFF'; ?>">
					<td width="20"><?php echo $checkbox; ?></td>
					<td width="20" align="right"><img src="..\images\<?php echo $icon; ?>" width="16" height="16"></td>
					<td width="250" style="border-right: solid 1px #DDDDDD">
					<p class="filename1"><?php echo $dsp_name; ?></p></td>
					<td width="40" style="border-right: solid 1px #DDDDDD">
					<p class="properties1"><?php echo $dsp_type; ?></p></td>
					<td style="border-right: solid 1px #DDDDDD">
					<p class="properties1"><?php echo $dsp_size; ?></p></td>
					<td style="border-right: solid 0px #DDDDDD">
					<p class="properties1"><?php echo $dimension; ?></p></td>
					<!--
					<td width="60" style="border-right: solid 1px #DDDDDD">
					<p class="properties"><?php echo $permission; ?></p></td>
					<td width="50" style="border-right: solid 1px #DDDDDD">
					<p class="properties"><?php echo $owner; ?></p></td>
					<td width="80" style="border-right: solid 1px #DDDDDD">
					<p class="properties"><?php echo $creattime; ?></p></td>
					<td><p class="properties"><?php echo $modifytime; ?></p></td>
					-->
				</tr>
				<?php
				$i++;
				break;
				}
			}
		
		switch ($_SESSION['imgviewtype'])
			{
			case 'thumb':
			?>
			</table></td></tr>
			<?php
			break;
			
			case 'list':
			?>
			</table></td></tr>
			<?php
			}
		if ($filenum!=0)
			{
			?>
			<tr><td height="10"</tr>
			<tr><td colspan="<?php echo $itemonrow; ?>">
			<input id="btndelete" type="submit" value="Delete selected file(s)" disabled>
			<input type="hidden" name="action" value="delete">
			<input type="hidden" name="directory" value="<?php echo $dir; ?>">
			<input type="hidden" name="totalfiles" value="<?php echo $total; ?>">
			</td></tr>
			<?php
			}
		}
	else
		{
		echo '<tr><td colspan="'.$itemonrow.'"><p class="bigtitle">';
		echo 'No file was found in this folder !';
		echo '</p></td></tr>';
		}
	} // display_directory end

/**
 main process...
*/
function main_process($dir)
	{
	//if a parameter dir is passed, use that
	$_SERVER['PHP_SELF'];
	//echo $dir;
	//echo SITEROOT;
	//$dir=ereg_replace(SITEROOT,"",$dir);
	$dir=str_replace(SITEROOT,"",$dir);
	if(!$dir)$dir="";
	//echo $dir;
	$current_folder=ROOTFOLDER."$dir";
	//echo $current_folder;
	display_directory($current_folder);
	}
?>
