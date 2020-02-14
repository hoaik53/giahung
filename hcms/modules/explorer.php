<?php
if($_GET['file_type'] == 'files' || $_GET['file_type'] == 'images')
{
    $type = $_GET['file_type'];
    $getinfo = "type=up" . $type . "&stype=manager";
}
if($_GET["file_type"] == "files")$manageitem = $strFile;
if($_GET["file_type"] == "images")$manageitem = $strImage;

?>
<div class="ui-widget-content">
    <h3 class="ui-widget-header"> <?=$strManagement." &raquo; ".$manageitem?> </h3>
    <div class="ui-widget-body" id="filemanager" style="overflow: hidden; position: relative; padding: 0;">
    <iframe src="bsexplorer/browse.php?<?php echo $getinfo;?>&lang=vi" width="100%" height="500" scrolling="no" style="border: none;"></iframe>
    <div class="clear"></div>
    </div>
</div>
<br /><br />