<?php 
///////////////showchangepic
$showchangepic = false;
if(in_array($tblname,array('galleries')))
$showchangepic = true;
////////////////////////////
/////////////////////showchangeurl
$showchangeurl = false;
if(in_array($tblname,array('news')))
$showchangeurl = true;
//////////////////////
 ?>
<div class="ui-widget-content">
    <h3 class="ui-widget-header"> <?=$strEditDetail?> </h3>
    <div class="ui-widget-body adminform">
        <form name="addsub" method="post" action="" style="" onsubmit="return add_cate();">
        	<input type="hidden" name="level" />
        	<input type="hidden" name="action" value="addsub" />
        	<input type="hidden" name="tblname" value="<?php echo $_REQUEST['tblname']; ?>" />
                  <span class="label"><?php echo $strName; ?> :</span> 
                  <input type="text" name="subname" class="longinput" />
                  <div class="clear"></div><?php if($showchangepic){ /////////////////////showchangepic ?>
                  <span class="label"><?php echo $strImage; ?> :</span> 
                  <input type="text" name="new_pic" class="longinput" onFocus="blur()" onClick="show_popup('<?php echo $_SESSION['language']; ?>','images','<?php echo $_GET['tblname']; ?>',this.form.name,this.name)" />
                  <div class="clear"></div><?php } ?><?php if($showchangeurl){ /////////////////////showchangeurl ?>
                  <span class="label"><?php echo $strUrl; ?> :</span> 
                  <input type="text" name="new_url" class="longinput" />
                  <div class="clear"></div>
                  <span class="label" style="vertical-align: top;"> <?=$strDescription?> </span><span style="display: inline-block; padding: 5px 2px;"><textarea class="bseditor"></textarea></span>
                  <div class="clear"></div><?php } ?>
                  <p class="bigtitle" style="margin-top: 12px; margin-bottom: 12px;">
                    <input type="submit" class="button" style="cursor:pointer;" name="Submit" value="<?php echo $strAdd; ?> " />
        			&nbsp;&nbsp;&nbsp;
        			<input type="button"  class="button" style="cursor:pointer;" name="Cancel" value="<?php echo $strBack; ?> " onClick="window.history.back(-1);" />
                  </p>
                  
        </form>
        <div class="clear"></div>
    </div>
</div>
