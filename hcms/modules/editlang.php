<?php
$root = "./";

if (isset($_POST['select']))
{
	$sel_php=$_POST['select'];
	//$sel_php=$_POST['select1'];
}
else
{
	$sel_php="";
}
// store template
if (isset($_POST['Submit']))
{
	$body=$_POST['inputLineEntry'];
	
	$body=stripcslashes($body);
	
	$filename="./languages/".$sel_php;
	if (is_writeable($filename))
	{
		$file=fopen($filename,'w');
		if ($file)
			fputs($file,$body);
		fclose($file);
		$dump="<table width='50%' border='0' cellspacing='5' cellpadding='0' align='center'>
				<tr>
				<td class='dump'><img src='images/alert.gif' width='16' height='16' align='absmiddle' border='0'>Thay đổi ngôn ngữ thành công!</td>
				</tr>
				</table>";
	} else {
		$dump="<table width='50%' border='0' cellspacing='5' cellpadding='0' align='center'>
				<tr>
				<td class='dump'><img src='images/alert.gif' width='16' height='16' align='absmiddle' border='0'>Language is not writeable. Please make php file (in languages folder) writeable (chmod 666)</td>
				</tr>
				</table>";
	}
}

if (isset($_POST['Revert']))
{
	$filename="./languages/".$sel_php;
	$original="./languages/langold/".$sel_php;
	if (file_exists($original))
	{
		if (@copy($original,$filename)) {
			chmod ($filename, 0666);
			$dump="<table width='50%' border='0' cellspacing='5' cellpadding='0' align='center'>
<tr>
					<td class='dump'><img src='images/alert.gif' width='16' height='16' align='absmiddle' border='0'>Language reverted to langold successfully!</td>
</tr>
</table>";
		}
		else
			$dump="table width='50%' border='0' cellspacing='5' cellpadding='0' align='center'>
					<tr>
					<td class='dump'><img src='images/alert.gif' width='16' height='16' align='absmiddle' border='0'>Language NOT reverted! (No write access)</td>
					</tr>
					</table>";
	} else
		$dump="<table width='50%' border='0' cellspacing='5' cellpadding='0' align='center'>
<tr>
				<td class='dump'><img src='images/alert.gif' width='16' height='16' align='absmiddle' border='0'>Folder langold not exists!</td>
</tr>
</table>";
}

if(isset($_POST['Backup']))
{
	$filename="./languages/".$sel_php;
	$original="./languages/langold/".$sel_php;
	if(file_exists($original))
	{
		if(@copy($filename,$original))
		{
			chmod($original,0666);
			$dump="<table width='50%' border='0' cellspacing='5' cellpadding='0' align='center'>
					<tr>
					<td class='dump'><img src='images/alert.gif' width='16' height='16' align='absmiddle' border='0'>Language Backup to folder langold successfully!</td>
					</tr>
					</table>";
		}
		else
		{
			$dump="table width='50%' border='0' cellspacing='5' cellpadding='0' align='center'>
					<tr>
					<td class='dump'><img src='images/alert.gif' width='16' height='16' align='absmiddle' border='0'>Language NOT backuper! (No write access)</td>
					</tr>
					</table>";
		}	
	}
	else
	{
		$dump="<table width='50%' border='0' cellspacing='5' cellpadding='0' align='center'>
				<tr>
				<td class='dump'><img src='images/alert.gif' width='16' height='16' align='absmiddle' border='0'>Folder langold not exists!</td>
				</tr>
				</table>";
	}
}
//Lang for Website
$templs=array();
				$dir = "./languages";
				// Open a known directory, and proceed to read its contents
				if (is_dir($dir)) {
					if ($dh = opendir($dir)) {
						while (($file = readdir($dh)) !== false) {

							if (substr($file,strrpos($file,'.'))=='.php')
									$templs[]=$file;
						}
						closedir($dh);
					}
				}
				sort($templs);

for ($i=0; $i<count($templs); $i++){
	if ($templs[$i]==$sel_php) {
		$templates.='<option value="'.$templs[$i].'" selected>'.$templs[$i].'</option>';
	}
	else
	{
		$templates.='<option value="'.$templs[$i].'">'.$templs[$i].'</option>';
	}
}

if ($sel_php<>""){
      $filename=$root."languages/".$sel_php;
      $body=file_get_contents($filename);
      $body=htmlspecialchars($body);
	}
else{
	$submit_disable='disabled';
}
if(count($dump) > 0) { ?>
    <div class="ui-widget" id="message">
        <div class="ui-state-error" style="padding: 5px 20px;">
            <div class="ui-header">
                <?=$strMessage?>
            </div>
            <?=$dump?>
        </div>
    </div>
    <?php } ?>
    <script type="text/javascript">
    $(document).ready(function(){
        setTimeout('$("#message").slideUp(1500)',3000);
    });
    </script>
<div class="ui-widget-content">
    <h3 class="ui-widget-header"> <?=$strEdit." ".$strLanguage?> </h3>
      <script>
      $(document).ready(function(){
        var editor = CodeMirror.fromTextArea(document.getElementById("inputLineEntry"), {
            lineNumbers: true,
            matchBrackets: true,
            mode: "application/x-httpd-php",
            indentUnit: 4,
            indentWithTabs: true,
            enterMode: "keep",
            tabMode: "shift"
          });
      });
          
        </script>
      <form name="form1" id="form1" method="post">
	  <fieldset>
        <legend><img src="images/file_32.gif" width="32" height="32" align="absmiddle" /> Lựa chọn ngôn ngữ :</legend>
	   <div class="tabele">
      <p> Ngôn ngữ Front-end BCMS V3.1 :
          <select name="select" class="textfield2">
    	  <?php echo $templates; ?>
    	  </select>

        <input name="SeleTempl" type="submit" class="button" onClick="action='?module=editlang'" value="Xem" />
	  </p>
	  </div><br />
     </fieldset>
		<br />
	<fieldset><legend><img src="images/edit_32.gif" width="32" height="32" align="absmiddle" /> Chỉnh sửa ngôn ngữ:</legend>
        <textarea style="width: 100%; height: 400px; border: 1px solid #D9D9D9;background-color: #F7F7F7;" id="inputLineEntry" name="inputLineEntry" wrap="on" cols="80" rows="25"><?php echo $body; ?></textarea>
        <div><br /><input type="button" value="<?=$strSelect." ".$strAll?>" class="button" onClick="javascript:this.form.inputLineEntry.focus();this.form.inputLineEntry.select();">

                   <input type="submit" name="Submit" value="<?=$strSaveChange?>" class="button" <?php echo $submit_disable; ?> />
		     &nbsp;&nbsp;<input type="submit" name="Revert" value="<?=$strRestoreLang?>" class="button" <?php echo $submit_disable; ?> onclick="cf=confirm('<?=$strRsCf?>');if (cf) return true; return false;" />
			&nbsp;&nbsp;<input type="submit" name="Backup" value="<?=$strBackupLang?>" class="button" <?php echo $submit_disable; ?> onclick="cf=confirm('<?=$strBkCf?>'); if(cf) return true; return false;" />
		</div>
	</fieldset>
    </form>
    <div class="clear"></div>
    </div>
</div>