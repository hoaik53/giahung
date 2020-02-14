<?php if(!defined('bcms'))die('Cannot access directly!'); ?>
<?php
//config module
$tblname = $_REQUEST['tblname'];
$idfield = 'id';
$configarrray = array();
//get some array for select elelment

$activeArray = array();
$getActive = get_all("active","","");
if(count($getActive))
{
    foreach($getActive as $aitem)
    {
        $activeArray[] = $aitem['id'].":$inden".stripslashes($aitem['status']);
    }
}
$activeArray = ":--".$strSelect."--;".implode(";",$activeArray);

$levelArray = array();
$getLevel = get_all("level","","");
if(count($getLevel))
{
    foreach($getLevel as $aitem)
    {
        $levelArray[] = $aitem['level'].":$inden".stripslashes($aitem['name']);
    }
}
$levelArray = ":--".$strSelect."--;".implode(";",$levelArray);

$avdproductsArray = array();
$getAvdproducts = get_all("avdproducts","","");
if(count($getAvdproducts))
{
    foreach($getAvdproducts as $aitem)
    {
        $avdproductsArray[] = $aitem['id'].":$inden".stripslashes($aitem['type']);
    }
}
$avdproductsArray = ":--".$strSelect."--;".implode(";",$avdproductsArray);

$advertisingArray = array();
$getAdvertising = get_all("advertising","","");
if(count($getAdvertising))
{
    foreach($getAdvertising as $aitem)
    {
        $advertisingArray[] = $aitem['id'].":$inden".stripslashes($aitem['type_ad']);
    }
}
$advertisingArray = ":--".$strSelect."--;".implode(";",$advertisingArray);


$langArray = array();
$getLang = get_all("languages",""," id asc ");
if(count($getLang))
{
    foreach($getLang as $aitem)
    {
        $langArray[] = $aitem['lang'].":$inden".stripslashes($aitem['name']);
    }
}
$langArray = ":--".$strSelect."--;".implode(";",$langArray);

$edittype = 'detailedit';
if($_GET['type'] == 'quickedit')$edittype = "quickedit";
$have_cat = table_exists($tblname."_cat");
/**
		Danh sách sản phẩm

Tên sản phẩm-title-text-60-none-no-none-none
Mã sản phẩm-code-text-60-none-no-none-none
Nhóm sản phẩm-category-select_data-none-none-no-products_cat.name-products_cat.id
Mô tả ngắn-brief-plaintext-none-none-yes-none-none
Chi tiết sản phẩm-content-textarea-none-none-yes-none-none
Giá sản phẩm-price-text-60-none-no-none-none
Bảo hành-warranty-text-60-none-no-none-none
Xuất xứ-origin-text-60-none-no-none-none
Icon khuyến mại-icon-imageonserver-60-none-yes-none-none
Hình ảnh-image-imageonserver-60-none-yes-none-none
Ngày đăng-log-time-none-none-yes-none-none
Loại sản phẩm-avdproducts-select-none-none-no-avdproducts.type-avdproducts.id
Cấp độ-level-select-none-none-no-level.name-level.level
Ngôn ngữ-lang-select-none-none-no-languages.code-languages.id
Trạng thái-active-select-none-none-no-active.status-active.id
*/

