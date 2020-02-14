<?php if(!defined('bcms'))die('Cannot access directly!'); ?>
<?php
//config 
require_once('quickedit_config.php');
//gen ajax
function array2str($_array,$showkey = false)
{
    if(!is_array($_array))return;
    $str = "";
    if($showkey == false)
    foreach($_array as $item)
    {
        if($item == "true" || $item == "false" )$str .= " $item ,";
        else $str .= " '$item' ,";
    }
    if($showkey == true)
    foreach($_array as $key => $value)
    {
        if($value == "true" || $value == "false" || preg_match('/^function/',$value)  )$str .= "$key : $value ,";
        else $str .= "$key : '$value',";
    }
    $str =  preg_replace("/,$/"," ",$str);
    return $str;
}
function showModel()
{
    global $idfield,$configarrray,$editarray,$viewarray;
    $str = "[";
    foreach($configarrray as $key => $value)
    {
        $str .= "\n{ name : '".$key."' ,";
        foreach($value as $skey => $svalue)
        {
            $str .= " $skey : ";
            if(!is_array($svalue))
            {
                if($svalue == "true" || $svalue == "false" || preg_match('/^function/',$svalue)  )$str .= " ".$svalue." ,";
                else $str .= "'".$svalue."',";
            }
            else $str .= "{ " .array2str($svalue,true). " } ,";
        }
        $str = preg_replace("/,$/"," ",$str);
        $str .= "},";
    }
    $str = preg_replace("/,$/"," ",$str);
    $str .= "]";
    return $str;
}
if(in_array($tblname,array('articles','news','products')))
{
    if(isset($_GET['catID']))
    {
        $havecat = ",'catID':'".$_GET['catID']."'";
    }
}
$currence = " VNĐ";
?>
<script type="text/javascript">
jQuery.extend($.fn.fmatter , {
    currencyFmatter : function(cellvalue, options, rowdata) {
    return cellvalue+"<?=$currence?>";
}
});
jQuery.extend($.fn.fmatter.currencyFmatter , {
    unformat : function(cellvalue, options) {
    return cellvalue.replace("<?=$currence?>","");
}
});
jQuery.extend($.fn.fmatter , {
    linkUrl : function(cellvalue, options, rowdata) {
    return "<a target='_blank' href='"+cellvalue+"'>"+cellvalue+"</a>";
}
});
jQuery.extend($.fn.fmatter.linkUrl , {
    unformat : function(cellvalue, options, cell) {
    return $("a",cell).attr('href');
}
});
jQuery.extend($.fn.fmatter , {
    imgView : function(cellvalue, options, rowdata) {
    return "<a target='_blank' class='imgpreview' onclick='popupImg(this)' href='/"+cellvalue+"'><img src=\"ajax/image.php?width=50&amp;height=50&amp;cropratio=2:1&amp;image=/"+cellvalue+"\"  /></a>";
}
});
jQuery.extend($.fn.fmatter.imgView , {
    unformat : function(cellvalue, options, cell) {
    return $("a",cell).attr('href');
}
});
function popupImg(obj)
{
    
}
function delSelectedRows()
  {
        row_id_s = $("#list").getGridParam('selarrrow');
        if(row_id_s.length > 0)
        {
            jQuery("#list").jqGrid('delGridRow', row_id_s ,{delData : {tblname:'<?=$tblname?>'},
                                                        afterShowForm : function ($form) {
                                                                $form.closest('div.ui-jqdialog').position({
                                                                    my: "center",
                                                                    of: window
                                                                });
                                                            }
                                                    });
        }
        else 
        {
            var mydialog = $("<div>"+$.jgrid.nav.alerttext+"</div>");
            mydialog.dialog({
                autoOpen : false,
                title : $.jgrid.nav.alertcap,
                modal : true,
                position : 'center',
                close : function(){$(this).remove();},
                buttons  :   { "OK": function() { $(this).dialog("close"); } }
            });
            mydialog.dialog('open');
        }
		
  }
