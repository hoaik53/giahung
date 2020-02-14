<form name="goback" method="get" action="">
<input type="hidden" name="module" value="categories">
<input type="hidden" name="tblname" value="">
</form>

<script language="JavaScript">
function takeback(name)
	{
	document.goback.tblname.value=name;
	document.goback.submit();
	}
</script>
	
<form name="img_mng" method="get" action="img_mng.php">
<input type="hidden" name="tblname" value="">
<input type="hidden" name="id" value="">
<input type="hidden" name="catID" value="">
</form>

<form name="viewnedit" method="get" action="">
<input type="hidden" name="module" value="viewrec">
<input type="hidden" name="tblname" value="">
<input type="hidden" name="catID" value="">
<input type="hidden" name="id" value="">
</form>

<form name="del" method="get" action="">
<input type="hidden" name="module" value="delete">
<input type="hidden" name="tblname" value="">
</form>

<script language="JavaScript">
function img_mng(tblname,id,cid)
	{
	document.img_mng.tblname.value=tblname;
	document.img_mng.id.value=id;
	document.img_mng.catID.value=cid;
	document.img_mng.submit();
	}
function view(tblname,id,cid)
	{
	document.viewnedit.tblname.value=tblname
	document.viewnedit.id.value=id
	document.viewnedit.catID.value=cid
	document.viewnedit.submit()
	}
function dodelete()
	{
	var isvalid=false
	for (var counter=0; counter < data_table.length; counter++)
		{
		if (data_table.elements[counter].checked == true)
			{
			isvalid=true;
			}
		}
	if (isvalid==true)
		{
		if (confirm('<?php echo $strDelete; ?> ?!!'))
			{
			if (confirm("<?php echo $strConfirm.' '.$strAgain; ?> !!!"))
				{
				document.data_table.submit();
				}
			}
		}
	else
		alert('Bạn phải chọn ít nhất một thông tin')
	}

</script>
<div style="width: 100%; text-align: center; position: relative; height: 30px; vertical-align: middle;">
    <div id="topcontrol" style="width: 100%; text-align: center; position: absolute;background-color: #E1E1E1;">
    <?php
    if (isset($_SESSION['userID']))
    	{
    	$allow_edit=true;
    	?>
        
    	<a href="javascript:void(0);" class="back_button" onClick="window.history.go(-1)">
    	<?php echo $strBack; ?>
    	</a>
    	<a href="javascript:void(0);" class="add_button" onClick="document.addnew.submit();">
    	<?php echo $strAdd; ?>
    	</a>
    	<a href="javascript:void(0);" class="del_button" onClick="dodelete('data_table')" >
    	<?php echo $strDelete; ?>
    	</a>
        
    	<?php
    	}
    else
    	{
    	?>
    	<p class="buttontext">&nbsp;&nbsp;<?php echo $strNotice['208']; ?></p>
    	<?php
    	}
    	?>
    </div>
