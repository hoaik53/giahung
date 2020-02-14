function TrackCount(fieldObj,countFieldName,maxChars)
{
  var countField = eval("fieldObj.form."+countFieldName);
  var diff = maxChars - fieldObj.value.length;

  // Need to check & enforce limit here also in case user pastes data
  if (diff < 0)
  {
    fieldObj.value = fieldObj.value.substring(0,maxChars);
    diff = maxChars - fieldObj.value.length;
  }
  countField.value = diff;
}

function LimitText(fieldObj,maxChars)
{
  var result = true;
  if (fieldObj.value.length >= maxChars)
    result = false;
  
  if (window.event)
    window.event.returnValue = result;
  return result;
}
/**
 * DHTML textbox character counter (IE4+) script. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
 */

function taLimit() {
	var taObj=event.srcElement;
	if (taObj.value.length==taObj.maxLength*1) return false;
}
function taCount(visCnt) { 
	var taObj=event.srcElement;
	if (taObj.value.length>taObj.maxLength*1) taObj.value=taObj.value.substring(0,taObj.maxLength*1);
	if (visCnt) visCnt.innerText=taObj.maxLength-taObj.value.length;
}