function changeGroup()
  {
        row_id_s = $("#list").getGridParam('selarrrow');
        if(row_id_s.length > 0)
        {
            var bOK = $.jgrid.bs.changeGroup;
            var bCancel = $.jgrid.edit.cancel;
            var mydialog = $("<div>"+$.jgrid.bs.altChangeGroup+
                                "<br/><b>"+$.jgrid.bs.selectGroup+
                                " : </b> <span id='selectContainer'>"+
                                $.jgrid.bs.gettingGroupList+"</span><br/><span id='ajaxstatus'></span></div>");
            mydialog.children('#selectContainer').load("ajax/jqgrid_changegroup.php?action=getgroups&tblname=<?=$tblname?>");
            mydialog.dialog({
                autoOpen : false,
                title : $.jgrid.bs.changeGroup,
                position : 'center',
                modal : true,
                close : function(){$(this).remove();$('#list').trigger("reloadGrid");},
                buttons : { "<?=$strChangeCat?>" : function(){
                                                $(this).button("option","disabled",true);
                                                var toGroup = mydialog.find("#catSelect").val();
                                                //alert(toGroup);
                                                $.ajax({
                                                    url : 'ajax/jqgrid_changegroup.php',
                                                    type : "POST",
                                                    data : {"action":"changegroup",
                                                            "togroup" : toGroup,
                                                            "tblname":"<?=$tblname?>",
                                                            "ids" : row_id_s 
                                                            },
                                                    beforeSend : function(){
                                                                        mydialog.find('#ajaxstatus').html($.jgrid.defaults.loadtext);
                                                                    },
                                                    success : function($data){
                                                                        if($data == 0)
                                                                        mydialog.find('#ajaxstatus').html($.jgrid.bs.errorChange);
                                                                        else mydialog.find('#ajaxstatus').html($.jgrid.bs.saveChange);
                                                                        setTimeout(function(){mydialog.dialog('close');},500); 
                                                                    }
                                                });
                                            }, 
                            "<?=$strCancel?>" : function(){mydialog.dialog('close');}}
                
            });
            mydialog.dialog('open');
           // alert(row_id_s);
        }
            
       else 
        {
            var mydialog = $("<div>"+$.jgrid.nav.alerttext+"</div>");
            mydialog.dialog({
                autoOpen : false,
                title : $.jgrid.nav.alertcap,
                modal : true,
                position : 'center',
                width:100,
                height:100,
                close : function(){$(this).remove();},
                buttons  :   { "OK": function() { $(this).dialog("close"); } }
            });
            mydialog.dialog('open');
        }
  }
