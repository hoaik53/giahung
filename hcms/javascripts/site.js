$(document).ready(function(){
    //show hide menu
    $curState = "show";
    $("#show_hide_lmenu").click(function(){
        //$curState = bsGetCookie("smenu");
        if($curState == "show")
        {
            $(this).siblings().hide();
            $(this).parent().css("width","0");
            $("#rightbody").css("marginLeft","7px");
            $curState = "hide";
        }
        else
        {
            $(this).siblings().show();
            $(this).parent().css("width","200px");
            $("#rightbody").css("marginLeft",'210px');
            $curState = "show";
        }
    });
    $('.select_date').datepicker();
    //menu left make this foat topcontrol
    var name = "#menuleft";
	var menuYloc = null;
    if($(name).length > 0)menuYloc = parseInt($(name).offset().top); else menuYloc = 0;
    if($('#topcontrol').length > 0)topcontrolYloc = parseInt($('#topcontrol').offset().top);else topcontrolYloc = 0;
			$(window).scroll(function () {
			    offset = parseInt($(document).scrollTop()) - menuYloc
			    offset1 = parseInt($(document).scrollTop()) - topcontrolYloc
				if(offset > 0)
                {
                    offset = offset+"px";
                    $(name).animate({top:offset},{duration:200,queue:false});
                    
                }
                if(offset1 > 0)
                {
                    offset1 = offset1+"px";
                    $('#topcontrol').animate({top:offset1},{duration:200,queue:false});
                }
                if($(document).scrollTop() < menuYloc)
                {
                    $(name).animate({top:0},{duration:200,queue:false});
                    
                }
                if($(document).scrollTop() < topcontrolYloc)
                {
                    $('#topcontrol').animate({top:0},{duration:200,queue:false});
                }
			});
    
    
    
    
    //panel tab
    $('.paneltab').tabs({
        disabled: [1]
    });
    $(".reset_button").button({
        icons : {
            primary: "ui-icon-arrowrefresh-1-s"}
    });
    $(".submit_button").button({
        icons : {
            primary: "ui-icon-check"}
    });
    $(".save_button").button({
        icons : {
            primary: "ui-icon-check"}
    });
    $(".popup_button").button({
        icons : {
            primary: "ui-icon-newwin"}
    });
    //button style
    $(".button").button();
    $(".back_button").button({
        icons: {
                primary: "ui-icon-arrowreturnthick-1-w"
            }
    });
    $(".edit_button").button({
        icons: {
                primary: "ui-icon-pencil"
            }
    });
    $(".first_button").button({
        icons: {
                primary: "ui-icon-arrowreturnthickstop-1-w"
            }
    });
    $(".last_button").button({
        icons: {
                primary: "ui-icon-arrowreturnthickstop-1-e"
            }
    });
    $(".pre_button").button({
        icons: {
                primary: "ui-icon-arrowthick-1-w"
            }
    });
    $(".next_button").button({
        icons: {
                primary: "ui-icon-arrowthick-1-e"
            }
    });
    $(".search_button").button({
        icons: {
                primary: "ui-icon-search"
            }
    });
    $(".refresh_button").button({
        icons: {
                primary: "ui-icon-refresh"
            }
    });
    $(".cancel_button").button({
        icons: {
                primary: "ui-icon-circle-close"
            }
    });
    $(".del_button").button({
        icons: {
                primary: "ui-icon-trash"
            }
    });
    $(".add_button").button({
        icons: {
                primary: "ui-icon-plus"
            }
    });
    $(".only_icon").button({
            text : false
    });
    $("a[rel=detail],.detail_button").button("option","icons",{primary : "ui-icon-extlink"});
    $("a[rel=del],.del_button").button("option","icons",{primary : "ui-icon-trash"});
    $("a[rel=edit],.edit_button").button("option","icons",{primary : "ui-icon-pencil"});
    $("a[rel=add],.add_button").button("option","icons",{primary : "ui-icon-plus"});
    //change image
    $(".previewable").blur(function(){
        //var fieldname = $(this).attr("name");
        if($(this).val() != "")
        //$("#"+fieldname+"_prev").attr("src","../"+$(this).val());
        {
            $(this).nextAll('.imgpreview:first')
                    .attr("href","/"+$(this).val())
                    .children('img')
                    .attr("src","ajax/image.php?width=50&height=50&cropratio=2:1&image=/"+$(this).val());
        }
    });
    $(".previewable").change(function(){
        //var fieldname = $(this).attr("name");
        if($(this).val() != "")
        //$("#"+fieldname+"_prev").attr("src","../"+$(this).val());
        {
            $(this).nextAll('.imgpreview:first')
                    .attr("href","/"+$(this).val())
                    .children('img')
                    .attr("src","ajax/image.php?width=50&height=50&cropratio=2:1&image=/"+$(this).val());
        }
        
    });
    // ajax/image.php?width=50&amp;height=50&amp;cropratio=2:1&amp;image=/
    $(".imgpreview").lightBox();
    //support open popup 
    //del image link
	$('.del_image_link').click(function(){
		$(this).prev().val('').nextAll('.imgpreview:first')
                    .attr("href","/"+$(this).val())
                    .children('img')
                    .attr("src","");
	});
});
jQuery(function($){
	$.datepicker.regional['vi'] = {
		closeText: 'Đóng',
		prevText: '&#x3c;Trước',
		nextText: 'Tiếp&#x3e;',
		currentText: 'Hôm nay',
		monthNames: ['Tháng Một', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu',
		'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười Hai'],
		monthNamesShort: ["Th1", "Th2", "Th3", "Th4", "Th5", "Th6", "Th7", "Th8", "Th9", "Th10", "Th11", "Th12"],
		dayNames: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
		dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
		dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
		weekHeader: 'Tu',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
        dateFormat:'yy-mm-dd',
        changeMonth : true,
        changeYear : true,    
        gotoCurrent : true,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['vi']);
});