<?php if (substr_count($_SERVER['PHP_SELF'],'/mailing_list.php')>0) die ("You can't access this file directly..."); ?>
<script type=text/javascript>
function init() 
	{
	myFlipFlop = new Bs_FlipFlop();
	myFlipFlop.fieldAvailableCssClass = 'flipFlopField';
	myFlipFlop.fieldSelectedCssClass  = 'flipFlopField';
	myFlipFlop.showCaptionLine        = false;
	myFlipFlop.convertField('mySelect');
	}

function del_group()
{
if (confirm('Ban dang chon xoa nhom user ! Xin xac nhan bang cach click\n\n              OK [= CO]          CANCEL [= KHONG] !'))
	if (confirm('Ban co chac la ban muon xoa nhom nay khong ?'))
		if (confirm('Xin xac nhan lai lan cuoi !'))
			{	
			//document.group4del.action='delete';
			document.group4del.submit();
			}
}
function setdisplay(frmname, act)
{
if (eval(frmname + '.style.display')=='none')
	eval(frmname + '.style.display="";');
else
	eval(frmname + '.style.display="none";');

switch(act)
	{
	case 'new':
	eval('document.' + frmname + '.group_name.value="";');
	eval('document.' + frmname + '.group_desc.value="";');
	eval('document.' + frmname + '.action.value="new";');
	break;
	
	case 'edit':
	eval('document.' + frmname + '.group.value=document.exist_value.gid.value;');
	eval('document.' + frmname + '.group_name.value=document.exist_value.gname.value;');
	eval('document.' + frmname + '.group_desc.value=document.exist_value.gdesc.value;');
	eval('document.' + frmname + '.action.value="edit";');
	break;
	
	case 'change':
	eval('document.' + frmname + '.group.value=document.exist_value.gid.value;');
	eval('document.' + frmname + '.action.value="change";');
	break;
	}
}
</script>
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<table width="95%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="5">&nbsp;</td>
		<td align="center" valign="top">
		<table width="95%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top">
			
			<table width="80%" border="0" cellpadding="0" cellspacing="0" background="">
				  <tr>
				  <td height="40" colspan="3" align="center" valign="middle">
				  <?php
					$allow_edit=false;
					$view='select * from mail_groups';
					$view.=' where author = "'.$_SESSION['userID'].'"';
					$view.=' order by id ASC';	
					$doview=mysql_query($view,$link);
					if ($doview and mysql_num_rows($doview)>0)
						{
						$return_rows=mysql_num_rows($doview);
						$id_array=array($return_rows);
						$author_array=array($return_rows);
						$name_array=array($return_rows);
						$list_array=array($return_rows);
						$desc_array=array($return_rows);
						$i=0;
						while ($result=mysql_fetch_array($doview))
							{
							$id_array[$i]=$result['id'];
							$author_array[$i]=$result['author'];
							$name_array[$i]=$result['name'];
							$list_array[$i]=$result['list'];
							$desc_array[$i]=$result['description'];
							if (isset($_POST['group']) && $id_array[$i]==$_POST['group'])
								{
								$cur_group=$name_array[$i];
								$cur_desc=$desc_array[$i];
								$cur_list=$list_array[$i];
								}
							$i++;
							}
						}
					?>
				  <table width="95%" height="30" border="0" cellpadding="2" cellspacing="2">
				  <tr>
					<td bgcolor="#E1E1E1">&nbsp;</td>
					<td width="500" onClick="" style="border: 1px solid #E1E1E1">
					<form name="viewgroup" style="margin: 0;" method="post" action="">
					<p class="buttontext"> <?php echo $strCategoryEmail; ?> :
					<select name="group" style="padding: 6; Font-family: Tahoma; Font-size: 11; border: solid 1px #EEEEEE">
					<option value=""><?php echo $strAlls; ?></option>
					<?php
					$j=0;
					while (isset($id_array[$j]))
						{
						echo '<option value="'.$id_array[$j].'"';
						echo '>';
						echo $name_array[$j].'</option>';
						$j++;
						}
					?>
					</select>
					&nbsp;
					<input type="button" onClick="javascript: document.viewgroup.submit();" style="background-color: #F7F7F7; font-color: #FFFFFF;" value=" Xem " onMouseOver="changebd(this,'#336699')" onMouseOut="undobd(this)">
					</p></form></td>
					<!--
					<td width="70" onClick="javascript: document.viewgroup.submit();" style="cursor: hand; border: 1px solid #E1E1E1" onMouseOver="changebd(this,'#336699')" onMouseOut="undobd(this)">
					<p class="buttontext"><img align="absmiddle" src="images/view.gif" width="22" height="22">
					&nbsp;&nbsp;Xem</p></td>
					-->
						<?php
						if ($_SESSION['usergroup']==1)
							{
							$allow_edit=true;
							$allow_delete=false;
							?>
							<td width="70" onClick="setdisplay('new_group','new');" style="cursor: hand; border: 1px solid #E1E1E1" onMouseOver="changebd(this,'#336699')" onMouseOut="undobd(this)">
							<p class="buttontext"><img align="absmiddle" src="images/filenew.gif" width="25" height="22">
							&nbsp;&nbsp;<?php echo $strCreatNew; ?></p></td>
							<?php
							if (isset($_POST['group']) && $_POST['group']!='')
								{
								$getvalue='select * from mail_groups where id="'.$_POST['group'].'" limit 0,1';
								$doget=mysql_query($getvalue,$link);
								if ($doget && mysql_num_rows($doget)==1)
									{
									$value=mysql_fetch_array($doget);
									echo '<form name="exist_value" style="display: none">';
									echo '<input type="hidden" name="gdesc" value="'.$value['description'].'">';
									echo '<input type="hidden" name="gname" value="'.$value['name'].'">';
									echo '<input type="hidden" name="gid" value="'.$_POST['group'].'">';
									echo '</form>';
									}
								?>
								<td width="70" onClick="setdisplay('new_group','edit');" style="cursor: hand; border: 1px solid #E1E1E1" onMouseOver="changebd(this,'#336699')" onMouseOut="undobd(this)">
								<p class="buttontext"><img align="absmiddle" src="images/edit.gif" width="22" height="22">
								&nbsp;&nbsp;<?php echo $strEdit; ?></p></td>
								<td width="70" onClick="del_group();" style="cursor: hand; border: 1px solid #E1E1E1" onMouseOver="changebd(this,'#336699')" onMouseOut="undobd(this)">
								<form style="display: none" name="group4del" method="post" action="">
								<input type="hidden" name="group" value="<?php echo $_POST['group']; ?>">
								<input type="hidden" name="action" value="delete">
								</form>
								<p class="buttontext"><img align="absmiddle" src="images/cancel.gif" width="22" height="22">
								&nbsp;&nbsp;<?php echo $strDelete; ?></p></td>
								<?php
								}
							}
						else
							{
							?>
							<td width="400" style="cursor: hand; border: 1px solid #E1E1E1" onMouseOver="changebd(this,'#336699')" onMouseOut="undobd(this)">
							<p class="buttontext">&nbsp;&nbsp;<?php echo $strAcceptInfo; ?></p></td>
							<?php
							}
						?>
						<td bgcolor="#E1E1E1">&nbsp;</td>
					</tr>
				  	</table>
				 	</td>
				  </tr>
				  
				  <tr><td align="center" valign="top" colspan="3">
				  <?php
				  if (isset($_POST['action']))
				  	{
					$error=0;
					$msg='';
					$action=$_POST['action'];
					switch ($action)
						{
						case 'new':
						if (checkdata('mail_groups','name',$_POST['group_name'])==0)
							{
							$msg.='Tạo nhóm mới <br>';
							$query='insert into mail_groups(name,author,list,description) values("'.$_POST['group_name'].'","'.$_SESSION['userID'].'","","'.$_POST['group_desc'].'")';
							}
						else
							{
							$error+=1;
							$msg.=$error_code['exsistdata'];
							}
						break;
						
						case 'edit':
						if (checkdata('mail_groups','id',$_POST['group'])==1)
							{
							$msg.='Cập nhật thông tin nhóm : ';
							$msg.= ' <font color="#FF5500">'.$cur_group.'</font><br>';
							$query='update mail_groups set name="'.$_POST['group_name'].'"';
							$query.=', description="'.$_POST['group_desc'].'"';
							$query.=' where id="'.$_POST['group'].'"';
							}
						else
							{
							$error+=1;
							$msg.=$error_code['noexsistdata'];
							}
						break;
						
						case 'delete':
						if (checkdata('user_groups','id',$_POST['group'])==1)
							{
							$msg.='Xóa thông tin nhóm : ';
							$msg.= ' <font color="#FF5500">'.$cur_group.'</font><br>';
							$query='delete from mail_groups ';
							$query.=' where id="'.$_POST['group'].'" and author="'.$_SESSION['userID'].'"';
							}
						else
							{
							$error+=1;
							$msg.=$error_code['noexsistdata'];
							}
						break;
						
						case 'change':
						$select=$_POST['mySelect'];
						$newlist='';
						$i=0;
						$idcount=0;
						while (isset($select[$i]))
							{
							if  ($select[$i]!='')
								{
								$idcount++;
								if ($idcount>1)
									$newlist.=',';
								$newlist.=$select[$i];
								}
							$i++;
							}
						
						if (checkdata('mail_groups','id',$_POST['group'])==1)
							{
							$msg.='Cập nhật thông tin nhóm : ';
							$msg.= ' <font color="#FF5500">'.$cur_group.'</font><br>';
							$query='update mail_groups set list="'.$newlist.'"';
							$query.=' where id="'.$_POST['group'].'"';
							}
						else
							{
							$error+=1;
							$msg.=$error_code['noexsistdata'];
							}
						break;
						
						}
					
					if (isset($query))
						{
						//echo $query;
						if (mysql_query($query,$link))
							{
							$msg.='Thông tin được cập nhật thành công !<br><br>';
							}
						else
							{
							$msg.=$error_code['querynorun'];
							}
						}
					else
						{
						$msg.='<br>Không thể cập nhật thông tin !<br>';
						}
					$msg.='<script>';
					$msg.='setTimeout(\'window.location.replace("?module=mailing_list")\',3000);';
					$msg.='</script>';
					echo '<p class="bigtitle"><br>'.$msg.'</p>';
					//echo $action;
					}
					?>
				  <br>
				  <form name="new_group" method="post" action="" style="display: none" enctype="multipart/form-data">
				  <input type="hidden" name="action" value="">
				  <input type="hidden" name="group" value="">
					<table width="70%" border="0" cellspacing="0" cellpadding="0" style="border: solid 1px #336699">
					  <tr>
						<td width="30%" colspan="3" bgcolor="#FFCC33">
						<p class="bigtitle">:: <?php echo $strCreatNewEdit; ?> ::</p></td>
					  </tr>
					  <tr>
						<td width="25%"><p class="formtitle"><?php echo $strCategoryName; ?></p></td>
						<td width="5%">&nbsp;</td>
						<td width="70%"><input type="text" class="mediuminput" name="group_name"></td>
					  </tr>
					  <tr>
						<td width="25%" valign="top"><p class="formtitle"><?php echo $strDesc; ?></p></td>
						<td width="1">&nbsp;</td>
						<td width="70%">
						<TEXTAREA onkeypress="return taLimit()" onkeyup="return taCount(myCounter)" name="group_desc" rows="7" wrap="physical" cols="40" maxLength="255"></TEXTAREA> 
                        <p class="formindex"><?php echo $strMaxCharSize; ?><B><SPAN 
                        id=myCounter> 255 </SPAN></B> <?php echo $strChar; ?> ...</p>
						</td>
					  </tr>
					  <tr>
						<td width="30%" colspan="3">
						<p class="bigtitle">
						<input type="submit" class="submit" value="&nbsp;&nbsp;Tạo&nbsp;&nbsp;">
						&nbsp;&nbsp;&nbsp;
						<input type="submit" class="reset" value="Reset">
						</p></td>
					  </tr>
					</table>
					</form>
				  </td></tr>
				 
				  <tr align="center" valign="top">
					<td colspan="3" align="center" valign="top">
					<table width="80%" cellspacing="0" cellpadding="0">
					  <?php
						if (isset($_POST['group']))
							{
							?>
							<tr>
							<td><p class="grouptitle">Đang xem danh sách Email: 
							<?php
							if (isset($cur_group,$cur_desc,$cur_list))
								{
								$list_array=explode(',',$cur_list);
								$l=0;
								$list='';
								$counter=0;
								while (isset($list_array[$l]) && $list_array[$l]!='')
									{
									if ($l>0)
										$list.=',';
									$list.='"'.$list_array[$l].'"';
									$l++;
									$counter++;
									}
								//echo $list;	
								echo ' <font color="#FF5500">'.$cur_group.'</font>';
								echo ' <font size="1px">( '.$counter.' email';
								if ($counter>1)
									echo 's';
								echo ' )</font>';
								echo '</p>';
								echo '<p class="formindex" style="margin: 0; margin-left: 6; text-align: justify;"><b>'.$strDesc.' :</b> '.$cur_desc.'</p>';
								}
							?>
							</td>
							</tr>
							
							<?php
							if (isset($_POST['group']) && $_POST['group']!='')
								{
								?>
								<tr>
								<td align="center">
								<form name="edit_list" method="post" action="" style="display: none;">
								  <input type="hidden" name="action" value="">
								  <input type="hidden" name="group" value="">
									<table width="80%" border="0" cellspacing="0" cellpadding="0" style="border: solid 1px #336699">
									  <tr>
										<td width="30%" bgcolor="#FFCC33">
										<p class="bigtitle">:: <?php echo $strListChange; ?> ::</p></td>
									  </tr>
									  <tr>
										<td><p class="formtitle" style="padding: 3"><?php echo $strCategoryEmail; ?>
										<?php
										echo ' <font color="#FF5500">'.$cur_group.'</font>';
										echo ' <font size="1px">( '.$counter.' email';
										if ($counter>1)
											echo 's';
										echo ' )</font>';
										?>
										</p></td>
										</tr>
									  <tr>
										<td valign="top">
										  <?php
											//Danh sach toan bo contact cua User
											$full='select * from contacts where author="'.$_SESSION['userID'].'" order by id ASC';
											$dofull=mysql_query($full,$link);
											$counter=1;
											if ($dofull and mysql_num_rows($dofull)>0 and isset($cur_list))
												{
												$listid_array=explode(',',$cur_list);
												?>
												<p align="center">
												<SELECT id="mySelect" multiple size="10" name="mySelect">
												<?php
												while ($result=mysql_fetch_array($dofull))
													{
													echo '<option value="'.$result['id'].'"';
													for ($i=0; $i<=count($listid_array); $i++)
														{
														if (isset($listid_array[$i]) and $listid_array[$i]==$result['id'])
															echo ' selected';
														}
													echo '>';
													echo $result['Name'].' - '.$result['EmailAddress'];
													echo '</option>';
													}
												?>
												</SELECT></p>
												<?php
												}
											?>
										  
										</td>
										</tr>
									  <tr>
										<td width="30%">
										<p class="bigtitle">
										<input type="submit" class="submit" value="&nbsp;&nbsp;Tạo&nbsp;&nbsp;">
										&nbsp;&nbsp;&nbsp;
										<input type="submit" class="reset" value="Reset">
										</p></td>
									  </tr>
									</table>
									</form>
								</td>
								</tr>
								<?php
								}
							?>
							
							<tr>
								<td width="100%">
								<table width="100%" height="30" border="0" cellpadding="2" cellspacing="2">
								  <tr>
									<td bgcolor="#E1E1E1">&nbsp;</td>
									<td width="90" onClick="javascript: document.data_table.submit();" style="cursor: hand; border: 1px solid #E1E1E1" onMouseOver="changebd(this,'#336699')" onMouseOut="undobd(this)">
									<p class="buttontext"><img align="absmiddle" src="images/mail.gif" width="22" height="22">
									&nbsp;&nbsp;Gửi Email</p>
									</td>
									<?php
								if (isset($_SESSION['userID']))
									{
									$allow_edit=true;
									?>
									<td width="90" onClick="window.location='?contact';" style="cursor: hand; border: 1px solid #E1E1E1" onMouseOver="changebd(this,'#336699')" onMouseOut="undobd(this)">
									  <p class="buttontext"><img align="absmiddle" src="images/filenew.gif" width="22" height="22">
									  &nbsp;&nbsp;<?php echo $strCreatNew; ?></p>
									</td>
									<td width="120" onClick="setdisplay('edit_list','change');" style="cursor: hand; border: 1px solid #E1E1E1" onMouseOver="changebd(this,'#336699')" onMouseOut="undobd(this)">
									  <p class="buttontext"><img align="absmiddle" src="images/move_user.gif" width="22" height="22">
									  &nbsp;&nbsp;<?php echo $strGroupMove; ?></p>
									</td>
									<td width="70" style="cursor: hand; border: 1px solid #E1E1E1" onMouseOver="changebd(this,'#336699')" onMouseOut="undobd(this)">
									<p class="buttontext"><img align="absmiddle" src="images/cancel.gif" width="22" height="22"> &nbsp;&nbsp;<?php echo $strDelete; ?></p>
									</td>
									<?php
									}
								else
									{
									?>
									<td width="90" style="cursor: hand; border: 1px solid #E1E1E1" onMouseOver="changebd(this,'#336699')" onMouseOut="undobd(this)">
									  <p class="buttontext">&nbsp;&nbsp;<?php echo $strAcceptInfo; ?></p>
									</td>
									<?php
									}
									?>
								  <td bgcolor="#E1E1E1">&nbsp;</td>
								  </tr>
								</table></td>
								</tr>
								<!--<tr>
								<td><p class="formtitle">
								&nbsp;Danh sch Email :
								</p></td>
								</tr>-->
								<tr>
								<td align="center" valign="top">
								
								<!-- Data Table -->
								<?php
								//Khai bao thong tin bang
								$title=array('<input name="cbxSelectAll" style="display: ; margin: 0;" type="checkbox" onclick="javascript: checkAll(this.form);">',
										'ID',
										'Tên','Công ty','Địa chỉ Công ty','E-mail',
										'Đ.T c.ty','Fax c.ty','Di động',
										'Đ.T nhà','Chức vụ','Địa chỉ nhà riêng','Ghi chú',
										'FirstName','LastName','MiddleName','Nickname',
										'HomeStreet','HomeCity','HomePostalCode','HomeState',
										'HomeCountryRegion','HomeFax','PersonalWebPage',
										'BusinessStreet','BusinessCity','BusinessPostalCode',
										'BusinessState','BusinessCountryRegion','BusinessWebPage',
										'Pager','Department'
										);
								$var_array=array('id',
										'id',
										'Name','Company','OfficeLocation','EmailAddress',
										'BusinessPhone','BusinessFax','MobilePhone',
										'HomePhone','JobTitle','Address','Notes',
										'FirstName','LastName','MiddleName','Nickname',
										'HomeStreet','HomeCity','HomePostalCode','HomeState',
										'HomeCountryRegion','HomeFax','PersonalWebPage',
										'BusinessStreet','BusinessCity','BusinessPostalCode',
										'BusinessState','BusinessCountryRegion','BusinessWebPage',
										'Pager','Department'
										);
								$dimension=array(25,
										25,
										120,120,200,200,
										80,80,80,
										80,120,200,200,
										120,120,120,120,
										120,120,60,60,
										60,80,200,
										120,120,60,
										60,60,200,
										120,120
										//*/
										);
								$bordercolor='#336699';
								$titlecolor='#FFCC33';
								$hightlightcolor='#EEEEEE';
								$div_height=300;
								$tbl_width=0;
								$s=0;
								while (isset($dimension[$s]))
									{
									$tbl_width+=$dimension[$s];
									$s++;
									}
								?>
								<DIV style="WIDTH: 770px; HEIGHT: <?php echo $div_height;?>px; OVERFLOW: auto; border: solid 1px <?php echo $bordercolor; ?>">
								<form name="viewcontact" style="margin: 0;" method="post" action="contact.php">
								<input type="hidden" name="contactID" value="">
								</form>
								<script language="JavaScript">
								function view(groupid)
								{
								document.viewgroup.group.value=groupid;
								document.viewgroup.submit();
								}
								function contactprofile(id)
								{
								document.viewcontact.contactID.value=id;
								document.viewcontact.submit();
								}
								</script>
								<form name="data_table" method="post" action="compose.php">
								<TABLE id="dataTable" cellSpacing="1" cellPadding="0" border="0" width="<?php echo $tbl_width; ?>">
									<TR bgcolor="<?php echo $titlecolor; ?>">
									<?php
									$i=0;
									while (isset($title[$i]))
										{
										echo '<td width="'.$dimension[$i].'" class="tdtitle">';
										echo $title[$i];
										echo '</td>';
										$i++;
										}
									?>
									</TR>
								<?php
								$view='select * from contacts';
								$view.=' where';
								if ($_POST['group']!='')
									$view.=' id in ('.$list.') and';
								$view.=' author="'.$_SESSION['userID'].'"';
								$view.=' order by id ASC';	
								$doview=mysql_query($view,$link);
								$counter=1;
								if ($doview and mysql_num_rows($doview)>0)
									{
									$return_rows=mysql_num_rows($doview);
									//for ($i=0; $i<30000; $i++)
									while ($result=mysql_fetch_array($doview))
										{
										//$result=mysql_fetch_array($doview);
										$x=0;
										while (isset($var_array[$x]))
											{
											$$var_array[$x]=stripslashes(strip_tags(chop($result[$var_array[$x]])));
											$x++;
											}
										
										?>
										<TR id=dataRow<?php echo $id; ?> onMouseOver="change(this,'<?php echo $hightlightcolor; ?>')" onMouseOut="undo(this)" style="cursor: hand">
										<TD TF_colKey="check" align="center">
										<input type="checkbox" name="chkbox<?php echo $counter; ?>" value="<?php echo $id; ?>" onClick="javascript:colorRow(this);">
										</TD>
										<?php
										$j=1;
										while (isset($var_array[$j]))
											{
											echo '<TD width="'.$dimension[$j].'" TF_colKey="'.$var_array[$j].'" class="tdtext" onClick="contactprofile('.$$var_array[1].')">';
											echo $$var_array[$j];
											echo '</TD>';
											$j++;	
											}
										?>
										</TR>
										<?php
										$counter++;
										}
									}
								?>
								</TABLE>
								</form>
								</DIV>
								<!-- End Data Table -->
								
								<!-- Filter -->
								<table width="100%" cellpadding="0" cellspacing="0" align="center">
									<tr>
									<td align="center" valign="middle">
									<table width="100%" height="30" border="0" cellpadding="2" cellspacing="2">
									  <tr>
										<td bgcolor="#E1E1E1">&nbsp;</td>
										<td width="150" style="border: 1px solid #E1E1E1">
										<p class="buttontext">
										<INPUT onclick="TF_enableFilter(dataTable, filter, this)" type="checkbox">
										&nbsp;&nbsp;B&#7853;t / Tắt Bộ lọc</p></td>
										<td width="80" onclick="filter.reset()" style="cursor: hand; border: 1px solid #E1E1E1" onMouseOver="changebd(this,'#336699')" onMouseOut="undobd(this)">
										<p class="buttontext"><img align="absmiddle" src="images/reset.gif" width="22" height="22">
										&nbsp;&nbsp;Reset</p></td>
										<td bgcolor="#E1E1E1">&nbsp;</td>
										</tr>
									  </table>
									</td>
									</tr>
									
									<tr>
									  <td align="center" valign="top">
									  <form name="filter" onsubmit="TF_filterTable(dataTable, filter);return false" onreset="_TF_showAll(dataTable)" style="display: none">
									  <DIV style="WIDTH: 770px; HEIGHT: 80; OVERFLOW: auto; border: solid 1px #336699; display: block">
									  <table width="100%" border="0" cellspacing="0" cellpadding="0">
										<?php
										$itemonrow=4;
										$width=100/$itemonrow;
										$counter=$itemonrow;
										$i=1;
										echo '<tr>';
										while (isset($var_array[$i]))
											{	
											if ($counter==$itemonrow)
												{
												echo '</tr><tr>';
												$counter=0;
												}
											?>
											<td onMouseOver="change(this,'#EEEEEE')" onMouseOut="undo(this)">
											<p class="formtitle"><?php echo $title[$i]; ?></p>
											<p class="formindex"><?php echo $strAll; ?>
											<input type="text" onkeyup="TF_filterTable(dataTable, filter)" name="s<?php echo $var_array[$i]; ?>" TF_colKey="<?php echo $var_array[$i]; ?>" TF_searchType="substring1" class="shortinput">
											<br><?php echo $strHavein; ?>
											<input type="text" onkeyup="TF_filterTable(dataTable, filter)" name="s<?php echo $var_array[$i]; ?>" TF_colKey="<?php echo $var_array[$i]; ?>" TF_searchType="substring" class="shortinput"></p>
											</td>
											<?php
											$counter++;
											$i++;
											}
										?>
										</table>
										</div>
										</form>
										</td>
									  </tr>
									</table>
									</td>
								</tr>
								<?php
								}
							else
								{
								echo '<tr>';
								echo '<td align="center" valign="top">';
								echo '<br><br>';
								echo '<p class="bigtitle">'.$strGroupView.'</p>';
								echo '</td>';
								echo '</tr>';
								}
								?>
							</table>
					<?php
					if ($allow_edit==true)
						{
						?>
						<SCRIPT language="JavaScript">
						var frmvalidator  = new Validator("new_group");
						frmvalidator.addValidation("group_name","req","Nhom User khong the ko co ten !");
						</script>
						<?php
						}
					?>
				</td>
              </tr>
              
			  
			  <tr align="center" valign="top">
                <td colspan="3" bordercolor="#FF3300" style="border-bottom-style: solid; border-bottom-width: 2">&nbsp;
				
				</td>
              </tr>
            </table>
			</td>
          </tr>
          
		  <tr>
            <td>&nbsp;</td>
          </tr>
          
        </table></td>
        <td width="5">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>