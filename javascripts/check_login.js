function checkform(frmname)
	{
	if (document.login.username.value=='')
		{
		alert('<!-- strNoUserName -->');
		document.login.username.focus();
		return false;
		}
	if (document.login.password.value=='')
		{
		alert('<!-- strNoPassWord -->');
		document.login.password.focus();
		return false;
		}
	}