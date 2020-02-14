// JavaScript Document

var vatgia_product_favorites_comment	= '<div class="title">Lợi ích khi theo dõi sản phẩm?</div><div class="content">Khi quý khách "Theo dõi" sản phẩm thì mọi thông tin như giá cả, hỏi đáp, đánh giá liên quan đến sản phẩm được cập nhật, thì hệ thống sẽ tự động gửi thông tin vào tài khoản của quý khách trên Vatgia.com. Quý khách có thể theo dõi thông báo mới từ hệ thống trên icon hình quả cầu bên cạnh ô tìm kiếm của website.</div>';
function addToCartButton(record_id, estore_id, estore_name, vatgia_verified, map_friend, direct_add_to_cart_link, baokim_payment, redirect){
	strReturn	= '<div class="add_to_cart_button">';
	if(vatgia_verified == 1) strReturn	+= '<div class="vatgia_verified">Hãy đặt hàng tại đây<br />để được đảm bảo an toàn <img class="tooltip_content" tooltipContent="vatgia_verified_text" src="' + fs_imagepath + 'icon_question_small.gif" style="cursor:pointer" /></div>';
	if(direct_add_to_cart_link != ""){
		strReturn	+= '<div><a href="' + direct_add_to_cart_link + '"><img src="' + fs_imagepath + 'btn_order.gif" /></a></div>';
		strReturn	+= '<div class="end"><a class="tooltip_content" tooltipContent="vatgia_product_favorites_comment" href="/home/addfavorites.php?addto=product&record_id=' + record_id + '&redirect=' + redirect + '" rel="nofollow"><img src="' + fs_imagepath + 'btn_order_favorites.gif" /></a></div>';
	}
	else{
		href	= '/home/addtocart.php?iPro=' + record_id + '&estore_id=' + estore_id + '&estore_name=' + estore_name + '&return=' + redirect;
		strReturn	+= '<div><a href="javascript:;" onclick="addToCartLink(\'' + href + '\'); return false;"><img src="' + fs_imagepath + 'btn_order.gif" /></a></div>';
		strReturn	+= '<div class="or">Hoặc</div>';
		strReturn	+= '<div>';
			if(map_friend !== null){
				strReturn	+= '<select id="friend_id"><option value="0">- Chọn người nhận -</option>';
				$.each(map_friend, function(key, value){
					strReturn	+= '<option value="' + key + '">' + value + '</option>';
				});
				strReturn	+= '</select>';
			}
			strReturn	+= '<a href="javascript:;" onClick="window.location.href=\'/home/buynow.php?iPro=' + record_id + '&iUse=' + estore_id + '&iUf=\' + parseInt($(&quot;#friend_id&quot;).val())"><img src="' + fs_imagepath + 'btn_order_1_click.gif" /></a>';
		strReturn	+= '</div>';
		strReturn	+= '<div' + (baokim_payment == 0 ? ' class="end"' : "") + '><a class="tooltip_content" tooltipContent="vatgia_product_favorites_comment" href="/home/addfavorites.php?addto=product&record_id=' + record_id + '&redirect=' + redirect + '" rel="nofollow"><img src="' + fs_imagepath + 'btn_order_favorites.gif" /></a></div>';
		if(baokim_payment == 1) strReturn	+= '<div class="baokim_pay_now end">An toàn hơn qua Baokim.vn<br /><a href="/home/baokim_pay_now.php?iPro=' + record_id + '&iUse=' + estore_id + '" target="_blank"><img src="' + fs_imagepath + 'btn_order_baokim.gif" /></a></div>';
		else strReturn	+= '<div class="baokim_pay_now end">Gian hàng này chưa được hỗ trợ <b style="color:#FF0000">thanh toán tạm giữ với Baokim.vn</b>. <a class="text_link_bold" href="javascript:;" onclick="baokimRequestIntegrate(' + estore_id + ')">Yêu cầu hỗ trợ</a></div>';
	}
	strReturn	+= '</div>';
	return strReturn;
}

