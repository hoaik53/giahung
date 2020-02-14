/** PRIVATE FUNCTIONS **/
function _TF_trimWhitespace(txt) {
	var strTmp = txt;
	//trimming from the front
	for (counter=0; counter<strTmp.length; counter++)
		if (strTmp.charAt(counter) != " ")
			break;
	//trimming from the back
	strTmp = strTmp.substring(counter,strTmp.length);
	counter = strTmp.length - 1;
	for (counter; counter>=0; counter--)
		if (strTmp.charAt(counter) != " ")
			break;
	return strTmp.substring(0, counter+1);
}

function _TF_showAll(tb) {
	for (i=0;i<tb.rows.length;i++)
	{
		tb.rows[i].style.display = "";
	}
}

function _TF_shouldShow(type, con, val) {
	var toshow=true;
	if (type != null) type = type.toLowerCase();
	switch (type)
	{
		case "item":
			var strarray = val.split(",");
			innershow = false;
			for (ss=0;ss<strarray.length;ss++){
				if (con==_TF_trimWhitespace(strarray[ss])){
					innershow=true;
					break;
				}
			}
			if (innershow == false)
				toshow=false;
		break
		case "full":
			if (val!=con)
				toshow = false;
		break
		case "substring":
			if (val.indexOf(con)<0)
				toshow = false;
		break
		default: //is "substring1" search
			if (val.indexOf(con)!=0) //pattern must start from 1st char
				toshow = false;
			if (con.charAt(con.length-1) == " ")
			{ //last char is a space, so lets do a full search as well
				if (_TF_trimWhitespace(con) != val)
					toshow = false;
				else
					toshow = true;
			}
		break
	}
	return toshow;
}

function _TF_filterTable(tb, conditions) {
	//given an array of conditions, lets search the table
	for (i=0;i<tb.rows.length;i++)
	{
		var show = true;
		var rw = tb.rows[i];
		for (j=0;j<rw.cells.length;j++)
		{
			var cl = rw.cells[j];
			for (k=0;k<conditions.length;k++)
			{
				var colKey = cl.getAttribute("TF_colKey");
				if (colKey == null) //attribute not found
					continue; //so lets not search on this cell.
				if (conditions[k].name.toUpperCase() == colKey.toUpperCase())
				{
					var tbVal = cl.innerText;
					var conVals = conditions[k].value;
					if (conditions[k].single) //single value
					{ 
						show = _TF_shouldShow(conditions[k].type, conditions[k].value, cl.innerText);
					} else { //multiple values
						for (l=0;l<conditions[k].value.length;l++)
						{
							innershow = _TF_shouldShow(conditions[k].type, conditions[k].value[l], cl.innerText);
							if (innershow == true) break;
						}
						if (innershow == false)
							show = false;
					}
				}
			}
			//if any condition has failed, then we stop the matching (due to AND behaviour)
			if (show == false)
				break;
		}
		if (show == true)
			tb.rows[i].style.display = "";
		else
			tb.rows[i].style.display = "none";
	}
}

/** PUBLIC FUNCTIONS **/
//main function
function TF_filterTable(tb, frm) {
	var conditions = new Array();
	if (frm.style.display == "none") //filtering is off
		return _TF_showAll(tb);

	//go thru each type of input elements to figure out the filter conditions
	var inputs = frm.tags("INPUT");
	for (i=0;i<inputs.length;i++)
	{ //looping thru all INPUT elements
		if (inputs[i].getAttribute("TF_colKey") == null) //attribute not found
			continue; //we assume that this input field is not for us
		switch (inputs[i].type)
		{
			case "text":
			case "hidden":
				if(inputs[i].value != "")
				{
					index = conditions.length;
					conditions[index] = new Object;
					conditions[index].name = inputs[i].getAttribute("TF_colKey");
					conditions[index].type = inputs[i].getAttribute("TF_searchType");
					conditions[index].value = inputs[i].value;
					conditions[index].single = true;
				}
			break
		}
	}
	var inputs = frm.tags("SELECT");
	//able to do multiple selection box
	for (i=0;i<inputs.length;i++)
	{ //looping thru all SELECT elements
		if (inputs[i].getAttribute("TF_colKey") == null) //attribute not found
			continue; //we assume that this input field is not for us
		var opts = inputs[i].options;
		var optsSelected = new Array();
		for (intLoop=0; intLoop<opts.length; intLoop++)
		{ //looping thru all OPTIONS elements
			if (opts[intLoop].selected && (opts[intLoop].getAttribute("TF_not_used") == null))
			{
				index = optsSelected.length;
				optsSelected[index] = opts[intLoop].value;
			}
		}
		if (optsSelected.length > 0) //has selected items
		{
			index = conditions.length;
			conditions[index] = new Object;
			conditions[index].name = inputs[i].getAttribute("TF_colKey");
			conditions[index].type = inputs[i].getAttribute("TF_searchType");
			conditions[index].value = optsSelected;
			conditions[index].single = false;
		}
	}
	//ok, now that we have all the conditions, lets do the filtering proper
	_TF_filterTable(tb, conditions);
}

function TF_enableFilter(tb, frm, val) {
	if (val.checked) //filtering is on
		{
		frm.style.display = "";
		document.all.cbxSelectAll.style.display="none";
		}
	else
		{ //filtering is off
		frm.style.display = "none";
		document.all.cbxSelectAll.style.display="";
		}
	//refresh the table
	TF_filterTable(tb, frm);
}

function _TF_get_value(input) {
	switch (input.type)
	{
		case "text":
			 return input.value;
		break
		case "select-one":
			if (input.selectedIndex > -1) //has value
				return input.options(input.selectedIndex).value;
			else
				return "";
		break;
	}
}

//util function that concat two input fields and set the result in the third
function TF_concat_and_set(salText, salSelect, salHidden) {
	var valLeft = _TF_get_value(salText);
	var valRight = _TF_get_value(salSelect);
	salHidden.value = valLeft + valRight;
}