</div>
<div class="block">
<table width="100%" border="0" cellpadding="0" cellspacing="0" background="">
	<tr><td height="40">
	<p class="bigtitle" style="text-align: left; margin: 0 0 0 36;">
	<img src="images/bs_forward.gif" width="16" height="16" align="absmiddle">
	<?php
		echo $_REQUEST['tblname'];
	?></p>
	</td></tr>
	  
	<tr align="center" valign="top">
    <td colspan="3" align="center" valign="top">
	<?php
	$havedata=false;
	if (!isset($_REQUEST['tblname']))
		{
		echo '<tr><td>';
		echo '<p class="bigtitle">No selected table !</p>';
		echo '</td></tr>';
		}
	else
		{
		$tblname=$_REQUEST['tblname'];
		//echo $tblname;
		// Khai bao thong tin ve bang
		//Thong tin ve cac cot cua bang
		@$open_file=fopen($db_dir.$tblname.'.'.$db_fileex,'r',1);
		if (!$open_file)
			{
			echo '<tr><td><p>';
			echo 'Can not retrieve Table field !';
			echo '</td></tr></p>';
			}
		else
			{
			//Khoi tao
			$start=0;
			$real_colum=1;
			$line=0;
			$title_array=array();
			$field_array=array();
			//Doc noi dung tung dong
			while($cur_line=fgets($open_file))
				{
				$line+=1;
				//echo $line;
				//Neu gap dong trong
				if (strlen($cur_line)==2)
					{
					$start=1;
					$start_line=$line+1;
					//echo $start_line;
					$index=$real_colum;
					$dimension=0;
					}
				//Bat dau lay DL
				if ($start==1 && $line>=$start_line)
					{
					$line_array=explode('-',$cur_line);
					$title_array[$index]=$line_array[0];
					$dimension+=round(strlen(trim($title_array[$index]))*12,0);
					$field_array[$index]=$line_array[1];
					//echo $field_array[$index];
					$index+=1;
					$havedata=true;
					}
				}
			}
		$title_array[0]='<input name="cbxSelectAll" style="display: ; margin: 0;" type="checkbox" onclick="javascript: checkAll(this.form);">';
		$field_array[0]='id';
		// So dong hien thi
		$max=100;
		//So cot hien thi
		$colum=5;
		//Kich thuoc chung cho moi cot
		//$dimension=100;
		$bordercolor='#336699';
		$titlecolor='#FFCC33';
		$hightlightcolor='#EEEEEE';
		$div_height=400;
		//show_datatbl($list,'datatbl','','dataTable',$title_array,$dimension,$field_array);
		?>
		<!-- Data Table -->
		<DIV style="WIDTH: 100%; OVERFLOW: auto; border: solid 1px <?php echo $bordercolor; ?>">
		<form name='addnew' method="get" action="">
		<input type="hidden" name="module" value="addnew">
		<input type="hidden" name="tblname" value="<?php echo $tblname; ?>">
		<?php
		if (isset($_REQUEST['catID']))
			{
			?>
			<input type="hidden" name="catID" value="<?php echo $_REQUEST['catID']; ?>">
			<?php
			}
		?>
		</form>
		<form name="data_table" method="post" action="">
		<input type="hidden" name="module" value="delete">
		<table id="dataTable" cellSpacing="1" cellPadding="0" border="0" width="1200">
			<TR bgcolor="<?php echo $titlecolor; ?>">
				<?php
				$i=0;
				while (isset($title_array[$i]))
					{
					echo '<td ';
					//echo 'width="" ';
					//echo $dimension;
					echo 'class="tdtitle">';
					echo $title_array[$i];
					echo '</td>';
					$i++;
					}
				?>
			</TR>
			<?php
			//Thong tin Browse
			if (isset($_POST['found']))
				$found=$_POST['found'];
			if (isset($_POST['totalpage']))
				$totalpage=$_POST['totalpage'];
			if (isset($_POST['curpage']))
				{
				$curpage=$_POST['curpage'];
				$from=($curpage-1)*$max;
				$to=$from+$max;
				$range=' limit '.$from.','.$to;
				}
			else
				$curpage=1;
			
			$list='select * from '.$tblname.' where';
			if (isset($_REQUEST['catID']) and $_REQUEST['catID']!='')
				$list.=' category="'.$_REQUEST['catID'].'" and';
			$list.=' lang="'.get_langID().'"';
			$list.=' order by id ASC';
			if (isset($range))
				$list.=$range;
			//echo $list;
			$doview=mysql_query($list,$link);
			//$doview=mysql_query($view,$link);
			$counter=1;
			if ($doview and mysql_num_rows($doview)>0)
				{
				$return_rows=mysql_num_rows($doview);
				//for ($i=0; $i<30000; $i++)
				while ($result=mysql_fetch_array($doview))
					{
					//$result=mysql_fetch_array($doview);
					$x=0;
					while (isset($field_array[$x]))
						{
						$$field_array[$x]=stripslashes(strip_tags(chop($result[$field_array[$x]])));
						$x++;
						}
						?>
				<TR id="dataRow<?php echo $id; ?>" onMouseOver="change(this,'<?php echo $hightlightcolor; ?>')" onMouseOut="undo(this)" style="cursor: pointer;">
					<TD TF_colKey="check" align="center" class="tdtext">
					<input type="checkbox" name="chkbox<?php echo $counter; ?>" value="<?php echo $id; ?>" onClick="javascript:colorRow(this);">
					</TD>
					<?php
					$j=$real_colum;
					while (isset($field_array[$j]))
						{
						$$field_array[$j]=get($$field_array[$j],20);
						echo '<TD width="';
						if ( strlen($title_array[$j]) < strlen($$field_array[$j]) )
							echo (strlen($$field_array[$j])*15);
						else
							echo (strlen($title_array[$j])*15);
						echo '" TF_colKey="'.$field_array[$j].'" class="tdtext" onClick="javascript: view(\''.$tblname.'\','.$result[0].'';
						if (isset($_REQUEST['catID']))
							echo ',\''.$_REQUEST['catID'].'\'';
						else
							echo ",''";
						echo ');">';
						echo $$field_array[$j];
						echo '</TD>';
						$j++;
						}
						?>
					</TR>
					<?php
					$counter++;
					}
				}
				?>
			</table>
			<input type="hidden" name="tblname" value="<?php echo $tblname; ?>">
			<?php
			if (isset($_REQUEST['catID']))
				echo '<input type="hidden" name="catID" value="'.$_REQUEST['catID'].'">';
			?>
			<input type="hidden" name="total_rows" value="<?php echo $return_rows; ?>">
			</form>
			</DIV>
			<!-- End Data Table -->
			<?php
			}
		?>
	</td>
    </tr>
</table>
</div>