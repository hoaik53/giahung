<?php
$languages_code='vietnamese-utf-8';
$languages_name='Tiếng Việt UNICODE UTF-8';
$charset = 'UTF-8';
$allow_recoding = TRUE;
$text_dir = 'ltr'; // ('ltr' for left to right, 'rtl' for right to left)
$left_font_family = 'verdana, arial, helvetica, geneva, sans-serif';
$right_font_family = 'arial, helvetica, geneva, sans-serif';
$number_thousands_separator = ',';
$number_decimal_separator = '.';
// shortcuts for Byte, Kilo, Mega, Giga, Tera, Peta, Exa
$byteUnits = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');

//----------------------------------- Date / Time --------------------------------------------
$strDay='Ngày';
$strMonth='Tháng';
$strYear='Năm';
$date_rule='dd/mm/yyyy';
$day_of_week = array('CN', 'thứ 2', 'thứ 3', 'thứ 4', 'thứ 5', 'thứ 6', 'thứ 7');
$month_of_year = array('Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12');
//--------------------------------------------------------------------------------------------

//---------------------------------- Descriptions --------------------------------------------
$strLoginNote ='<p class="formindex">';
$strLoginNote.='<strong>Vì sao cần phải đăng nhập hệ thống ?</strong><br><br>';
$strLoginNote.='<ul type="square">';
$strLoginNote.='<li> Bạn cần phải đăng nhập mới có thể thao tác với website.</li>';
$strLoginNote.='<li> Tùy theo phân quyền của mỗi người dùng,sẽ có những quyền hạn khác nhau.</li>';
$strLoginNote.='<li> Hạn chế truy cập bất hợp pháp từ những người dùng không có phận sự.</li>';
$strLoginNote.='<li> Hãy nhập đúng Tên sử dụng và Mật khẩu của bạn để có được quyền hạn của mình.</li>';
$strLoginNote.='</ul>';
$strLoginNote.='</p>';
$strNoteImg='<br>- Ảnh không được quá 100Kbs<br>- Tên file không được chứa ký tự đặc biệt<br>- File ảnh phải có dạng .GIF,.JPG,hoặc .BMP';
$strChoicelang.='LỰA CHỌN NGÔN NGỮ CHỈNH SỬA';
//--------------------------------------------------------------------------------------------

//----------------------------- Access / Session / Authorize ---------------------------------
$strAccessDenied = 'Truy cập không hợp lệ';
$strLogin='Đăng nhập';
$strLogAs='Xin chào, ';
$strLogoutOk='Kết thúc phiên làm việc !';
$strLogoutFail='Không thể kết thúc phiên làm việc !';
$strLoginOk ='Đăng nhập thành công !<br>Đang thực hiện cấp quyền cho người sử dụng.<br>';
$strLoginOk.='Chuyển tới bảng điều khiển trong vòng 3 giây nữa<br><a href="?module=cpanel" style="text-decoration: none">Bấm vào đây</a> nếu muốn truy cập ngay.';
$strLoginTitle='Đăng nhập Hệ Thống Quản Trị';
$strUserName='Tên truy cập';
$strUserNameRule='Chỉ gồm chữ, số, dấu gạch dưới. Trong khoảng 4 - 21 ký tự';
$strNoUserName='Bạn chưa nhập Tên truy cập';
$strPassWord='Mật khẩu';
$strPassWordRule='Chỉ gồm chữ, số. Trong khoảng 4 - 21 ký tự';
$strRememberMeNote='Chỉ sử dụng trên hệ thống đáng tin cậy';
$strNoPassWord='Bạn chưa nhập Mật khẩu';
$strRememberMe='Lưu thông tin truy cập';
$strLoading='Đang truy cập hệ thống.Xin chờ...';
$strUpdateOk='Thay đổi thành công,<br>- Đang cấp quyền cho người sử dụng,<br>- Tự động thoát khỏi hệ thống.<br>- Mời đăng nhập lại để xác nhận !';
//---------------------------------------------------------------------------------------------

