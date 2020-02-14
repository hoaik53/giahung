<?php if (substr_count($_SERVER['PHP_SELF'],'/categories.php')>0) die ("You can't access this file directly..."); ?>
<script language="javascript" type="text/javascript">
function switchcontent(className, filtertag){
	this.className=className
	this.collapsePrev=false //Default: Collapse previous content each time
	this.persistType="none" //Default: Disable persistence
	//Limit type of element to scan for on page for switch contents if 2nd function parameter is defined, for efficiency sake (ie: "div")
	this.filter_content_tag=(typeof filtertag!="undefined")? filtertag.toLowerCase() : ""
}

switchcontent.prototype.setStatus=function(openHTML, closeHTML){ //PUBLIC: Set open/ closing HTML indicator. Optional
	this.statusOpen=openHTML
	this.statusClosed=closeHTML
}

switchcontent.prototype.setColor=function(openColor, closeColor){ //PUBLIC: Set open/ closing color of switch header. Optional
	this.colorOpen=openColor
	this.colorClosed=closeColor
}

switchcontent.prototype.setPersist=function(bool, days){ //PUBLIC: Enable/ disable persistence. Default is false.
	if (bool==true){ //if enable persistence
		if (typeof days=="undefined") //if session only
			this.persistType="session"
		else{ //else if non session persistent
			this.persistType="days"
			this.persistDays=parseInt(days)
		}
	}
	else
		this.persistType="none"
}

switchcontent.prototype.collapsePrevious=function(bool){ //PUBLIC: Enable/ disable collapse previous content. Default is false.
	this.collapsePrev=bool
}


switchcontent.prototype.sweepToggle=function(setting){ //PUBLIC: Expand/ contract all contents method. (Values: "contract"|"expand")
	if (typeof this.headers!="undefined" && this.headers.length>0){ //if there are switch contents defined on the page
		for (var i=0; i<this.headers.length; i++){
			if (setting=="expand")
				this.expandcontent(this.headers[i]) //expand each content
			else if (setting=="contract")
				this.contractcontent(this.headers[i]) //contract each content
		}
	}
}


// -------------------------------------------------------------------
// PUBLIC: defaultExpanded(indices_of_contents)- Set contents that should be expanded by default when the page loads.
// Note that the persistence feature (if enabled) overrides this setting.
// Pass in the position of the contents relative to the rest of the contents ie: defaultExpanded(0,2,3) would expand the 1st, 3rd, and 4th contents by default
// -------------------------------------------------------------------

switchcontent.prototype.defaultExpanded=function(){
	var expandedindices=[] //Array to hold indices (position) of content to be expanded by default
	//Loop through function arguments, and store each one within array
	//Two test conditions: 1) End of Arguments array, or 2) If "collapsePrev" is enabled, only the first entered index (as only 1 content can be expanded at any time)
	for (var i=0; (!this.collapsePrev && i<arguments.length) || (this.collapsePrev && i==0); i++)
		expandedindices[expandedindices.length]=arguments[i]
	this.expandedindices=expandedindices.join(",") //convert array into a string of the format: "0,2,3" for later parsing by script
}


//PRIVATE: Sets color of switch header.

switchcontent.prototype.togglecolor=function(header, status){
	if (typeof this.colorOpen!="undefined")
		header.style.color=status
}


//PRIVATE: Sets status indicator HTML of switch header.

switchcontent.prototype.togglestatus=function(header, status){
	if (typeof this.statusOpen!="undefined")
		header.firstChild.innerHTML=status
}


//PRIVATE: Contracts a content based on its corresponding header entered

switchcontent.prototype.contractcontent=function(header){
	var innercontent=document.getElementById(header.id.replace("-title", "")) //Reference content for this header
	innercontent.style.display="none"
	this.togglestatus(header, this.statusClosed)
	this.togglecolor(header, this.colorClosed)
}


//PRIVATE: Expands a content based on its corresponding header entered

switchcontent.prototype.expandcontent=function(header){
	var innercontent=document.getElementById(header.id.replace("-title", ""))
	innercontent.style.display="block"
	this.togglestatus(header, this.statusOpen)
	this.togglecolor(header, this.colorOpen)
}

// -------------------------------------------------------------------
// PRIVATE: toggledisplay(header)- Toggles between a content being expanded or contracted
// If "Collapse Previous" is enabled, contracts previous open content before expanding current
// -------------------------------------------------------------------

switchcontent.prototype.toggledisplay=function(header){
	var innercontent=document.getElementById(header.id.replace("-title", "")) //Reference content for this header
	if (innercontent.style.display=="block")
		this.contractcontent(header)
	else{
		this.expandcontent(header)
		if (this.collapsePrev && typeof this.prevHeader!="undefined" && this.prevHeader.id!=header.id) // If "Collapse Previous" is enabled and there's a previous open content
			this.contractcontent(this.prevHeader) //Contract that content first
	}
	if (this.collapsePrev)
		this.prevHeader=header //Set current expanded content as the next "Previous Content"
}


// -------------------------------------------------------------------
// PRIVATE: collectElementbyClass()- Searches and stores all switch contents (based on shared class name) and their headers in two arrays
// Each content should carry an unique ID, and for its header, an ID equal to "CONTENTID-TITLE"
// -------------------------------------------------------------------

switchcontent.prototype.collectElementbyClass=function(classname){ //Returns an array containing DIVs with specified classname
	var classnameRE=new RegExp("(^|\\s+)"+classname+"($|\\s+)", "i") //regular expression to screen for classname within element
	this.headers=[], this.innercontents=[]
	if (this.filter_content_tag!="") //If user defined limit type of element to scan for to a certain element (ie: "div" only)
		var allelements=document.getElementsByTagName(this.filter_content_tag)
	else //else, scan all elements on the page!
		var allelements=document.all? document.all : document.getElementsByTagName("*")
	for (var i=0; i<allelements.length; i++){
		if (typeof allelements[i].className=="string" && allelements[i].className.search(classnameRE)!=-1){
			if (document.getElementById(allelements[i].id+"-title")!=null){ //if header exists for this inner content
				this.headers[this.headers.length]=document.getElementById(allelements[i].id+"-title") //store reference to header intended for this inner content
				this.innercontents[this.innercontents.length]=allelements[i] //store reference to this inner content
			}
		}
	}
}


