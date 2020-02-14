<?php if (substr_count($_SERVER['PHP_SELF'],'/categories.php')>0) die ("You can't access this file directly..."); ?>
<form name="temp" method="post" action="categories.php">
</form>
<input type="hidden" id="rowId" />
<input type="hidden" id="tempId" />
<table style="width: 100%;" cellpadding="0" cellspacing="0">
<?php
$system_tbl=array('users','user_group');
if (isset($_REQUEST['tblname']) and !in_array($_REQUEST['tblname'],$system_tbl))
	{
	$tblname=$_REQUEST['tblname'];
	$msg='';	
	$redirect ='<script>';
	$redirect.='setTimeout(\'window.location.replace("index.php")\',3000);';
	$redirect.='</script>';
		?>	
	  	<tr align="center" valign="top">
        <td colspan="3" align="center" valign="top">
		<table style="width: 100%;" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top">
			<form name="viewtbl" method="post" action="viewtbl.php">
			<input type="hidden" name="tblname" value="<?php echo $tblname; ?>" />
			<input type="hidden" name="catname" value="" />
			<input type="hidden" name="catID" value="" />
			</form>
			<script language="javascript" type="text/javascript">
			function browsecat(cname,cid)
				{
				document.viewtbl.catname.value=cname;
				document.viewtbl.catID.value=cid;
				document.viewtbl.submit();
				}
			</script>
			<form name="tree" method="post" action="" onSubmit="return accept();" style="display: block;">
			<input type="hidden" name="action" value="changename" />
			<input type="hidden" name="level" />
			<input type="hidden" name="hotnews" />
			<table style="width: 100%;" cellspacing="0" cellpadding="0">
			  <tr>
				<td align="center" valign="top" style="border-left: solid 0px #336699; border-right: solid 0px #336699;">
				<table id="mainTable" cellpadding="0" cellspacing="0" style="width: 100%;">
				<?php
				if ($_SESSION['usergroup']<2)
					{
					?>
					<tr><td>
					<span class="treetext" style="cursor: pointer;" onClick="addsubitem('0');"><img src="images/paste_plain.gif" alt="" />&nbsp;<?php echo $strAdd.' '.$strCategory; ?></span>&nbsp;&nbsp;
					<?php
					}
				?>
				<span class="treetext" style="cursor: pointer;" onClick="window.location='?module=addnew&tblname=<?php echo $tblname; ?>'"><img src="images/page_white_text.gif" alt="" />&nbsp;<?php echo $strAdd.' '.$strRecord; ?></span>
				</td></tr>
				
				<tr><td style="border-top: solid 1px #CCCCCC; height: 10px;">&nbsp;</td></tr>
				<?php
				$tree ='select * from '.$tblname.'_cat';
				$tree.=' where lang="'.get_langID().'"';
				switch ($_SESSION['usergroup'])
					{
					case '1':
					case '2':
					$tree.=' and level like "%"';
					break;
					
					case 3:
					case 4:
					$tree.=' and level like "02.%"';
					break;
					
					default:
					$tree.=' and level like "04.%"';
					break;
					}
				$tree.=' order by level ASC';
				$dotree=mysql_query($tree,$link);
				if ($dotree and mysql_num_rows($dotree)>0)
					{
					$i=0;
					while ($result=mysql_fetch_array($dotree))
						{
						$id_array[$i]=$result['id'];
						$name_array[$i]=$result['name'];
						$level_array[$i]=$result['level'];
						$hotnews_array[$i]=$result['new'];
						$path[$i]=str_replace('.','',$result['level']);
						$pos[$i]=substr($path[$i],-2,2);
						//echo $pos[$i].'<br>';
						$level[$i]=substr_count($level_array[$i],'.')+1;
						if ($level[$i]==1)
							{
							$type_array[$i]='parent';
							$group[$i]='root';
							}
						else
							{
							$type_array[$i]='child';
							$group[$i]=substr($path[$i],0,2*($level[$i]-1));
							}
						$i++;
						}
					$i=0;
					$rows=mysql_num_rows($dotree);
					$row_count=0;
					while (isset($id_array[$i]))
						{	
						$indent='';
						$isparent=false;
						for ($x=1;$x<=$level[$i];$x++)
							{
							$indent.= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							}
						if ($type_array[$i]=='parent')
							{
							$isparent=true;
							$image="folder.gif";
							}
						else
							{
							$image='text.gif';
							}
						?>
						<TR id="<?php echo $id_array[$i]; ?>">
						
						<TD><p class="treetext">
						<?php
						echo $indent;
						?>
						<span id="bobcontent<?php echo $i+1; ?>-title" class="handcursor" style="cursor:pointer;"><img src="images/<?php echo $image; ?>" style="cursor:pointer;" hspace="3" alt="" /></span>
						<input class="invisible" type="text" value="<?php echo $name_array[$i]; ?>" id="<?php echo $id_array[$i]; ?>"  name="item<?php echo $id_array[$i]; ?>" onFocus="javascript: this.style.border='solid 1px #336699';" onBlur="javascript: this.style.border='solid 0px #F4F6F4';this.style.bgcolor='#FFFFFF';" />
						
						<div id="bobcontent<?php echo $i+1; ?>" class="switchgroup1">
						<table align="center" cellpadding="0" style="border: solid 1px #FFCC00; width: 800px; height:auto; background-color: #F7F7F7;">
						<tr>
						<TD align="center" onclick="window.location='?module=viewtbl&SID=<?php echo session_id(); ?>&tblname=<?php echo $tblname; ?>&catname=<?php echo $name_array[$i]; ?>&catID=<?php echo $id_array[$i]; ?>'" class="button_off" onMouseOver="this.className='button_over';" onMouseOut="this.className='button_off';">&raquo; <?php echo $strView; ?></TD>
						
						<?php
						if ($_SESSION['usergroup']<2)
							{?>
							<TD align="center" onClick="addsubitem('<?php if ($level[$i]<$limit_menu_level) echo $level_array[$i]; else echo '&nbsp;'; ?>');" class="button_off" onMouseOver="this.className='button_over';" onMouseOut="this.className='button_off';">
							&raquo; <?php echo $strAdd.' '.$strSubCategory; ?></TD>
						
							<TD align="center" onClick="del('<?php echo $level_array[$i]; ?>')" class="button_off" onMouseOver="this.className='button_over';" onMouseOut="this.className='button_off';">
							<?php echo $strDelete; ?></td>
							

							<TD class="title3" style="text-align: center;" align="center" onMouseOver="change(this,'#F4F6F4');" onMouseOut="undo(this);">
							<?php echo $strChangePos; ?> 
							<select name="<?php echo str_replace('.','',$level_array[$i]); ?>" onChange="changepos('<?php echo $level_array[$i]; ?>')">
							<?php
							$a=0;
							while (isset($pos[$a]))
								{
								if ($group[$a]==$group[$i])
									{
									echo '<option value="'.$pos[$a].'"';
									if ($pos[$a]==$pos[$i])
										echo ' selected="selected"';
									echo '> '.$pos[$a].' </option>';
									}
								$a++;
								}
							?>
							</select>
							</TD>

							<?php
							if ($level[$i]>1)
							{
							?>
							<TD valign="middle" class="title3" style="text-align: center" align="center" onMouseOver="change(this,'#F4F6F4');" onMouseOut="undo(this);">
							<?php echo $strChangeLevel; ?>
							<?php
							if ($group[$i]!='root')
								{
								?>
								<select name="clevel<?php echo str_replace('.','',$level_array[$i]); ?>" onChange="changelevel('<?php echo $level_array[$i]; ?>');">
								<?php
								for ($a=1;$a<=$level[$i];$a++)
									{
									echo '<option value="'.$a.'"';
									if ($a==$level[$i])
										echo 'selected="selected"';
									echo '> '.$a.' </option>';
									}
								}
							else
								echo '&nbsp;';
							}
							if ($_SESSION['usergroup']<2)
								{
								?>
								<TD colspan="5" class="title3" align="left" onMouseOver="change(this,'#F4F6F4');" onMouseOut="undo(this);">
								<?php echo $strChangeCat; ?> <select name="cgroup<?php echo str_replace('.','',$level_array[$i]); ?>" onChange="changegroup('<?php echo $level_array[$i]; ?>')">
								<?php
								$a=0;
								while (isset($id_array[$a]))
									{
									if ($level[$a]<$limit_menu_level and $level[$a]<=$level[$i])
										{
										echo '<option value="'.$level_array[$a].'"';
										if ($path[$a]==$path[$i])
											echo ' selected="selected"';
										echo '> '.$name_array[$a].' </option>';
										}
									$a++;
									}
								?>
								</select>
								</TD></tr>
								<?php
								}
							}
						?>
						</table>
						<?php
						$i++;
						}
					}
				?>
				</div>
				</table>
				</td>
			  </tr>
			  <tr><td style="border-left: solid 0px #336699; border-right: solid 0px #336699; border-bottom: solid 0px #336699;">
				<p class="bigtitle" style="margin-top: 12px; margin-bottom: 6px;">
				<input type="submit" style="cursor:pointer;" name="Save" value=" <?php echo $strSaveChange; ?> " />
				&nbsp;&nbsp;&nbsp;
				<input type="reset" style="cursor:pointer;" name="Reload" value=" <?php echo $strReset; ?> ()" />
				</p></td></tr>
			</table>
			</form>
			</td>
          </tr>
        </table></td>
      </tr>
      <?php
	  }
?>
</table>