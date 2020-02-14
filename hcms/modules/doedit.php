<?php
session_start();
?>
<form name="goback" method="get" action="">
<input type="hidden" name="module" value="viewrec">
<input type="hidden" name="tblname" value="">
<input type="hidden" name="id" value="">
</form>
<script language="JavaScript">
function takeback(tblname,id)
	{
	document.goback.tblname.value=tblname;
	document.goback.id.value=id;
	document.goback.submit();
	}
</script>
<form name="vtable" method="get" action="">
<input type="hidden" name="module" value="quickedit">
<input type="hidden" name="tblname" value="">
<input type="hidden" name="catID" value="">
</form>
<script language="JavaScript">
function viewtable(name,cid)
	{
	document.vtable.tblname.value=name;
	document.vtable.catID.value=cid;
	document.vtable.submit();
	}
</script>
<?php
$have_image=false;
$allow_update=false;
$error=0;
$text='';
$load_var=' No input data or wrong! <br>';
$up_imgage='<br>';
$run_sql=' No command !<br>';
$check_row=' No data exist to update !<br>';
$status=' Proccessing ...<br>';
//$active='y';
//$impdate=date('Y-m-d H:i:s');
//$transfer='setTimeout("window.location=\'index.php\'",3000);';
if (isset($_POST['tblname']))
	{
	$tblname=$_POST['tblname'];
	if (isset($_POST['id']))
		$ID=$_POST['id'];
	
	//Kiem tra bien dau vao
	include ('get_vars.php');
	
	//Kiem tra ton tai cua ban ghi
	include ('test_exist.php');
	
	if ($have_image==true && $allow_update==true)
		{
		$imagesize=160000;
		$i=0;
		while (isset($type_array[$i]))
			{
			if ($type_array[$i]=='image')
				{
				$image=$field_array[$i];
				//echo $image;
				include ('up_image.php');
				}
			$i++;
			}
		}
	
	if ($allow_update==true)
		{
		$update='UPDATE ';
		$update.=$tblname;
		$update.=' set ';
		$counter=0;
		while (isset($field_array[$counter]))
			{
			/*
			echo $counter.' - ';
			echo $field_array[$counter].' - ';
			echo $type_array[$counter].' - ';
			echo $$field_array[$counter].'<br>';
			*/
			if ($type_array[$counter]=='image')
				{
				if ($have_image==true)
					{
					if ($counter>0)
						$update.=',';
					$temp_var=$field_array[$counter].'_name';
					$update.=$field_array[$counter].'="'.$$temp_var.'"';
					}
				}
			else
				{
				if ($counter>0)
					$update.=', ';
				$update.=$field_array[$counter].'="'.addslashes($$field_array[$counter]).'"';
				}
			$counter+=1;
			}
		$update.=' where id='.$ID;
		//echo $update;
		//exit;
		$doupdate=mysql_query($update,$link);
		if (!$doupdate)
			{
			$status='Error in conecting to Database';
			}
		else
			{
			$status='Congratulation ! Data updated succesfully !';
			if (isset($tblname,$ID))
				{
				$status.='<br>';
				$status.='<input type="button" class="button"  name="back" value=" &laquo; '.$strBack.' " onClick="takeback(\''.$tblname.'\',\''.$ID.'\');">';
				$status.='&nbsp;&nbsp;&nbsp;';
				$detail=' here ';
				$status.='<input type="button" class="button"  name="back" value=" '.$strViewtableTitle.' &raquo; " onClick="viewtable(\''.$tblname.'\'';
				if (isset($_POST['catID']))
					$status.=',\''.$_POST['catID'].'\'';
				else
					$status.='';
				$status.=');">';
				$status.='&nbsp;&nbsp;&nbsp;';
				$status.='</p>';
				}
			}
			
		}
	}
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="">
                <tr>
                  <td colspan="3" style="background: #fff;">
				  <p align="justify" style="margin-left: 18; line-height: 200%">
				  <strong>Load functions and procedure :</strong> Done !<br>
				  <strong>Check your exist data :</strong><?php echo $check_row ?>
				  <strong>Check your input data :</strong><?php echo $load_var ?>
				  <strong>Check your upload image : </strong><?php echo $up_imgage ?>
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
						echo '<input type="button" class="button" name="back" value="&laquo; '.$strBack.'" onClick="takeback(\''.$tblname.'\',\''.$ID.'\');">';
						echo '&nbsp;&nbsp;&nbsp;( Note : Your edited information will be lost )';
						}
					echo '</p>';
					}
				  ?>
				  </p>
				  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>