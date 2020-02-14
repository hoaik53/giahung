;(function($){
/**
 * jqGrid English Translation
 * Tony Tomov tony@trirand.com
 * http://trirand.com/blog/ 
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
**/
$.jgrid = {
	defaults : {
		recordtext: "Hiển thị {0} - {1} trong {2}",
		emptyrecords: "Không có bản ghi nào",
		loadtext: "Đang tải...",
		pgtext : "Trang {0} tổng số {1}"
	},
    bs : {
        selectGroup : 'Chọn nhóm',
        changeGroup : 'Đổi nhóm',
        altChangeGroup : 'Đổi nhóm cho các bản ghi đã chọn',
        saveChange : 'Lưu thay đổi',
        errorChange : 'Chưa lưu được thay đổi',
        gettingGroupList : 'Đang lấy danh sách nhóm'
    },
	search : {
		caption: "Tìm kiếm...",
		Find: "Tìm",
		Reset: "Đặt lại",
		odata : ['equal', 'not equal', 'less', 'less or equal','greater','greater or equal', 'begins with','does not begin with','is in','is not in','ends with','does not end with','contains','does not contain'],
		groupOps: [	{ op: "AND", text: "all" },	{ op: "OR",  text: "any" }	],
		matchText: " match",
		rulesText: " rules"
	},
	edit : {
		addCaption: "Thêm bản ghi",
		editCaption: "Sửa bản ghi",
		bSubmit: "Lưu",
		bCancel: "Hủy",
		bClose: "Đóng",
		saveData: "Dữ liệu đã thay đổi! Lưu thay dổi?",
		bYes : "Có",
		bNo : "Không",
		bExit : "Hủy",
		msg: {
			required:"Trường bắt buộc",
			number:"Chỉ được nhập số",
			minValue:"giá trị phải lớn hơn hoặc bằng ",
			maxValue:"giá trị phải nhỏ hơn hoặc bằng",
			email: " không phải e-mail hợp lệ",
			integer: "Chỉ nhập số nguyên",
			date: "Nhập ngày chưa hợp lệ",
			url: "URL chưa hợp lệ. Bắt đầu bằng ('http://' hoặc 'https://')",
			nodefined : " chưa được định nghĩa!",
			novalue : " không có giá trị trả về!",
			customarray : "Hàm phải trả về mảng!",
			customfcheck : "Hàm nên hiển thị các kiểm tra tùy chỉnh!"
			
		}
	},
	view : {
		caption: "Xem bản ghi",
		bClose: "Đóng"
	},
	del : {
		caption: "Xóa",
		msg: "Xóa các bản ghi đã chọn?",
		bSubmit: "Xóa",
		bCancel: "Hủy"
	},
	nav : {
		edittext: "",
		edittitle: "Sửa hàng được chọn",
		addtext:"",
		addtitle: "Thêm hàng mới",
		deltext: "",
		deltitle: "Xóa bản ghi đã chọn",
		searchtext: "",
		searchtitle: "Tìm các bản ghi",
		refreshtext: "",
		refreshtitle: "Tải lại",
		alertcap: "Thông báo",
		alerttext: "Hãy chọn một hàng",
		viewtext: "",
		viewtitle: "Xem bản ghi được chọn"
	},
	col : {
		caption: "Chọn các cột",
		bSubmit: "Ok",
		bCancel: "Hủy"
	},
	errors : {
		errcap : "Lỗi",
		nourl : "Chưa có url",
		norecords: "Không có bản ghi nào",
		model : "Số tên cột khác số lượng colModel!"
	},
	formatter : {
		integer : {thousandsSeparator: " ", defaultValue: '0'},
		number : {decimalSeparator:".", thousandsSeparator: " ", decimalPlaces: 2, defaultValue: '0.00'},
		currency : {decimalSeparator:".", thousandsSeparator: " ", decimalPlaces: 2, prefix: "", suffix:"", defaultValue: '0.00'},
		date : {
			dayNames:   [
				"CN", "T.Hai", "T.Ba", "T.Tu", "T.Năm", "T.Sáu", "T.Bảy",
				"Chủ nhật", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7"
			],
			monthNames: [
				"Th1", "Th2", "Th3", "Th4", "Th5", "Th6", "Th7", "Th8", "Th9", "Th10", "Th11", "Th12",
				"Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
			],
			AmPm : ["s","c","S","C"],
			S: function (j) {return j < 11 || j > 13 ? ['st', 'nd', 'rd', 'th'][Math.min((j - 1) % 10, 3)] : 'th'},
			srcformat: 'Y-m-d',
			newformat: 'd-m-Y',
            
			masks : {
				ISO8601Long:"Y-m-d H:i:s",
				ISO8601Short:"Y-m-d",
				ShortDate: "n/j/Y",
				LongDate: "l, F d, Y",
				FullDateTime: "l, F d, Y g:i:s A",
				MonthDay: "F d",
				ShortTime: "g:i A",
				LongTime: "g:i:s A",
				SortableDateTime: "Y-m-d\\TH:i:s",
				UniversalSortableDateTime: "Y-m-d H:i:sO",
				YearMonth: "F, Y"
			},
			reformatAfterEdit : false
		},
		baseLinkUrl: '',
		showAction: '',
		target: '',
		checkbox : {disabled:true},
		idName : 'id'
	}
};
})(jQuery);
//my caption
strPreviewImage = "Xem trước ảnh";