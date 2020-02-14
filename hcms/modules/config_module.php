<script>
xcAutoHide=100;
xcStickyMode=1;
</script>
<form name="goback" method="get" action="">
<input type="hidden" name="module" value="viewtbl">
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
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td align="center" valign="top">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" background="">
          
		  <tr><td align="center" valign="middle" colspan="3">&nbsp;
		  
		  </td></tr>
		  <tr align="center" valign="top">
            <td colspan="3" align="center" valign="top">
			<table cellpadding="0" cellspacing="0" width="95%" border="0">
				<?php
				if (!isset($_REQUEST['tblname']))
					{
					echo '<tr><td><p>';
					echo 'Chua chon ban ghi can xem';
					echo '</td></tr></p>';
					}
				else
					{
					echo '<form name="mainform" method="post" enctype="multipart/form-data" action="" onsubmit=\'return confirm(" :: XAC NHAN THONG TIN CAP NHAT ::\n\nClick OK de xac nhan tien hanh cap nhat\nClick CANCEL tro lai tiep tuc sua thong tin");\'>';
					$tblname=$_REQUEST['tblname'];
					$ID=$_REQUEST['id'];
					//Hien thi ten bang
					?>
					<tr><td colspan="3">
					<p align="left" style="margin-top:6; margin-bottom:6; margin-left:0">
					<font color="#FF3300" size="2"><strong>
					<?php
					echo ':: ';
					echo $siteName;
					echo ' -> '.$tblname.' -> '.$strConfigModule.' ::';
					?>
					</strong></font></p>
					</td></tr>
					<?php
					//Truy van CSDL ve ban ghi
					$detail='select * from '.$tblname;
					$detail.=' where id="1"';
					$dodetail=mysql_query($detail,$link);
					//Neu ko thanh cong
					if (!$dodetail)
						{
						echo '<tr><td><p>';
						echo 'Chưa có cấu hình khởi tạo';
						echo '</td></tr></p>';
						}
					else
						{
						$result=mysql_fetch_array($dodetail);
						//Index cua mang result
						$index=0;
						//Thong tin ve cac cot cua bang
						@$open_file=fopen($db_dir.$tblname.'.'.$cf_fileex,'r',1);
						if (!$open_file)
							{
							echo '<tr><td><p>';
							echo 'Khong the lay thong tin ve ban ghi !';
							echo '</td></tr></p>';
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
									echo '<tr>';
									//Tieu de cot du lieu
									echo '<td width="25%" valign="top"><p align="left"><strong>'.$field_title.'</strong></p></td>';
									//Cot trong
									echo '<td width="5%">&nbsp;</td>';
									//Gia tri cot du lieu
									echo '<td width="70%" valign="top"><p align="justify">';
									//Goi ham xu ly kieu du lieu
									draw($line_array,$field_value);
									echo '</p></td>';
									echo '</tr>';
									$index+=1;
									}
								}
							}
						}
					?>
					<tr><td colspan="3">
					<p align="center" style="margin-top:18; margin-bottom:0">
					<input type="button" name="back" value="&laquo; <?php echo $strBack; ?>" onClick="takeback('<?php echo $tblname; ?>','<?php if (isset($_REQUEST['catID'])) echo $_REQUEST['catID']; else echo ''; ?>');">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="submit" name="send" value="<?php echo $strUpdate; ?> &raquo;">
					<input type="hidden" name="module" value="update">
					<input type="hidden" name="tblname" value="<?php echo $tblname; ?>">
					<input type="hidden" name="id" value="<?php echo $ID; ?>">
					<?php
					if (isset($_REQUEST['catID']))
						{
						?>
						<input type="hidden" name="catID" value="<?php echo $_REQUEST['catID']; ?>">
						<?php
						}
					?>
					</p></td></tr>
					</form>
					<?php
					}
				?>
				</table>
			</td>
          </tr>
          
		</table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
    </table></td>
    <td width="5">&nbsp;</td>
  </tr>
</table>