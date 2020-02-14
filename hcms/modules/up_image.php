<?php
//$warning=0;
$isize=$field_array[$i].'_size';
$itype=$field_array[$i].'_type';
$iname=$field_array[$i].'_name';
$itemp=$field_array[$i].'_temp';
if (strlen($$isize)>0)
	{
	if ($$isize==0)
		{
		$allow_update=false;
		$up_imgage.='- The image you choose has a zero length. Please choose another one<br>';
		}
	else
		{
		if ($$isize>$imagesize)
			{
			$allow_update=false;
			$up_imgage.='- The image you choose is too large. Please choose another one has size < 50 Kilobytes<br>';
			}
		else
			{
			if ($$itype!='image/gif' && $$itype!='image/pjpeg' && $$itype!='image/bmp')
				{
				$allow_update=false;
				$up_imgage.='- The Image you choose is not supported by website. Please choose format JPEG (*.jpg), GIF (*.gif) or BITMAP (*.bmp)<br>';
				}
			else
				{
				//$material=substr($producttype,0,1);
				//$group=substr($producttype,1,1);	
				$duplicate=false;
				$curdir=$root_dir.$upimages_dir.$tblname.'/';
				//echo $curdir;
				$dir=opendir($curdir);
				while ($file=readdir($dir))
					{
					//echo '<br>';
					//echo $file.'<br>';
					if ($file==$$iname)
						{
						//echo basename($file);
						$temp=filesize($curdir.$file);
						//echo $temp;
						//echo $isize;
						if ($temp==$$isize)
							{
							?>
							<script language="JavaScript">
							if (confirm('Chu y: hinh anh nay da co tren server ! Ban co muon dung chung ko ?')==false)
								{
								takeback('<?php echo $tblname; ?>','<?php echo $ID; ?>');
								}
							else
								{
								<?php
								$up_imgage=' Done ! <br>';
								?>
								}
							</script>
							<?php
							}
						else
							{
							?>
							<script language="JavaScript">
							alert('Chu y: Ten file nay da co tren server ! Ban phai doi ten truoc');
							takeback('<?php echo $tblname; ?>','<?php echo $ID; ?>');
							</script>
							<?php
							}
						$up_imgage.='- ';
						$up_imgage.='Use existing image on server !<br>';
						$up_imgage.='<img src="'.$curdir.$file.'">';
						$up_imgage.='<br>';
						$duplicate=true;
						break;
						}
					}
				closedir($dir);
				if ($duplicate==false)
					{
					//Kiem tra xem da co ban ghi nao su dung hinh anh nay chua
					//Neu co thi ghi de ten file, new chua thi ghi voi file khac
					$check_used='select * from '.$tblname.' where id="'.$ID.'" order by id ASC';
					$docheck=mysql_query($check_used,$link);
					if (!$docheck)
						{
						$up_imgage=' Error !<br>';
						$allow_update=false;
						}
					else
						{
						$used=mysql_num_rows($docheck);
						$used_row=mysql_fetch_array($docheck);
						$used_img=$used_row[$image];
						if ($used_img!='')
							{	
							$upfile=$root_dir.$upimages_dir.$tblname.'/'.$used_img;
							$$iname=$used_img;
							$up_imgage.='- Replace old image with new image<br>';
							$allow_update=true;
							}
						else
							{
							$upfile=$root_dir.$upimages_dir.$tblname.'/'.$$iname;
							$up_imgage.='- Old image not found. Creat new image<br>';
							$allow_update=true;
							}
						if (move_uploaded_file($$itemp,$upfile))
							{
							$up_imgage.='- All action done !<br>';
							$allow_update=true;
							}
						else
							{
							$up_imgage=' Can not upload your selected image !<br>';
							$allow_update=false;
							}
						}
					}
				else
					{
					$$iname=$tblname.'/'.$file;
					$allow_update=true;
					}
				}
			}
		}
	}
?>