function updateAttributes()
	{
	document.myform.bgcolor.value=MyBgColor;
	document.myform.background.value=MyBgImg;
	}

//Ham hien thi menu JS
var curbgColor;
var curbdColor;
//Doi mau nen
function change(obj,color)
	{
	curbgColor=obj.bgColor;
	obj.bgColor=color;
	}
function undo(obj)
	{
	obj.bgColor=curbgColor;
	}
//Doi mau vien
function changebd(obj,color)
	{
	curbdColor=obj.style.borderColor;
	obj.style.borderColor=color;
	}
function undobd(obj)
	{
	obj.style.borderColor=curbdColor;
	}
//Gan gia tri bien
function get(formname,element)
	{
	var varname=eval ("document." + formname + "." + element + ".value;");
	return varname;
	}