//PRIVATE: init()- Initializes Switch Content function (collapse contents by default unless exception is found)

switchcontent.prototype.init=function(){
	var instanceOf=this
	this.collectElementbyClass(this.className) //Get all headers and its corresponding content based on shared class name of contents
	if (this.headers.length==0) //If no headers are present (no contents to switch), just exit
		return
	//If admin has changed number of days to persist from current cookie records, reset persistence by deleting cookie
	if (this.persistType=="days" && (parseInt(switchcontent.getCookie(this.className+"_dtrack"))!=this.persistDays))
		switchcontent.setCookie(this.className+"_d", "", -1) //delete cookie
	// Get ids of open contents below. Four possible scenerios:
	// 1) Session only persistence is enabled AND corresponding cookie contains a non blank ("") string
	// 2) Regular (in days) persistence is enabled AND corresponding cookie contains a non blank ("") string
	// 3) If there are contents that should be enabled by default (even if persistence is enabled and this IS the first page load)
	// 4) Default to no contents should be expanded on page load ("" value)
	var opencontents_ids=(this.persistType=="session" && switchcontent.getCookie(this.className)!="")? ','+switchcontent.getCookie(this.className)+',' : (this.persistType=="days" && switchcontent.getCookie(this.className+"_d")!="")? ','+switchcontent.getCookie(this.className+"_d")+',' : (this.expandedindices)? ','+this.expandedindices+',' : ""
	for (var i=0; i<this.headers.length; i++){ //BEGIN FOR LOOP
		if (typeof this.statusOpen!="undefined") //If open/ closing HTML indicator is enabled/ set
			this.headers[i].innerHTML='<span class="status"></span>'+this.headers[i].innerHTML //Add a span element to original HTML to store indicator
		if (opencontents_ids.indexOf(','+i+',')!=-1){ //if index "i" exists within cookie string or default-enabled string (i=position of the content to expand)
			this.expandcontent(this.headers[i]) //Expand each content per stored indices (if ""Collapse Previous" is set, only one content)
			if (this.collapsePrev) //If "Collapse Previous" set
			this.prevHeader=this.headers[i]  //Indicate the expanded content's corresponding header as the last clicked on header (for logic purpose)
		}
		else //else if no indices found in stored string
			this.contractcontent(this.headers[i]) //Contract each content by default
		this.headers[i].onclick=function(){instanceOf.toggledisplay(this)}
	} //END FOR LOOP
	switchcontent.dotask(window, function(){instanceOf.rememberpluscleanup()}, "unload") //Call persistence method onunload
}


// -------------------------------------------------------------------
// PRIVATE: rememberpluscleanup()- Stores the indices of content that are expanded inside session only cookie
// If "Collapse Previous" is enabled, only 1st expanded content index is stored
// -------------------------------------------------------------------

//Function to store index of opened ULs relative to other ULs in Tree into cookie:
switchcontent.prototype.rememberpluscleanup=function(){
	//Define array to hold ids of open content that should be persisted
	//Default to just "none" to account for the case where no contents are open when user leaves the page (and persist that):
	var opencontents=new Array("none")
	for (var i=0; i<this.innercontents.length; i++){
		//If persistence enabled, content in question is expanded, and either "Collapse Previous" is disabled, or if enabled, this is the first expanded content
		if (this.persistType!="none" && this.innercontents[i].style.display=="block" && (!this.collapsePrev || (this.collapsePrev && opencontents.length<2)))
			opencontents[opencontents.length]=i //save the index of the opened UL (relative to the entire list of ULs) as an array element
		this.headers[i].onclick=null //Cleanup code
	}
	if (opencontents.length>1) //If there exists open content to be persisted
		opencontents.shift() //Boot the "none" value from the array, so all it contains are the ids of the open contents
	if (typeof this.statusOpen!="undefined")
		this.statusOpen=this.statusClosed=null //Cleanup code
	if (this.persistType=="session") //if session only cookie set
		switchcontent.setCookie(this.className, opencontents.join(",")) //populate cookie with indices of open contents: classname=1,2,3,etc
	else if (this.persistType=="days" && typeof this.persistDays=="number"){ //if persistent cookie set instead
		switchcontent.setCookie(this.className+"_d", opencontents.join(","), this.persistDays) //populate cookie with indices of open contents
		switchcontent.setCookie(this.className+"_dtrack", this.persistDays, this.persistDays) //also remember number of days to persist (int)
	}
}


// -------------------------------------------------------------------
// A few utility functions below:
// -------------------------------------------------------------------


switchcontent.dotask=function(target, functionref, tasktype){ //assign a function to execute to an event handler (ie: onunload)
	var tasktype=(window.addEventListener)? tasktype : "on"+tasktype
	if (target.addEventListener)
		target.addEventListener(tasktype, functionref, false)
	else if (target.attachEvent)
		target.attachEvent(tasktype, functionref)
}

switchcontent.getCookie=function(Name){ 
	var re=new RegExp(Name+"=[^;]+", "i"); //construct RE to search for target name/value pair
	if (document.cookie.match(re)) //if cookie found
		return document.cookie.match(re)[0].split("=")[1] //return its value
	return ""
}

switchcontent.setCookie=function(name, value, days){
	if (typeof days!="undefined"){ //if set persistent cookie
		var expireDate = new Date()
		var expstring=expireDate.setDate(expireDate.getDate()+days)
		document.cookie = name+"="+value+"; expires="+expireDate.toGMTString()
	}
	else //else if this is a session only cookie
		document.cookie = name+"="+value
}