function addToCartLink(href){
	quantity		= 1;
	obTemp		= $("#addtocart_quantity");
	if(obTemp.length) quantity = parseInt(obTemp.val());
	if(quantity <= 0 || isNaN(quantity)){
		alert("Số lượng phải lớn hơn 0.");
		obTemp.focus();
		return false;
	}
	window.location.href	= href + "&quantity=" + quantity;
}

function baokimRequestIntegrate(estore_id){
	if(user_logged == 0){
		windowPrompt("Đăng nhập", generateFormLogin({
			success: function(){
				$.get(con_ajax_path + "baokim_request_integrate.php?iEst=" + estore_id, function(data){
					if(checkAjaxResponse(data)){
						closeWindowPrompt();
						alert("Bạn đã gửi thành công.");
						window.location.reload();
					}
				});
			}
		}));
	}
	else{
		$.get(con_ajax_path + "baokim_request_integrate.php?iEst=" + estore_id, function(data){
			if(checkAjaxResponse(data)){
				alert("Bạn đã gửi thành công.");
			}
		});
	}
}

// Show sản phẩm theo độ phân giải màn hình
function changeDataMatchResolution(sel){
	
	if(sel == "") sel = ".list_product:not(.fixed), .list_review:not(.fixed), .list_category:not(.fixed)";
	$(sel).each(function(index){
		
		width		= (typeof($(this).attr("dataWidth")) != "undefined" ? $(this).attr("dataWidth") : (isIE ? 157 : 158));
		col		= (typeof($(this).attr("dataCol")) != "undefined" ? $(this).attr("dataCol") : 8);
		
		numCol	= parseInt($(this).width() / width);
		if(numCol < 3) numCol = 3;
		if(numCol > col) numCol = col;
		colWidth	= 100 / numCol;
		if(isIE6 || isIE7) colWidth = colWidth - 0.1;
		
		$(this).find(".fl").width(colWidth + "%");
		n = $(this).attr("dataLine") * numCol;
		
		$(this).find(".fl:lt(" + n + ")").removeClass("hidden");
		if(n > 0) $(this).find(".fl:gt(" + (n-1) + ")").addClass("hidden");
		
		// Trường hợp page_div nằm bên trong
		$(this).find(".page_div a, .page_div_top a").each(function(index2){
			$(this).attr("href", function(index3, attr){
				return changePageSize(attr, n);
			});
		});
		
		// Trường hợp page_div nằm bên ngoài
		if($(this).hasClass("view_thumbnail_table") == true){
			$(this).parent().find(".page_div a, .page_div_top a").each(function(index2){
				$(this).attr("href", function(index3, attr){
					return changePageSize(attr, n);
				});
			});
		}
		
	});
	
}

// Change type khi post, edit sản phẩm
function changeTypeProduct(type, ob){
	if(type == 1) ob.val(1).attr("disabled", true);
	else ob.attr("disabled", false);
}

// Change page
function changePage(sel, index){
	$("." + sel + " > ul").hide();
	$("." + sel + " > ul:eq(" + index + ")").fadeIn("slow");
	$("." + sel + " > .page_break a").removeClass("current");
	$("." + sel + " > .page_break a:eq(" + index + ")").addClass("current");
}

function changePageSize(url, n){
	urlReturn	= "";
	// Check xem có Mod-write ko
	check	= url.lastIndexOf(".php?");
	// Nếu là link Mod-write
	if(check == -1){
		temp	= url.lastIndexOf("_");
		if(temp != -1) urlReturn = url.substr(0, temp) + "_" + n;
		else urlReturn = url + "_" + n;
	}
	// Ngược lại thì show kiểu khác
	else{
		temp	= url.lastIndexOf("page=");
		if(temp == -1){
			urlReturn = url;
		}
		else{
			temp1	= url.substr(0, temp);
			temp2	= url.substr((temp + 5));
			urlReturn = temp1 + "page=" + parseInt(temp2) + "_" + n;
		}
	}
	return urlReturn;
}

