<?php if(!defined('bcms'))die('Cannot access directly!'); ?>
<?php
/**
 * @author HocVT
 * @Modulefiles
 * admin/modules/popup_config.php
 * admin/database/popup.pdb
 * css/module_popup.css
 * @Tables
 * popup
 * popup_conf
 * 
 * 
 * 
 * 
 * if (@GetImageSize("http://www.testdomain.com/testimage.gif")) {
echo "image exists";
} else {
echo "image does not exist";
}
 * 
 */ 

$default_config = array("image"      => '',
                        "linkUrl"    => '',
                        "active"     => '0', //0-inactive,1-active
                        "showafter"  => '0',
                        "timeshow"   => '0', // (s), 0 - no auto close
                        "newtab"     => '1'  // 0 - no, 1- yes , open newtab when click on the popup
                        );
$path = $root_dir."upimages/"; //directory to save image
$msg = array();
//print_r($_POST);
$get_old_config = get_by_id("popup_conf",1);
if($_POST['act_'] == 'act_reset')
{
    $data = $default_config;
    $data['id'] = 1;
    if(!do_sql("popup_conf",$data,'update'))
        do_sql("popup_conf",$data,'insert');
    $msg[] = 'OK';
}
else if(isset($_POST['active']))
{
    $msg[] = 'Updating ...';
    $data = $_POST;
    include('classes/image_tool.php');
    $data['id'] = 1;
    if(!do_sql("popup_conf",$data,'update'))
        do_sql("popup_conf",$data,'insert');
    
    $msg[] = 'OK';
}

$data = get_by_id('popup_conf',1);

?>
<div>
    <?php if(count($msg) > 0) { ?>
    <div class="ui-widget" id="message">
        <div class="ui-state-error" style="padding: 5px 20px;">
            <div class="ui-header">
                Thông báo
            </div>
            <?=implode("<br /> &raquo; ",$msg)?>
        </div>
    </div>
    <?php } ?>
    <script type="text/javascript">
    $(document).ready(function(){
        setTimeout('$("#message").fadeOut(1500)',5000);
    });
    </script>
    <br />
    <div class="ui-widget-content" style="">
    	<h3 class="ui-widget-header" style="">Các thông số bạn có thể lụa chọn</h3>
        <div class="ui-widget-body">
            <form name="admin_popup" class="adminform" action="?module=popup_config" method="POST" enctype="multipart/form-data">
                <span class="label">Ảnh</span>
                <input class="previewable" 
					type="text" 
					name="image" 
					style="cursor: pointer; background-image:url(images/image.gif); background-position:right; background-repeat:no-repeat;width:400px;vertical-align: top;" 
					onFocus="blur()" 
					onclick="selectFile(this);" 
					value="<?= $data['image'] ?>" /> 
				<span class="del_button only_icon del_image_link" style="display:;height: 25px;vertical-align: top;"></span>
				<br clear="both"/>
				<span class="label"></span>
				<a target='_blank' class='imgpreview' href='<?= $siteURL."/".$data['image'] ?>'>
					<img src="ajax/image.php?width=50&amp;height=50&amp;cropratio=2:1&amp;image=/<?= $data['image'] ?>"  />
				</a>
				<div class="clear"></div>
                <span class="label"><?= $strUrl ?></span>
                    <input class="longinput" type="text" name="linkUrl" value="<?=$data['linkUrl']?>" />
                    <span></span>
                <div class="clear"></div>
                <span class="label"><?= $strActive ?></span>
                    <select name="active">
                        <option value="0"> <?= $strInActive ?> </option>
                        <option <?php if($data['active']==1)echo 'selected="selected"'; ?> value="1"> <?= $strActive ?> </option>
                    </select>
                <div class="clear"></div>
                <span class="label"><?= $strShowAfter ?></span>
                    <input class="longinput" type="text" name="showafter" value="<?=$data['showafter']?>" /> (s)
                    <span></span>
                <div class="clear"></div>
                <span class="label"><?= $strTimeShow; ?></span>
                    <input class="longinput" type="text" name="timeshow" value="<?=$data['timeshow']?>" /> (s) 0 - <?= $strInActive ?>
                    <span></span>
                <div class="clear"></div>
                <span class="label"><?= $strOpenNewTab ?></span>
                    <select name="newtab">
                        <option value="0"> <?= $strInActive ?> </option>
                        <option <?php if($data['newtab']==1)echo 'selected="selected"'; ?> value="1"> <?= $strActive ?> </option>
                    </select>
                    
                <div class="clear"></div>
                <input type="hidden" name="act_" />
                <div class="control">
                    <a href="javascript:void(0);" type="submit" rel="act_save" class="submit_button" ><?=$strSaveConfig?></a>
                    <a href="javascript:void(0);" type="reset" class="reset_button" ><?=$strReset?></a>
                    <a href="javascript:void(0);" type="submit" rel="act_reset" class="submit_button" ><?=$strDefault?></a>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $('.submit_button').click(function(){
                            $("input[name=act_]").val($(this).attr("rel")) ;
                            $(this).parents('form')[0].submit();
                            
                        });
                        $('.reset_button').click(function(){
                            $(this).parents('form')[0].reset();
                        });
                    });
                </script>
            </form>
        </div>
            
    </div>
    

</div><br />