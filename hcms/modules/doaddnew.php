<?php
session_start();
?>
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
</head>

<?php
$have_image=false;
$allow_update=false;
$error=0;
$text='';
$load_var=' No input data or wrong! <br>';
$up_imgage='<br>';
$run_sql=' No command !<br>';
$check_row=' No check !<br>';
$status=' Proccessing ...<br>';
//$active='y';
//$impdate=date('Y-m-d H:i:s');
//$transfer='setTimeout("window.location=\'index.php\'",3000);';
if (isset($_POST['tblname']))
	{
	$tblname=$_POST['tblname'];
	
	//Kiem tra bien dau vao
	include ('get_vars.php');
	
	//Kiem tra ton tai cua ban ghi
	//include ('test_exist.php');
	
	if ($have_image==true && $allow_update==true)
		{
		$imagesize=170000;
		$i=0;
		while (isset($type_array[$i]))
			{
			if ($type_array[$i]=='image')
				{
				$image=$field_array[$i];
				$isize=$image.'_size';
				$itype=$image.'_type';
				$iname=$image.'_name';
				$itemp=$image.'_temp';
				//echo $image;
				include ('add_image.php');
				}
			$i++;
			}
		}
	
	if ($allow_update==true)
		{
		$update='INSERT into ';
		$update.=$tblname.'(';
		//Liet ke ten cac truong
		$counter=0;
		while (isset($field_array[$counter]))
			{
			if ($counter>0)
				$update.=',';
			$update.=$field_array[$counter];
			$counter+=1;
			}
		$update.=') values(';
		//Dien gia tri cac truong
		$counter=0;
		while (isset($field_array[$counter]))
			{
			if ($type_array[$counter]=='image')
				{
				if ($have_image==true)
					{
					if ($counter>0)
						$update.=',';
					$temp_var=$field_array[$counter].'_name';
					$update.='"'.$$temp_var.'"';
					}
				else
					{
					if ($counter>0)
						$update.=',';
					$update.='""';
					}
				}
			else
				{
				if ($counter>0)
					$update.=',';
				$update.='"'.addslashes($$field_array[$counter]).'"';
				}
			$counter+=1;
			}
		$update.=')';
		//echo $update;
		//exit;
		$doupdate=mysql_query($update,$link);
		if (!$doupdate)
			{
			$status='Error in conecting to Database ! This may be the following problem:<br>';
			$status.='- Duplicate data in current table. Please check your table content<br>';
			$status.='- Error in connecting to your server. Please contact your website administartor<br>';
			}
		else
			{
			$status='Congratulation ! Data updated succesfully !';
			if (isset($tblname))
				{
				//Lay thong tin ve bang
				//Doc thu muc
				$open_file=fopen($db_dir.$tblname.'.'.$db_fileex,'r');
				$first_line=fgets($open_file);
				$tbldetail=chop($first_line);
				$status.='<br>';
				$status.='<input class="button" style="height:24px"  type="button" name="back" value=" &laquo; '.$strViewtableTitle.' " onClick="takeback(\''.$tblname.'\'';
				if (isset($_POST['catname']))
					$status.=',\''.$_POST['catname'].'\'';
				else
					$status.=",''";
				if (isset($_POST['catID']))
				$status.=',\''.$_POST['catID'].'\'';
				else
					$status.=",''";
				$status.=');">';
				$status.='&nbsp;&nbsp;&nbsp;';
				$status.='<input type="button" class="button" style="height:24px"  name="back" value=" '.$strAdd.' &raquo; " onClick="document.addnew.submit();">';
				$status.='</p>';
				echo '<form name="addnew" method="get" action="">';
				echo '<input type="hidden" name="module" value="addnew">';
				echo '<input type="hidden" name="tblname" value="'.$tblname.'">';
				if (isset($_POST['catID']))
					echo '<input type="hidden" name="catID" value="'.$_POST['catID'].'">';
				if (isset($_POST['catname']))	
					echo '<input type="hidden" name="catname" value="'.$_POST['catname'].'">';
				echo '</form>';
				}
			}
		
			
		}
	}



//exit;
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" background="#fff">
                <tr>
                  <td colspan="3" style="background-color: #fff;">
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
					if (isset($tblname))
						{
						//Lay thong tin ve bang
						//Doc thu muc
						$open_file=fopen($db_dir.$tblname.'.'.$db_fileex,'r');
						$first_line=fgets($open_file);
						$tbldetail=chop($first_line);
						$status.='<br>';
						$status.='<input type="button" class="button" name="back" value="^ Xem bang" onClick="takeback(\''.$tblname.'\',\''.$tbldetail.'\');">';
						$status.='&nbsp;&nbsp;&nbsp;( Note : View your updated data )</p>';
						}
					}
				  ?>
				  </p>
				  </td>
                </tr>
              </table>
