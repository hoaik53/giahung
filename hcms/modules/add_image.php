<?php
//$warning=0;

if (strlen($$iname)>0)
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
				$duplicate=false;
				$curdir=$root_dir.$upimages_dir.$tblname.'/';
				if (@$dir=opendir($curdir))
					{
					while ($file=readdir($dir))
						{
						if ($file==$$iname)
							{
							$temp=filesize($curdir.$file);
							//Lay thong tin ve bang
							//Doc thu muc
							$open_file=fopen($db_dir.$tblname.'.'.$db_fileex,'r');
							$first_line=fgets($open_file);
							$tbldetail=chop($first_line);
							
							if ($temp==$$isize)
								{
								$share_image=basename($file);
								?>
								<script language="JavaScript">
								alert('Image existed on server. Use it. You can change later')
								/*
								if (confirm('Chu y: hinh anh nay da co tren server ! Ban co muon dung chung ko ?')==false)
									{
									takeback('<?php echo $tblname; ?>','<?php echo $tbldetail; ?>');
									}
								else
									{
									<?php
									$up_imgage=' Done ! <br>';
									?>
									}
								*/
								</script>
								<?php
								}
							else
								{
								?>
								<script language="JavaScript">
								alert('Chu y: Ten file nay da co tren server ! Ban phai doi ten truoc');
								takeback('<?php echo $tblname; ?>','<?php echo $tbldetail; ?>');
								</script>
								<?php
								}
							$up_imgage.='- ';
							$up_imgage.='Preview existed image on server !<br>';
							$up_imgage.='<img src="'.$curdir.$file.'">';
							$up_imgage.='<br>';
							$duplicate=true;
							break;
							}
						}
					closedir($dir);
					}
				if ($duplicate==false)
					{
					$upfile=$root_dir.$upimages_dir.$tblname.'/'.$$iname;
					$up_imgage.='- Test OK ! No duplication of this image on server<br>';
					$allow_update=true;
					}
				else
					{
					$$iname=$share_image;
					$up_imgage.='- Use existed image on server<br>';
					$allow_update=true;
					}
				if (isset($upfile))
					{
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
			}
		}
	}
?>