//--------------------------------------- Title -----------------------------------------------
$strvSpider ='Bạn đang sử dụng hệ thống quản trị BCMS Version 3.2';
$strvSpider.='<br> Xây dựng và phát triển bởi BLUESKY JSC ™';
$strvSpider.='<br>Xin liên hệ email info@bluesky.vn để biết thêm chi tiết !';
$strControlPanelTitle='Bảng điều khiển hệ thống';
$strUserGroupTitle='Quản lý nhóm người dùng';
$strCategoriesTitle='Quản lý danh mục SP';
$strViewtableTitle='Danh sách bản ghi';
$strViewrecTitle='Thông tin bản ghi';
$strUpdaterecTitle='Cập nhật thông tin bản ghi';
$strAddnewTitle='Thêm bản ghi mới';
$strCreatUserTitle='Tạo tài khoản người dùng';
$strExplorerTitle='Duyệt nội dung Server';
$strViewUserTitle='Xem thông tin tài khoản';
$strvSpiderTitle='Hệ thống quản trị website';
$strConfirmDel = "Bạn muốn xóa người dùng đã chọn ?";
//--------------------------------------------------------------------------------------------

//--------------------------------------- Captions -------------------------------------------
$strAll='Toàn bộ';
$strHavein='Có chứa';
$strBrowseDir='Duyệt thư mục';
$strRootFolder='Thư mục gốc';
$strAbsPath='Đường dẫn chính xác';
$strUrl='Liên kết';
$strSlide='Slide show';
$photo='photo';
$strMember='Thành viên';
$strRegTime='Thời gian đăng ký';
$strLastLog='Đăng nhập lần cuối';
$strArticle='Bài viết';
$strRank='Xếp hạng';
$strProductComment='Bình chọn';
$strLevel='Cấp độ';
$strSelectLevel='Chọn cấp độ';
$strActive='Kích hoạt';
$strInActive = "Không kích hoạt";
$strShowAfter = "Hiển thị sau";
$strTimeShow = "Thời gian hiển thị";
$strOpenNewTab = "Mở tab mới";
$strAdd='Thêm';
$strSearch='Tìm';
$strPage='Trang';
$strCategory='Mục';
$strSubCategory='Mục con';
$strRecord='Bản ghi';
$strOf='của';
$strName='Tên';
$strType='Loại';
$strSize='Dung lượng';
$strDimension='Kích thước';
$strInput='Nhập';
$strSelect='Chọn';
$strChangePos='Thay đổi vị trí';
$strChangeLevel='Thay đổi cấp';
$strChangeCat='Chuyển nhóm';
$strConfirm='Xác nhận';
$strAnother='Khác';
$strNotLike='Không giống';
$strAgain='Một lần nữa';
$strWebHome='Trang chủ';
$strInformation='Thông tin';
$strContact='Liên lạc';
$strManagement='Quản lý';
$strSystem='Hệ thống';
$strAction = 'Action';
$strLanguage='Ngôn ngữ';
$strFontend='Giao diện';
$strBackend='Quản trị';
$strTheme='Giao diện';
$strLevelView='Chỉ được phép xem';
$strMenu='Danh sách';
$strPs='Chú ý';
$strViewAll='Xem toàn bộ';
$strPreview='Xem trước';
$strExistImage='Hình có trên server';
$strUrlImage='Hình có trên website khác';
$strUrlImageRule='Nhập đường dẫn đầy đủ, có cả http://';
$strUploadImage='Hình có trên máy tính';
$strUpdate='Cập nhật';
$strSuccess='Thành công';
$strErro='Lỗi';
$strProgress='Tiến trình';
$strOK = "OK";
$strCancel = "Hủy";
$strConfigPopup = "Cấu hình quảng cáo popup";
$strMeta = "Thông tin meta";
//--------------------------------------------------------------------------------------------

