<?php
$duplicate=false;
$curdir=$upimages_dir.$tblname.'\\';
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
			$rem_imgage=' Done ! <br>';
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
	$rem_imgage.='- ';
	$rem_imgage.='Use existing image on server !<br>';
	$rem_imgage.='<img src="'.$curdir.$file.'">';
	$rem_imgage.='<br>';
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
					$rem_imgage=' Error !<br>';
					$allow_update=false;
					}
				else
					{
					$used=mysql_num_rows($docheck);
					$used_row=mysql_fetch_array($docheck);
					$used_img=$used_row[$image];
					if ($used_img!='')
						{	
						$upfile=$upimages_dir.$tblname.'\\'.$used_img;
						$$iname=$used_img;
						$rem_imgage.='- Replace old image with new image<br>';
						$allow_update=true;
						}
					else
						{
						$upfile=$upimages_dir.$tblname.'\\'.$$iname;
						$rem_imgage.='- Old image not found. Creat new image<br>';
						$allow_update=true;
						}
					if (move_uploaded_file($$itemp,$upfile))
						{
						$rem_imgage.='- All action done !<br>';
						$allow_update=true;
						}
					else
						{
						$rem_imgage=' Can not upload your selected image !<br>';
						$allow_update=false;
						}
					}
				}
			else
				{
				$$iname=$tblname.'\\'.$file;
				$allow_update=true;
				}
			}
		}
	}
?>