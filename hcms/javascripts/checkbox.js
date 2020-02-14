/*
var form='data_table' //Give the form name here
function SetChecked(val,chkName)
{
dml=document.forms[form];
len = dml.elements.length;
var i=0;
for( i=0 ; i<len ; i++)
	{
	if (dml.elements[i].name==chkName)
		{
		dml.elements[i].checked=val;
		}
	}
}

function ValidateForm(dml,chkName)
{
len = dml.elements.length;
var i=0;
for( i=0 ; i<len ; i++)
	{
	if ((dml.elements[i].name==chkName) && (dml.elements[i].checked==1)) return true
	}
alert("Ban phai chon it nhat mot ban ghi")
return false;
}

function getElement(eid)
{
   if (document.all)
		{
      	return document.all[eid];
   		}
   if (document.getElementById)
   		{
		return document.getElementById(eid);
		}
}

// -->
*/
//declare global variables
var rowsSelected = 0;
//change the background color of a row when selected and
//also count how many rows are selected
function colorRow(srcElement)
{
  var cb = srcElement;
  var curElement = cb;
  while (curElement && !(curElement.tagName == "TR"))
  {
    curElement = curElement.parentNode;
  }
  if (cb.name != "cbxSelectAll")//!(curElement == cb) && 
  {
    if (cb.checked)
    {
      curElement.style.backgroundColor = "#CCDDEE";
      rowsSelected = rowsSelected + 1;
    }
    else
    {
      curElement.style.backgroundColor = "";
      curElement.bgColor = "#F4F6F4";
	  rowsSelected = rowsSelected - 1;
    }
  }
}

//color all rows when the main checkbox is clicked
function checkAll(form)
	{
  	var thisNumRowsSelected = 0;
  	var isChecked = form.cbxSelectAll.checked;
    //alert(isChecked);
  	for (var i=0; i < form.elements.length; i++)
	  	{
		if (form.elements[i].name.indexOf('chkbox') > -1)
			{
		  	var curElement = form.elements[i];
		  	if (isChecked)
				{
				curElement.checked = true;
				thisNumRowsSelected = thisNumRowsSelected + 1;
                //alert(curElement.tagName);
				while (curElement.tagName != "TR")
					{
				  	curElement = curElement.parentNode;
                    //alert(curElement.tagName);
					}
				if (form.elements[i].name != "cbxSelectAll")
					{
				  	curElement.style.backgroundColor = "#CCDDEE";
					}
				 }
			else
				{
				rowsSelected=0;                
				curElement.checked = false;
				while (!(curElement.tagName == "TR"))
					{
				  	curElement = curElement.parentNode;
					}
				if (form.elements[i].name != "cbxSelectAll")
					{
				  	curElement.style.backgroundColor = "";
      				curElement.bgColor = "#F4F6F4";
	  				}
				 }
			}
		}
  	rowsSelected = thisNumRowsSelected;
	}
// JavaScript Document
function docheckone()
		   {
		   		var alen=document.user4del.elements.length;
				var isChecked=true;
				alen=(alen>5)?document.user4del.chkbox.length:0;
				if (alen>0)
				{
			   		for(var i=0;i<alen;i++)
						if(document.user4del.chkbox[i].checked==false)
							isChecked=false;
				}else
				{
					if(document.user4del.chkbox.checked==false)
						isChecked=false;
				}				
				document.user4del.chkall.checked=isChecked;
		   }
function checkInput()
		   {
				var alen=document.user4del.elements.length;
				var isChecked=false;
				var isNum=true;
				alen=(alen>5)?document.user4del.chkbox.length:0;
				if (alen>0)
				{
			   		for(var i=0;i<alen;i++)
					{
						if(document.user4del.chkbox[i].checked==true)
						{
							isChecked=true;							
							break;
						}
					}
					if (!isChecked)											
						alert("Please select at least one of them 1");
					
				}else
				{
					if(document.user4del.chkbox.checked==true)
						isChecked=true;
					if (!isChecked)											
						alert("Please select at least one of them 2");
				}
				
				if (isChecked)											
					calculatechon();
				
												
			return isChecked;
		  } 
function calculatechon()
			{			
				var strchon="";
				var alen=document.user4del.elements.length;				
				alen=(alen>5)?document.user4del.chkbox.length:0;
				if (alen>0)
				{
			   		for(var i=0;i<alen;i++)
						if(document.user4del.chkbox[i].checked==true)
							strchon+=document.user4del.chkbox[i].value+",";
				}else
				{
					if(document.user4del.chkbox.checked==true)
						strchon=document.user4del.chkbox[i].value;
				}
				document.user4del.chkboxs.value=strchon;	
				
			}
function docheck(status,from_)
		   {
		   		var alen=document.user4del.elements.length;
				alen=(alen>5)?document.user4del.chkbox.length:0;
				if (alen>0)
				{
			   		for(var i=0;i<alen;i++)
						document.user4del.chkbox[i].checked=status;
				}else
				{
						document.user4del.chkbox.checked=status;
				}
				if(from_>0)
					document.user4del.chkall.checked=status;
		   }