var expDays = 30;
var exp = new Date(); 
exp.setTime(exp.getTime() + (expDays*24*60*60*1000));

function When(info){
	// When
	    	var rightNow = new Date()
		var WWHTime = 0;
		WWHTime = GetCookie('WWhenH')
		
		WWHTime = WWHTime * 1

		var lastHereFormatting = new Date(WWHTime);  // Date-i-fy that number
	        var intLastVisit = (lastHereFormatting.getYear() * 10000)+(lastHereFormatting.getMonth() * 100) + lastHereFormatting.getDate()
	        var lastHereInDateFormat = "" + lastHereFormatting;  // Gotta use substring functions
	        var dayOfWeek = lastHereInDateFormat.substring(0,3)
	        var monthOfYear = lastHereInDateFormat.substring(4,7)
	        var dateOfMonth = lastHereInDateFormat.substring(7,10)
		var hours = "" + lastHereFormatting.getHours()
		var year = lastHereFormatting.getYear()
                if (year < 1000) year+=1900
		var minutes = "" + lastHereFormatting.getMinutes()
		if (minutes.substring(0,1) == minutes){
			minutes = "0" + minutes
		}
	    switch (dayOfWeek)
		    {
		    case 'Sun':
		    dayOfWeek='CN';
		    break;
		    case 'Mon':
		    dayOfWeek='Thứ 2';
		    break;
		    case 'Tue':
		    dayOfWeek='Thứ 3';
		    break;
		    case 'Wed':
		    dayOfWeek='Thứ 4';
		    break;
		    case 'Thu':
		    dayOfWeek='Thứ 5';
		    break;
		    case 'Fri':
		    dayOfWeek='Thứ 6';
		    break;
		    case 'Sat':
		    dayOfWeek='Thứ 7';
		    break;
			}
		switch (monthOfYear)
			{
			case 'Jan':
		    monthOfYear='1';
		    break;
		    case 'Feb':
		    monthOfYear='2';
		    break;
		    case 'Mar':
		    monthOfYear='3';
		    break;
		    case 'Apr':
		    monthOfYear='4';
		    break;
		    case 'May':
		    monthOfYear='5';
		    break;
		    case 'Jun':
		    monthOfYear='6';
		    break;
		    case 'Jul':
		    monthOfYear='7';
		    break;
		    case 'Aug':
		    monthOfYear='8';
		    break;
		    case 'Sep':
		    monthOfYear='9';
		    break;
		    case 'Oct':
		    monthOfYear='10';
		    break;
		    case 'Nov':
		    monthOfYear='11';
		    break;
		    case 'Dec':
		    monthOfYear='12';
		    break;
			}
	        var WWHText = dayOfWeek + ", " + dateOfMonth + '/' + monthOfYear + "/" + year + ", " +  hours + ":" + minutes// display
	
		SetCookie ("WWhenH", rightNow.getTime(), exp)
	return WWHText;
}

function Count(info){
	var psj=0;
	// How many times
		var WWHCount = GetCookie('WWHCount')
		if (WWHCount == null) {
			WWHCount = 0;
		}
		else{
			WWHCount++;
		}
		SetCookie ('WWHCount', WWHCount, exp);


	return WWHCount+1;
}



function set(){
//	VisitorName = prompt("Who are you?", "Nada");
//	SetCookie ('VisitorName', VisitorName, exp);
	SetCookie ('WWHCount', 0, exp);
	SetCookie ('WWhenH', 0, exp);
}

function getCookieVal (offset) {  
	var endstr = document.cookie.indexOf (";", offset);  
	if (endstr == -1)    
		endstr = document.cookie.length;  
		return unescape(document.cookie.substring(offset, endstr));
}

function GetCookie (name) {  
	var arg = name + "=";  
	var alen = arg.length;  
	var clen = document.cookie.length;  
	var i = 0;  
	while (i < clen) {    
	var j = i + alen;    
	if (document.cookie.substring(i, j) == arg)      
		return getCookieVal (j);    
		i = document.cookie.indexOf(" ", i) + 1;    
		if (i == 0) break;   
	}  
	return null;
}

function SetCookie (name, value) {  
	var argv = SetCookie.arguments;  
	var argc = SetCookie.arguments.length;  
	var expires = (argc > 2) ? argv[2] : null;  
	var path = (argc > 3) ? argv[3] : null;  
	var domain = (argc > 4) ? argv[4] : null;  
	var secure = (argc > 5) ? argv[5] : false;  
	document.cookie = name + "=" + escape (value) + 
	((expires == null) ? "" : ("; expires=" + expires.toGMTString())) + 
	((path == null) ? "" : ("; path=" + path)) +  
	((domain == null) ? "" : ("; domain=" + domain)) +    
	((secure == true) ? "; secure" : "");
}

function DeleteCookie (name) {  
	var exp = new Date();  
	exp.setTime (exp.getTime() - 1);  
	// This cookie is history  
	var cval = GetCookie (name);  
	document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString();

}

if (Count()==1){
visit1=("Cho b&#7841;n !");
visit2=("M&#7915;ng b&#7841;n &#273;&#7871;n v&#7899;i chng ti");
visit3=("Chc vui v&#7867; !");
When();
}
else if (Count()>1)
{
visit1=("Vui m&#7915;ng g&#7863;p l&#7841;i b&#7841;n !");
visit2=("L&#7847;n cu&#7889;i b&#7841;n &#273;&#7871;n l");
visit3=When();
}