<?php
if (isset($_REQUEST['file_type']))
	{
	?>
	<style>
	html, body, button, div, input, select, fieldset { font-family: Tahoma,Arial,Verdana; font-size: 11px;};
	</style>
	<SCRIPT LANGUAGE=JavaScript>
	<!--
	function check_select()
		{
		frmname='thumbnail';
		chkname='checkbox';
		counter=0;
		//Total element is not include 4 form's element
		total=eval('document.' + frmname + '.length;')-3;
		//alert(total)
		for (i=0;i<total;i++)
			{
			if (eval('document.' + frmname + '.' + chkname + i))
				if (eval('document.' + frmname + '.' + chkname + i + '.checked;')==true)
					counter+=1;
			}
		//document.write(counter);
		if (counter>0)
			eval('document.' + frmname + '.btndelete.disabled=false;');
		else
			eval('document.' + frmname + '.btndelete.disabled=true;');
		}

	function check_upimage()
		{
		frmname='Upload';
		chkname='upimage0';
		counter=0;
		total=eval('document.' + frmname + '.length;');
		for (i=0;i<total;i++)
			{
			if (eval('document.' + frmname + '.' + chkname + i))
				if (eval('document.' + frmname + '.' + chkname + i + '.value')!='')
					counter+=1;
			}
		//document.write(counter);
		if (counter>0)
			eval('document.' + frmname + '.btnupload.disabled=false;');
		else
			eval('document.' + frmname + '.btnupload.disabled=true;');
		}
	current_row=null;
	current_class=null;
	function PreviewFile(source,type,width,height,rowid)
		{
		//alert (url)
		//Hilight row
		if (current_row!=null && current_class!=null)
			eval('document.all.itemrow'+current_row+'.className="'+current_class+'"')
		current_row=rowid
		current_class=eval('document.all.itemrow'+current_row+'.className');
		//current_class=current_row.className
		eval('document.all.itemrow'+current_row+'.className="'+current_class+'_over"')
		switch (type)
			{
			case 'databases':
			document.ImgFrm.ImageUrl.value=url
			//document.ImgFrm.ImgSelectBtn.disabled=false
			break;
			}
		}
	// -->
	</SCRIPT>
	<table width="100%" height="100%" cellpadding="0" cellspacing="6" style="border: solid 0px #336699">
		<tr>
		<td width="60%" valign="top">
		<table width="100%" cellspacing="0" cellpadding="0">
		<tr><td>
		<p class="title3"><?php echo $strBrowseDir; ?> : </p>
		<p class="formindex" style="line-height: 150%">
		<?php
		//---------- Switch file type ----------------
		if (isset($_REQUEST['file_type']))
			{
			switch ($_REQUEST['file_type'])
				{
				case 'databases':
				$file_type=$_REQUEST['file_type'];
				$valid_file_types=$VALID_NORMAL_DATABASE_TYPES;
				$default_dir=$upfiles_dir;
				$hidden_dir=array();
				$max_file_size=$max_updatabase_size;
				break;
				}
			}
		else
			{
			}
		switch ($_SESSION['usergroup'])
			{
			case '1':
			case '2':
			break;
			
			case '3':
			array_push($hidden_dir,'USER');
			break;
			
			default:
			array_push($hidden_dir,'ADMIN','MODER');
			break;
			}
		echo '<strong>'.$strSupportedFileType.' :</strong> ';
		for ($i=0;$i<count($valid_file_types);$i++)
			{
			if ($i>0)
				echo ', ';
			echo strtoupper($valid_file_types[$i]);
			}
		echo '<br><strong>'.$strMaxFileSize.' :</strong> ';
		$s=$max_file_size;
		if($s>1000*1000)
			{
			$s=round($s/(1000*1000));
			echo "$s MB";
			}
		if($s>1000)
			{
			$s=round($s/1000);
			echo "$s KB";
			}
		?>
		</p>
		</td></tr>
		<tr>
			<td valign="top">
			<div ID="browse_window" style="background-color: #FFFFFF; padding: 3 3 3 3; border: solid 1px #FFCC00;">
			<!-- Browse images -->
			<table cellpadding="0" cellspacing="0" width="100%" border="0">
			<tr><td colspan="3">
			<p align="left" class="title4">
			<?php
			echo ':: ';
			//echo $siteName;
			//echo ' -> Image Manager';
			if (!isset($_SESSION['imgviewtype']))
				$_SESSION['imgviewtype']='list';
			
			if (isset($_GET['viewtype']))
				{
				switch ($_GET['viewtype'])
					{
					case 'thumbnail':
					$_SESSION['imgviewtype']='thumb';
					break;
					
					case 'list':
					$_SESSION['imgviewtype']='list';
					break;
					}
				echo '<script>window.history.go(-1);</script>;';
				}
			
			if ($_SESSION['imgviewtype']=='thumb')
				{
				$type='list';
				$current='Thumbnail Mode';
				$choose='List Mode';
				}
			else
				{
				$type='thumbnail';
				$current='List Mode';
				$choose='Thumbnail Mode';
				}
			
			//echo ' -> ';
			echo '<font color="#FF6600">'.$current.'</font>';
			echo ' [ Switch to <a href="javascript: window.location=\''.$_SERVER['PHP_SELF'].'?';
			//echo 'language='.$_REQUEST['language'].'&';
			//echo 'frmname='.$_REQUEST['frmname'].'&';
			//echo 'field='.$_REQUEST['field'].'&';
			echo 'module=explorer&';
			echo 'file_type='.$_REQUEST['file_type'].'&';
			echo 'viewtype='.$type.'\'">';
			echo $choose;
			echo '</a> ]';
			echo ' ::';
			?>
			</p>
			</td></tr>
				
			<tr><td colspan="3">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<form name="thumbnail" method="post" action="<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']; ?>" onsubmit='return confirm("Are you sure you want to delete selected image ?\n\nOK to CONFIRM \nCANCEL to cancel");'>
			<?php
			$max=9;
			$itemonrow=3;
			$line=0;
			//---------- Get file extension --------------
			function get_extension($filename)
				{
				$revname=strrev($filename);
				$z=explode(".",$revname);
				return strrev($z[0]);
				}
			//--------------------------------- Do upload file ----------------------------
			?>
			<?php
			if (isset($_POST['directory'],$_POST['totalfiles'],$_POST['action']) and $_POST['action']=='delete')
				{
				$cur_dir=$_POST['directory'];
				//echo $cur_dir;
				$totalfiles=$_POST['totalfiles'];
				//Kiem tra bien dau vao
				$success='';
				$unsuccess='';
				for ($i=0;$i<=$totalfiles;$i++)
					{
					if (isset($_POST['checkbox'.$i]))
						{
						//echo 'Hehe';
						$file=$_POST['checkbox'.$i];
						//echo $_POST['checkbox'.$i];
						if (unlink($cur_dir.$file))
							{
							$success.='<li>'.$file.'</li>';
							}
						else
							{
							$unsuccess.='<li>'.$file.'</li>';
							}
						}
					}
				//End of Delete operation
				?>
				<tr><td colspan="3">
				<p class="formtitle">
				<?php
				if ($success!='')
					echo '- Deleted image(s) : '.$success.'<br>';
				if ($unsuccess!='')
					echo '- Can not delete : '.$unsuccess.'<br><br> No file exsist or you don\'t have permisson to attemp this operation ';
				?>
				</p>
				</td></tr>
				<?php
				echo '<script>';
				echo 'window.location="'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'].'"';
				echo '</script>';
				}
			
			if (isset($_POST['directory'],$_POST['action']) and $_POST['action']=='upload')
				{
				$error=0;
				$cur_dir=trim($_POST['directory']);
				$up_image='Target directory: '.$cur_dir;
				//Kiem tra bien dau vao
				set_time_limit(0);
				if (!isset($max_file_size))
					$max_file_size=100000;
				$img_prefix='upimage0';
				for ($y=1;$y<=$max_upload_img;$y++)
					{
					$image=$img_prefix.$y;	
					//$up_image.='<br><strong>- Upload image number '.$y.' : </strong>';
					if (isset($_FILES[$image]))
						{
						$error=0;
						//$image=$_FILES['\''.$upimg_name.'\''];
						$iname=$image.'_name';
						$$iname=$_FILES[$image]['name'];
						$ext_arr=explode('.',trim($$iname));
						$ext=$ext_arr[1];
						if ($$iname!='')
							{
							$up_image.='<br>'.$y.'. <strong> Name :</strong> '.$$iname;
							$isize=$image.'_size';
							$$isize=$_FILES[$image]['size'];
							$up_image.=' / <strong>Size :</strong> '.$$isize.' bytes';
							if ($$isize>$max_file_size)
								{
								?>
								<script>
								alert('File [ <?php echo $$iname; ?> ] has size [ <?php echo $$isize; ?> ] that not supported ! \n\n                          Can not upload this file')
								</script>
								<?php
								$error++;
								}
							if ($$isize==0)
								{
								?>
								<script>
								alert('File [ <?php echo $$iname; ?> ] has size [ 0 ] that not valid ! \n\n                          Can not upload this file')
								</script>
								<?php
								$error++;
								}
							$itype=$image.'_type';
							$$itype=$_FILES[$image]['type'];
							$up_image.=' / <strong>Type :</strong> '.$$itype;
							//if ($$itype!='image/gif' && $$itype!='image/pjpeg' && $$itype!='image/bmp')
							if (!in_array($ext,$valid_file_types))
								{
								?>
								<script>
								alert('File [ <?php echo $$iname; ?> ] has extension [ <?php echo $ext; ?> ] that not supported ! \n\n                          Can not upload this file')
								</script>
								<?php
								$error++;
								}
							$itemp=$image.'_temp';
							$$itemp=$_FILES["$image"]['tmp_name'];
								//echo $image;
							if ($error==0)
								{
								$upfile=$cur_dir.$$iname;
								//echo $$iname;
								//echo $cur_dir;
								//$upfile=str_replace('/','\\',$upfile);
								//echo $itemp.': ';
								//echo $$itemp;
								//echo $upfile;
								if (is_uploaded_file($$itemp))
									{
									//echo 'True !';
									if (move_uploaded_file($$itemp,$upfile))
										{
										?>
										<script>
										alert('File [ <?php echo $$iname; ?> ] has been uploaded successfully !')
										</script>
										<?php
										}
									else
										{
										?>
										<script>
										alert('Upload proccess is not complete. Please check your connection or select a smaller file! \n\n                          Can not upload this file')
										</script>
										<?php
										$error++;
										}
									}
								}
							else
								{
								?>
								<script>
								alert('File [ <?php echo $$iname; ?> ] is not supported by this web server ! \n\n                          Can not upload this file')
								//alert('This type is not allowed !')
								</script>
								<?php
								}
							}
						else
							{
							//$up_image.=' not selected !<br>';
							}
						}
					
					}
				?>
				<tr><td colspan="3">
				<p class="formtitle">
				<?php
				echo $up_image.'<br><br>';
				?>
				</p>
				</td></tr>
				<?php
				echo '<script>';
				echo 'window.history.go(-1)';
				echo '</script>';
				}
				//exit;
				?>
			<?php
			//------------------------------------ End upload -----------------------------
			//$VALID_IMAGE_FILE_TYPES =  array("gif","jpg","jpeg","png","png");
			//To the root of site
			define("SITEROOT", $root_dir);
			//Path from this file to root
			define("FILEPATH", '');
			//Root folder to go
			define("ROOTFOLDER", FILEPATH.$root_dir.$default_dir);
			//Browse
			//include("dirwalk.php");
			//-------------------------------- Dir walk ------------------------------------
			//include ('../config.inc.php');
			/**
			   Get the extension of a file. You might want to see objFile.Type too
			   In php4, you can use pathinfo() function for this
			*/
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
			function print_filesize($file)
				{
				$s=filesize($file);
				if($s>1024*1024){
					$s=round($s/(1024*1024));
					return "$s MB";
					}
				if($s>1024){
					$s=round($s/1024);
					return "$s KB";
					}
				return "$s B";
				}
			function print_dirsize($dir)
				{
				$d=stat($dir);
				$s=$d['size'];
				if($s>1024*1024*1024)
					{
					$s=round($s/(1024*1024*1024));
					return "$s GB";
					}
				if($s>1024*1024)
					{
					$s=round($s/(1024*1024));
					return "$s MB";
					}
				if($s>1024)
					{
					$s=round($s/1024);
					return "$s KB";
					}
				return "$s B";
				}
			/**
			 print the links at the top to navigate to parent folders
			*/
			function print_header_links($folder_path)
				{
				global $strBack;
				global $strRootFolder;
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
					echo '<p class="button"><a href="javascript: window.location=\''.$_SERVER['PHP_SELF'].'?';
					//echo 'language='.$_REQUEST['language'];
					//echo '&frmname='.$_REQUEST['frmname'];
					//echo '&field='.$_REQUEST['field'];
					echo ' module=explorer';
					echo '&file_type='.$_REQUEST['file_type'];
					echo '\'">';
					echo '<img hspace="2" src="images/folder_w3.jpg" alt="'.$strBack.' '.$strRootFolder.'" border="0" align="absmiddle">'.$strRootFolder.'</a>'."\n";
					for($i=0;$i<count($arr_folders); $i++)
						{
						//echo "$i ..$arr_folders[$i]..$prev_folder $arr_folders[$i]<br>\n";
						echo "<br>\n";
						for($x=0;$x<=$i;$x++) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							if($i==count($arr_folders)-1)
								echo '<img hspace="2" src="images/folder_w1.jpg" border="0" alt="Current folder ..."><b>', $arr_folders[$i], "</b><br>\n";
							else
								{
								echo '<a href="javascript: window.location=\'', $_SERVER['PHP_SELF'], '?';
								//echo 'language='.$_REQUEST['language'].'&';
								//echo 'frmname='.$_REQUEST['frmname'].'&';
								//echo 'field='.$_REQUEST['field'].'&';
								echo 'module=explorer&';
								echo 'file_type='.$_REQUEST['file_type'].'&';
								echo 'dir='.urlencode(ereg_replace("^/","","$prev_folder/$arr_folders[$i]")).'\'"><img hspace="2" src="images/folder_w4.jpg" border="0" alt="Go to '.$arr_folders[$i].'">'.$arr_folders[$i]."</a>\n";
								}
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
			    global $root_dir;
			    global $default_dir;
			    global $hidden_dir;
				/*
				if (!isset($_SESSION['current_image_dir']))
					{
					$_SESSION['current_image_dir']=$root_dir.$upimages_dir;
					}
				*/
				global $valid_file_types;
				global $max;
				global $itemonrow;
				global $line;
				global $strName;
				global $strType;
				global $strSize;
				global $strDimension;
				global $siteUrl;
				global $strDelete;
				global $strNotice;
				$dir = ereg_replace("/+","/","$dir/"); // squeeze extra slashes
				//echo $dir;
				//if(DEBUG)
					$dirext= print_header_links($dir);
				echo $dirext;
				//Display every file in the folder, that matches
				//the extension given in valid_file_types
				if(!($d=@dir($dir)))
					{
					echo "<p class=\"bigtitle\" style='text-align: center; margin: 12 0 0 0;'>".$strNotice['401']." - [ ".basename($dir)." ]</p>";
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
						if (is_dir("$dir/$entry") and !in_array($entry,$hidden_dir))
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
				reset($dirs);
				asort($files);
				reset($files);
				
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
							<p class="filename" style="color: #FFFFFF"><?php echo $strName; ?></p></td>
							<td bgcolor="#336699" width="40" style="border-right: solid 1px #DDDDDD">
							<p class="properties" style="color: #FFFFFF"><?php echo $strType; ?></p></td>
							<td bgcolor="#336699" width="50" style="border-right: solid 1px #DDDDDD">
							<p class="properties" style="color: #FFFFFF"><?php echo $strSize; ?></p></td>
							<!--<td bgcolor="#336699" width="70" style="border-right: solid 1px #DDDDDD">
							<p class="properties" style="color: #FFFFFF"><?php echo $strDimension; ?></p></td>
							
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
					$file_count=0;
					while (isset($all[$i]))
						{
						//Gioi han do dai ten file
						if ($_SESSION['imgviewtype']=='thumb')
							$length=10;
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
								//$icon='file16.gif';
								$icon='';
								//echo $default_dir;
								//echo $dir;
								//$ImgUrl=str_replace(SITEROOT.FILEPATH,'',$dir.$all[$i]);
								$ImgUrl=$dir.$all[$i];
								//$ImgUrl=str_replace(SITEROOT.FILEPATH,$siteUrl,$dir.$all[$i]);
								//$ImgUrl=str_replace($root_dir,'',str_replace($default_dir,str_replace($root_dir,$siteUrl,$default_dir),$dir.$all[$i]));
								$dsp_type=strtoupper($ext);
								$dsp_size=print_filesize("$dir/$all[$i]");
								$permission=fileperms($dir.$all[$i]);
								$dimension=$width.'x'.$height;
								$owner=@fileowner($dir.$all[$i]);
								$creattime=@filectime($dir.$all[$i]);
								$modifytime=@filemtime($dir.$all[$i]);
								//$image=displaypic( str_replace($upimages_dir,'',str_replace('/','\\',$dir)).''.$all[$i],'tiny','center" style="cursor: hand" alt="'.$all[$i].' - '.$information.'" onClick="window.open(\''.$dir.$all[$i].'\')');
								$checkbox='&nbsp;';
								$checkbox="\n".'<input type="checkbox" name="checkbox'.$file_count.'" value="'.$all[$i].'" onClick="check_select();" style="border: none;">';
								$dsp_name ='<strong style="cursor: hand;"';
								//$dsp_name.=' onClick="window.open(\''.$dir.$all[$i].'\')"';
								if (isset($_SESSION['imgviewtype'],$_REQUEST['file_type']) and $_SESSION['imgviewtype']=='list' and $_REQUEST['file_type']=='images')
									$dsp_name.=' onClick="PreviewFile(\''.$dir.$all[$i].'\',\''.$_REQUEST['file_type'].'\'';
								if (isset($width) and $width!=0)
									$dsp_name.=','.$width;
								else
									$dsp_name.=',0';
								if (isset($height) and $height!=0)
									$dsp_name.=','.$height;
								else
									$dsp_name.=',0';
								$dsp_name.=','.$i;
								$dsp_name.=')">';
								$dsp_name.= ucfirst($name).'</strong>';
								
								$indent='<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
								//$dimension='<font size="1">'.strtoupper($ext).' ('.$width.'x'.$height.') / '.print_filesize("$dir/$all[$i]").'</font>';
								$file_count++;
								}
							}
						//Neu la thu muc
						if ($type[$i]=='dir')// and !in_array($all[$i],$hidden_dir))
							{
							$checkbox='&nbsp;';
							$icon='folder16.gif';
							$dsp_type='DIR';
							$dsp_size=' N/A ';
							//$dsp_size=print_dirsize(realpath($dir.$all[$i]));
							//echo $siteUrl.str_replace($root_dir,'',$dir.$all[$i]);
							//echo realpath($dir.$all[$i]);
							$dimension=' ';
							$permission=@fileperms($dir.$all[$i]);
							$owner=@fileowner($dir.$all[$i]);
							$creattime=@filectime($dir.$all[$i]);
							$modifytime=@filemtime($dir.$all[$i]);
							/*
							echo "<img hspace=\"4\" align='absmiddle' src=\"../images/artgroup.gif\" alt=\"Browse content of '".$all[$i]."'\" border=\"0\">";
							*/
							$dsp_name ="<a href=\"javascript: window.location='".$_SERVER['PHP_SELF']."?";
							//$dsp_name.='language='.$_REQUEST['language'].'&';
							//$dsp_name.='frmname='.$_REQUEST['frmname'].'&';
							//$dsp_name.='field='.$_REQUEST['field'].'&';
							$dsp_name.='module=explorer&';
							$dsp_name.='file_type='.$_REQUEST['file_type'].'&';
							$dsp_name.="dir=".urlencode(ereg_replace("/+","/",cut_root_folder("$dir/$all[$i]")))."'\">";
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
							//echo '<tr><td style="border: 1px solid #EEEEEE;" valign="middle" align="center" height="'.(15*$itemonrow).'" onMouseOver="changebd(this,\'#CCCCCC\')" onMouseOut="undobd(this)">';
							if($type[$i]=='file')
								{
								$information=strtoupper($ext).' ('.$width.'x'.$height.') / '.print_filesize("$dir/$all[$i]");
								//displaypic( str_replace($ImgUrl,'',str_replace('/','\\',$dir)).''.$all[$i],'tiny','center" style="cursor: hand" alt="'.$all[$i].' - '.$information.'" onClick="window.open(\''.$dir.$all[$i].'\')');
								$text='<img src="'.$ImgUrl.'" width="48" height="48" onclick="window.open(\''.$ImgUrl.'\',\'\',\'fulscreen=1\')" style="cursor: hand;" alt="'.$dsp_type.' ('.$dimension.') - '.$dsp_size.'"><br>';
								$text.='<input type="checkbox" name="checkbox'.$file_count.'" value="'.$all[$i].'" onClick="check_select();">';
								$text.='<strong>'.ucfirst($name).'</strong>';
								//$text.='<br>';
								}
							if ($type[$i]=='dir')
								{
								$text ='<a href="'.$_SERVER['PHP_SELF'].'?';
								//$text.='language='.$_REQUEST['language'].'&';
								//$text.='frmname='.$_REQUEST['frmname'].'&';
								//$text.='field='.$_REQUEST['field'].'&';
								$text.='module=explorer&';
								$text.='file_type='.$_REQUEST['file_type'].'&';
								$text.="dir=".urlencode(ereg_replace("/+","/",cut_root_folder("$dir/$all[$i]")))."\">";
								$text.="<img hspace=\"4\" width=\"48\" height=\"48\" align='absmiddle' src=\"images/folder48.gif\" alt=\"Browse content of '".$all[$i]."'\" border=\"0\">";
								$text.='<br><strong>'.ucfirst($name).'</strong>';
								$text.="</a>\n";
								}
							//echo "</td></tr>\n";
							echo '<tr><td><p class="properties">'.$text.'</p></td></tr>'."\n";
							
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
							<tr id="itemrow<?php echo $i; ?>" class="<?php if ($i%2==0) echo 'itemrow2'; else echo 'itemrow1'; ?>">
								<td width="20"><?php echo $checkbox; ?></td>
								<td width="20" align="right">
								<?php if (isset($icon) and $icon!='') echo '<img src="images/'.$icon.'" width="16" height="16">'; ?>
								</td>
								<td width="250" style="border-right: solid 1px #DDDDDD">
								<p class="filename1"><a href="../updatabases/<?php echo ucfirst($name); ?>"><?php echo $dsp_name; ?></a></p></td>
								<td width="40" style="border-right: solid 1px #DDDDDD">
								<p class="properties1"><?php echo $dsp_type; ?></p></td>
								<td style="border-right: solid 1px #DDDDDD" >
								<p class="properties1" style="text-align: right; margin: 0 3 0 0"><?php echo $dsp_size; ?></p></td>
								<!--<td style="border-right: solid 0px #DDDDDD">
								<p class="properties1"><?php echo $dimension; ?></p></td>-->
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
						<input id="btndelete" type="submit" value=" <?php echo $strDelete; ?> " disabled>
						<input type="hidden" name="action" value="delete">
						<input type="hidden" name="directory" value="<?php echo $dir; ?>">
						<input type="hidden" name="totalfiles" value="<?php echo $total; ?>">
						</td></tr>
						<?php
						}
					}
				else
					{
					echo '<tr><td colspan="'.$itemonrow.'"><p class="bigtitle" style="text-align: center; margin: 12 0 0 0;">';
					echo $strNotice['402'];
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
			//------------------------------- End Dir walk ---------------------------------
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
			if (isset($_GET['dir']))
				{
				$dir=$_GET['dir'];
				//echo $dir;
				$dir=str_replace('.','',$dir);
				$dir=str_replace('\\','',$dir);
				$dir=str_replace($default_dir,'',$dir);
				//echo $dir;
				//----- Dont show hidden folder
				$temp=explode('/',$dir);
				if (in_array(end($temp),$hidden_dir))
					$dir=$root_dir;
				}
			else
				$dir=$root_dir;
			//echo $dir;
			main_process($dir);
			?>
			<tr><td colspan="<?php echo $itemonrow; ?>">&nbsp;</td></tr>
			</form></table>
			</td></tr>
			</table>
			</div>
			</td>
		</tr>
		</table>
		</td>
		<td valign="top"><p class="title3"><?php echo $strBackup; ?> : <a href="../updatabases/backup.php" style="cursor: pointer;"><img src="images/save_ico2.gif" width="25" height="20" border="0"></a></p></td>
		</tr>
	</table>
	<?php
	}
?>