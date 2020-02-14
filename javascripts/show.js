function show(trid)
	{
	for (i=1;i<=4;i++)
		{
		if (i==trid)
			{
			status=eval('document.all.option' + i + '.style.display;');
			if (status=='none')
				{
				eval('document.all.option' + i + '.style.display="block";');
				eval('document.all.btntxt' + i + '.style.color="#FF0000";');
				}
			else
				{
				eval('document.all.option' + i + '.style.display="none";');
				eval('document.all.btntxt' + i + '.style.color="#000000";');
				}
			}
		else
			{
			eval('document.all.option' + i + '.style.display="none";');
			eval('document.all.btntxt' + i + '.style.color="#000000";');
			}
		}
	}