function checkProductFormAction(form, type){
	ob	= $("form[name='" + form + "']");
	if(ob.find("input[name='c\[\]']:checked").length == 0){
		alert("Bạn hãy chọn ít nhất 1 sản phẩm.");
		return;
	}
	// Enable input redirect
	ob.find("input[name='redirect']").removeAttr("disabled");
	switch(type){
		case "add_to_favorites"		: url	= con_root_path + "add_to_favorites.php"; break;
		case "add_to_estore_temp"	: url	= con_root_path + "add_to_estore_temp.php"; break;
		default: ob.find("input[name='redirect']").attr("disabled", true); url = con_root_path + "compare.php"; break;
	}
	ob.attr({ action: url, method: "get" });
	ob.submit();
}

function deleteExclusivePicture(iPro, iGal, authen_code){
	if(confirm("Bạn có muốn xóa ảnh này không?")){
		$("#picture_" + iPro + "_" + iGal).load(con_ajax_path + "delete_exclusive_picture.php?iPro=" + iPro + "&iGal=" + iGal + "&authen_code=" + authen_code);
	}
}

function fixHeightFooter(){
	$(".fix_height_footer").height(0);
	// Fix lại chiều cao #container_content_left để tránh trường hợp bên phải thấp hơn bên trái footer sẽ bị đè
	if($(".container_content_left").height() !== null){
		if($(".container_content_center").height() !== null){
			height	= ($(".container_content_center").height() < $(".container_content_right").height() ? $(".container_content_right").height() : $(".container_content_center").height());
			if(height < $(".container_content_left").height()){
				fix_height_footer	= $(".container_content_left").height() - height;
				$(".fix_height_footer").height(fix_height_footer);
			}
		}
		else{
			if($(".container_content_center_right").height() < $(".container_content_left").height()){
				fix_height_footer	= $(".container_content_left").height() - $(".container_content_center_right").height();
				$(".fix_height_footer").height(fix_height_footer);
			}
		}
	}
}

function generateDataOption(compare, add_to_estore, logged, supplier){
	if(compare == 1) document.write('<a class="compare" href="javascript:checkProductFormAction(\'product\', \'compare\');">So sánh</a> &nbsp; ');
	favorites	= (logged == 1 ? "checkProductFormAction('product', 'add_to_favorites')" : "alert('Bạn phải đăng nhập mới sử dụng được tính năng này.')");
	document.write('<a class="add_to_favorites" href="javascript:' + favorites + ';">Thích SP</a>');
	if(supplier == 1 && add_to_estore == 1) document.write(' &nbsp; <a class="add_to_estore_temp" href="javascript:checkProductFormAction(\'product\', \'add_to_estore_temp\');">Bán</a>');
}

function generateEstoreDataOption(type, id, arrUpPrice, authen_code){
	if(type == "add"){
		document.write('<a title="Thêm sản phẩm vào gian hàng" class="colorbox_iframe text_link add" href="' + con_ajax_path + 'load_add_product.php?iData=' + id + '" target="_blank" rel="nofollow">Tôi muốn bán sản phẩm này</a>');
	}
	else{
		document.write('<a title="Sửa thông tin sản phẩm" class="colorbox_iframe text_link edit" href="' + con_ajax_path + 'load_edit_product.php?iData=' + id + '" target="_blank" rel="nofollow">Sửa</a> &nbsp; ' +
							'<a title="Đưa vào chuyên mục đặc biệt" class="colorbox_iframe text_link season" href="' + con_ajax_path + 'load_season_product.php?iData=' + id + '" target="_blank" rel="nofollow">Chuyên mục đặc biệt</a> &nbsp; ' +
							'<a title="Tự động đưa sản phẩm lên đầu danh mục" class="text_link auto_up" href="/profile/?module=product_auto_up&record_id=' + id + '" target="_blank" rel="nofollow">Tự động up</a> &nbsp; ' +
							'<a title="Đưa sản phẩm lên đầu danh mục" class="text_link up" href="javascript:if(confirm(\'Bạn có chắc muốn Up sản phẩm này lên đầu danh mục, sản phẩm đặc biệt, (vào phần Sản phẩm mới cập nhật) không?\\nMỗi lần Up chúng tôi sẽ thu phí là ' + arrUpPrice[0] + 'đ / ' + arrUpPrice[1] + '\')) window.location.href=\'/home/up_product.php?record_id=' + id + '&redirect=' + fs_redirect + '\';" rel="nofollow">Up lên đầu</a> &nbsp; ' +
							'<a title="Xóa sản phẩm" class="text_link delete" href="javascript:if(confirm(\'Bạn có muốn xóa sản phẩm này tại gian hàng của mình không?\')) window.location.href=\'' + con_root_path + 'delete_product.php?record_id=' + id + '&authen_code=' + authen_code + '&redirect=' + fs_redirect + '\';" rel="nofollow">Xóa</a>');
	}
}

