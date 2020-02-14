<?php
session_start();
?>
<script language="JavaScript">
function takeback()
	{
	document.goback.submit();
	}
</script>
</head>

<?php
$have_image=false;
$allow_update=false;
$allow_remove=true;
$error=0;
$text='';
//$load_var=' No input data or wrong! <br>';
$rem_image='<br>';
$run_sql=' No command !<br>';
$check_row=' No data exist to update !<br>';
$status=' Proccessing ...<br>';

if (isset($_REQUEST['tblname']))
	{
	$tblname=$_REQUEST['tblname'];
	//echo 'Table name : '.$tblname;
	$IDs='';
	if (isset($_REQUEST['total_rows']))
		{
		//echo 'Total rows : '.$_REQUEST['total_rows'];
		$counter=0;
		for ($i=1;$i<=$_REQUEST['total_rows'];$i++)
			{
			if (isset($_REQUEST['chkbox'.$i]) and $_REQUEST['chkbox'.$i]!='')
				{
				$counter++;
				if ($counter>1)
					$IDs.=',';
				$IDs.=$_REQUEST['chkbox'.$i];
				}
			}
		//echo 'Selected : '.$IDs;
		if ($counter>0)
			$allow_update=true;
		}
	//Kiem tra ton tai cua ban ghi
	//include ('test_exist.php');
	
	if ($allow_update==true)
		{
		//Lay thong tin ve cac truong co chua anh
		@$open_file=fopen($db_dir.$tblname.'.'.$db_fileex,'r',1);
		if (!$open_file)
			{
			echo '<p>';
			echo 'Khong the lay thong tin ve ban ghi !';
			echo '</p>';
			$allow_update=false;
			}
		else
			{
			//Khoi tao
			$start=0;
			$line=0;
			//Doc noi dung tung dong
			$img_count=0;
			while($cur_line=fgets($open_file))
				{
				$line+=1;
				if ($line==1)
					$tbldetail=chop($cur_line);
				//echo $line;
				//Neu gap dong trong
				if (strlen($cur_line)==2)
					{
					$start=1;
					$start_line=$line+1;
					//echo $start_line;
					$index=0;
					$img_count=0;
					$field_array=array();
					$type_array=array();
					$image_array=array();
					}
				//Bat dau lay DL
				if ($start==1 && $line>=$start_line)
					{
					$line_array=explode('-',$cur_line);
					//Tieu de cot
					$field_array[$index]=$line_array[1];
					$type_array[$index]=$line_array[2];
					//echo $type_array[$index];
					if ($type_array[$index]=='image')
						{
						$image_array[$img_count]=$field_array[$index];
						//echo $image_array[$img_count];
						$img_count+=1;
						}
					//$var=$field_array[$index];
					//$type=$type_array[$index];
					$index+=1;
					}
				//$load_var=' Done !<br>';
				$allow_update=true;
				}
			//echo 'Image count: '.$img_count;
			}
		
		//Kiem tra noi dung truong co chua anh
		$img_count=0;
		while (isset($image_array[$img_count]))
			{
			//Noi dung truong co chua anh
			$cur_image='select * from '.$tblname.' where id in ('.$IDs.')';
			$docur_image=mysql_query($cur_image,$link);
			if (!$docur_image)
				{
				$rem_image.='- Can not get image information for '.$image_array[$img_count].'<br>';
				$allow_update=false;
				}
			else
				{
				$image='';
				while ($temp_result=mysql_fetch_array($docur_image))
					{
					$image=$temp_result[$image_array[$img_count]];
					if ($image=='')
						{
						$rem_image.='- No exist image for field <strong>'.$image_array[$img_count].'</strong> to delete<br>';
						$have_image=false;
						}
					else
						{
						$have_image=true;
						//Kiem tra xem anh co duoc su dung boi ban ghi khac khong
						//Danh sach cac bang de kiem tra
						$dir=opendir($db_dir);
						$tbl_counter=0;
						$tbl_array=array();
						while ($cur_file=readdir($dir))
							{
							if (strlen($cur_file)>2)
								{
								$dotpos=strpos(basename($cur_file),'.');
								$tbl_array[$tbl_counter]=substr($cur_file,0,$dotpos);
								//echo $tbl_array[$tbl_counter].'<br>';
								//Cac truong anh cua cac bang hien thoi
								$fo=fopen($db_dir.$tbl_array[$tbl_counter].'.'.$db_fileex,'r',1);
								$line_counter=0;
								$start_line==0;
								while ($cur_line=fgets($fo))
									{
									//echo $cur_line.'<br>';
									if (strlen($cur_line)==2)
										{
										$start_line=$line_counter;
										$sub_index=0;
										}
									if ($line_counter>$start_line)
										{
										$line_array=explode('-',$cur_line);
										$fname[$sub_index]=$line_array[1];
										$ftype[$sub_index]=$line_array[2];
										//echo $ftype[$sub_index];
										if ($ftype[$sub_index]=='image')
											{
											$check_used='select * from '.$tbl_array[$tbl_counter].' where '.$fname[$sub_index].'="'.$image.'"';
											//echo $check_used.'<br>';
											$docheck_used=mysql_query($check_used);
											if (!$docheck_used)
												{
												$rem_image.='- Can not check for record used this image';
												$allow_update=false;
												}
											else
												{
												$rows=mysql_num_rows($docheck_used);
												if ($rows>=2)
													{
													while ($result=mysql_fetch_array($docheck_used))
														$rem_image.='- Image used by <strong>'.$tbl_array[$tbl_counter].'</strong> -> '.$result[0].'<br>';
													$rem_image.='This image will not be removed !<br>';
													$allow_remove=false;
													$allow_update=true;
													}
												}
											}
										$sub_index+=1;
										}
									$line_counter+=1;
									}
								}
							}
						//echo 'Here - '.$have_image.' - '.$allow_remove.'<br>';
						if ($allow_remove==true && $have_image==true)
							{
							$rem_image.='- Test OK ! No another records used <b>'.$image.'</b> , prepare to delete ...<br>';
							///*
							$file_to_remove=str_replace('/','//',$root_dir.$upimages_dir).$tblname.'//'.$image;
							//$dir=opendir($upimages_dir.$tblname.'\\');
							//echo $file_to_remove;
							if (!unlink($file_to_remove))
								{
								$rem_image.=' - Can not remove this image from server. Request canceled<br>';
								$allow_update=false;
								}
							else
								{
								$rem_image.=' - Image of '.$image_array[$img_count].' : <strong>'.$image.'</strong> has been deleted successfully !<br>';
								$allow_update=true;
								closedir($dir);
								}
							//*/
							}
						}
					}
				}
			$img_count+=1;
			}
		//echo $rem_image;
		//exit;
		}
	
	if ($allow_update==true)
		{
		$delete='delete from ';
		$delete.=$tblname;
		$delete.=' where id in ('.$IDs.')';
		//echo $delete;
		//exit;
		$dodelete=mysql_query($delete,$link);
		if (!$dodelete)
			{
			$status='Error in conecting to Database';
			}
		else
			{
			$status='Congratulation ! Data deleted succesfully !';
			if (isset($tblname))
				{
				//Lay thong tin ve bang
				//Doc thu muc
				$open_file=fopen($db_dir.$tblname.'.'.$db_fileex,'r');
				$first_line=fgets($open_file);
				$tbldetail=chop($first_line);
				$status.='<br>';
				?>
				<form name="goback" method="get" action="">
				<input type="hidden" name="module" value="viewtbl">
				<input type="hidden" name="tblname" value="<?php echo $tblname; ?>">
				<?php
				if (isset($_REQUEST['catname']))
					echo '<input type="hidden" name="catname" value="'.$_REQUEST['catname'].'">';
				if (isset($_REQUEST['catname']))
					echo '<input type="hidden" name="catID" value="'.$_REQUEST['catID'].'">';
				?>
				</form>
				<?php
				$status.='<input type="button" name="back" value=" &laquo; '.$strViewtableTitle.' " onClick="takeback();">';
				$status.='&nbsp;&nbsp;&nbsp;( Note : View your updated data )</p>';
				}
			}	
		}
	}
//exit;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" background="">
                <tr>
                  <td colspan="3">
				  <p align="justify" style="margin-left: 18; line-height: 200%">
				  <strong>Load functions and procedure :</strong> Done !<br>
				  <strong>Check your exist data :</strong><?php echo $check_row; ?>
				  <strong>Check your exist image : </strong><?php echo $rem_image; ?>
				  <?php 
				  if ($allow_update==true)
				  	{
					echo '<font color="#FF3300"><strong>Start updating your Data - Please wait for a minute !<br></strong></font>';
					?>
					<strong>Update status :<br></strong><?php echo $status ?>
					
					<?php
					}
				  else
				  	{
					echo '<p align="left" style="margin-top: 12">';
					echo '<font color="#FF3300"><strong>Can not update your Data - Please check your input data !<br></strong></font><br>';
					if (isset($tblname,$ID))
						{
						echo '<input type="button" name="back" value="<< Quay lai" onClick="takeback(\''.$tblname.'\',\''.$ID.'\');">';
						echo '&nbsp;&nbsp;&nbsp;( Note : Your edited information will be lost )</p>';
						}
					}
				  ?>
				  </p>
				  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
