// JavaScript Document

//Browser detection
var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari"
		},
		{
			prop: window.opera,
			identity: "Opera"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};
BrowserDetect.init();

//Date manipulator functions
// ===================================================================
// Author: Matt Kruse <matt@mattkruse.com>
// WWW: http://www.mattkruse.com/
//
// NOTICE: You may use this code for any purpose, commercial or
// private, without any further permission from the author. You may
// remove this notice from your final code if you wish, however it is
// appreciated by the author if at least my web site address is kept.
//
// You may *NOT* re-distribute this code in any way except through its
// use. That means, you can include it in your product, or your web
// site, or any other form where the code is actually being used. You
// may not put the plain javascript up on your site for download or
// include it in your javascript libraries for download. 
// If you wish to share this code with others, please just point them
// to the URL instead.
// Please DO NOT link directly to my .js files from your site. Copy
// the files to your server and use them there. Thank you.
// ===================================================================

//var MONTH_NAMES=new Array('January','February','March','April','May','June','July','August','September','October','November','December','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');var DAY_NAMES=new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sun','Mon','Tue','Wed','Thu','Fri','Sat');
var MONTH_NAMES=new Array('January','February','March','April','May','June','July','August','September','October','November','December','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
var DAY_NAMES=new Array('CN','Thứ 2','Thứ 3','Wednesday','Thursday','Friday','Saturday','Sun','Mon','Tue','Wed','Thu','Fri','Sat');
function LZ(x){return(x<0||x>9?"":"0")+x}
function isDate(val,format){var date=getDateFromFormat(val,format);if(date==0){return false;}return true;}
function compareDates(date1,dateformat1,date2,dateformat2){var d1=getDateFromFormat(date1,dateformat1);var d2=getDateFromFormat(date2,dateformat2);if(d1==0 || d2==0){return -1;}else if(d1 > d2){return 1;}return 0;}
function formatDate(date,format){format=format+"";var result="";var i_format=0;var c="";var token="";var y=date.getYear()+"";var M=date.getMonth()+1;var d=date.getDate();var E=date.getDay();var H=date.getHours();var m=date.getMinutes();var s=date.getSeconds();var yyyy,yy,MMM,MM,dd,hh,h,mm,ss,ampm,HH,H,KK,K,kk,k;var value=new Object();if(y.length < 4){y=""+(y-0+1900);}value["y"]=""+y;value["yyyy"]=y;value["yy"]=y.substring(2,4);value["M"]=M;value["MM"]=LZ(M);value["MMM"]=MONTH_NAMES[M-1];value["NNN"]=MONTH_NAMES[M+11];value["d"]=d;value["dd"]=LZ(d);value["E"]=DAY_NAMES[E+7];value["EE"]=DAY_NAMES[E];value["H"]=H;value["HH"]=LZ(H);if(H==0){value["h"]=12;}else if(H>12){value["h"]=H-12;}else{value["h"]=H;}value["hh"]=LZ(value["h"]);if(H>11){value["K"]=H-12;}else{value["K"]=H;}value["k"]=H+1;value["KK"]=LZ(value["K"]);value["kk"]=LZ(value["k"]);if(H > 11){value["a"]="PM";}else{value["a"]="AM";}value["m"]=m;value["mm"]=LZ(m);value["s"]=s;value["ss"]=LZ(s);while(i_format < format.length){c=format.charAt(i_format);token="";while((format.charAt(i_format)==c) &&(i_format < format.length)){token += format.charAt(i_format++);}if(value[token] != null){result=result + value[token];}else{result=result + token;}}return result;}
function _isInteger(val){var digits="1234567890";for(var i=0;i < val.length;i++){if(digits.indexOf(val.charAt(i))==-1){return false;}}return true;}
function _getInt(str,i,minlength,maxlength){for(var x=maxlength;x>=minlength;x--){var token=str.substring(i,i+x);if(token.length < minlength){return null;}if(_isInteger(token)){return token;}}return null;}
function getDateFromFormat(val,format){val=val+"";format=format+"";var i_val=0;var i_format=0;var c="";var token="";var token2="";var x,y;var now=new Date();var year=now.getYear();var month=now.getMonth()+1;var date=1;var hh=now.getHours();var mm=now.getMinutes();var ss=now.getSeconds();var ampm="";while(i_format < format.length){c=format.charAt(i_format);token="";while((format.charAt(i_format)==c) &&(i_format < format.length)){token += format.charAt(i_format++);}if(token=="yyyy" || token=="yy" || token=="y"){if(token=="yyyy"){x=4;y=4;}if(token=="yy"){x=2;y=2;}if(token=="y"){x=2;y=4;}year=_getInt(val,i_val,x,y);if(year==null){return 0;}i_val += year.length;if(year.length==2){if(year > 70){year=1900+(year-0);}else{year=2000+(year-0);}}}else if(token=="MMM"||token=="NNN"){month=0;for(var i=0;i<MONTH_NAMES.length;i++){var month_name=MONTH_NAMES[i];if(val.substring(i_val,i_val+month_name.length).toLowerCase()==month_name.toLowerCase()){if(token=="MMM"||(token=="NNN"&&i>11)){month=i+1;if(month>12){month -= 12;}i_val += month_name.length;break;}}}if((month < 1)||(month>12)){return 0;}}else if(token=="EE"||token=="E"){for(var i=0;i<DAY_NAMES.length;i++){var day_name=DAY_NAMES[i];if(val.substring(i_val,i_val+day_name.length).toLowerCase()==day_name.toLowerCase()){i_val += day_name.length;break;}}}else if(token=="MM"||token=="M"){month=_getInt(val,i_val,token.length,2);if(month==null||(month<1)||(month>12)){return 0;}i_val+=month.length;}else if(token=="dd"||token=="d"){date=_getInt(val,i_val,token.length,2);if(date==null||(date<1)||(date>31)){return 0;}i_val+=date.length;}else if(token=="hh"||token=="h"){hh=_getInt(val,i_val,token.length,2);if(hh==null||(hh<1)||(hh>12)){return 0;}i_val+=hh.length;}else if(token=="HH"||token=="H"){hh=_getInt(val,i_val,token.length,2);if(hh==null||(hh<0)||(hh>23)){return 0;}i_val+=hh.length;}else if(token=="KK"||token=="K"){hh=_getInt(val,i_val,token.length,2);if(hh==null||(hh<0)||(hh>11)){return 0;}i_val+=hh.length;}else if(token=="kk"||token=="k"){hh=_getInt(val,i_val,token.length,2);if(hh==null||(hh<1)||(hh>24)){return 0;}i_val+=hh.length;hh--;}else if(token=="mm"||token=="m"){mm=_getInt(val,i_val,token.length,2);if(mm==null||(mm<0)||(mm>59)){return 0;}i_val+=mm.length;}else if(token=="ss"||token=="s"){ss=_getInt(val,i_val,token.length,2);if(ss==null||(ss<0)||(ss>59)){return 0;}i_val+=ss.length;}else if(token=="a"){if(val.substring(i_val,i_val+2).toLowerCase()=="am"){ampm="AM";}else if(val.substring(i_val,i_val+2).toLowerCase()=="pm"){ampm="PM";}else{return 0;}i_val+=2;}else{if(val.substring(i_val,i_val+token.length)!=token){return 0;}else{i_val+=token.length;}}}if(i_val != val.length){return 0;}if(month==2){if( ((year%4==0)&&(year%100 != 0) ) ||(year%400==0) ){if(date > 29){return 0;}}else{if(date > 28){return 0;}}}if((month==4)||(month==6)||(month==9)||(month==11)){if(date > 30){return 0;}}if(hh<12 && ampm=="PM"){hh=hh-0+12;}else if(hh>11 && ampm=="AM"){hh-=12;}var newdate=new Date(year,month-1,date,hh,mm,ss);return newdate.getTime();}
function parseDate(val){var preferEuro=(arguments.length==2)?arguments[1]:false;generalFormats=new Array('y-M-d','MMM d, y','MMM d,y','y-MMM-d','d-MMM-y','MMM d');monthFirst=new Array('M/d/y','M-d-y','M.d.y','MMM-d','M/d','M-d');dateFirst =new Array('d/M/y','d-M-y','d.M.y','d-MMM','d/M','d-M');var checkList=new Array('generalFormats',preferEuro?'dateFirst':'monthFirst',preferEuro?'monthFirst':'dateFirst');var d=null;for(var i=0;i<checkList.length;i++){var l=window[checkList[i]];for(var j=0;j<l.length;j++){d=getDateFromFormat(val,l[j]);if(d!=0){return new Date(d);}}}return null;}

//Display Banner Ads-----------------------------------------------------------------------------

function flashWrite(url,w,h,vars,id,bg){

     var flashStr=
    "<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='"+w+"' height='"+h+"' id='"+id+"' align='middle'>"+
    "<param name='allowScriptAccess' value='always' />"+
    "<param name='movie' value='"+url+"' />"+
    "<param name='FlashVars' value='"+vars+"' />"+
    "<param name='wmode' value='transparent' />"+
    "<param name='menu' value='false' />"+
    "<param name='quality' value='high' />"+
    "<embed src='"+url+"' FlashVars='"+vars+"' wmode='transparent' menu='false' quality='high' width='"+w+"' height='"+h+"' allowScriptAccess='always' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />"+
    "</object>";
    document.write(flashStr);
}

function ChangeTopBanner()
{
//	alert(BannerLnk);
	if (TopBanner.length==0)
		return;
	CurTopBanner++;
	if (CurTopBanner >= TopBanner.length)	{
		CurTopBanner=0;
	}
	document.links[BannerLnk].href= '/ad/click.php?banner=' + TopBanner[CurTopBanner][3];
	if(TopBanner[CurTopBanner][2]=='1') document.links[BannerLnk].target= '_blank';
	else document.links[BannerLnk].target= '';
	document.images['imgTopBanner'].src = PageHost.concat(TopBanner[CurTopBanner][0]);
}

function DisplayTopBanner(rbn)
{
	if (TopBanner.length==0)
	{
		document.write('<table cellspacing=0 cellpadding=0 border=0 width=468 height=60 bgcolor="#92BB05"><tr><td><table cellspacing=0 cellpadding=0 border=0 width="466" height="58"><tr><td  bgcolor="#92BB05" align=center><a href="/ad/register.php?menu=100&cat=0&pos=1"><img border="0" src="/images/topbanner.gif" width="468" height="60"></a></td></tr></table></td></tr></table>');
		return;
	}
	CurTopBanner=Math.floor(Math.random()*12321) % TopBanner.length;
	BannerLnk=document.links.length;
	if(TopBanner[CurTopBanner][0].indexOf(".swf")>0) {
		document.write('<table cellspacing=0 cellpadding=0 border=0 width=468 height=60 bgcolor="#92BB05"><tr><td>');
		flashWrite(PageHost.concat(TopBanner[CurTopBanner][0]),468,60,TopBanner[CurTopBanner][1]);
		document.write('</td></tr></table>');
		return;
	}
	// Nguyen sua 30/03/2007
	if(TopBanner[CurTopBanner][0].indexOf(".htm")>0) {
		document.write('<table cellspacing=0 cellpadding=0 border=0 width=468 height=60 bgcolor="#92BB05"><tr><td>');
		document.write('<iframe width="468" height="60" src="');document.write(TopBanner[CurTopBanner][0]);document.write('" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe>');
		document.write('</td></tr></table>');
		return;
	}
	//
	
	if (TopBanner[CurTopBanner][1]=='')
	{
		document.write('<table cellspacing=0 cellpadding=0 border=0 width=468 height=60 bgcolor="#92BB05"><tr><td><a href="/index.php"><img name="imgTopBanner" src="', PageHost.concat(TopBanner[CurTopBanner][0]), '" width=468 height=60 border=0></a></td></tr></table>');
	}
	else
	{
		if(TopBanner[CurTopBanner][2]=='1')
			document.write('<table cellspacing=0 cellpadding=0 border=0 width=468 height=60 bgcolor="#92BB05"><tr><td><a href="/ad/click.php?banner=',TopBanner[CurTopBanner][3], '" target="_blank"><img name="imgTopBanner" src="', PageHost.concat(TopBanner[CurTopBanner][0]), '" width=468 height=60 border=0></a></td></tr></table>');
		else
			document.write('<table cellspacing=0 cellpadding=0 border=0 width=468 height=60 bgcolor="#92BB05"><tr><td><a href="/ad/click.php?banner=',TopBanner[CurTopBanner][3], '"><img name="imgTopBanner" src="', PageHost.concat(TopBanner[CurTopBanner][0]), '" width=468 height=60 border=0></a></td></tr></table>');
	}

	if (typeof(rbn) == 'undefined')
	{
		rbn = 1;
	}

	if (rbn)
	{
		setInterval('ChangeTopBanner()', 15000);
	}
}

function ChangeTopPageBanner(Vitri)
{

	if (TopPageBanner.length==0)
		return;
if(Vitri == 0)
{
for(i=0;i<TopPageBanner.length;i++)
{
CurTopPageBanner++;
	if (CurTopPageBanner >= TopPageBanner.length)	{
		CurTopPageBanner=0;
	}
if(TopPageBanner[CurTopPageBanner][4] == Vitri)
{
	document.links[TP_BannerLnk].href= '/ad/click.php?banner=' + TopPageBanner[CurTopPageBanner][3];
	if(TopPageBanner[CurTopPageBanner][2]=='1') document.links[TP_BannerLnk].target= '_blank';
	else document.links[TP_BannerLnk].target= '';
	document.images['imgTopPageBanner'].src = PageHost.concat(TopPageBanner[CurTopPageBanner][0]);
	return;
}
}
}

if(Vitri == 1)
{
for(i=0;i<TopPageBanner.length;i++)
{
CurTopPageBanner1++;
	if (CurTopPageBanner1 >= TopPageBanner.length)	{
		CurTopPageBanner1 = 0;
	}
if(TopPageBanner[CurTopPageBanner1][4] == Vitri)
{
	document.links[TP_BannerLnk1].href= '/ad/click.php?banner=' + TopPageBanner[CurTopPageBanner1][3];
	if(TopPageBanner[CurTopPageBanner1][2]=='1') document.links[TP_BannerLnk1].target= '_blank';
	else document.links[TP_BannerLnk1].target= '';
	document.images['imgTopPageBanner1'].src = PageHost.concat(TopPageBanner[CurTopPageBanner1][0]);
	return;
}
}


}

if(Vitri == 2)
{
for(i=0;i<TopPageBanner.length;i++)
{
CurTopPageBanner2++;
	if (CurTopPageBanner2 >= TopPageBanner.length)	{
		CurTopPageBanner2 = 0;
	}
if(TopPageBanner[CurTopPageBanner2][4] == Vitri)
{
	document.links[TP_BannerLnk2].href= '/ad/click.php?banner=' + TopPageBanner[CurTopPageBanner2][3];
	if(TopPageBanner[CurTopPageBanner2][2]=='1') document.links[TP_BannerLnk2].target= '_blank';
	else document.links[TP_BannerLnk2].target= '';
	document.images['imgTopPageBanner2'].src = PageHost.concat(TopPageBanner[CurTopPageBanner2][0]);
	return;
}
}
}

}

function DisplayTopPageBanner(index,rbn)
{

if (TopPageBanner.length==0)
	{
		return;
	}

	CurCenterBanner=Math.floor(Math.random()*12321) % TopPageBanner.length;
	if(index ==0) TP_BannerLnk=document.links.length;
	if(index==1) TP_BannerLnk1=document.links.length;
	if(index==2) TP_BannerLnk2=document.links.length;


	for(i=0; i < TopPageBanner.length; i++)
	{
	if(TopPageBanner[CurCenterBanner][4] == index)
{
	if(TopPageBanner[CurCenterBanner][0].indexOf(".swf")>0) {
		document.write('<table cellspacing=0 cellpadding=0 border=0 width=420 height=120 bgcolor="#92BB05"><tr><td>');
		flashWrite(PageHost.concat(TopPageBanner[CurCenterBanner][0]),420,120,TopPageBanner[CurCenterBanner][1]);
		document.write('</td></tr></table>');
		return;
									}
	if(index==0)
	{
	if (TopPageBanner[CurCenterBanner][1]=='')
	{
		document.write('<table cellspacing=0 cellpadding=0 border=0 width=420 height=120 bgcolor="#92BB05"><tr><td><a href="/index.php"><img name="imgTopPageBanner" src="', PageHost.concat(TopPageBanner[CurCenterBanner][0]), '" width=420 height=120 border=0></a></td></tr></table>');
	}
	else
	{
		if(TopPageBanner[CurCenterBanner][2]=='1')
			document.write('<table cellspacing=0 cellpadding=0 border=0 width=420 height=120 bgcolor="#92BB05"><tr><td><a href="/ad/click.php?banner=',TopPageBanner[CurCenterBanner][3], '" target="_blank"><img name="imgTopPageBanner" src="', PageHost.concat(TopPageBanner[CurCenterBanner][0]), '" width=420 height=120 border=0></a></td></tr></table>');
		else
			document.write('<table cellspacing=0 cellpadding=0 border=0 width=420 height=120 bgcolor="#92BB05"><tr><td><a href="/ad/click.php?banner=',TopPageBanner[CurCenterBanner][3], '"><img name="imgTopPageBanner" src="', PageHost.concat(TopPageBanner[CurCenterBanner][0]), '" width=420 height=120 border=0></a></td></tr></table>');
	}
	}//end if
	if(index==1)
	{
	if (TopPageBanner[CurCenterBanner][1]=='')
	{
		document.write('<table cellspacing=0 cellpadding=0 border=0 width=420 height=120 bgcolor="#92BB05"><tr><td><a href="/index.php"><img name="imgTopPageBanner1" src="', PageHost.concat(TopPageBanner[CurCenterBanner][0]), '" width=420 height=120 border=0></a></td></tr></table>');
	}
	else
	{
		if(TopPageBanner[CurCenterBanner][2]=='1')
			document.write('<table cellspacing=0 cellpadding=0 border=0 width=420 height=120 bgcolor="#92BB05"><tr><td><a href="/ad/click.php?banner=',TopPageBanner[CurCenterBanner][3], '" target="_blank"><img name="imgTopPageBanner1" src="', PageHost.concat(TopPageBanner[CurCenterBanner][0]), '" width=420 height=120 border=0></a></td></tr></table>');
		else
			document.write('<table cellspacing=0 cellpadding=0 border=0 width=420 height=120 bgcolor="#92BB05"><tr><td><a href="/ad/click.php?banner=',TopPageBanner[CurCenterBanner][3], '"><img name="imgTopPageBanner1" src="', PageHost.concat(TopPageBanner[CurCenterBanner][0]), '" width=420 height=120 border=0></a></td></tr></table>');
	}
	}//end if
if(index==2)
	{
	if (TopPageBanner[CurCenterBanner][1]=='')
	{
		document.write('<table cellspacing=0 cellpadding=0 border=0 width=420 height=120 bgcolor="#92BB05"><tr><td><a href="/index.php"><img name="imgTopPageBanner2" src="', PageHost.concat(TopPageBanner[CurCenterBanner][0]), '" width=420 height=120 border=0></a></td></tr></table>');
	}
	else
	{
		if(TopPageBanner[CurCenterBanner][2]=='1')
			document.write('<table cellspacing=0 cellpadding=0 border=0 width=420 height=120 bgcolor="#92BB05"><tr><td><a href="/ad/click.php?banner=',TopPageBanner[CurCenterBanner][3], '" target="_blank"><img name="imgTopPageBanner2" src="', PageHost.concat(TopPageBanner[CurCenterBanner][0]), '" width=420 height=120 border=0></a></td></tr></table>');
		else
			document.write('<table cellspacing=0 cellpadding=0 border=0 width=420 height=120 bgcolor="#92BB05"><tr><td><a href="/ad/click.php?banner=',TopPageBanner[CurCenterBanner][3], '"><img name="imgTopPageBanner2" src="', PageHost.concat(TopPageBanner[CurCenterBanner][0]), '" width=420 height=120 border=0></a></td></tr></table>');
	}
	}//end if
//Ra khoi vong lap
i= TopPageBanner.length;

} //end if

       else
	{
	CurCenterBanner++;
	if(CurCenterBanner >= TopPageBanner.length)  CurCenterBanner = 0;
	}
	}//end for

	if (typeof(rbn) == 'undefined')
	{
		rbn = 1;
	}

	if (rbn)
	{

		if (index ==0)
			{
			CurTopPageBanner = CurCenterBanner;
			setInterval('ChangeTopPageBanner(0)', 15000);
			}

		if(index ==1)
		{

		CurTopPageBanner1 = CurCenterBanner;
		setInterval('ChangeTopPageBanner(1)', 15000);

		}
		if(index ==2)
		{

		CurTopPageBanner2 = CurCenterBanner;
		setInterval('ChangeTopPageBanner(2)', 15000);

		}

	}
return;

	if (TopPageBanner.length==0)
	{
		return;
	}
	CurTopPageBanner=Math.floor(Math.random()*12321) % TopPageBanner.length
//Lam sua:
	TP_BannerLnk=document.links.length;
	if(TopPageBanner[CurTopPageBanner][0].indexOf(".swf")>0) {
		document.write('<table cellspacing=0 cellpadding=0 border=0 width=420 height=120 bgcolor="#92BB05"><tr><td>');
		flashWrite(PageHost.concat(TopPageBanner[CurTopPageBanner][0]),420,120,TopPageBanner[CurTopPageBanner][1]);
		document.write('</td></tr></table>');
		return;
	}
	if (TopPageBanner[CurTopPageBanner][1]=='')
	{
		document.write('<table cellspacing=0 cellpadding=0 border=0 width=420 height=120 bgcolor="#92BB05"><tr><td><a href="/index.php"><img name="imgTopPageBanner" src="', PageHost.concat(TopPageBanner[CurTopPageBanner][0]), '" width=420 height=120 border=0></a></td></tr></table>');
	}
	else
	{
		if(TopPageBanner[CurTopPageBanner][2]=='1')
			document.write('<table cellspacing=0 cellpadding=0 border=0 width=420 height=120 bgcolor="#92BB05"><tr><td><a href="/ad/click.php?banner=',TopPageBanner[CurTopPageBanner][3], '" target="_blank"><img name="imgTopPageBanner" src="', PageHost.concat(TopPageBanner[CurTopPageBanner][0]), '" width=420 height=120 border=0></a></td></tr></table>');
		else
			document.write('<table cellspacing=0 cellpadding=0 border=0 width=420 height=120 bgcolor="#92BB05"><tr><td><a href="/ad/click.php?banner=',TopPageBanner[CurTopPageBanner][3], '"><img name="imgTopPageBanner" src="', PageHost.concat(TopPageBanner[CurTopPageBanner][0]), '" width=420 height=120 border=0></a></td></tr></table>');
	}

	if (typeof(rbn) == 'undefined')
	{
		rbn = 1;
	}

	if (rbn)
	{
		setInterval('ChangeTopPageBanner()', 5000);
	}

}
function DisplayRight200Banner()
{
  var BannerPostion = Math.floor(Math.random()*12321) % Right200Banner.length;
  var x = 0;
  var y = 0;
  var z = 0;
  var Right1stBanner = new Array();
  var Right2ndBanner = new Array();
  var Right3rdBanner = new Array();

//Phan loai thu tu cac Banner
  for(i=0;i<Right200Banner.length;i++)
  {
    if(Right200Banner[i][4]=='-1')
    {
      Right1stBanner[x]= Right200Banner[i];
      x++;
    }

    if(Right200Banner[i][4]=='-2')
    {
      Right2ndBanner[y]= Right200Banner[i];
      y++;
    }
    if(Right200Banner[i][4]=='-3')
    {
      Right3rdBanner[z]= Right200Banner[i];
      z++;
    }

  }

//Hien cac Banner -1
  for(j=0;j<x;j++)
  {
    if(Right1stBanner[j][0].indexOf(".swf")>0)
    {
	   document.write('<tr><td>');
	   flashWrite(PageHost.concat(Right1stBanner[j][0]),210,Right1stBanner[j][6],Right1stBanner[j][1]);
	   document.write('</td></tr>');
	}
	else if(Right1stBanner[j][0].indexOf(".htm")>0)
	{
		document.write('<iframe width="');document.write(Right1stBanner[j][5]);document.write('" height="');document.write(Right1stBanner[j][6]);document.write('" src="');document.write(Right1stBanner[j][0]);document.write('" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe>');
	}
	else
    {
	   if (Right1stBanner[j][1]=='')
       {
	       document.write('<tr><td><a href="/index.php"><img src="', PageHost.concat(Right1stBanner[j][0]), '" width=210 border=0></a></td></tr>');
       }
	   else
       {
           if(Right1stBanner[j][2]=='1')
           {
                document.write('<tr><td><a href="/ad/click.php?banner=',Right1stBanner[j][3],'" target="_blank"><img src="', PageHost.concat(Right1stBanner[j][0]), '" width=210 border=0></a></td></tr>');
	       }
	       else
           {
				document.write('<tr><td><a href="/ad/click.php?banner=',Right1stBanner[j][3],'"><img src="', PageHost.concat(Right1stBanner[j][0]), '" width=210 border=0></a></td></tr>');
	       }
	    }
	}
  }

//Hien cac Banner -2
  for(k=0;k<y;k++)
  {
    if(Right2ndBanner[k][0].indexOf(".swf")>0)
    {
	   document.write('<tr><td>');
	   flashWrite(PageHost.concat(Right2ndBanner[k][0]),210,Right2ndBanner[k][6],Right2ndBanner[k][1]);
	   document.write('</td></tr>');
	}
	else
	if(Right2ndBanner[k][0].indexOf(".htm")>0)
	{
		document.write('<iframe width="');document.write(Right2ndBanner[k][5]);document.write('" height="');document.write(Right2ndBanner[k][6]);document.write('" src="');document.write(Right2ndtBanner[k][0]);document.write('" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe>');
	}
	else
    {
	   if (Right2ndBanner[k][1]=='')
       {
	       document.write('<tr><td><a href="/index.php"><img src="', PageHost.concat(Right2ndBanner[k][0]), '" width=210 border=0></a></td></tr>');
       }
	   else
       {
           if(Right2ndBanner[k][2]=='1')
           {
                document.write('<tr><td><a href="/ad/click.php?banner=',Right2ndBanner[k][3],'" target="_blank"><img src="', PageHost.concat(Right1stBanner[j][0]), '" width=210 border=0></a></td></tr>');
	       }
	       else
           {
				document.write('<tr><td><a href="/ad/click.php?banner=',Right2ndBanner[k][3],'"><img src="', PageHost.concat(Right2ndBanner[k][0]), '" width=210 border=0></a></td></tr>');
	       }
	    }
	}
  }

//Hien cac Banner -3
  for(l=0;l<z;l++)
  {
    if(Right3rdBanner[l][0].indexOf(".swf")>0)
    {
	   document.write('<tr><td>');
	   flashWrite(PageHost.concat(Right3rdBanner[l][0]),210,Right3rdBanner[l][6],Right3rdBanner[l][1]);
	   document.write('</td></tr>');
	}
	else if(Right3rdBanner[l][0].indexOf(".htm")>0)
	{
		document.write('<iframe width="');document.write(Right3rdBanner[l][5]);document.write('" height="');document.write(Right3rdBanner[l][6]);document.write('" src="');document.write(Right3rdBanner[l][0]);document.write('" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe>');
	}
	else
    {
	   if (Right3rdBanner[l][1]=='')
       {
	       document.write('<tr><td><a href="/index.php"><img src="', PageHost.concat(Right3rdBanner[l][0]), '" width=210 border=0></a></td></tr>');
       }
	   else
       {
           if(Right3rdBanner[l][2]=='1')
           {
                document.write('<tr><td><a href="/ad/click.php?banner=',Right3rdBanner[l][3],'" target="_blank"><img src="', PageHost.concat(Right3rdBanner[l][0]), '" width=210 border=0></a></td></tr>');
	       }
	       else
           {
				document.write('<tr><td><a href="/ad/click.php?banner=',Right3rdBanner[l][3],'"><img src="', PageHost.concat(Right3rdBanner[l][0]), '" width=210 border=0></a></td></tr>');
	       }
	    }
	}
  }

//Hien cac banner thuong
    for(t=BannerPostion;t<Right200Banner.length;t++)
    {
      if(Right200Banner[t][4]!='-1'&&Right200Banner[t][4]!='-2'&&Right200Banner[t][4]!='-3')
      {
        if(Right200Banner[t][0].indexOf(".swf")>0) {
			document.write('<tr><td>');
	   		flashWrite(PageHost.concat(Right200Banner[t][0]),210,Right200Banner[t][6],Right200Banner[t][1]);
	   		document.write('</td></tr>');
		} 
		else if(Right200Banner[t][0].indexOf(".htm")>0){
		document.write('<iframe width="');document.write(Right200Banner[t][5]);document.write('" height="');document.write(Right200Banner[t][6]);document.write('" src="');document.write(Right200Banner[t][0]);document.write('" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe>');
	}
	else
		{
			if (Right200Banner[t][1]=='') {
				document.write('<tr><td><a href="/index.php"><img src="', PageHost.concat(Right200Banner[t][0]), '" width=210 border=0></a></td></tr>');
			}
			else {
				if(Right200Banner[t][2]=='1') {
					document.write('<tr><td><a href="/ad/click.php?banner=',Right200Banner[t][3],'" target="_blank"><img src="', PageHost.concat(Right200Banner[t][0]), '" width=210 border=0></a></td></tr>');
				}
				else {
					document.write('<tr><td><a href="/ad/click.php?banner=',Right200Banner[t][3],'"><img src="', PageHost.concat(Right200Banner[t][0]), '" width=210 border=0></a></td></tr>');
				}
			}
		}
      }
    }
    
    for(t=0;t<BannerPostion;t++)
    {
      if(Right200Banner[t][4]!='-1'&&Right200Banner[t][4]!='-2'&&Right200Banner[t][4]!='-3')
      {
        if(Right200Banner[t][0].indexOf(".swf")>0) {
			document.write('<tr><td>');
	   		flashWrite(PageHost.concat(Right200Banner[t][0]),210,Right200Banner[t][6],Right200Banner[t][1]);
	   		document.write('</td></tr>');
		}
		else if(Right200Banner[j][0].indexOf(".htm")>0)
	{
		document.write('<iframe width="');document.write(Right200Banner[t][5]);document.write('" height="');document.write(Right200Banner[t][6]);document.write('" src="');document.write(Right200Banner[t][0]);document.write('" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe>');
	}
	else{
			if (Right200Banner[t][1]=='') {
				document.write('<tr><td><a href="/index.php"><img src="', PageHost.concat(Right200Banner[t][0]), '" width=210 border=0></a></td></tr>');
			}
			else {
				if(Right200Banner[t][2]=='1') {
					document.write('<tr><td><a href="/ad/click.php?banner=',Right200Banner[t][3],'" target="_blank"><img src="', PageHost.concat(Right200Banner[t][0]), '" width=210 border=0></a></td></tr>');
				}
				else {
					document.write('<tr><td><a href="/ad/click.php?banner=',Right200Banner[t][3],'"><img src="', PageHost.concat(Right200Banner[t][0]), '" width=210 border=0></a></td></tr>');
				}
			}
		}
      }
    }

}//function

function DisplayOnPage200Banner()
{
	if (Right200Banner.length<2) return;
	document.write('<table cellspacing=0 cellpadding=0 border=0 width="100%" bgcolor="#FFFFFF">');
	i=Math.floor(Math.random()*12321) % Right200Banner.length;
	if(Right200Banner[i][0].indexOf(".swf")>0) {
		document.write('<tr><td>');
	   	flashWrite(PageHost.concat(Right200Banner[i][0]),210,Right200Banner[i][6],Right200Banner[i][1]);
	   	document.write('</td>');
	}
	else {
		if (Right200Banner[i][1]=='') {
			document.write('<tr><td><a href="/index.php"><img src="', PageHost.concat(Right200Banner[i][0]), '" width=210 border=0></a></td>');
		}
		else {
			if(Right200Banner[i][2]=='1') {
				document.write('<tr><td><a href="/ad/click.php?banner=',Right200Banner[i][3],'" target="_blank"><img src="', PageHost.concat(Right200Banner[i][0]), '" width=210 border=0></a></td>');
			}
			else {
				document.write('<tr><td><a href="/ad/click.php?banner=',Right200Banner[i][3],'"><img src="', PageHost.concat(Right200Banner[i][0]), '" width=210 border=0></a></td>');
			}
		}
	}
	i++;
	if(i >= Right200Banner.length) i=0;
	if(Right200Banner[i][0].indexOf(".swf")>0) {
		document.write('<td>');
	   	flashWrite(PageHost.concat(Right200Banner[i][0]),210,Right200Banner[i][6],Right200Banner[i][1]);
	   	document.write('</td>');
	}
	else {
		if (Right200Banner[i][1]=='') {
			document.write('<td><a href="/index.php"><img src="', PageHost.concat(Right200Banner[i][0]), '" width=210 border=0></a></td>');
		}
		else {
			if(Right200Banner[i][2]=='1') {
				document.write('<td><a href="/ad/click.php?banner=',Right200Banner[i][3],'" target="_blank"><img src="', PageHost.concat(Right200Banner[i][0]), '" width=210 border=0></a></td>');
			}
			else {
				document.write('<td><a href="/ad/click.php?banner=',Right200Banner[i][3],'"><img src="', PageHost.concat(Right200Banner[i][0]), '" width=210 border=0></a></td>');
			}
		}
	}
	document.write('</tr></table>');
}

//N2
function DisplayLeftBanner()
{
    if (Left130Banner.length==0)	{
		return;
	}
	document.write('<table cellspacing=0 cellpadding=0 border=0 width=130 bgcolor="#92BB05">');

    	var BannerNumber=Left130Banner.length;
    	var pos = Math.floor(Math.random()*12321) % BannerNumber;
    	
	for(i=pos ; i< BannerNumber; i++) {
			if(Left130Banner[i][0].indexOf(".swf")>0) {
			document.write('<tr><td>');
	   		flashWrite(PageHost.concat(Left130Banner[i][0]),133,Left130Banner[i][6],Left130Banner[i][1]);
	   		document.write('</td></tr>');
		}
		else
		if(Left130Banner[i][0].indexOf(".htm")>0)
	{
		document.write('<iframe width="');document.write(Left130Banner[i][5]);document.write('" height="');document.write(Left130Banner[i][6]);document.write('" src="');document.write(Left130Banner[i][0]);document.write('" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe>');
	}
	else
		 {
			if (Left130Banner[i][1]=='') {
				document.write('<tr><td><a href="/index.php"><img src="', PageHost.concat(Left130Banner[i][0]), '" width=130 border=0></a></td></tr>');
			}
			else {
				if(Left130Banner[i][2]=='1') {
					document.write('<tr><td><a href="/ad/click.php?banner=',Left130Banner[i][3],'" target="_blank"><img src="', PageHost.concat(Left130Banner[i][0]), '" width=133 border=0></a></td></tr>');
				}
				else {
					document.write('<tr><td><a href="/ad/click.php?banner=',Left130Banner[i][3],'"><img src="', PageHost.concat(Left130Banner[i][0]), '" width=133 border=0></a></td></tr>');
				}
			}
		}
	}
       
	for(i=0 ; i<pos; i++) {
			if(Left130Banner[i][0].indexOf(".swf")>0) {
			document.write('<tr><td>');
	   		flashWrite(PageHost.concat(Left130Banner[i][0]),133,Left130Banner[i][6],Left130Banner[i][1]);
	   		document.write('</td></tr>');
		}
		else
		if(Left130Banner[i][0].indexOf(".htm")>0)
	{
		document.write('<iframe width="');document.write(Left130Banner[i][5]);document.write('" height="');document.write(Left130Banner[i][6]);document.write('" src="');document.write(Left130Banner[i][0]);document.write('" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe>');
	}
		else{
			if (Left130Banner[i][1]=='') {
				document.write('<tr><td><a href="/index.php"><img src="', PageHost.concat(Left130Banner[i][0]), '" width=130 border=0></a></td></tr>');
			}
			else {
				if(Left130Banner[i][2]=='1') {
					document.write('<tr><td><a href="/ad/click.php?banner=',Left130Banner[i][3],'" target="_blank"><img src="', PageHost.concat(Left130Banner[i][0]), '" width=133 border=0></a></td></tr>');
				}
				else {
					document.write('<tr><td><a href="/ad/click.php?banner=',Left130Banner[i][3],'"><img src="', PageHost.concat(Left130Banner[i][0]), '" width=133 border=0></a></td></tr>');
				}
			}
		}
 	}

	document.write('</table>');
}

function ChangeBottomBanner()
{
	if (BottomBanner.length==0)
		return;
	CurBottomBanner++;
	if (CurBottomBanner >= BottomBanner.length)	{
		CurBottomBanner=0;
	}
	document.links[BottomBannerLnk].href= '/ad/click.php?banner=' + BottomBanner[CurBottomBanner][3];
	if(BottomBanner[CurBottomBanner][2]=='1') document.links[BottomBannerLnk].target= '_blank';
	else document.links[BottomBannerLnk].target= '';
	document.images['imgBottomBanner'].src = PageHost.concat(BottomBanner[CurBottomBanner][0]);
}

function DisplayBottomBanner(rbn)
{
	if (BottomBanner.length==0)
	{
		return;
	}
	CurBottomBanner=Math.floor(Math.random()*12321) % BottomBanner.length;
	BottomBannerLnk=document.links.length;
	if(BottomBanner[CurBottomBanner][0].indexOf(".swf")>0) {
		document.write('<table cellspacing=0 cellpadding=0 border=0 width=778 height=120 bgcolor="#92BB05" align="center"><tr><td><OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" WIDTH="778" HEIGHT="120"><PARAM NAME=movie VALUE="', PageHost.concat(BottomBanner[CurBottomBanner][0]),'"><PARAM NAME=quality VALUE=high><embed src="',PageHost.concat(BottomBanner[CurBottomBanner][0]),'" width="778" height="120" quality="high" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer/"></embed></OBJECT></td></tr></table>');
		return;
	}
	if (BottomBanner[CurBottomBanner][1]=='')
	{
		document.write('<table cellspacing=0 cellpadding=0 border=0 width=778 height=120 bgcolor="#92BB05" align="center"><tr><td><a href="/index.php"><img name="imgBottomBanner" src="', PageHost.concat(BottomBanner[CurBottomBanner][0]), '" width=778 height=120 border=0></a></td></tr></table>');
	}
	else
	{
		if(BottomBanner[CurBottomBanner][2]=='1')
			document.write('<table cellspacing=0 cellpadding=0 border=0 width=778 height=120 bgcolor="#92BB05" align="center"><tr><td><a href="/ad/click.php?banner=',BottomBanner[CurBottomBanner][3], '" target="_blank"><img name="imgBottomBanner" src="', PageHost.concat(BottomBanner[CurBottomBanner][0]), '" width=778 height=120 border=0></a></td></tr></table>');
		else
			document.write('<table cellspacing=0 cellpadding=0 border=0 width=778 height=120 bgcolor="#92BB05" align="center"><tr><td><a href="/ad/click.php?banner=',BottomBanner[CurBottomBanner][3], '"><img name="imgBottomBanner" src="', PageHost.concat(BottomBanner[CurBottomBanner][0]), '" width=778 height=120 border=0></a></td></tr></table>');
	}

	if (typeof(rbn) == 'undefined')
	{
		rbn = 1;
	}

	if (rbn)
	{
		setInterval('ChangeBottomBanner()', 15000);
	}
}
// Nguyen them 06/04/2006
function DisplayFloatBanner(side)
{
	if( side == 0 ) // ko in gi ca
		return;
		
	if( FloatBanner.length == 0 )
		return;
		
	document.write('<table cellspacing=0 cellpadding=0 border=0 width=115 bgcolor="#FFFFFF">');
	
	if (side==1) // ben trai
		for (i=0; i<FloatBanner.length; i++)
			if(FloatBanner[i][4]=='8')
				if(FloatBanner[i][0].indexOf(".swf")>0)
				{ 
					document.write('<tr><td>');
	   				flashWrite(PageHost.concat(FloatBanner[i][0]),115,FloatBanner[i][6],FloatBanner[i][1]);
	   				document.write('</td></tr>');
	   			}
	   			else
	   			{
	   				document.write('<tr><td><a href="',FloatBanner[i][1],'" target="_blank"><img src="', PageHost.concat(FloatBanner[i][0]), '" width=115 border=0></a></td></tr>');
	   			}
	   			//Removed by PhuongNH
	   			/*
	   			else if(FloatBanner[i][0].indexOf(".htm")>0)
	   			{
	   				document.write('<tr><td>');
	   				document.write('<iframe width="');document.write(FloatBanner[i][5]);document.write('" height="');document.write(FloatBanner[i][6]);document.write('" src="');document.write(FloatBanner[i][0]);document.write('" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe>');
	   				document.write('</td></tr>');
	   			}
				else if(FloatBanner[i][1]=='')
					document.write('<tr><td><a href="/index.php"><img src="', PageHost.concat(FloatBanner[i][0]), '" width=115 border=0></a></td></tr>');
					else if(FloatBanner[i][2]=='1')
						document.write('<tr><td><a href="/ad/click.php?banner=',FloatBanner[i][3],'" target="_blank"><img src="', PageHost.concat(FloatBanner[i][0]), '" width=115 border=0></a></td></tr>');
						else 
							document.write('<tr><td><a href="/ad/click.php?banner=',FloatBanner[i][3],'"><img src="', PageHost.concat(FloatBanner[i][0]), '" width=115 border=0></a></td></tr>');
				*/
		
	if (side==2) // ben phai
		for (i=0; i<FloatBanner.length; i++)
			if(FloatBanner[i][4]=='9')
				if(FloatBanner[i][0].indexOf(".swf")>0) 
				{
					document.write('<tr><td>');
	   				flashWrite(PageHost.concat(FloatBanner[i][0]),115,FloatBanner[i][6],FloatBanner[i][1]);
	   				document.write('</td></tr>');
				}
				else
				{
					//Open link in new window
					document.write('<tr><td><a href="',FloatBanner[i][1],'" target="_blank"><img src="', PageHost.concat(FloatBanner[i][0]), '" width=115 border=0></a></td></tr>');
				}
				//Removed by PhuongNH
				/*
				else if(FloatBanner[i][0].indexOf(".htm")>0)
	   			{
	   				document.write('<tr><td>');
	   				document.write('<iframe width="');document.write(FloatBanner[i][5]);document.write('" height="');document.write(FloatBanner[i][6]);document.write('" src="');document.write(FloatBanner[i][0]);document.write('" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe>');
	   				document.write('</td></tr>');
	   			}	
				else if(FloatBanner[i][1]=='')
					document.write('<tr><td><a href="/index.php"><img src="', PageHost.concat(FloatBanner[i][0]), '" width=115 border=0></a></td></tr>');
					else if(FloatBanner[i][2]=='1')
						document.write('<tr><td><a href="/ad/click.php?banner=',FloatBanner[i][3],'" target="_blank"><img src="', PageHost.concat(FloatBanner[i][0]), '" width=115 border=0></a></td></tr>');
						else 
							document.write('<tr><td><a href="/ad/click.php?banner=',FloatBanner[i][3],'"><img src="', PageHost.concat(FloatBanner[i][0]), '" width=115 border=0></a></td></tr>');
				*/
		
	document.write('</table>');
}

function DisplayOnPage210Banner()
{
	if (OnPage210Banner.length<2) return;
	document.write('<table cellspacing=0 cellpadding=0 border=0 width="100%" bgcolor="#FFFFFF">');
	i=Math.floor(Math.random()*12321) % OnPage210Banner.length;
	if(OnPage210Banner[i][0].indexOf(".swf")>0) {
		document.write('<tr><td>');
	   	flashWrite(PageHost.concat(OnPage210Banner[i][0]),210,OnPage210Banner[i][6],OnPage210Banner[i][1]);
	   	document.write('</td>');
	}
	else {
		if (OnPage210Banner[i][1]=='') {
			document.write('<tr><td><a href="/index.php"><img src="', PageHost.concat(OnPage210Banner[i][0]), '" width=210 border=0></a></td>');
		}
		else {
			if(OnPage210Banner[i][2]=='1') {
				document.write('<tr><td><a href="/ad/click.php?banner=',OnPage210Banner[i][3],'" target="_blank"><img src="', PageHost.concat(OnPage210Banner[i][0]), '" width=210 border=0></a></td>');
			}
			else {
				document.write('<tr><td><a href="/ad/click.php?banner=',OnPage210Banner[i][3],'"><img src="', PageHost.concat(OnPage210Banner[i][0]), '" width=210 border=0></a></td>');
			}
		}
	}
	i++;
	if(i >= OnPage210Banner.length) i=0;
	if(OnPage210Banner[i][0].indexOf(".swf")>0) {
		document.write('<td>');
	   	flashWrite(PageHost.concat(OnPage210Banner[i][0]),210,OnPage210Banner[i][6],OnPage210Banner[i][1]);
	   	document.write('</td>');
	}
	else {
		if (OnPage210Banner[i][1]=='') {
			document.write('<td><a href="/index.php"><img src="', PageHost.concat(OnPage210Banner[i][0]), '" width=210 border=0></a></td>');
		}
		else {
			if(OnPage210Banner[i][2]=='1') {
				document.write('<td><a href="/ad/click.php?banner=',OnPage210Banner[i][3],'" target="_blank"><img src="', PageHost.concat(OnPage210Banner[i][0]), '" width=210 border=0></a></td>');
			}
			else {
				document.write('<td><a href="/ad/click.php?banner=',OnPage210Banner[i][3],'"><img src="', PageHost.concat(OnPage210Banner[i][0]), '" width=210 border=0></a></td>');
			}
		}
	}
	document.write('</tr></table>');
}

/////////////////////////////////
// File Name: mBanner.js       //
// By: Manish Kumar Namdeo     //
/////////////////////////////////

// BANNER OBJECT
function Banner(objName)
   {
	this.obj = objName;
	this.aNodes = [];
	this.currentBanner =Math.floor(Math.random()*3);
	};

// ADD NEW BANNER
Banner.prototype.add = function(bannerType, bannerPath, bannerDuration, height, width, hyperlink) {
	this.aNodes[this.aNodes.length] = new Node(this.obj +"_"+ this.aNodes.length, bannerType, bannerPath, bannerDuration, height, width, hyperlink);
};

// Node object
function Node(name, bannerType, bannerPath, bannerDuration, height, width, hyperlink) {
	this.name = name;
	this.bannerType = bannerType;
	this.bannerPath = bannerPath;
	this.bannerDuration = bannerDuration;
	this.height = height
	this.width = width;
	this.hyperlink= hyperlink;
//	alert (name +"|" + bannerType +"|" + bannerPath +"|" + bannerDuration +"|" + height +"|" + width + "|" + hyperlink);
};
// Outputs the banner to the page
Banner.prototype.toString = function() {
	var str = ""
	
	//alert(this.aNodes.length);
	for (var iCtr=0; iCtr < this.aNodes.length; iCtr++) //old: iCtr=0
	    { 
	    //alert(pos);
		str = str + '<span name="'+this.aNodes[iCtr].name+'" '
		str = str + 'id="'+this.aNodes[iCtr].name+'" ';
		str = str + 'class="m_banner_hide" ';
		str = str + 'bgcolor="#FFFCDA" ';	// CHANGE BANNER COLOR HERE
		str = str + 'align="center" ';
		str = str + 'valign="top" >\n';
		if (this.aNodes[iCtr].hyperlink != ""){
			str = str + '<a href="'+this.aNodes[iCtr].hyperlink+'" target="_blank">';
		}
		if ( this.aNodes[iCtr].bannerType == "TEXT" )
		{
			str=str+ '<iframe width="'+this.aNodes[iCtr].width+'" height="'+this.aNodes[iCtr].height+'" src="'+this.aNodes[iCtr].bannerPath+'" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe> ';
		}	
		if ( this.aNodes[iCtr].bannerType == "FLASH" ){
			str=str+ '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" '
			str=str+ 'codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" '
			str=str+ 'width="'+this.aNodes[iCtr].width+'" '
			str=str+ 'height="'+this.aNodes[iCtr].height+'" '
			str=str+ 'id="bnr_'+this.aNodes[iCtr].name+'" align="middle" VIEWASTEXT> '
			str=str+ '<param name="allowScriptAccess" value="always" />'
			str=str+ '<param name="movie" value="'+this.aNodes[iCtr].bannerPath+'" />'
			//str=str+ 'param name="FlashVars" value="'+vars+'" />'
			str=str+ '<param name="wmode" value="transparent" />'
			str=str+ '<param name="menu" value="false" />'
			str=str+ '<param name="quality" value="high" />'
			str=str+ '<embed src="'+this.aNodes[iCtr].bannerPath+'" wmode="transparent" menu="false" quality="high" width="'+this.aNodes[iCtr].width+'" height="'+this.aNodes[iCtr].height+'" name="bnr_'+this.aNodes[iCtr].name+'" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />'
			str=str+ '</embed></object>'
			
		}else if ( this.aNodes[iCtr].bannerType == "IMAGE" ){
			str = str + '<img src="'+this.aNodes[iCtr].bannerPath+'" ';
			str = str + 'border="0" ';
			str = str + 'height="'+this.aNodes[iCtr].height+'" ';
			str = str + 'width="'+this.aNodes[iCtr].width+'">';
		}

		if (this.aNodes[iCtr].hyperlink != ""){
			str = str + '</a>';
		}

		str += '</span>';
			}
	document.write(str);
str="";
return str;
};

// START THE BANNER ROTATION
Banner.prototype.start = function(){
	this.changeBanner();
	var thisBannerObj = this.obj;
	// CURRENT BANNER IS ALREADY INCREMENTED IN changeBanner() FUNCTION
	setTimeout(thisBannerObj+".start()", this.aNodes[this.currentBanner].bannerDuration * 1000);

}

// CHANGE BANNER
Banner.prototype.changeBanner = function(){
	var thisBanner;
	var prevBanner = -1;
	if (this.currentBanner>this.aNodes.length-1)
	{
		this.currentBanner=0;
	}
	if (this.currentBanner < this.aNodes.length ){
		thisBanner = this.currentBanner;
		if (this.aNodes.length > 1){
			if ( thisBanner > 0 ){
				prevBanner = thisBanner - 1;
			}else{
				prevBanner = this.aNodes.length-1;
			}
		}
		if (this.currentBanner < this.aNodes.length - 1){
			this.currentBanner = this.currentBanner + 1;
		}else{
			this.currentBanner = 0;
		}
	}
	

	if (prevBanner >= 0){
		document.getElementById(this.aNodes[prevBanner].name).className = "m_banner_hide";
	}
	document.getElementById(this.aNodes[thisBanner].name).className = "m_banner_show";
}



//-----------------------------------------------------------------------------------------------

// - Ads rotator --------------------------------------------------------------------------------
//Function runs when this page has been loaded and does the following:
//1. Determine the browser name and version  (since the script will only work on Netscape 3+ and Internet Explorer 4+).
//2. Start the timer object that will periodically change the image displayed by the Banner Ad.
//3. Preload the images used by the Banner Ad rotator script
function InitialiseBannerAdRotator() {

//Determine the browser name and version
//The script will only work on Netscape 3+ and Internet Explorer 4+
var BrowserType = navigator.appName;
var BrowserVersion = parseInt(navigator.appVersion);

if (BrowserType == "Netscape" && (BrowserVersion >= 3)) {
IsValidBrowser = true;
}

if (BrowserType == "Microsoft Internet Explorer" && (BrowserVersion >= 4)) {
IsValidBrowser = true;
}

if (IsValidBrowser) {
TimerObject = setTimeout("ChangeImage()", DisplayInterval);
BannerAdCode = 0;

for (i = 0; i < NumberOfImages; i++) {
BannerAdImages[i] = new Image();
BannerAdImages[i].src = ' ' + ImageFolder + ImageFileNames[i];
}

}

}

//Function to change the src of the Banner Ad image
function ChangeImage() {

if (IsValidBrowser) {
BannerAdCode = BannerAdCode + 1;

if (BannerAdCode == NumberOfImages) {
BannerAdCode = 0;
}

window.document.bannerad.src = BannerAdImages[BannerAdCode].src;
TimerObject = setTimeout("ChangeImage()", DisplayInterval);
}
}

//Function to redirect the browser window/frame to a new location,
//depending on which image is currently being displayed by the Banner Ad.
//If Banner Ad is being displayed on an old browser then the DefaultURL is displayed
function ChangePage() {

if (IsValidBrowser) {

if (TargetFrame != '' && (FramesObject)) {
FramesObject.location.href = ImageURLs[BannerAdCode];
} else {
document.location = ImageURLs[BannerAdCode];
}

} else if (!IsValidBrowser) {
document.location = DefaultURL;
}

}
//-----------------------------------------------------------------------------------------------

//- Utilities -----------------------------------------------------------------------------------
//Show container
function showContainer(containerID)
{
	var browserName = BrowserDetect.browser;
	//alert(browserName);
	var objContainer = document.getElementById(containerID);
	//alert(objContainer.style.display);
	if (objContainer)
	{
		if (browserName == "Explorer") // is IE
		{
			objContainer.style.display = "block";
		}
		else
		{
			//alert("It's FF");
			objContainer.style.display = "block";
			objContainer.style.visibility = "visible";				
		}
	}
}

function hideContainer(containerID)
{
	var browserName = BrowserDetect.browser;
	//alert(browserName);
	var objContainer = document.getElementById(containerID);
	//alert(objContainer.style.display);
	if (objContainer)
	{
		
		if (browserName == "Explorer") // is IE
		{
			objContainer.style.display = "none";
		}
		else
		{
			//alert("It's FF");
			//alert("Hide");
			//alert(objContainer.innerHTML);
			//objContainer.innerHTML = "";
			//objContainer.style.display = "none";
			//objContainer.style.visibility = "hidden";				
			objContainer.style.visibility = "collapse";
			//Remove text
			//eval("var "+containerID+"_innerHTML = '"+objContainer.innerHTML+"'");
			//objContainer.innerHTML = "";
		}
	}
}
//Show/Hide container
function toggleContainer(containerID)
{
	var browserName = BrowserDetect.browser;
	//alert(browserName);
	var objContainer = document.getElementById(containerID);
	//alert(objContainer.style.display);
	if (objContainer)
	{
		
		if (browserName == "Explorer") // is IE
		{
			var displayStatus = objContainer.style.display;
			//alert("It's IE");
			//alert(displayStatus);
			if (displayStatus == "" || displayStatus == "none")
			{
				objContainer.style.display = "block";
			}
			else
			{
				objContainer.style.display = "none";
			}
		}
		else
		{
			//alert("It's FF");
			var displayStatus = objContainer.style.visibility;
			//alert(displayStatus);
			if (!displayStatus || displayStatus == "" || displayStatus == "hidden" || displayStatus == "collapse")
			{
				//alert("Visible");
				//alert(objContainer.innerHTML);
				//objContainer.innerHTML = eval("containerID+"_innerHTML);
				objContainer.style.display = "block";
				objContainer.style.visibility = "visible";				
			}
			else
			{
				//alert("Hide");
				//alert(objContainer.innerHTML);
				//objContainer.innerHTML = "";
				//objContainer.style.display = "none";
				//objContainer.style.visibility = "hidden";				
				objContainer.style.visibility = "collapse";
				//Remove text
				//eval("var "+containerID+"_innerHTML = '"+objContainer.innerHTML+"'");
				//objContainer.innerHTML = "";
			}
		}
		/*
		if (!displayStatus || displayStatus == "" || objContainer.style.visibility == "" || objContainer.style.visibility == "hidden")
		{
			displayStatus = "none";
			objContainer.style.visibility = "hidden";
		}
		if (displayStatus == "none" || objContainer.style.visibility == "" || objContainer.style.visibility == "hidden" || objContainer.style.visibility == "collapse")
		{
			objContainer.style.display = "block";
			objContainer.style.visibility = "visible";
		}
		else
		{
			//objContainer.innerHTML = "";
			objContainer.style.display = "none";
			objContainer.style.visibility = "collapse";
		}
		*/
	}
}

//Toggle child menu item when click on parent item
function toggleChildItem(startIndex, itemClassName)
{
	try
	{
		var itemLevel = itemClassName.substring(itemClassName.lastIndexOf("level"), itemClassName.lastIndexOf("_"));
		itemLevel = itemLevel.replace(/level/g,"");
		//alert(itemLevel);
		//alert("Item ["+startIndex+"] -> "+itemClassName);
		var count = startIndex;
		while (startIndex>=0 && startIndex<300)
		{
			count++;
			var itemID = "menu_item_"+count;
			//alert(itemID);
			var obj = document.getElementById(itemID);
			var cell = obj.childNodes[0];
			//alert(obj.className);
			if (cell && cell.className != itemClassName)
			{
				//var item_level = cell.className.substring(cell.className.lastIndexOf("level"),  cell.className.lastIndexOf("_"));
				//item_level = item_level.replace(/level/g,"");
				//if ((item_level-itemLevel) == 1)
					toggleContainer(obj.id);
			}
			else
			{
				return;
			}		
		}
	}
	catch (Ex)
	{}
}

//Toggle parent item when child item is selected
function toggleParentItem(catID)
{
	try
	{
		//alert("Item ["+startIndex+"] -> "+itemClassName);
		var objAllRow = document.getElementsByTagName("tr");
		var catIDs = "";
		for (i=0; i<objAllRow.length; i++)
		{
			if (objAllRow[i].getAttribute("catID") && objAllRow[i].getAttribute("catID") == catID)
			{
				//alert('Found it');
				//Set row/cell style & behavior
				var objSelectedRow = objAllRow[i];
				var objSelectedCell = objSelectedRow.childNodes[0];
				//alert(objSelectedCell.className);
				var oldSelectedCellClassName = objSelectedCell.className;
				objSelectedCell.className = objSelectedCell.className+'_selected';
				//objSelectedCell.onmouseover = '';
				//objSelectedCell.onmouseout = '';
				//objSelectedCell.onclick = '';
				objSelectedCell.setAttribute('onmouseover','');
				objSelectedCell.setAttribute('onmouseout','');
				objSelectedCell.setAttribute('onclick','');
				//Toggle parent item
				var invert_counter = i;
				while (invert_counter >= 0)
				{
					invert_counter--;
					if (objAllRow[invert_counter].getAttribute("catID"))
					{						
						var objCurrentRow = objAllRow[invert_counter];
						var objCurrentCell = objCurrentRow.childNodes[0];
						if (objCurrentCell && objCurrentCell.className != oldSelectedCellClassName && objCurrentCell.className.indexOf("level1")>0)
						{
							//alert(objCurrentRow.id);
							//alert(objCurrentCell.className);
							toggleChildItem(objCurrentRow.id.replace('menu_item_',''),'left_menu_level1_cell');
							return;
						}
						else
						{
							//return;
						}
					}		
				}
			}
			//catIDs += "; "+objAllRow[i].catID;
		}
	}
	catch (Ex)
	{}
}
//-----------------------------------------------------------------------------------------------

function isValidEmail(str) {
   return (str.indexOf(".") > 2) && (str.indexOf("@") > 0) && (str.substring(str.lastIndexOf(".")+1).length>0);
 
}

function isValidPhoneNumber(str)
{
	var strTemp = str.replace(/\-/g,"");
	var strTemp = strTemp.replace(/\./g,"");
	var strTemp = strTemp.replace(/\(/g,"");
	var strTemp = strTemp.replace(/\)/g,"");
	var strTemp = strTemp.replace(/\s/g,"");
	//alert(strTemp);
	return !isNaN(strTemp);
}