// Generate page break
function generatePageBreak(sel){
	// Nếu chỉ có 1 page thì return luôn
	if($("." + sel + " > ul").length <= 1) return;
	
	strReturn	= "";
	$("." + sel + " > ul").each(function(index){
		strReturn	+= '<a' + (index == 0 ? ' class="current"' : "") + ' href="javascript:;" onClick="changePage(\'' + sel + '\', ' + index + ')">' + (index+1) + '</a>';
	});
	
	$("." + sel + " > .page_break").html(strReturn);
}

function generateViewOption(){
	if(typeof(defViewName) == "undefined") defViewName = "view";
	if(typeof(defViewValue) == "undefined") defViewValue	= 0;
	document.write('<b>Hiển thị:</b> ');
	arrView	= Array("Chi tiết", "Ảnh sản phẩm", "Rút gọn");
	arrImg	= Array("list", "thumbnail", "collapse");
	def		= $.cookie(defViewName);
	if(typeof(arrView[def]) == "undefined") def = defViewValue;
	for(i=0; i<arrView.length; i++){
		img	= (i == def ? "icon_view_" + arrImg[i] + "_on.gif" : "icon_view_" + arrImg[i] + "_off.gif");
		document.write('<a title="' + arrView[i] + '" href="javascript:;" onClick="$.cookie(\'' + defViewName + '\', ' + i + ', { expires: null, path: \'/\' }); window.location.reload(false)"><img src="' + fs_imagepath + img + '" /></a>');
	}
}

function noticeProduct(pro_id, u_id, u_name){
	arrText		= Array("Sai giá", " &nbsp; | &nbsp; ", "Hết hàng");
	args			= noticeProduct.arguments;
	css			= (!isIE6 && !isIE7 ? '' : '');
	if(typeof(args[3]) != "undefined"){
		arrText	= Array("Báo sai giá", " &nbsp; ", "Báo hết hàng");
		css		= '';
	}
	strReturn	= '<span class="font_small' + css + '">';
	onClick		= 'windowPrompt(\'Đăng nhập\', generateFormLogin)';
	if(user_logged == 1) onClick	= 'windowPrompt({ content: \'Bạn đã kiểm tra và chắc chắn giá tại gian hàng ' + u_name + ' là sai?\', confirm: function(c){ if(c){$.get(\'/ajax/notice_price.php?iUse=' + u_id + '&iPro=' + pro_id + '\')} } })';
	strReturn	+= '<a title="Báo sai giá sản phẩm của gian hàng này" class="text_link" href="javascript:;" onClick="' + onClick + '">' + arrText[0] + '</a>' + arrText[1];
	if(user_logged == 1) onClick	= 'windowPrompt({ content: \'Bạn đã kiểm tra và chắc chắn sản phẩm gian hàng ' + u_name + ' đã hết hàng?\', confirm: function(c){ if(c){$.get(\'/ajax/notice_stock.php?iUse=' + u_id + '&iPro=' + pro_id + '\')} } })';
	strReturn	+= '<a title="Báo hết hàng tại gian hàng này" class="text_link" href="javascript:;" onClick="' + onClick + '">' + arrText[2] + '</a>';
	strReturn	+= '</span>';
	return strReturn;
}