$(function(){
    var lastSel;
    $("#list").jqGrid({
        url:'ajax/jqgrid.php',
        datatype: 'json',
        mtype: 'GET',
        colNames:[<?=array2str($titlearray)?>],
        colModel : <?=showModel()?>,
        /*
     [ 
           {name:'id', index:'id', width:55}, 
           {name:'title', index:'title', editable : true,edittype:'text',editoptions: {style:'height:19px'}}, 
           {name:'log', index:'log', width:100, align:'right', 
                                     search : true ,editable : true,
                                     edittype:'text',
                                     editoptions:{
                                     dataInit: function(element) {
                                                       $(element).datepicker();
                                                                 }
    
                                                 }
            } 
         ]
     */ 
     
        ondblClickRow: function(id){
            if(id)
                { 
                    <?php if($edittype == 'quickedit') { ?>
                    jQuery('#list').jqGrid('restoreRow',lastSel); 
                    jQuery('#list').jqGrid('editRow',id,true,null,function(data){
                                                if(data.responseText == '1')
                                                {
                                                    return true;
                                                }
                                                else {
                                                    return false;
                                                }
                                               },null,{"tblname":"<?=$tblname?>"});
                    lastSel=id; 
                    <?php }
                    else if($edittype == 'detailedit') {
                        ?>
                    window.location='?module=viewrec&tblname=<?=$tblname?>&catID=<?=$_GET['catID']?>&id='+id;
                    <?php
                    } ?>
                }    
        },
        onSelectRow : function(id){
                if(id)
                { 
                    <?php if($_GET['editon'] == 'select') { ?>
                    jQuery('#list').jqGrid('restoreRow',lastSel); 
                    jQuery('#list').jqGrid('editRow',id,true,null,function(data){
                                                if(data.responseText == '1')
                                                {
                                                    return true;
                                                }
                                                else {
                                                    return false;
                                                }
                                               },null,{"tblname":"<?=$tblname?>"});
                    lastSel=id; 
                    <?php } ?>
                } 
                
        },
        height: '100%',
        loadui : 'block',
        //width:900,
        autowidth:true,
        //fixed:true,
        shrinkToFit:true,
        pager: '#pager',
        rowNum:15,
        gridview : true,
        rowList:[15,30,50,100],
        sortname: 'id',
        sortorder: 'asc',
        viewrecords: true,
        multiselect : true,
        caption: 'Bảng dữ liệu &raquo; <?=$tblname?>',
        editurl:'ajax/jqgrid_edit.php',
        postData : {'tblname':'<?=$tblname?>'<?=$havecat?>},
        //toppager:true,
        gridComplete: function(){
            $(".imgpreview").each(function(index,element){
                $(element).lightBox();
            });
            <?php if(in_array("act",$viewarray) && $edittype == 'quickedit'){ ?>
            var ids = jQuery("#list").jqGrid('getDataIDs'); 
            for(var i=0;i < ids.length;i++)
            { 
                var cl = ids[i]; 
                be = "<a href='javascript:void(0);' class='ebutton' onclick=\"jQuery('#list').editRow('"+cl+"');\" >E</a>"; 
                se = "<a href='javascript:void(0);' class='sbutton' onclick=\"jQuery('#list').saveRow('"+cl+"');\" >S</a>"; 
                ce = "<a href='javascript:void(0);' class='cbutton' onclick=\"jQuery('#list').restoreRow('"+cl+"');\" >C</a>"; 
                jQuery("#list").jqGrid('setRowData',ids[i],{act:be+se+ce});
            }
            $(".ebutton").button({
                icons : {
                        primary: "ui-icon-pencil"
                        },
                text : false
            });
            $(".sbutton").button({
                icons : {
                        primary: "ui-icon-disk"
                        },
                text : false
            });
            $(".cbutton").button({
                icons : {
                        primary: "ui-icon-arrowreturnthick-1-w"
                        },
                text : false
            });
            <?php } ?>
        }
      }); 
  //$("#list").jqGrid();
  jQuery('#list').jqGrid('filterToolbar',{stringResult:true, searchOnEnter: true,autosearch : true});
  //jQuery('#list').jqGrid('filterToolbar',{stringResult:true, searchOnEnter: true,autosearch : true});
  
  jQuery("#list").jqGrid('navGrid','#pager',{del:true,
                                                view:false,
                                                search:false,
                                                edit:false,
                                                add : false},
                                                {},
                                                {},
                                                {mtype:"POST",reloadAfterSubmit:true,
                                                    onclickSubmit: function(rowid){
                                                        var val = $('#tags').getCell(rowid, 'list_id');
                                                        return {tblname:'<?=$tblname?>'};
                                                    }
                                                } // del options
                                                );
  function getCellValue(el)
  {
        var _content = $(el).attr('id');
        if(!_content)return;
        else 
        {
            var dimention = _content;
            console.log(jQuery('#list').getCell(dimention.substr(0,dimention.indexOf("_")),dimention.substr(dimention.indexOf("_")+1,dimention.length-dimention.indexOf("_"))));
        }
  }
  
}); 
</script>
<div style="width: 100%; text-align: center; position: relative; height: 30px; vertical-align: middle;z-index: 1;">
    <div id="topcontrol" style="width: 100%; text-align: center; position: absolute;background-color: #E1E1E1;">
    <?php
    if (isset($_SESSION['userID']))
    	{
    	$allow_edit=true;
    	?>
        
    	<a href="javascript:void(0);" class="back_button" onclick="window.history.go(-1)">
    	<?php echo $strBack; ?>
    	</a>
    	<a href="javascript:void(0);" class="add_button" onclick="document.addnew.submit();">
    	<?php echo $strAdd; ?>
    	</a>
    	<a href="javascript:void(0);" class="del_button" onclick="delSelectedRows()" >
    	<?php echo $strDelete; ?>
    	</a>
        <?php if($have_cat){ ?>
        <a href="javascript:void(0);" class="edit_button" onclick="changeGroup()" >
    	<?php echo 'Đổi nhóm'; ?>
    	</a>
        <?php } ?>
        
    	<?php
    	}
    else
    	{
    	?>
    	<p class="buttontext">&nbsp;&nbsp;<?php echo $strNotice['208']; ?></p>
    	<?php
    	}
    	?>
    <span id="toggle_button" class="showcontrol" style="float: left; height: 28px;"></span>
    </div>
</div>

<table id="list"><tr><td/></tr></table> 
<div id="pager"></div> 
<form name='addnew' method="get" action="">
	<input type="hidden" name="module" value="addnew" />
	<input type="hidden" name="tblname" value="<?php echo $tblname; ?>" />
	<?php
	if (isset($_REQUEST['catID']))
		{
		?>
		<input type="hidden" name="catID" value="<?php echo $_REQUEST['catID']; ?>" />
		<?php
		}
	?>
</form>
<?php
?>