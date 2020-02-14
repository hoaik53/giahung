<?php
$languages_code='english-iso-8859-1';
$languages_name='English ISO 8859-1';
$charset = 'utf-8';
//$charset = 'iso-8859-1';
$allow_recoding = TRUE;
$text_dir = 'ltr'; // ('ltr' for left to right, 'rtl' for right to left)
$left_font_family = 'verdana, arial, helvetica, geneva, sans-serif';
$right_font_family = 'arial, helvetica, geneva, sans-serif';
$number_thousands_separator = ',';
$number_decimal_separator = '.';
// shortcuts for Byte, Kilo, Mega, Giga, Tera, Peta, Exa
$byteUnits = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');

//----------------------------------- Date / Time --------------------------------------------
$strDay='Day';
$strMonth='Month';
$strYear='Year';
$date_rule='mm/dd/yyyy';
$day_of_week = array('Sun', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa');
$month_of_year = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
//--------------------------------------------------------------------------------------------

//---------------------------------- Descriptions --------------------------------------------
$strLoginNote ='<p class="formindex">';
$strLoginNote.='<strong>Why have to log-in ?</strong><br><br>';
$strLoginNote.='<ul type="square">';
$strLoginNote.='<li> You must log-in to access control panel.</li>';
$strLoginNote.='<li> Every user has a seperately permission.</li>';
$strLoginNote.='</ul>';
$strLoginNote.='</p>';
$strNoteImg='<br>- Max image size : 100Kbs<br>- File name not contain special character<br>- File must have extension : .GIF,.JPG,hoặc .BMP';
//--------------------------------------------------------------------------------------------

//----------------------------- Access / Session / Authorize ---------------------------------
$strAccessDenied = 'Access denied';
$strLogin='Log In';
$strLogAs='Logged as ';
$strLogoutOk='Log out successful !';
$strLogoutFail='Can not log you out !';
$strLoginOk ='Log In successful !<br><br>Setting up your permission.<br><br>';
$strLoginOk.='Redirect to Control Panel in 3 seconds<br><br><a href="?module=cpanel" style="text-decoration: none">Click here</a> for instant access.';
$strLoginTitle='System authorization';
$strUserName='Username';
$strUserNameRule='Must be character or number, accept '."'".'_'."'".' in about 4 - 21 characters';
$strNoUserName='Please input your Username';
$strPassWord='Password';
$strPassWordRule='Must be character or number in about 4 - 21 characters';
$strRememberMeNote='Use on security system ';
$strNoPassWord='Please input your Password';
$strRememberMe='Remember me';
$strLoading='Loading. Please wait ...';
$strUpdateOk='Password changed successfully,<br>- Setting up your permission,<br>- Auto log out.<br>- Please re-Log in !';
//---------------------------------------------------------------------------------------------

//--------------------------------------- Title -----------------------------------------------
$strvSpider ='You are using vSpider - Site Manager System, version 3.1. Designed and Developed by';
$strvSpider.=' Global IT Developement Co.,Ltd -';
$strControlPanelTitle='Main Control Panel';
$strUserGroupTitle='Usergroup Management';
$strCategoriesTitle='Categories Management';
$strViewtableTitle='Records List';
$strViewrecTitle='Record Information';
$strUpdaterecTitle='Update Record Information';
$strAddnewTitle='Add new Record';
$strCreatUserTitle='Creat new User';
$strExplorerTitle='Server Resource Browser';
$strViewUserTitle='User Profile';
$strvSpiderTitle='vSpider - Site Manager System, version 3.1';

$strConfirmDel = "Delete selected user ?";
//--------------------------------------------------------------------------------------------

//--------------------------------------- Captions -------------------------------------------
$strAll='Match';
$strHavein='Have';
$strBrowseDir='Directory browser';
$strRootFolder='Root directory';
$strAbsPath='Absolute path';
$strUrl='Link';
//$strImage='Ảnh';
$strMember='Member';
$strRegTime='Registration time';
$strLastLog='Last Lon-in';
$strRank='Rank';
$strLevel='Level';
$strActive='Active';
$strAdd='Add';
$strCategory='Category';
$strplace='Place';
$strSubCategory='Sub-category';
$strRecord='Record';
$strOf='of';
$strName='Name';
$strType='Type';
$strSize='Size';
$strDimension='Dimension';
$strInput='Input';
$strSelect='Select';
$strChangePos='Change position';
$strChangeLevel='Change Level';
$strChangeCat='Change Category';
$strConfirm='Confirm';
$strAnother='Another';
$strNotLike='Not like';
$strAgain='Again';
$strWebHome='Web home';
$strInformation='Information';
$strContact='Contact';
$strManagement='Management';
$strSystem='System';
$strAction = 'Action';
$strLanguage='Language';
$strTheme='Theme';
$strLevelView='View only';
$strMenu='Menu';
$strPs='Note';
$strViewAll='View all';
$strPreview='Preview';
$strExistImage='Image on server';
$strUrlImage='Image on Internet';
$strUrlImageRule='Type full path, include http://';
$strUploadImage='File on hard disk';
$strUpdate='Update';
$strSuccess='Success';
$strErro='Error';
$strProgress='Progress';
$strLangsys='Language System';
$strLanglayout='Layout';
$strLangvspider='vSpider';
$streditlanglayout='Edit Language Layout';
$streditlangvspider='Edit Language vSpider';
$strLanga='Languages';
$strvSpiderstatusAr='List articles Inactive';

$strOK = "OK";
$strCancel = "Cancel";
$strConfigPopup = "Popup config";
//--------------------------------------------------------------------------------------------

//----------------------------------- Button caption -----------------------------------------
$strView='View';
$strEdit='Edit';
$strDelete='Delete';
$strDeleteUser='Delete user';
$strAddUser='Add user';
$strReset='Reset';
$strEnable='Enable';
$strDisable='Disable';
$strFilter='Filter';
$strLogOut='Log-out';
$strCreatNew='Creat new';
$strMove='Move';
$strBack='Back';
$strPersonal='Personal';
$strAbout='vSpider';
$strControlPanel='Control Panel';
$strSendMail='Send E-mail';
$strSendMsg='Send message';
$strBan='Ban';
$strSaveConfig='Save congifs';
$strSaveChange='Save changes';
$strSaveInformation='Save informations';
//--------------------------------------------------------------------------------------------
	
//----------------------------------------- Icon name ----------------------------------------
$strArticle='Products';
$strSunfarm='Sunfarm';
$strEropa='Eropa';
$strNuitan='Nui Tan';
$strNews='Articles';
$strProduct='Products';
$strCity='Tỉnh/Thành Phố';
$strDistrict='Quận/Huyện';
$strSupport='Support Online';
$strKqncln='Research results';
$strWeblink='Weblinks';
$strPending='Pending';
$strTrash='Trash';
$strOrder='Orders';
$strRates='Rates';
$strMembers='Members';
$strMessage='Message';
$strImage='Image';
$strDatabase='Database';
$strLog='System Log';
$strFile='File';
$strActive='Active';
$strInActive = "Inactive";
$strShowAfter = "Show after";
$strTimeShow = "Time show";
$strOpenNewTab = "Open in new tab";
$strMailingList='Mailing list';
$strConfig='Config';
$strSummary='Summary';
$strPermission='Permission';
$strBan='Ban';
$strGroup='Group';
$strUser='User';
$strPool='Pool';
$quicklink='Quick links';
$cpanel_='Control Panel';
$add_article=' Add Articles';
$add_users=' Add User';
$add_pro=' Add Products';
$add_weblinkss=' Add Weblink';
$add_npoll=' Add Poll';
$add_supports='Add Support Online';
$active_status='Articles wait for Active';
$strDefault = "Default config";
//--------------------------------------------------------------------------------------------

//----------------------------------- Personal informations ----------------------------------
$strRealName='RealName';
$strNull='Not show';
$strRealNameRule='Alow charaters, spacees in about 4 - 40 characters';
$strBirthDay='Birth day';
$strGender='Gender';
$strMale='Male';
$strFemale='Nữ';
$strAddress='Address';
$strAddressRule='About 5 - 100 characters';
$strJob='Job';
$strJobRule='About 5 - 50 characters';
$strJobAddress='Office address';
$strJobAddressRule='About 5 - 100 characters';
$strPhone='Phone';
$strPhoneRule='Allow number, space, - ';
$strEmail='Email';
$strEmailRule='You active E-mail';
$strYahooId='Yahoo ID';
$strYahooIdRule='Your active Yahoo ID';
$strWebsite='Website';
$strWebsiteRule='Your website';
$strDescription='Description';
$strDescriptionRule='In about 255 characters';
$strSign='Sign';
$strSignRule='In about 255 characters';
$strShowSign='Show your sign at the end of article';
$strAvatar='Avatar';
$strSupportedFileType='Supported file extensions';
$strMaxFileSize='Max file size';
$strClickView='Click here to confirm';
//--------------------------------------------------------------------------------------------

//---------------------------------------- Error handling ------------------------------------
$strHaveError='Error ! Please check : ';
$strErr=array (
	// 1.. Lỗi SQL
		'101'=>'Can not connect to Database',
		'102'=>'Can not addnew record',
		'103'=>'Can not update record',
		'104'=>'Can not delete record',
		'105'=>'Can not creat table',
		'106'=>'Data exsisted on server',
		'107'=>'Data does not exsisted',
		'108'=>'Can not proccess command',
	// 2.. Lỗi Hệ thống
		'201'=>'You are not allowed to access this Area !',
		'202'=>'Username is invalid',
		'203'=>'Password is invalid',
		'204'=>'Username or Password is incorrect or Account does not exsist',
		'205'=>'System is under-construction',
		'206'=>'Changes do not cause effect, please re-input',
		'207'=>'New Password is invalid',
	// 3.. Lỗi File
	// 4.. Lỗi nhóm, mục
		'401'=>'Can not request information about sub-category',
		'402'=>'Deleted category is not empty',
		'403'=>'Can not delete category',
		'404'=>'Can not request information about deleted category',
		'405'=>'Can not request information about moved category',
		'406'=>'Can not request information about moved category',
		'407'=>'Can not request information about destination group',
		'408'=>'Can not request information about destination group',
		);
//--------------------------------------------------------------------------------------------

//------------------------------------------ Notices -----------------------------------------
$strHaveNotice='Infomation of system : ';
$strNotice=array (
	// 1.. SQL
		'101'=>'Query proccess successful',
		'102'=>'Addnew record successful',
		'103'=>'Update record successful',
		'104'=>'Delete record successful',
		'105'=>'Creat new table successful',
		'106'=>'Creat new User record successful',
	// 2.. Hệ thống
		'201'=>'You are not allowed to access this Area !',
		'202'=>'Username is invalid',
		'203'=>'Password is invalid',
		'204'=>'Username or Password is incorrect or Account does not exsist',
		'205'=>'System is under-construction',
		'206'=>'Changes do not cause effect, please re-input',
		'207'=>'New Password is invalid',
		'208'=>'You are not allowed to change these informations',
	// 3.. Lỗi File
	// 4.. Thư mục
		'401'=>'Can not access directiory',
		'402'=>'Empty directory or contain not supported file',
		);
//--------------------------------------------------------------------------------------------

//--------------------------------- Commands and descriptions --------------------------------

//--------------------------------------------------------------------------------------------