function accept()
	{
	if (confirm("<?php echo $strSaveChange; ?> ?")==true)
		{
		if (confirm("<?php echo $strConfirm.' '.$strAgain; ?> !!!")==true)
			return true;
		else
			return false;
		}
	else
		return false;
	}

function addsubitem(parentlevel)
	{
	var state=document.tree.style.display;
	if (state=="block")
		{
		document.addsub.style.display="block";
		document.tree.style.display="none";
		document.addsub.level.value=parentlevel;
		document.addsub.subname.focus();
		}
	else
		{
		document.addsub.style.display="none";
		document.tree.style.display="block";
		document.addsub.level.value='';
		}
	}

function del(parentlevel)
	{
	if (confirm("<?php echo $strDelete.' '.$strCategory; ?> ' " + parentlevel + " ' ?")==true)
		{
		if (confirm("<?php echo $strConfirm.' '.$strAgain; ?> !!!")==true)
			{
			document.tree.action.value="delete";
			document.tree.level.value=parentlevel;
			document.tree.submit();
			}
		}
	}
	
function addrecord(parentlevel)
	{
	if (confirm("<?php echo $strquestion; ?>")==true)
		{
		document.tree.action.value="addrecord";
		document.tree.level.value=parentlevel;
		document.tree.submit();
		}
	}

function changepos(olevel)
	{
	if (confirm("<?php echo $strChangePos; ?> ?")==true)
		{
		if (confirm("<?php echo $strConfirm.' '.$strAgain; ?> !!!")==true)
			{
			document.tree.action.value="changepos";
			document.tree.level.value=olevel;
			document.tree.submit();
			}
		}
	}

function changelevel(olevel)
	{
	if (confirm("<?php echo $strChangeLevel; ?> ?")==true)
		{
		if (confirm("<?php echo $strConfirm.' '.$strAgain; ?> !!!")==true)
			{
			document.tree.action.value="changelevel";
			document.tree.level.value=olevel;
			document.tree.submit();
			}
		}
	}
function changehotnews(olevel, hotnews)
	{
	// alert("olevel::" + olevel);
	if (confirm("<?php echo "Ban co muon tiep tuc?"; ?> ?")==true)
		{
		if (confirm("<?php echo $strConfirm.' '.$strAgain; ?> !!!")==true)
			{
			document.tree.action.value="hotnews";
			//alert("olevel::" + olevel + "::hotnews::" + hotnews);
			document.tree.level.value=olevel;
			document.tree.hotnews.value = hotnews;
			document.tree.submit();
			}
		}
	}
function changegroup(olevel)
	{
	if (confirm("<?php echo $strChangeCat; ?> ?")==true)
		{
		if (confirm("<?php echo $strConfirm.' '.$strAgain; ?> !!!")==true)
			{
			document.tree.action.value="changegroup";
			document.tree.level.value=olevel;
			document.tree.submit();
			}
		}
	}
