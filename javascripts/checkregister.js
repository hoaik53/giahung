function checkregister()
	{
 	str = document.checkreg.phone.value;
	if (document.checkreg.username.value=='')
		{
		alert('Bạn phải nhập tên truy cập !');
		document.checkreg.username.focus();
		return false;
		}
	if (document.checkreg.password.value=='')
		{
		alert('Bạn phải nhập mật khẩu !');
		document.checkreg.password.focus();
		return false;
		}
	if (document.checkreg.fullname.value=='')
		{
		alert('Bạn phải nhập họ và tên !');
		document.checkreg.fullname.focus();
		return false;
		}
	if (document.checkreg.genre.value=='')
		{
		alert('Bạn phải nhập giới tính !');
		document.checkreg.genre.focus();
		return false;
		}
	if (document.checkreg.address.value=='')
		{
		alert('Bạn phải nhập địa chỉ !');
		document.checkreg.address.focus();
		return false;
		}
	if (str=='')
		{
		alert('Bạn phải nhập số điện thoại !');
		document.checkreg.phone.focus();
		return false;
		}
	if (document.checkreg.email.value=='')
		{
		alert('Bạn phải nhập địa chỉ email !');
		document.checkreg.email.focus();
		return false;
		}
	if (document.checkreg.job.value=='')
		{
		alert('Bạn phải nhập nghề nghiệp !');
		document.checkreg.job.focus();
		return false;
		}
	if (document.checkreg.jobadd.value=='')
		{
		alert('Bạn phải nhập địa chỉ công tác !');
		document.checkreg.jobadd.focus();
		return false;
		}
	if (isNaN(str))
	 	{
 	   	alert("Số điện thoại phải là số !");
		document.checkreg.phone.focus();
		return false;
 	 	}
	mail = /^[a-z][a-z0-9_\.]*\@[a-z]*\.[a-z]*[a-z0-9_\.]*/g;
	if(mail.test(document.checkreg.email.value)==false)
		{
		alert("Email không hợp lệ !");
		document.checkreg.email.focus();
		flag=false;
		return false;
		}
	}
function forgotpass()
	{
	if (document.forgot.email.value=='')
		{
		alert('Bạn phải nhập địa chỉ email !');
		document.forgot.email.focus();
		return false;
		}
	mail = /^[a-z][a-z0-9_\.]*\@[a-z]*\.[a-z]*[a-z0-9_\.]$/g;
	if(mail.test(document.forgot.email.value)==false)
		{
		alert("Email không hợp lệ !");
		document.forgot.email.focus();
		flag=false;
		return false;
		}
	}