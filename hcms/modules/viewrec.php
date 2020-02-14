<?php 
xcAutoHide=100;
xcStickyMode=1;
</script>
<form name="goback" method="get" action="">
<input type="hidden" name="module" value="quickedit"/>
<input type="hidden" name="tblname" value="">
<input type="hidden" name="catID" value="">
</form>
<script language="JavaScript">
function takeback(name,cid)
	{
	document.goback.tblname.value=name;
	document.goback.catID.value=cid;
	document.goback.submit();
	}
</script><?php
if (!isset($_REQUEST['tblname'],$_REQUEST['id']))
	{
	echo '<tr><td><p>';
	echo 'Chua chon ban ghi can xem';
	echo '</td></tr></p>';
	}
else
	{
	?>
    <form name="mainform" method="post" enctype="multipart/form-data" action="" onsubmit='return confirm(" :: XAC NHAN THONG TIN CAP NHAT ::\n\nClick OK de xac nhan tien hanh cap nhat\nClick CANCEL tro lai tiep tuc sua thong tin");'><?php
	$tblname=$_REQUEST['tblname'];
	$ID=$_REQUEST['id'];
	//Hien thi ten bang
	?><?php
	$thisheaders = ':: ';
	$thisheaders .= $siteName;
	$thisheaders .= ' -> '.$tblname.' -> '.$ID.' ::';
	?>
<div class="ui-widget-content" style="">
    	<h3 class="ui-widget-header" style=""><?=$thisheaders?></h3>
        <div class="ui-widget-body">
				<div class="adminform"><?php
						//Truy van CSDL ve ban ghi
						$detail='select * from '.$tblname;
						$detail.=' where id="'.$ID.'"';
						$dodetail=mysql_query($detail,$link);
						//Neu ko thanh cong
						if (!$dodetail)
							{
							echo '<div>';
							echo 'Co loi trong ket noi toi CSDL';
							echo '</div>';
							}
						else
							{
							$result=mysql_fetch_array($dodetail);
							//Index cua mang result
							$index=0;
							//Thong tin ve cac cot cua bang
							@$open_file=fopen($db_dir.$tblname.'.'.$db_fileex,'r',1);
							if (!$open_file)
								{
								echo '<div>';
								echo 'Khong the lay thong tin ve ban ghi !';
								echo '</div>';
								}
								else
								{
								//Khoi tao
								$start=0;
								$line=0;
								//Doc noi dung tung dong
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
										}
									//Bat dau lay DL
									if ($start==1 && $line>=$start_line)
										{
										$line_array=explode('-',$cur_line);
										//Tieu de cot
										$field_title=$line_array[0];
										$field_value=stripslashes($result[$line_array[1]]);
										//echo $field_value;
										//Hien thi len trinh duyet
										//echo '<div>';
										//Tieu de cot du lieu
										echo '<div class="label"><p align="left"><strong>'.$field_title.'</strong></p></div>';
										//Gia tri cot du lieu
										echo '<div class="field"><p align="justify">';
										//Goi ham xu ly kieu du lieu
										draw($line_array,$field_value);
										echo '</p></div>';
										echo '<div class="clear"></div>';
										$index+=1;
										}
									}
								}
							}
						?>
						<div>
                            <div>
        						<p align="center" style="margin-top:18; margin-bottom:0">
        						<input type="button" class="button" name="back" value="&laquo;<?php echo $strBack; ?>" onClick="takeback('<?php echo $tblname; ?>','<?php if (isset($_REQUEST['catID'])) echo $_REQUEST['catID']; else echo ''; ?>');">
        						<input type="submit"  class="button" name="send" value="<?php echo $strUpdate; ?> &raquo;">
        						<input type="hidden" name="module" value="update">
        						<input type="hidden" name="tblname" value="<?php echo $tblname; ?>">
        						<input type="hidden" name="id" value="<?php echo $ID; ?>"><?php
        						if (isset($_REQUEST['catID']))
        							{
        							?>
        							<input type="hidden" name="catID" value="<?php echo $_REQUEST['catID']; ?>"><?php
        							}
        						?>
        						</p>
                            </div>
                        </div>
						</form>
						
					</div>
     </div>
</div><?php
	}
?>
<br />
<br />                         