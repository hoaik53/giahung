//Doi mau nen
var curbgColor;
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