// Resize window về đúng độ phân giải màn hình (Full Screen)
function resizeWindow(){
	
	minWidth	= 994;
	bodyWidth= ($("#body").width() < minWidth ? minWidth : $("#body").width());
	if($("#container_body").width() == 1000) bodyWidth = 1000;
	
	$("#container_body, .header_bar_v2").width(bodyWidth);
	/*
	search_keyword_width	 = bodyWidth - $(".header_search .search_help").outerWidth(true) -
													$(".header_search .search_in").outerWidth(true) -
													$(".header_search .search_text .left").outerWidth(true) - $(".header_search .search_text .right").outerWidth(true) - 2 -
													$(".header_search .search_area").outerWidth(true) -
													$(".header_search .statistic").outerWidth(true) -
													$(".header_search .register_estore").outerWidth(true);
	*/
	changeDataMatchResolution("");
	
	$(".data_option:first").width($(".data_option_fixed:first").width() - 10);
	
}

function showPriceUsd(use_name, price, price_usd, exchange){
	onClick		= 'windowPrompt({ content: \'' + price + ' VNĐ = ' + price_usd + ' USD<br />Tỉ giá tại gian hàng <b>' + use_name + '</b>: 1 USD = ' + exchange + ' VNĐ\', alert: true })';
	strReturn	= '<span class="price_usd" style="cursor:pointer" onClick="' + onClick + '">?USD</span>';
	return strReturn;
}

function showSkype(nick, text, max_length){
	name	= (text.length <= max_length || max_length == 0) ? text : text.substr(0, max_length) + "...";
	document.write('<a title="' + text + '" class="text_link" href="skype:' + nick + '?call" rel="nofollow">' + name + '</a>');
}

function showTeaserProduct(){
	$(".view_list_table .teaser, .view_list_table .exclusive_teaser").each(function(index, domEle){
		defHeight	= $(domEle).css("height");
		$(".view_list_table .show_teaser a:eq(" + index + ")").toggle(
			function(){
				$(this).attr("title", "Thu nhỏ");
				$(this).removeClass("expand");
				$(domEle).css("height", "auto");
			},
			function(){
				$(this).attr("title", "Mở rộng");
				$(this).addClass("expand");
				$(domEle).css("height", defHeight);
			}
		);
	});
}

function showYM(nick, icontype, text, max_length){
	name	= (text.length <= max_length || max_length == 0) ? text : text.substr(0, max_length) + "...";
	document.write('<a title="' + text + '" class="text_link" href="ymsgr:sendim?' + nick + '&m=Xin chao, toi muon hoi ve san pham ' + window.location.href + ' !" rel="nofollow" style="background-image:url(http://opi.yahoo.com/online?u=' + nick + '&m=g&t=' + icontype + '&l=us)">' + name + '</a>');
}

/*** Tooltip ***/
function tooltipReview(){
	if(isIE6 || isIE7) return;
	$(".list_review pre").each(function(index, domEle){
		obTT	= $(domEle).parent().find(".tooltip");
		obTT.tooltip({
			bodyHandler: function(){
				$("#tooltip").css("width", "300px");
				$(domEle).find(".picture, .picture_only").html(function(index, html){
					return '<img src="' + $(this).attr("src") + '" />';
				});
				return $(domEle).html();
			},
			track: true,
			showURL: false,
			extraClass: "tooltip_review"
		});
	});
}
/*-- End Tooltip --*/

/*** Initiate Load ***/
function footerLoad(){
	
	footerLoadMain();
	
	$(".generate_star").html(function(index, html){
		$(this).attr("class", "star_vote");
		maxStar	= 10;
		if(typeof($(this).attr("maxStar")) != "undefined") maxStar	= $(this).attr("maxStar");
		return generateVote(html, maxStar);
	});
	
	$(".left_menu li:last-child, .left_menu_quick_search div:last-child, .left_menu_quick_search li:last-child, .left_banner td:last, .right_banner td:last").addClass("end");
	
}

function initLoad(){
	
	if(!isIE6){
		resizeWindow();
		$(window).resize(function(){
			resizeWindow();
		});
	}
	
	initLoadMain();
	
}

// Run a function when the page is fully loaded
function initLoaded(){
	
	initLoadedMain();
	
	fixHeightFooter();
	
	tooltipProduct();
	
}
/*-- End Initiate On Load --*/