//----------------------------------- Button caption -----------------------------------------
$strView='Xem';
$strEdit='Sửa';
$strDelete='Xóa';
$strDeleteUser='Xóa người dùng';
$strAddUser='Thêm người dùng';
$strDown='Tải';
$strReset='Nhập lại';
$strEnable='Bật';
$strDisable='Tắt';
$strFilter='Bộ lọc';
$strLogOut='Kết thúc';
$strCreatNew='Tạo mới';
$strMove='Chuyển';
$strBack='Trở lại';
$strPersonal='Cá nhân';
$strAbout='BCMS';
$strControlPanel='Bảng điều khiển';
$strSendMail='Gửi E-mail';
$strSendMsg='Gửi Tin nhắn';
$strBan='Kỷ luật';
$strSave = 'Lưu';
$strSaveConfig='Lưu lại các thiết lập';
$strSaveChange='Lưu lại các thay đổi';
$strSaveInformation='Lưu lại các thông tin';
$strChangePic='Đổi ảnh';
$strTickerRequest='Yêu cầu hỗ trợ';
//--------------------------------------------------------------------------------------------
	
//----------------------------------------- Icon name ----------------------------------------
$strProducts='Sản phẩm';
$strNews='Tin tức';
$strArticles='Bài viết';
$strOrders='Đơn hàng';
$strService='Dịch vụ';
$strKeywords='Từ khóa';
$strDownload='Báo giá';
$strCity='Thành phố';
$strSupport='Hỗ trợ trực tuyến';
$strProduct='Sản phẩm';
$strContact='Liên hệ';
$strMembers='Khách hàng';
$strWeblink='Quảng cáo';
$strPending='Chờ duyệt';
$strTrash='Thùng rác';
$strMessage='Tin nhắn';
$strImage='Hình ảnh';
$strDatabase='Cơ sở dữ liệu';
$strBackup='Backup database';
$strLog='Nhật ký';
$strFile='Tệp tin';
$strActive='Kích hoạt';
$strMailingList='Mailing list';
$strConfig='Cấu hình Site';
$strSummary='Thống kê';
$strPermission='Phân quyền';
$strBan='Kỷ luật';
$strGroup='Nhóm';
$strUser='Người dùng';
$strPool='Thăm dò ý kiến';
$strManufacturer='Hãng sản xuất';
$strSeri='Chủng loại SP';
$strOrder='Đơn hàng';
$strVideo='Video';
$strDesign='Thiết kế';
$strdefault='Quản lý trang Default';
$strDefault = "Cấu hình mặc định";
$strSearchprice='Giá tìm kiếm';
//--------------------------------------------------------------------------------------------

//----------------------------------- Personal informations ----------------------------------
$strRealName='Tên thật';
$strNull='Không hiển thị';
$strRealNameRule='Chỉ gồm chữ, dấu cách. Trong khoảng 4 - 40 ký tự';
$strBirthDay='Ngày sinh';
$strGender='Giới tính';
$strMale='Nam';
$strFemale='Nữ';
$strAddress='Địa chỉ';
$strAddressRule='Khoảng 5 - 100 ký tự';
$strJob='Nghề nghiệp';
$strJobRule='Khoảng 5 - 50 ký tự';
$strJobAddress='Nơi công tác';
$strJobAddressRule='Khoảng 5 - 100 ký tự';
$strPhone='Điện thoại';
$strPhoneRule='Chỉ gồm số, dấu cách, gạch ngang';
$strEmail='Email';
$strEmailRule='Địa chỉ E-mail còn sử dụng để hệ thống gửi E-mail kích hoạt tài khoản';
$strYahooId='Yahoo ID';
$strYahooIdRule='Yahoo ID đang sử dụng';
$strWebsite='Website';
$strWebsiteRule='Website cá nhân hoặc đơn vị có liên quan';
$strDescription='Mô tả bản thân';
$strDescriptionRule='Trong khoảng 255 ký tự';
$strSign='Chữ ký';
$strSignRule='Trong khoảng 255 ký tự';
$strShowSign='Hiển thị chữ ký cuối mỗi bài viết';
$strAvatar='Hình đại diện';
$strSupportedFileType='Định dạng file được hỗ trợ';
$strMaxFileSize='Kích thước file tối đa';
$strClickView='Kích vào đây để xác nhận những thông tin trên là chính xác';
//--------------------------------------------------------------------------------------------