</script>
<form name="temp" method="post" action="categories.php">
</form>
<input type="hidden" id="rowId" />
<input type="hidden" id="tempId" />
<table style="width: 100%;" cellpadding="0" cellspacing="0">
<?php
$system_tbl=array('users','user_group');
if (isset($_REQUEST['tblname']) and !in_array($_REQUEST['tblname'],$system_tbl))
	{
	$tblname=$_REQUEST['tblname'];
	$msg='';	
	$redirect ='<script>';
	$redirect.='setTimeout(\'window.location.replace("index.php")\',3000);';
	$redirect.='</script>';
	
	if (isset($_POST['action']))
		{
		$action=$_POST['action'];
		$tree ='select * from '.$tblname.'_cat';
		$tree.=' where lang="'.get_langID().'"';
		$tree.=' order by level ASC';
		$dotree=mysql_query($tree,$link);
		if ($dotree and mysql_num_rows($dotree)>=0)
			{
			$rows=mysql_num_rows($dotree);
			$i=0;
			while ($result=mysql_fetch_array($dotree))
				{
				$old_id[$i]=$result['id'];
				$old_name[$i]=$result['name'];
				$old_level[$i]=$result['level'];
				$old_path[$i]=str_replace('.','',$result['level']);
				$old_pos[$i]=substr($old_path[$i],-1,1);
				$i++;
				}
			switch ($action)
				{
				case 'changename':
				for ($x=0;$x<$rows;$x++)
					{
					if (isset($_POST['item'.$old_id[$x]]))
						{
						if  ($_POST['item'.$old_id[$x]]!=$old_name[$x])
							{
							$query='update '.$tblname.'_cat set name="'.$_POST['item'.$old_id[$x]].'" where id="'.$old_id[$x].'"';
							//$msg.=$query;
							$doquery=mysql_query($query,$link);
							$msg.='- '.$strUpdate.' : '.$old_name[$x].' -> '.$_POST['item'.$old_id[$x]].' - ';
							if ($doquery)
								{
								$msg.='<font color="red">'.$strSuccess.'</font>';
								}
							else
								{
								$msg.='<font color="red">'.$strErro.'</font>';
								}
							$msg.='<br>';
							}
						}
					}	
				break;
				
				case 'addsub':
				//Kiem tra
				if (isset($_POST['level'],$_POST['subname']))
					{
					$check ='select * from '.$tblname.'_cat';
					$check.=' where level like "';
					if ($_POST['level']!='0')
						$check.=$_POST['level'].'.';
					$check.='__"';
					$check.=' and lang="'.get_langID().'"';
					$check.=' order by level ASC';
					//$msg.=$check;
					$docheck=mysql_query($check,$link);
					if ($docheck)
						{
						$maxpos=0;
						while ($result=mysql_fetch_array($docheck))
							{
							$path=str_replace('.','',$result['level']);
							$pos=substr($path,-2,2);
							if ($maxpos<$pos)
								$maxpos=$pos;
							}
						//$msg.='Max position is : '.$maxpos;
						$newpos=$maxpos+1;
						if ($newpos<10)
							$newpos='0'.$newpos;
						if ($_POST['level']!='0')
							$newlevel=$_POST['level'].'.'.$newpos;
						else
							$newlevel=$newpos;
						$query ='insert into '.$tblname.'_cat(name,level,lang)';
						$query.=' values("'.$_POST['subname'].'","'.$newlevel.'","'.get_langID().'")';
						//$msg.=$query;
						$doquery=mysql_query($query,$link);
						$msg.='- '.$strAdd.' '.$strSubCategory.' : '.$_POST['subname'];
						if ($doquery)
							{
							$msg.='<font color="red">'.$strSuccess.'</font>';
							}
						else
							{
							$msg.='<font color="red">'.$strErro.'</font>';
							}
						}
					else
						{
						$msg.=$strErr['108'];
						}
					}
				else
					{
					$msg.=$strErr['401'];
					}
				break;
				
				case 'delete':
				//Kiem tra
				if (isset($_POST['level']))
					{
					$check ='select * from '.$tblname.'_cat';
					$check.=' where level like "'.$_POST['level'].'%"';
					$check.=' and lang="'.get_langID().'"';
					$check.=' order by level ASC';
					//$msg.=$check;
					$docheck=mysql_query($check,$link);
					if ($docheck)
						{
						$ids='';
						$count=0;
						$n=0;
						while ($result=mysql_fetch_array($docheck))
							{
							$count++;
							if ($count>1)
								$ids.=',';
							$ids.='"'.$result['id'].'"';
							$ids_array[$n]=$result['id'];
							$names[$n]=$result['name'];
							if ($result['level']==$_POST['level'])
								{
								$cur_name=$result['name'];
								$cur_id=$result['id'];
								}
							$n++;
							}
						$check2 ='select * from '.$tblname;
						$check2.=' where category in('.$ids.')';
						$check.=' and lang="'.get_langID().'"';
						$check2.=' order by category ASC';
						//$msg.=$check2;
						$docheck2=mysql_query($check2,$link);
						if ($docheck2 and mysql_num_rows($docheck2)>0)
							{
							$msg.=$strErr['402'];
							
							}
						else
							{
							if (isset($cur_name,$cur_id))
								{
								$msg.=$strDelete.' : '.$cur_name.' -> ';
								$delete ='delete from '.$tblname.'_cat';
								$delete.=' where level like "'.$_POST['level'].'%"';
								$delete.=' and lang="'.get_langID().'"';
								$dodelete=mysql_query($delete,$link);
								if ($dodelete)
									{
									$msg.=$strSuccess;
									$msg.='<br><br>'.$strUpdate.' ->';
									//Update level cho cac item con lai
									$oldlevel=substr_count($_POST['level'],'.')+1;
									$oldgroup=substr($_POST['level'],0,(strlen($_POST['level'])-2));
									$oldpos=substr($_POST['level'],-2,2);
									$oldpathlen=strlen($_POST['level']);
									$reread ='select * from '.$tblname.'_cat';
									$reread.=' where level like "'.$oldgroup.'%"';
									$reread.=' and lang="'.get_langID().'"';
									$reread.=' order by level ASC';
									$doread=mysql_query($reread,$link);
									if ($doread and mysql_num_rows($doread)>0)
										{
										$rows=mysql_num_rows($doread);
										$counter=0;
										while ($result=mysql_fetch_array($doread))
											{
											$fullevel=$result['level'];
											if (!isset($temp) or strstr($fullevel,$temp)==false)
												$counter++;
											$curpathlen=strlen($fullevel);
											$msg.='<br>- Old path: '.$fullevel=$result['level'];
											$old=substr($fullevel,0,$oldpathlen);
											$curpos=substr($old,-1,1);
											$newpos=$counter;
											if ($newpos<10)
												$newpos='0'.$newpos;
											$new=$oldgroup.$newpos;
											$temp=$old;
											$newpath=str_replace($old,$new,$fullevel);
											$msg.=' - New path: '.$newpath;
											$update='update '.$tblname.'_cat set level="'.$newpath.'" where id="'.$result['id'].'"';
											$msg.=' -> ';
											$doupdate=mysql_query($update,$link);
											if ($doupdate)
												{
												$msg.=$strSuccess;
												}
											else
												{
												$msg.='<font color="red">'.$strErro.' '.$result['id'].' - '.$newpath.'</font>';
												}
											}
										}
									}
								else
									{
									$msg.='<font color="red">'.$strErro['403'].'</font>';
									}
								}
							else
								{
								$msg.=$strErr['404'];
								}
							}
						}
					else
						{
						$msg.=$strErr['404'];
						}
					}
				else
					{
					$msg.=$strErr['404'];
					}
				break;
				
				case 'addrecord':
				if (isset($_POST['level']))
					{
					$check ='select * from '.$tblname.'_cat';
					$check.=' where level like "'.$_POST['level'].'%"';
					$check.=' and lang="'.get_langID().'"';
					$check.=' order by level ASC';
					//$msg.=$check;
					$docheck=mysql_query($check,$link);
					if ($docheck)
						{
						while ($result=mysql_fetch_array($docheck))
							{
							
							$ids.='"'.$result['id'].'"';
							$ids_array[$n]=$result['id'];
							$names[$n]=$result['name'];
							if ($result['level']==$_POST['level'])
								{
								$cur_name=$result['name'];
								$cur_id=$result['id'];
								}
							}
						}
						?>
                                <script language="javascript" type="text/javascript">
									setTimeout('window.location="admin.php?module=addnew&tblname=<?php echo$tblname; ?>&catID=<?php echo $cur_id; ?>&catname=<?php echo $cur_name; ?>"',0);
								</script>
                                <?php
					}
					break;
				
				case 'changepos':
				//Kiem tra
				if (isset($_POST['level']))
					{
					$newpos=$_POST[str_replace('.','',$_POST['level'])];
					$oldlevel=substr_count($_POST['level'],'.')+1;
					$oldpathlen=strlen($_POST['level']);
					$group=substr($_POST['level'],0,(strlen($_POST['level'])-2));
					$oldpos=substr($_POST['level'],-2,2);
					$fullpos=$group.$newpos;
					$msg.=$strMove.' : '.$_POST['level'].' - '.$fullpos.'<br>';
					$msg.='- Group: '.$group.'<br>';
					$msg.='- New position: '.$newpos.'<br>';
					//Danh sach
					$get ='select * from '.$tblname.'_cat';
					$get.=' where level like "'.$group.'%"';
					$get.=' and lang="'.get_langID().'"';
					$get.=' order by level ASC';
					//$msg.='- Old data: '.$get;
					$doget=mysql_query($get,$link);
					if ($doget and mysql_num_rows($doget)>0)
						{
						$m=0;
						$counter=1;
						$pos=array();
						while ($result=mysql_fetch_array($doget))
							{
							if ($counter<10)
								$prefix='0';
							else
								$prefix='';
							$ids[$m]=$result['id'];
							$names[$m]=$result['name'];
							$levels[$m]=$result['level'];
							if (!strstr($result['level'],($group.$prefix.$counter)))
								$counter++;
							if (isset($pos[($counter-1)]))
								$pos[($counter-1)].='+'.$result['id'].'/'.$result['level'];
							else
								$pos[($counter-1)]=$result['id'].'/'.$result['level'];
							$m++;
							}
						$new_order[($newpos-1)]=$pos[($oldpos-1)];
						$countold=$countnew=0;
						for ($i=1;$i<=$counter;$i++)
							{
							if ($i==$newpos)
								$countnew+=1;
							if ($i==$oldpos)
								$countold+=1;
							if (isset($pos[$countold]))
								$new_order[$countnew]=$pos[$countold];
							$countold++;
							$countnew++;
							}
						for ($i=0;$i<$counter;$i++)
							{
							$paths=explode('+',$new_order[$i]);
							$j=0;
							while (isset($paths[$j]))
								{
								if (($i+1)<10)
									$prefix='0';
								else
									$prefix='';
								$item_array=explode('/',$paths[$j]);
								$itempos=substr($item_array[1],($oldpathlen));
								$itemgroup=substr($item_array[1],0,strlen($item_array[1]-1));
								$newitempos=$group.$prefix.($i+1);
								if ($itempos!='')
									$newitempos.=$itempos;
								$query ='update '.$tblname.'_cat set level="'.$newitempos.'"';
								$query.=' where id="'.$item_array[0].'"';
								//$query.=' and lang="'.get_langID().'"';
								$msg.='<br>- Set '.$item_array[1].' -> '.$newitempos.' : ';
								$msg.='<br>- Key: '.$i.', Value: '.$new_order[$i];
								$msg.='<br>Query: '.$query;
								///*
								$doquery=mysql_query($query,$link);
								if ($doquery)
									{

									$msg.=$strSuccess;
									}
								else
									{
									$msg.='<font color="red">'.$strErro.'</font>';
									}
								//*/
								$j++;
								}
							}
						}
					else
						{
						$msg.=$strErr['405'];
						}
					}
				else
					{
					$msg.=$strErr['406'];
					}
				break;
				
				case 'changelevel':
				//Kiem tra
				if (isset($_POST['level']))
					{
					//echo $_POST['level'];
					$newlevel=$_POST['clevel'.str_replace('.','',$_POST['level'])];
					$oldlevel=substr_count($_POST['level'],'.')+1;
					$oldpathlen=strlen($_POST['level']);
					$oldgroup=substr($_POST['level'],0,(strlen($_POST['level'])-2));
					$group=substr($_POST['level'],0,(3*($newlevel-1)));
					$msg.='- New Group: '.$group;
					$fullpos=$group.$newlevel;
					$get ='select * from '.$tblname.'_cat';
					$get.=' where level like "'.$group;
					/*
					if ($newlevel>1)
						$get.='.';
					*/
					$get.='__';
					$get.='"';
					$get.=' and lang="'.get_langID().'"';
					$get.=' order by level ASC';
					$msg.='<br>Query: '.$get;
					$doget=mysql_query($get,$link);
					if ($doget and mysql_num_rows($doget)>0)
						{
						$newpos=1;
						while ($result1=mysql_fetch_array($doget))
							{
							$curpos=substr($result1['level'],-1,1);
							if ($curpos>=$newpos)
								$newpos=$curpos+1;
							}
						if ($newpos<10)
							$newpos='0'.$newpos;
						$msg.='<br>- New position : '.$newpos;
						$other ='select * from '.$tblname.'_cat';
						$other.=' where level like "'.$_POST['level'].'%"';
						$other.=' and lang="'.get_langID().'"';
						$other.=' order by level ASC';
						$doother=mysql_query($other,$link);
						if ($doother and mysql_num_rows($doother)>0)
							{
							while ($result2=mysql_fetch_array($doother))
								{
								$setpos=str_replace($_POST['level'],($group.$newpos),$result2['level']);
								$msg.='<br>- Moving : '.$result2['level'].' -> '.$setpos.' -> ';
								$update='update '.$tblname.'_cat set level="'.$setpos.'" where id="'.$result2['id'].'"';
								$msg.='<br>- Query : '.$update;
								///*
								if (mysql_query($update,$link))
									{
									$msg.=$strSuccess;
									}
								else
									{
									$msg.='<font color="red">'.$strErro.'</font>';
									}
								//*/
								}
							//Rewrite old items
							$msg.='<br>- Old group: '.$oldgroup;
							$reread ='select * from '.$tblname.'_cat';
							$reread.=' where level like "'.$oldgroup.'%"';
							$reread.=' and lang="'.get_langID().'"';
							$reread.=' order by level ASC';
							$doread=mysql_query($reread,$link);
							if ($doread and mysql_num_rows($doread)>0)
								{
								$rows=mysql_num_rows($doread);
								$counter=0;
								while ($result3=mysql_fetch_array($doread))
									{
									$fullevel=$result3['level'];
									if (!isset($temp) or strstr($fullevel,$temp)==false)
										$counter++;
									$curpathlen=strlen($fullevel);
									$msg.='<br>- Old path: '.$fullevel=$result3['level'];
									$old=substr($fullevel,0,$oldpathlen);
									$curpos=substr($old,-1,1);
									$newpos=$counter;
									if ($newpos<10)
										$newpos='0'.$newpos;
									$new=$oldgroup.$newpos;
									$temp=$old;
									$newpath=str_replace($old,$new,$fullevel);
									$msg.=' - New path: '.$newpath;
									$update='update '.$tblname.'_cat set level="'.$newpath.'" where id="'.$result3['id'].'"';
									$msg.=' -> ';
									///*
									$doupdate=mysql_query($update,$link);
									if ($doupdate)
										{
										$msg.=$strSuccess;
										}
									else
										{
										$msg.='<font color="red">'.$strErro.'</font>';
										}
									//*/
									}
								}
							}
						}
					else
						{
						$msg.=$strErr['405'];
						}
					}
				else
					{
					$msg.=$strErr['406'];
					}
				break;
				case 'hotnews':
					if (isset($_POST['level'],$_POST['hotnews']))					
					{
						$hotnews=$_POST['hotnews'];
						$level=$_POST['level'];
						$sql_stt = "UPDATE ".$tblname."_cat SET new='$hotnews' Where level='$level'";
						//echo $sql_stt;
						mysql_query($sql_stt,$link);
					}
				break;
				
				case 'changegroup':
				//Kiem tra
				if (isset($_POST['level']))
					{
					$newgroup=$_POST['cgroup'.str_replace('.','',$_POST['level'])];
					$oldlevel=strlen(str_replace('.','',$_POST['level']));
					$oldpathlen=strlen($_POST['level']);
					$oldgroup=substr($_POST['level'],0,(strlen($_POST['level'])-2));
					$group=substr($_POST['level'],0,(3*($newgroup-1)));
					$msg.='- New Group: '.$newgroup;
					$fullpos=$group.$newgroup;
					$get ='select * from '.$tblname.'_cat';
					$get.=' where level like "'.$newgroup.'.';
					$get.='%';
					$get.='"';

					$get.=' and lang="'.get_langID().'"';
					$get.=' order by level ASC';
					$msg.='<br>- Query : '.$get;
					$doget=mysql_query($get,$link);
					if ($doget)
						{
						$newpos=1;
						while ($result1=mysql_fetch_array($doget))
							{
							$curpos=substr($result1['level'],-2,2);
							if ($curpos>=$newpos)
								$newpos=$curpos+1;
							}
						if ($newpos<10)
							$newpos='0'.$newpos;
						$msg.='<br>- New position : '.$newpos;
						$other ='select * from '.$tblname.'_cat';
						$other.=' where level like "'.$_POST['level'].'%"';
						$other.=' and lang="'.get_langID().'"';
						$other.=' order by level ASC';
						$doother=mysql_query($other,$link);
						if ($doother and mysql_num_rows($doother)>0)
							{
							while ($result2=mysql_fetch_array($doother))
								{
								$setpos=substr_replace($result2['level'],($newgroup.'.'.$newpos),0,strlen($_POST['level']));
								$msg.='<br>- Moving : '.$result2['level'].' -> '.$setpos.' -> ';
								$update='update '.$tblname.'_cat set level="'.$setpos.'" where id="'.$result2['id'].'"';
								$msg.='<br>- Query : '.$update;
								///*
								if (mysql_query($update,$link))
									{
									$msg.=$strSuccess;
									}
								else
									{
									$msg.='<font color="red">'.$strErro.'</font>';
									}
								//*/
								}
							//Rewrite old items
							$msg.='<br>- Old group: '.$oldgroup;
							$reread ='select * from '.$tblname.'_cat';
							$reread.=' where level like "'.$oldgroup.'%"';
							$reread.=' and lang="'.get_langID().'"';
							$reread.=' order by level ASC';
							$doread=mysql_query($reread,$link);
							if ($doread and mysql_num_rows($doread)>0)
								{
								$rows=mysql_num_rows($doread);
								$counter=0;
								while ($result3=mysql_fetch_array($doread))
									{
									$fullevel=$result3['level'];
									if (!isset($temp) or strstr($fullevel,$temp)==false)
										$counter++;
									$curpathlen=strlen($fullevel);
									$msg.='<br>- Old path: '.$fullevel=$result3['level'];
									$old=substr($fullevel,0,$oldpathlen);
									$curpos=substr($old,-1,1);
									$newpos=$counter;
									if ($newpos<10)
										$newpos='0'.$newpos;
									$new=$oldgroup.$newpos;
									$temp=$old;
									$newpath=str_replace($old,$new,$fullevel);
									$msg.=' - New path: '.$newpath;
									$update='update '.$tblname.'_cat set level="'.$newpath.'" where id="'.$result3['id'].'"';
									$msg.=' -> ';
									//*
									$doupdate=mysql_query($update,$link);
									if ($doupdate)
										{
										$msg.=$strSuccess;
										}
									else
										{
										$msg.='<font color="red">'.$strErro.'</font>';
										}
									//*/
									}
								}
							}
						}
					else
						{
						$msg.='<br>'.$strErr['407'];
						}
					}
				else
					{
					$msg.='<br>'.$strErr['408'];
					}
				break;
				
				}
			}
		else
			{
			$msg.=$strErr['108'];
			}
		if (isset($msg))
			{
			?>
			<tr>
			<td style="width:auto; height: 30px;" colspan="3" align="center" valign="middle">
				<table style="width: 100%px;" cellspacing="0" cellpadding="0">
				<tr>
				<td style="background-color: #336699;">
				<p class="stitle"> &raquo; <?php echo $strProgress; ?></p>
				</td>
				</tr>
						
				
				<tr>
				<td>
				<table cellpadding="0" cellspacing="0" style="width: 100%; height:auto;">
					<tr>
					<td style="width: 20px; background-color: #E1E1E1">&nbsp;</td>
					<td onClick="window.history.go(-1);" style="cursor: pointer; border: 1px solid #E1E1E1; width:90px; height:auto;" onMouseOver="changebd(this,'#336699');" onMouseOut="undobd(this);">
					<p class="buttontext"><img align="absmiddle" src="images/previous.gif" style="width: 24px; height: 24px;" />
					&nbsp;&nbsp;<?php echo $strBack; ?></p></td>
					<td style="background-color: #E1E1E1;">&nbsp;</td>
					</tr>
				</table>
			  	</td>
			  	</tr>
				
				<tr>
				<td style="border-left: solid 1px #336699; border-right: solid 1px #336699; border-bottom: solid 1px #336699;">
				<p class="grouptitle" style="margin-top: 12px; margin-bottom: 12px;">
				<?php
				echo $msg;
				//echo $redirect;
				?>
				</p>
				</td>
				</tr>
			  </table>
			</td>
			</tr>
			<?php
			}
		}
	else
		{
		?>	
	  	<tr align="center" valign="top">
        <td colspan="3" align="center" valign="top">
		<table style="width: 100%;" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top">
			<form name="viewtbl" method="post" action="viewtbl.php">
			<input type="hidden" name="tblname" value="<?php echo $tblname; ?>" />
			<input type="hidden" name="catname" value="" />
			<input type="hidden" name="catID" value="" />
			</form>
			<script language="javascript" type="text/javascript">
			function browsecat(cname,cid)
				{
				document.viewtbl.catname.value=cname;
				document.viewtbl.catID.value=cid;
				document.viewtbl.submit();
				}
			</script>
			<form name="tree" method="post" action="" onSubmit="return accept();" style="display: block;">
			<input type="hidden" name="action" value="changename" />
			<input type="hidden" name="level" />
			<input type="hidden" name="hotnews" />
			<table style="width: 100%;" cellspacing="0" cellpadding="0">
			  <tr>
				<td align="center" valign="top" style="border-left: solid 0px #336699; border-right: solid 0px #336699;">
				<table id="mainTable" cellpadding="0" cellspacing="0" style="width: 100%;">
				<?php
				if ($_SESSION['usergroup']<2)
					{
					?>
					<tr><td>
					<span class="treetext" style="cursor: pointer;" onClick="addsubitem('0');"><img src="images/paste_plain.gif" alt="" />&nbsp;<?php echo $strAdd.' '.$strCategory; ?></span>&nbsp;&nbsp;
					<?php
					}
				?>
				<span class="treetext" style="cursor: pointer;" onClick="window.location='?module=addnew&tblname=<?php echo $tblname; ?>'"><img src="images/page_white_text.gif" alt="" />&nbsp;<?php echo $strAdd.' '.$strRecord; ?></span>
				</td></tr>
				
				<tr><td style="border-top: solid 1px #CCCCCC; height: 10px;">&nbsp;</td></tr>
				<?php
				$tree ='select * from '.$tblname.'_cat';
				$tree.=' where lang="'.get_langID().'"';
				switch ($_SESSION['usergroup'])
					{
					case '1':
					case '2':
					$tree.=' and level like "%"';
					break;
					
					case 3:
					case 4:
					$tree.=' and level like "02.%"';
					break;
					
					default:
					$tree.=' and level like "04.%"';
					break;
					}
				$tree.=' order by level ASC';
				$dotree=mysql_query($tree,$link);
				if ($dotree and mysql_num_rows($dotree)>0)
					{
					$i=0;
					while ($result=mysql_fetch_array($dotree))
						{
						$id_array[$i]=$result['id'];
						$name_array[$i]=$result['name'];
						$level_array[$i]=$result['level'];
						$hotnews_array[$i]=$result['new'];
						$path[$i]=str_replace('.','',$result['level']);
						$pos[$i]=substr($path[$i],-2,2);
						//echo $pos[$i].'<br>';
						$level[$i]=substr_count($level_array[$i],'.')+1;
						if ($level[$i]==1)
							{
							$type_array[$i]='parent';
							$group[$i]='root';
							}
						else
							{
							$type_array[$i]='child';
							$group[$i]=substr($path[$i],0,2*($level[$i]-1));
							}
						$i++;
						}
					$i=0;
					$rows=mysql_num_rows($dotree);
					$row_count=0;
					while (isset($id_array[$i]))
						{	
						$indent='';
						$isparent=false;
						for ($x=1;$x<=$level[$i];$x++)
							{
							$indent.= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							}
						if ($type_array[$i]=='parent')
							{
							$isparent=true;
							$image="folder.gif";
							}
						else
							{
							$image='text.gif';
							}
						?>
						<TR id="<?php echo $id_array[$i]; ?>">
						
						<TD><p class="treetext">
						<?php
						echo $indent;
						?>
						<span id="bobcontent<?php echo $i+1; ?>-title" class="handcursor" style="cursor:pointer;"><img src="images/<?php echo $image; ?>" style="cursor:pointer;" hspace="3" alt="<?=$strQickEdit?>" title="<?=$strQickEdit?>" /></span>
						<input class="invisible editable" type="text" value="<?php echo $name_array[$i]; ?>" id="<?php echo $id_array[$i]; ?>"  name="item<?php echo $id_array[$i]; ?>" onFocus="javascript: this.style.border='solid 1px #336699';" style='display:none' />
						<span class="editable" id="i<?php echo $id_array[$i]; ?>"><?php echo $name_array[$i]; ?></span>
						<div id="bobcontent<?php echo $i+1; ?>" class="switchgroup1">
						<table align="center" cellpadding="0" style="width: 100%;border: solid 1px #FFCC00;  height:auto; background-color: #F7F7F7;">
						<tr>
						<TD align="center" onclick="window.location='?module=viewtbl&SID=<?php echo session_id(); ?>&tblname=<?php echo $tblname; ?>&catname=<?php echo $name_array[$i]; ?>&catID=<?php echo $id_array[$i]; ?>'" class="button_off" onMouseOver="this.className='button_over';" onMouseOut="this.className='button_off';">&raquo; <?php echo $strView; ?></TD>
						
						<?php
						if ($_SESSION['usergroup']<2)
							{?>
							<TD align="center" onClick="addsubitem('<?php if ($level[$i]<$limit_menu_level) echo $level_array[$i]; else echo '&nbsp;'; ?>');" class="button_off" onMouseOver="this.className='button_over';" onMouseOut="this.className='button_off';">
							&raquo; <?php echo $strAdd.' '.$strSubCategory; ?></TD>
						
							<TD align="center" onClick="del('<?php echo $level_array[$i]; ?>')" class="button_off" onMouseOver="this.className='button_over';" onMouseOut="this.className='button_off';">
							<?php echo $strDelete; ?></td>
							

							<TD class="title3" style="text-align: center;" align="center" onMouseOver="change(this,'#F4F6F4');" onMouseOut="undo(this);">
							<?php echo $strChangePos; ?> 
							<select name="<?php echo str_replace('.','',$level_array[$i]); ?>" onChange="changepos('<?php echo $level_array[$i]; ?>')">
							<?php
							$a=0;
							while (isset($pos[$a]))
								{
								if ($group[$a]==$group[$i])
									{
									echo '<option value="'.$pos[$a].'"';
									if ($pos[$a]==$pos[$i])
										echo ' selected="selected"';
									echo '> '.$pos[$a].' </option>';
									}
								$a++;
								}
							?>
							</select>
							</TD>

							<?php
							if ($level[$i]>1)
							{
							?>
							<TD valign="middle" class="title3" style="text-align: center" align="center" onMouseOver="change(this,'#F4F6F4');" onMouseOut="undo(this);">
							<?php echo $strChangeLevel; ?>
							<?php
							if ($group[$i]!='root')
								{
								?>
								<select name="clevel<?php echo str_replace('.','',$level_array[$i]); ?>" onChange="changelevel('<?php echo $level_array[$i]; ?>');">
								<?php
								for ($a=1;$a<=$level[$i];$a++)
									{
									echo '<option value="'.$a.'"';
									if ($a==$level[$i])
										echo 'selected="selected"';
									echo '> '.$a.' </option>';
									}
								}
							else
								echo '&nbsp;';
							}
							if ($_SESSION['usergroup']<2)
								{
								?>
								<TD colspan="5" class="title3" align="left" onMouseOver="change(this,'#F4F6F4');" onMouseOut="undo(this);">
								<?php echo $strChangeCat; ?> <select name="cgroup<?php echo str_replace('.','',$level_array[$i]); ?>" onChange="changegroup('<?php echo $level_array[$i]; ?>')">
								<?php
								$a=0;
								while (isset($id_array[$a]))
									{
									if ($level[$a]<$limit_menu_level and $level[$a]<=$level[$i])
										{
										echo '<option value="'.$level_array[$a].'"';
										if ($path[$a]==$path[$i])
											echo ' selected="selected"';
										echo '> '.$name_array[$a].' </option>';
										}
									$a++;
									}
								?>
								</select>
								</TD></tr>
								<?php
								}
							}
						?>
						</table>
						<?php
						$i++;
						}
					}
				?>
				</div>
				</table>
				</td>
			  </tr>
<script type="text/javascript" language="javascript">
var bobexample=new switchcontent("switchgroup1", "div") //Limit scanning of switch contents to just "div" elements
bobexample.setStatus('', '')
bobexample.setColor('darkred', 'black')
bobexample.setPersist(true)
bobexample.collapsePrevious(true) //Only one content open at any given time
bobexample.init()
</script>
			  <tr><td style="border-top: 1px solid rgb(204, 204, 204);">
				<p class="bigtitle" style="margin-top: 20px; margin-bottom: 6px; clear:both">
				<a href="javascript:void(0);" class="submit_button"><?php echo $strSaveChange; ?></a>
                <a href="javascript:void(0);" class="reset_button"><?php echo $strReset; ?></a>
                </p></td></tr>
			</table>
			</form>
			
			<form name="addsub" method="post" action="" style="display: none;" onsubmit="return add_cate();">
			<input type="hidden" name="level" />
			<input type="hidden" name="action" value="addsub" />
			<input type="hidden" name="tblname" value="<?php echo $_REQUEST['tblname']; ?>" />
			<table style="width: 98%;" cellspacing="0" cellpadding="0">
              <tr>
                <td style="background-color: #336699;">
                  <p class="stitle"> &raquo; <?php echo $strAdd.' '.$strSubCategory; ?></p>
                </td>
              </tr>
              	
              <tr>
                <td style="border-left: solid 1px #336699; border-right: solid 1px #336699;">
                  <p class="bigtitle" style="margin-top: 12px; margin-bottom: 12px;">
                  <?php echo $strName; ?> : <input type="text" name="subname" class="longinput" />
				  </p>
                </td>
			  
			  <tr>
                <td style="border-left: solid 1px #336699; border-right: solid 1px #336699; border-bottom: solid 1px #336699;">
                  <p class="bigtitle" style="margin-top: 12px; margin-bottom: 12px;">
                    <input type="submit" style="cursor:pointer;" name="Submit" value=" <?php echo $strAdd; ?> " />
					&nbsp;&nbsp;&nbsp;
					<input type="button" style="cursor:pointer;" name="Cancel" value=" <?php echo $strBack; ?> " onClick="addsubitem();" />
                  </p>
                </td>
              </tr>
            </table>
			</form>
			</td>
          </tr>
        </table></td>
      </tr>
      <?php
	  }
	}
?>
</table>
<script language="javascript" type="text/javascript">
	function add_cate()
	{
		if(document.addsub.subname.value=='')
		{
			alert('Please enter subname!');
			document.addsub.subname.focus();
			return false;
		}
		return true;
	}
</script>