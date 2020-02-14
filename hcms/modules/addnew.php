
<script>
xcAutoHide=100;
xcStickyMode=1;
</script>
<form name="goback" method="get" action="">
<input type="hidden" name="module" value="quickedit">
<input type="hidden" name="tblname" value="">
<input type="hidden" name="catname" value="">
<input type="hidden" name="catID" value="">
</form>

<script language="JavaScript">
function takeback(name,cname,cid)
{
document.goback.tblname.value=name;
document.goback.catname.value=cname;
document.goback.catID.value=cid;
document.goback.submit();
}
</script>
<?php
if (!isset($_REQUEST['tblname']))
	{
	echo '<tr><td><p>';
	echo 'Chua chon bang de them ban ghi<br>';
	echo '</td></tr></p>';
	}
else
{ 
    $tblname=$_REQUEST['tblname'];
	if (isset($_REQUEST['catID']))
		{
		$catID=$_REQUEST['catID'];
		$category=$catID;
		}
    $thisheaders = ':: '.$siteName.' -> '.$tblname.' ::';
    ?>
<div class="ui-widget-content" style="">
    	<h3 class="ui-widget-header" style=""><?=$thisheaders?></h3>
        <div class="ui-widget-body">
					<form class="adminform" name="mainform" method="post" enctype="multipart/form-data" action="" onsubmit='return confirm(" :: XAC NHAN THONG TIN CAP NHAT ::\n\nClick OK de xac nhan tien hanh cap nhat\nClick CANCEL tro lai tiep tuc sua thong tin");'>
                    <?php
						//Index cua mang result
						$index=0;
						//Thong tin ve cac cot cua bang
						@$open_file=fopen($db_dir.$tblname.'.'.$db_fileex,'r',1);
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
                                    $field_title = $line_array[0];
                                    if (isset($$line_array[1]))
										$field_value=$$line_array[1];
									else
										$field_value='';
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
						?>
                        <div>
                            <div>
        						<p align="center" style="margin-top:18; margin-bottom:0">
        						<input type="button" class="button" name="back" value=" &laquo; <?php echo $strBack; ?>" onClick="takeback('<?php echo $tblname; ?>','<?php if (isset($_REQUEST['catname'])) echo $_REQUEST['catname']; else echo ''; ?>','<?php if (isset($_REQUEST['catID'])) echo $_REQUEST['catID']; else echo ''; ?>');">
        						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        						<input type="submit" class="button"  name="send" value=" <?php echo $strAdd; ?> &raquo; ">
        						<input type="hidden" name="tblname" value="<?php echo $tblname; ?>">
        						<input type="hidden" name="module" value="insert">
        						<?php
        						if (isset($_REQUEST['catID']))
        							{
        							?>
        							<input type="hidden" name="catID" value="<?php echo $_REQUEST['catID']; ?>">
        							<?php
        							}
        						if (isset($_REQUEST['catname']))
        							{
        							?>
        							<input type="hidden" name="catname" value="<?php echo $_REQUEST['catname']; ?>">
        							<?php
        							}
        						?>
        						</p>
                            </div>
                        </div>
						</form>
						<?php
						}
					?>
		</div>
    </div>
</div>
