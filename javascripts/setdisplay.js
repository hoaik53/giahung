function setdisplay(_a) 
{
	var formlength=16;
	if (document.all)
	{ // is IE
		if (_a=='edit')
		{
			for (i=1 ; i<=formlength; i++)
			{
			eval("document.getElementById('form"+ i + "').style.display='block';");
			eval("document.getElementById('info"+ i + "').style.display='none';");
			//eval("document.all.info"+ i + ".style.display='none';");
			}
		}
		if (_a=='view')
		{
			for (i=1; i<=formlength; i++)
			{
				eval("document.getElementById('form"+ i + "').style.display='none';");
				eval("document.getElementById('info"+ i + "').style.display='block';");
				//eval("document.all.info"+ i + ".style.display='block';");
				//eval("document.all.form"+ i + ".style.display='none';");
			}
		}
	}
	else
	{ // is NS/FF? 
		if (_a=='edit')
		{
			for (i=1 ; i<=formlength; i++)
			{
				eval("document.getElementById('form"+ i + "').style.visibility='visible';");
				eval("document.getElementById('form"+ i + "').style.display='block';");
				eval("document.getElementById('info"+ i + "').style.visibility='hidden';");
				eval("document.getElementById('info"+ i + "').style.display='none';");
				//eval("document.layers[form"+ i + "].style.display='block';");
				//eval("document.layers[info"+ i + "].style.display='none';");
			}
		}
		if (_a=='view')
		{
			for (i=1 ; i<=formlength; i++)
			{
				eval("document.getElementById('form"+ i + "').style.visibility='hidden';");
				eval("document.getElementById('form"+ i + "').style.display='none';");
				eval("document.getElementById('info"+ i + "').style.visibility='visible';");
				eval("document.getElementById('info"+ i + "').style.display='block';");
				//eval("document.layers[form"+ i + "].style.display='none';");
				//eval("document.layers[info"+ i + "].style.display='block';");
			}
		}
	}
}
