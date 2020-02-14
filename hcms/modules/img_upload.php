<?php
session_start();
include('function.php');
?>
<html>
<head>
<title>:: SMS - Site Manager System :: <?php echo $_SESSION['Site name']; ?> - Cap nhat thong tin ban ghi ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="style.css">
<form name="goback" method="post" action="viewtbl.php">
<input type="hidden" name="tblname" value="">
<input type="hidden" name="tbldetail" value="">
</form>
<script language="JavaScript">
function takeback(name,detail)
{
document.goback.tblname.value=name;
document.goback.tbldetail.value=detail;
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
$up_image='';
$run_sql=' No command !<br>';
$check_row=' No check !<br>';
$status=' Proccessing ...<br>';
//$active='y';
//$impdate=date('Y-m-d H:i:s');
//$transfer='setTimeout("window.location=\'index.php\'",3000);';
if (isset($_POST['tblname'],$_POST['id']))
	{
	$tblname=$_POST['tblname'];
	//echo $tblname;
	$ID=$_POST['id'];
	//echo $ID;
	//Kiem tra bien dau vao
	set_time_limit(0);
	$max_imgsize=100000;
	$img_prefix='upimage0';
	for ($y=1;$y<=$max_upload_img;$y++)
		{
		$image=$img_prefix.$y;	
		$up_image.='<br><strong>- Upload image number '.$y.' : </strong>';
		if (isset($_FILES[$image]))
			{
			$error=0;
			//$image=$_FILES['\''.$upimg_name.'\''];
			$iname=$image.'_name';
			$$iname=$_FILES[$image]['name'];
			if ($$iname!='')
				{
				$up_image.='<br>&nbsp;&nbsp;&nbsp;<strong> Name :</strong> '.$$iname;
				$isize=$image.'_size';
					$$isize=$_FILES[$image]['size'];
				$up_image.=' / <strong>Size :</strong> '.$$isize.' bytes';
				if ($$isize>$max_imgsize)
					{
					$up_image.='<br>-> Image size is not allowed (must be < '.$max_imgsize.' ) !';
					$error+=1;
					}
				if ($$isize==0)
					{
					$up_image.='<br>-> Image\'s size is ZERO !';
					$error+=1;
					}
				$itype=$image.'_type';
				$$itype=$_FILES[$image]['type'];
				$up_image.=' / <strong>Type :</strong> '.$$itype;
				if ($$itype!='image/gif' && $$itype!='image/pjpeg' && $$itype!='image/bmp')
					{
					$up_image.='<br>-> This image type is not allowed !';
					$error+=1;
					}
				$itemp=$image.'_temp';
				$$itemp=$_FILES[$image]['tmp_name'];
					//echo $image;
				if ($error==0)
					{
					$upfile=$upimages_dir.$tblname.'\\'.$ID.'\\'.$$iname;
					if (move_uploaded_file($$itemp,$upfile))
						{
						$up_image.='-> Upload proccess is allowed and successfully !';
						}
					else
						{
						$up_image.='-> Upload proccess is allowed but cannot upload ! May be connnection error. Please try again later or select smaller image size.';
						}
					}
				else
					{
					$up_image.='-> Upload proccess is not allowed !';
					}
				}
			else
				{
				$up_image.=' not selected !<br>';
				}
			}
		
		}
		
	if (isset($tblname))
		{
		//Lay thong tin ve bang
		//Doc thu muc
		$open_file=fopen($db_dir.$tblname.'.'.$db_fileex,'r');
		$first_line=fgets($open_file);
		$tbldetail=chop($first_line);
		$status.='<br>';
		$status.='<input type="button" name="back" value="<< Xem bang" onClick="takeback(\''.$tblname.'\',\''.$tbldetail.'\');">';
		$status.='&nbsp;&nbsp;&nbsp;( Note : View your updated data )</p>';
		}
	}
	
//exit;
?>
<body topmargin="0" leftmargin="0">
<center>
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top">
	<?php include ('top.php'); ?>
	</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10">&nbsp;</td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="">
                <tr>
                  <td width="32" align="center" valign="top"><img src="images/red_lefttitle.jpg" width="32" height="26"></td>
                  <td width="700" background="images/titlebg.gif">
                    <p align="center"><strong> Bang theo doi tien trinh - Proccess
                         information</strong></p>
                  </td>
                  <td width="32" align="center" valign="top"><img src="images/red_righttitle.jpg" width="32" height="26"></td>
                </tr>
                <tr>
                  <td colspan="3">
				  <p align="justify" style="margin-left: 18; line-height: 200%">
				  <strong>Your upload image status: </strong><?php echo $up_image ?>
				  <?php 
				  
				  ?>
				  </p>
				  </td>
                </tr>
                <tr>
                  <td colspan="3" bordercolor="#FF3300" style="border-bottom-style: solid; border-bottom-width: 2">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/tablebg.gif">
                <tr>
                  <td width="32" align="center" valign="top"><img src="images/red_lefttitle.jpg" width="32" height="26"></td>
                  <td background="images/titlebg.gif">
                    <p align="center"><strong> Thong tin mo ta chi tiet</strong></p>
                  </td>
                  <td width="32" align="center" valign="top"><img src="images/red_righttitle.jpg" width="32" height="26"></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" bordercolor="#FF3300" style="border-bottom-style: solid; border-bottom-width: 2">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
        </table></td>
        <td width="10" align="center" valign="top">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="32" background="images/topmenu_bg.gif" style="border-top-style: solid; border-top-width: 2;" bordercolor="#FF3300">
		<p align="center">Made by TuMinh @ Global Co.,Ltd - All rights reserved - Please contact nguyenminhtu@msn.com for further information - 2006</p>
		</td>
      </tr>
    </table></td>
  </tr>
</table>
</center>
</body>
</html>
