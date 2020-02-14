<?php if (substr_count($_SERVER['PHP_SELF'],'/login.php')>0) die ("You can't access this file directly..."); ?>
<?php
$invalid=false;
//------------------------------------- ACTIONS ------------------------------------------
if (isset($_REQUEST['action']))
	{
	$action=$_REQUEST['action'];
	//echo $action;
	switch ($action)
		{
		case 'logout':
		if (session_destroy())
			set_notice($strLogoutOk);
		else
			set_error();
        echo "<script> function delayer(){
                window.location = \"index.php\";
            } ;
            setTimeout('delayer()', 2000);
            </script>";
		break;
		
		case 'changepass':
		if (!isset($_POST['olduser'],$_POST['oldpass'],$_POST['newpass']))
			{
			$msg.='<p align="justify"><font color="FF0000"><strong>';
			$msg.=''.$strErr['206'].'';
			$msg.='</strong></font></p>';
			session_destroy();
			}
		else
			{
			$olduser=$_POST['olduser'];
			//echo $olduser;
			if (checkvalid($olduser)==false)
				{
				$error_msg.='<br>- '.$strErr['202'].' ';
				$error+=1;
				$invalid=true;
				}
			$oldpass=$_POST['oldpass'];
			//echo $oldpass;
			if (checkvalid($oldpass)==false)
				{
				$error_msg.='<br>- '.$strErr['203'].' ';
				$error+=1;
				$invalid=true;
				}
			$newpass=$_POST['newpass'];
			//echo $newpass;
			if (checkvalid($newpass)==false)
				{
				$error_msg.='<br>- '.$strErr['207'].' ';
				$error+=1;
				$invalid=true;
				}
			$error_msg.='</p>';
			
			if ($invalid==true && $error>0)
				{
				$msg.=$error_msg;
				}
			else
				{
				$check='select * from users where username="'.$olduser.'" and password="'.$oldpass.'" limit 0,1';
				$docheck=mysql_query($check,$link);
				if (!$docheck)
					{
					$msg.='<br>- '.$strErr['101'].'';
					}
				else
					{
					$row=mysql_num_rows($docheck);
					if ($row!=1)
						{
						$msg.='<br>- '.$strAccessDenied.' !';
						}
					else
						{
						$update='UPDATE users SET password="'.$newpass.'" where username="'.$olduser.'"';
						$doupdate=mysql_query($update,$link);
						if (!$doupdate)
							{
							$msg.='<br>- '.$strErr['101'].'';
							}
						else
							{
							session_destroy();
							$msg.='<br>- '.$strUpdateOk.'';
							}
						}
					}
				}
			}
		break;
		}
	}
//----------------------------------- END OF ACTIONS ------------------------------------
	
//-----------------------------------  PROCCESSING --------------------------------------
if (isset($_POST['username'],$_POST['password']))
	{
	///*
	$invalid_array=array('"','\'',' or ','=','?','.','$','<','>','/','!','~','@','#','$','^','&','*','*','(',')');
	$username=strtolower(strip_tags($_POST['username']));
	$username=chop($username);
	//$username=addslashes($username);
	$i=0;
	//$error_msg='';
	while (isset($invalid_array[$i]))
		{
		if (strstr($username,$invalid_array[$i]))
			{
			//$error_msg.='<br>- '.$strErr['202'].'';
			set_error($strErr['202']);
			$invalid=true;
			break;
			}
		$i++;
		}
	
	$password=strtolower(strip_tags($_POST['password']));
	$password=chop($password);
	$i=0;
	while (isset($invalid_array[$i]))
		{
		if (strstr($password,$invalid_array[$i]))
			{
			//$error_msg.='<br>- '.$strErr['203'].'';
			set_error($strErr['203']);
			$invalid=true;
			break;
			}
		$i++;
		}
	if ($invalid==false)
		{
		$username=trim($_POST['username']);
		$password=trim($_POST['password']);
		///$msg.='<font color="red"><strong>=> '.$strLoading.'</strong></font><br><br>';
		//$msg.='';
		//Kiem tra USERNAME va PASSWORD
		$password=md5($password);
		$check='select * from users where username="'.$username.'" and password="'.$password.'" limit 0,1';
		$docheck=mysql_query($check,$link);
		if (!$docheck)
			{
			//$msg.='<br>- '.$strErr['101'].'';
			set_error($strErr['101']);
			}
		else
			{
			$row=mysql_num_rows($docheck);
			if ($row!=1)
				{
				set_error($strErr['204']);
				//$msg.='<br>- '.$strLoading.' ';
				}
			else
				{
				$result=mysql_fetch_array($docheck);
				$userID=$result['id'];
				$usergroup=$result['groupof'];
				$username=$result['username'];
				$_SESSION['userID']=$userID;
				$_SESSION['username']=$username;
				$_SESSION['usergroup']=$usergroup;
				//$_SESSION['password']=$password;
				//$msg.='<br>- '.$strLoginOk.'';
				set_notice($strLoginOk);
				?>
				<script language="JavaScript">
				setTimeout('window.location.replace("<?php echo $phpself; ?>?module=cpanel")',3000);
				</script>
				<?php
				}
			}
		}
	$msg.='</p>';
	}
else
	{
	$msg.=$strLoginNote;
	}
?>
<div style="background-color: #DFEFF9; text-align: center; width:100%">
<div id="logform">
    <div id="logform_top"></div>
    <div id="logform_middle">
        <form name="login" method="post" onsubmit="return checkform();">
		<!--?php if (!load_languages()) echo 'Can not load languages'; ?-->
        <span class="label"><?php echo $strUserName; ?></span>
        <input class="cinput" type="text" name="username" size="39"/>
        <span class="label"><?php echo $strPassWord; ?></span>
        <input class="cinput" type="password" name="password" size="39"/>
        <input type="reset" class="button" value="<?php echo $strReset; ?>">
        <input type="submit" class="button" value="<?php echo $strLogin; ?>"/>
        <div class="clear"></div>
        <div>
            <?php
    		//if ($error>0) show_error(); 
    		if ($notice>0) show_notice();
    		?>
        </div>
        </form>
        <div class="clear"></div>
    </div>
    <div id="logform_bottom"></div>
</div>
</div>