if($tblname == 'products')
{
    $catarraystring = array();
    $getcats = get_all($tblname."_cat",""," level asc ");
    if(count($getcats))
    {
        foreach($getcats as $catitem)
        {
            if(strlen($catitem['level'])==5)$inden = "-- ";
            else if(strlen($catitem['level'])==8)$inden = "---- ";
            else $inden = "";
            $catarraystring[] = $catitem['id'].":$inden".stripslashes($catitem['name']);
        }
    }
    $scatarraystring = ":--".$strSelect."--;".implode(";",$catarraystring);
    $catarraystring = implode(";",$catarraystring);
    $idfield = 'id';//{name:'title', index:'title', editable : true,edittype:'text',editoptions: {style:'height:19px'}}, 
    $viewarray = array('id','title','code','category','image','price','warranty','origin','level','avdproducts');
    $titlearray = array('ID','Tiêu đề','Mã sản phẩm','Nhóm','Ảnh SP','Giá SP','Bảo hành','Xuất Xứ','Cấp độ','Loại sản phẩm');
    $configarrray = array(  'id'=>array("search" => "false","index"=>"id","width"=>25),
                            'title'=>     array("editable"=>"true",
                                            "index"    =>"title",
                                            "edittype" =>"text",
                                            "editoptions"=>array("style"=>"height:19px")),
                            'code'      =>array("editable"=>"true",
                                            "index"    =>"code",
                                            "edittype" =>"text",
											 "width" => 60,
                                            "editoptions"=>array("style"=>"height:19px","maxlen"=>"15")),
                            'category'  =>array("editable"=>"true",
                                            "width" => "100",
                                            "index"    =>"category",
                                            "stype"     => "select",
                                            "editoptions"=>array('value'=>$scatarraystring),
                                            "searchoptions" => array('value'=>$scatarraystring),
                                            "edittype" =>"select"),
							'image'=>     array("index"    =>"image",
                                                "search" => "false",
                                                "formatter"=>"imgView",
                                                "width"=>"40"),
							
                            'price'     =>array("editable"=>"true",
                                            "edittype"=>"text",
                                            "index"    =>"price",
                                            "width"=>"40",
                                            "align" => 'right',
                                            "formatter" => "currencyFmatter",
                                            "editoptions" => array("style"=>"height:19px","maxlen"=>"15")), 
							
							'warranty'=>     array("editable"=>"true",
                                            "index"    =>"warranty",
                                            "edittype" =>"text",
                                            "editoptions"=>array("style"=>"height:19px")),
							'origin'=>     array("editable"=>"true",
                                            "index"    =>"origin",
                                            "edittype" =>"text",
                                            "editoptions"=>array("style"=>"height:19px")),				
							'level'=>     array("index"    =>"level",
												"width"=>"50",
												"stype"     => "select",
												"editable"=>"true",
												"edittype" => "select",
												"searchoptions" => array('value'=>$levelArray),
												"editoptions" => array('value'=>$levelArray)
												),	
                            'avdproducts'      =>array("index"=>"avdproducts",
												"width"=>"50",
                                                "stype"     => "select",
												"editable"=>"true",
												"edittype" => "select",
                                                "searchoptions" => array('value'=>$avdproductsArray),
												"editoptions" => array('value'=>$avdproductsArray)
												),	
                        );
    $edittype = 'detailedit';
}
else if($tblname == 'weblinks')
{
    $idfield = 'id';//{name:'title', index:'title', editable : true,edittype:'text',editoptions: {style:'height:19px'}}, 
    $viewarray = array('id','org_name','org_web','image','level','advertising','active');
    $titlearray = array('ID','Tiêu đề','Liên kết','Hình ảnh','Mức ưu tiên','Vị trí','Trạng thái');
    $configarrray = array(  'id'=>array("index"=>"id","width"=>50),
                            'org_name'=>     array("index"    =>"org_name", "width"=>"100"),
                            'org_web'=>     array("index"    =>"org_web","formatter"=>"linkUrl"),
                            'image'=>     array("index"    =>"image",
                                                "formatter"=>"imgView",
                                                "width"=>"50",
                                                "search"=>"false"),
                            'level'=>     array("index"    =>"level"),
                            'advertising'      =>array("index"=>"advertising",
												"width"=>"120",
                                                "stype"     => "select",
												"editable"=>"true",
                                                "searchoptions" => array('value'=>$advertisingArray)
												),
                            'active'      =>array("index"=>"active",
                                                "stype"     => "select",                            
                                                "searchoptions" => array('value'=>$activeArray)
                                                )
                        );
    $edittype = 'detailedit';
}
else if($tblname == 'news' or $tblname == 'articles')
{
    $idfield = 'id';//{name:'title', index:'title', editable : true,edittype:'text',editoptions: {style:'height:19px'}}, 
    $viewarray = array('id','title','category','icon','level','log','lang','active');
    $titlearray = array('ID','Tiêu đề','Nhóm','Image','Mức ưu tiên','Thời gian nhập','Ngôn ngữ','Trạng thái');
    $configarrray = array(  'id'=>array("index"=>"id","width"=>50),
                            'title'=>     array("index"    =>"title","width"=>"300"),
                            'category'=>     array("index"    =>"category",
													"search"=>"false",
													),
                            'icon'=>     array("index"    =>"icon",
                                                "search" => "false",
                                                "formatter"=>"imgView",
                                                "width"=>"50"),
                            'level'=>     array("index"    =>"level"),
                            'log'=>     array("index"    =>"log"),
                            'lang'=>     array("index"    =>"lang"),
                            'active'      =>array("index"=>"active",
                                                "stype"     => "select",                            
                                                "searchoptions" => array('value'=>$activeArray))
                        );
    $edittype = 'detailedit';
}
else if($tblname == 'categorys')
{
    $idfield = 'id';//{name:'title', index:'title', editable : true,edittype:'text',editoptions: {style:'height:19px'}}, 
    $viewarray = array('id','title','category','area','service','discount','minimum_price','image_banner','log','lang','active');
    $titlearray = array('ID','Tiêu đề','Nhóm SP','Khu vực','Phí dịch vụ','Giá giảm','Mức giá tối thiểu','Banner','Thời gian nhập','Ngôn ngữ','Trạng thái');
    $configarrray = array(  'id'=>array("index"=>"id","width"=>50),
                            'title'=>     array("index"    =>"title","width"=>"300"),
                            'category'=>     array("index"    =>"category",
													"search"=>"false",
													"searchoptions" => array('value'=>$activeArray)
													),
							'area'=>     array("index"    =>"area","width"=>"80" ),
							'service'=>     array("index"    =>"service","width"=>"90" ),
							'discount'=>     array("index"    =>"discount","width"=>"90" ),
							'minimum_price'=>     array("index"    =>"minimum_price","width"=>"130" ),
                            'image_banner'=>     array("index"    =>"image_banner",
                                                "search" => "false",
                                                "formatter"=>"imgView",
                                                "width"=>"60"),
                            'log'=>     array("index"    =>"log"),
                            'lang'=>     array("index"    =>"lang"),
                            'active'      =>array("index"=>"active",
                                                "stype"     => "select",                            
                                                "searchoptions" => array('value'=>$activeArray))
                        );
    $edittype = 'detailedit';
}
else if($tblname == "site")
{
    $idfield = 'id';//{name:'title', index:'title', editable : true,edittype:'text',editoptions: {style:'height:19px'}}, 
    $viewarray = array('id','sitename','siteurl','background_colorbg','keywords','lang');
    $titlearray = array('ID','Tên site','Link site','background_colorbg(Meta)','Keyword(Meta)','WEB Icon','Ngôn ngữ');
    $configarrray = array(  'id'=>array("index"=>"id","width"=>50),
                            'sitename'=>     array("index"    =>"sitename","width"=>"200","search"=>"false"),
                            'siteurl'=>     array("index"    =>"siteurl","search"=>"false","width"=>"200"),
                            'background_colorbg'=>     array("index"    =>"background_colorbg","width"=>"300"),
                            'keywords'=>     array("index"    =>"keywords",
                                                "width"=>"300"),
                            'icon'=>     array("index"    =>"icon",
                                                "search" => "false",
                                                "formatter"=>"imgView",
                                                "width"=>"60"),
                            'lang'=>     array("index"    =>"lang")
                        );
    $edittype = 'detailedit';
}else if($tblname == "support_online")
{
    $idfield = 'id';//{name:'title', index:'title', editable : true,edittype:'text',editoptions: {style:'height:19px'}}, 
    $viewarray = array('id','support_name','nick_name','support_phone','support_email','active','lang');
    $titlearray = array('ID','Tên','Nick','Số điện thoại','Email','Trạng thái','Ngôn ngữ');
    $configarrray = array(  'id'=>array("index"=>"id","width"=>50),
                            'support_name'=>     array("index"    =>"support_name","width"=>"200","search"=>"false"),
                            'nick_name'=>     array("index"    =>"nick_name","width"=>"200"),
                            'support_phone'=>     array("index"    =>"support_phone","width"=>"300"),
                            'support_email'=>     array("index"    =>"support_email","width"=>"300"),
                            'active'=>     array("index"    =>"active"),
                            'lang'=>     array("index"    =>"lang")
                        );
    $edittype = 'detailedit';
}else if($tblname == "contact")
{
    $idfield = 'id';//{name:'title', index:'title', editable : true,edittype:'text',editoptions: {style:'height:19px'}}, 
    $viewarray = array('id','fullname','address','phone','email','log','content','lang');
    $titlearray = array('ID','Tên','Địa chỉ','Số điện thoại','Email','Thời gian','Nội dung','Ngôn ngữ');
    $configarrray = array(  'id'=>array("index"=>"id","width"=>50),
                            'fullname'=>     array("index"    =>"fullname","width"=>"200","search"=>"false"),
                            'address'=>     array("index"    =>"address","width"=>"200"),
                            'phone'=>     array("index"    =>"phone","width"=>"300"),
                            'email'=>     array("index"    =>"email","width"=>"300"),
                            'log'=>     array("index"    =>"log","width"=>"300"),
                            'content'=>     array("index"    =>"content","width"=>'500'),
                            'lang'=>     array("index"    =>"lang")
                        );
    $edittype = 'detailedit';
}

else if($tblname == "linkex")
{
    $idfield = 'id';//{name:'title', index:'title', editable : true,edittype:'text',editoptions: {style:'height:19px'}}, 
    $viewarray = array('id','title','linksite','aboutsite','lang');
    $titlearray = array('ID','Từ khóa','URL-Link','Mô tả liên kết','Ngôn ngữ');
    $configarrray = array(  'id'=>array("index"=>"id","width"=>50),
                            'title'=>     array("index"    =>"title","width"=>"200"),
                            'linksite'=>     array("index"    =>"linksite","width"=>"200"),
                            'aboutsite'=>     array("index"    =>"aboutsite","width"=>'500'),
                            'lang'=>     array("index"    =>"lang","search"=>"false")
                        );
    $edittype = 'detailedit';
}
?>