//----------------------------------- copyright informations ----------------------------------
$strCopyright='© 2012 BCMS Version 3.2 - www.hoanggiagroup.com.vn - Thiết kế và phát triển bởi HOANGGIAGROUP ™';
//--------------------------------------------------------------------------------------------

//---------------------------------------- Error handling ------------------------------------
$strHaveError='Có lỗi ! Lỗi được thông báo như sau : ';
$strErr=array (
	// 1.. Lỗi SQL
		'101'=>'Không thể kết nối đến Cơ Sở Dữ Liệu',
		'102'=>'Truy vấn thêm bản ghi không hiệu lực',
		'103'=>'Truy vấn cập nhật bản ghi không hiệu lực',
		'104'=>'Truy vấn xóa bản ghi không hiệu lực',
		'105'=>'Truy vấn tạo bảng dữ liệu không hiệu lực',
		'106'=>'Dữ liệu đã có trên Server',
		'107'=>'Dữ liệu không tồn tại',
		'108'=>'Truy vấn không thể thực thi',
		'109'=>'Bỏ trống dữ liệu này ?',
	// 2.. Lỗi Hệ thống
		'201'=>'Bạn không được phép truy cập vùng thông tin này !',
		'202'=>'Tên truy cập không hợp lệ',
		'203'=>'Mật khẩu truy cập không hợp lệ',
		'204'=>'Tên truy cập và mật khẩu không chính xác hoặc tài khoản không tồn tại',
		'205'=>'Hệ thống hiện thời đang nâng cấp',
		'206'=>'Thay đổi không có hiệu lực,mời nhập lại',
		'207'=>'Mật khẩu mới không hợp lệ',
	// 3.. Lỗi File
	// 4.. Lỗi nhóm, mục
		'401'=>'Không thể lấy thông tin về mục con sẽ được tạo',
		'402'=>'Mục bị xóa không rỗng',
		'403'=>'Không thể xóa mục',
		'404'=>'Không thể lấy thông tin về mục bị xóa',
		'405'=>'Không thể lấy thông tin về mục sẽ chuyển',
		'406'=>'Không nhận được thông tin về mục sẽ chuyển',
		'407'=>'Không thể lấy thông tin về nhóm sẽ chuyển tới',
		'408'=>'Không nhận được thông tin về nhóm sẽ chuyển tới',
		);
//--------------------------------------------------------------------------------------------

//------------------------------------------ Notices -----------------------------------------
$strHaveNotice='Thông báo từ hệ thống : ';
$strNotice=array (
	// 1.. SQL
		'101'=>'Truy vấn thực thi thành công',
		'102'=>'Truy vấn thêm bản ghi thành công',
		'103'=>'Truy vấn cập nhật bản ghi thành công',
		'104'=>'Truy vấn xóa bản ghi thành công',
		'105'=>'Truy vấn tạo bảng dữ liệu thành công',
		'106'=>'Truy vấn tạo Người dùng thành công',
	// 2.. Hệ thống
		'201'=>'Bạn không được phép truy cập vùng thông tin này !',
		'202'=>'Tên truy cập không hợp lệ',
		'203'=>'Mật khẩu truy cập không hợp lệ',
		'204'=>'Tên truy cập và mật khẩu không chính xác hoặc tài khoản không tồn tại',
		'205'=>'Hệ thống hiện thời đang nâng cấp',
		'206'=>'Thay đổi không có hiệu lực,mời nhập lại',
		'207'=>'Mật khẩu mới không hợp lệ',
		'208'=>'Bạn không được cấp quyền thao tác với vùng thông tin này',
	// 3.. Lỗi File
	// 4.. Thư mục
		'401'=>'Không thể đọc nội dung thư mục',
		'402'=>'Thư mục rỗng hoặc chứa file không được hỗ trợ',
		);
//--------------------------------------------------------------------------------------------

//--------------------------------- Commands and descriptions --------------------------------

//--------------------------------------------------------------------------------------------