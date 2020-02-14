<?php if (substr_count($_SERVER['PHP_SELF'],'/user_group.php')>0) die ("You can't access this file directly..."); ?>
<form name="viewuser" action="?module=user_profile" method="POST">
<input type="hidden" name="userID" value="" />
<input type="hidden" name="group" value="" />
</form>
<script type="text/javascript">
function view(groupid)
	{
	document.viewgroup.group.value=groupid;
	document.viewgroup.submit();
	}
function viewrec(id,gid)
	{
	document.viewuser.userID.value=id;
	document.viewuser.submit();
    document.viewuser.group.value=gid ;
	}
function addrec(groupid)
	{
	document.viewuser.group.value=groupid ;
    document.viewuser.action = '?module=do_user';
	document.viewuser.submit();
	}
function checkAll(obj)
{
    if($(":checkbox[name=cbxSelectAll]",obj).is(":checked"))
    {
        $(":checkbox[name!=cbxSelectAll]",obj).attr("checked","checked"); 
    }
    else $(":checkbox[name!=cbxSelectAll]",obj).removeAttr("checked");
}
function delgroup(obj)
{
    $("form[name="+obj+"] input[name=action]").val("delete");
    $("form[name="+obj+"]")[0].submit();
}
function delrec(obj)
{
    if($("form[name="+obj+"] input[name^='chkbox']:checked").length==0)return false;
    var mydialog = $("<div><?=$strConfirmDel?></div>");
    mydialog.children('#selectContainer').load("ajax/jqgrid_changegroup.php?action=getgroups&tblname=<?=$tblname?>");
    mydialog.dialog({
        autoOpen : false,
        title : "<?=$strHaveNotice?>",
        position : 'center',
        modal : true,
        close : function(){$(this).remove();$('#list').trigger("reloadGrid");},
        buttons : { "<?=$strConfirm?>" : function(){
                            $("form[name="+obj+"] input[name=action]").val("deleteuser");
                            $("form[name="+obj+"]")[0].submit();
                                    }, 
                    "<?=$strCancel?>" : function(){mydialog.dialog('close');}}
        
    });
    mydialog.dialog('open');
    return false;
    
}
</script>
<?php
$user_group_tbl = "user_groups";
$user_tbl = "users";
//process post action 
if (isset($_POST['action']))
{
$imgpath='icons/gicon/';
$error=0;
$msg='';
$action=$_POST['action'];
$gtype='custom';
$iname = '';
if((isset($_FILES['icon']['error']))&&($_FILES['icon']['error']==0))
    {
        include('classes/image_tool.php');
        // upload image
        $myImage = new _image;
        $myImage->uploadTo = 'icons/gicon/'; // SET UPLOAD FOLDER HERE
        $myImage->returnType = 'array'; // RETURN ARRAY OF IMAGE DETAILS
        $img = $myImage->upload($_FILES['icon']);
        if($img) {
        $myImage->source_file = 'icons/gicon/'.$img['image']; // THIS IS AUTOMATICALLY SET BY UPLOAD - just here for reference
        //echo $myImage->source_file;
        $myImage->newPath = 'icons/gicon/';
        $myImage->namePrefix = '';
        $myImage->duplicates = 'o';
        $myImage->padColour = '#ffffff'; // SET THE BACKGROUND TO A HIDEOUS ORANGEY COLOUR
        $myImage->newWidth = 100;
        $myImage->newHeight = 75;
        
        $i = $myImage->resize(); // creates small thumbnail
        // check the file was create OK and add the image name to the variable: $image
        if(($i==true)&&(file_exists($img['path'].$img['image']))) {
        $iname = $img['path'].$img['image']; }
        } else {
        $iname = ''; // or set $image to nothing
        }
    }
$error = 0;
$error_msg = array();

switch ($action)
	{
	case 'new':
	if (checkdata($user_group_tbl,'description',$_POST['group_name'])==0 && $_POST['group_name'] != "")
		{
		$msg.='Tạo nhóm mới: <br>';
        $insert = do_sql($user_group_tbl,array("description"=>$_POST['group_name'],"icon"=>$iname,"type"=>$gtype),"insert");
        if($insert)$msg .=" Thêm thành công ! <br/> ";
        else $msg .= " Chưa thêm được nhóm người dùng ";
		
		}
	else
		{
		set_error($strErr['106']);
		}
	break;
	
	case 'edit':
	if (checkdata('user_groups','id',$_POST['group'])==1)
		{
		$msg.='Cập nhật thông tin nhóm : ';
		if ($cur_icon!='')
			$msg.= '<img src="icons/'.$cur_icon.'" width="22" height="22" border="0" align="absmiddle">';
		$msg.= ' <font color="#FF5500">'.$cur_group.'</font><br>';
		$query='update user_groups set description="'.$_POST['group_name'].'"';
		if ($iname!='')
			$query.=', icon="'.$iname.'"';
		$query.=' where id="'.$_POST['group'].'"';
		}
	else
		{
		set_error($strErr['107']);
		}
	break;
	
	case 'delete':
	if (checkdata('user_groups','id',$_POST['group'])==1)
		{
		$msg.='Xóa thông tin nhóm : ';
		//check if user in this group
        $check = get_all($user_tbl," groupof = '".$_POST['group']."' ");
        if(count($check))
        {
            $msg .= "Không thể xóa nhóm không rỗng";
        }
        else
        {
            $query='delete from user_groups ';
    		$query.=' where id="'.$_POST['group'].'" and type!="default"';
        }
            
		}
	else
		{
		$msg .= $strErr['107'];
		}
	break;
	
	case 'deleteuser':
	$IDs='';
    if($_SESSION['username'] != "admin")
    {
        $msg .= "Bạn không đủ quyền để thực hiện chức năng này";
        break;
    }
    $totalrow = do_sql("users",array("groupof"=>$_POST['group']),'count');
		//echo 'Total rows : '.$totalrow;
		$counter=0;
		for ($i=1;$i<=$totalrow;$i++)
			{
			if (isset($_REQUEST['chkbox'.$i]) and $_REQUEST['chkbox'.$i]!='')
				{
				$counter++;
				if ($counter>1)
					$IDs.=',';
				$IDs.=$_REQUEST['chkbox'.$i];
                if($_SESSION['userID'] == $_REQUEST['chkbox'.$i]) {
                    $msg .= "Bạn không thể xóa tài khoản của mình";
                    break 2;
                }
                if(get_by_id($user_tbl,$_REQUEST['chkbox'.$i],"username") == "admin"){
                    $msg .= "Bạn không thể xóa tài khoản admin";
                    break 2;
                }
				}
			}
	//	echo 'Selected : '.$IDs;
		if ($counter>0)
			$allow_delete=true;
		
		$msg.='Xóa user : ';
		$query='delete from users';
		$query.=' where id in ('.$IDs.') and id!="1"';
		//echo $query;
	break;
	
	}

if (isset($query))
	{
	if (mysql_query($query,$link))
		{
		$msg.='Thông tin được cập nhật thành công !<br><br>';
		if (isset($_FILES['icon']) && $_FILES['icon']!='')
			{
			$checkimg=validateimage('upload','icon',$imgpath);
			if ($checkimg=='ok')
				{
				if (@move_uploaded_file($itemp,$imgpath.'\\'.$iname))
					{
					$msg.='File(s) uploaded successfully !';
					}
				else
					{
					$msg.='Can not upload file(s) !';
					}
				}
			else
				{
				set_error($checkimg);
				}
			}
		}
	else
		{
		set_error($strErr['108']);
		}
	}
else
	{
	$msg.='<br>Không thể cập nhật thông tin !<br>';
	}
$msg.='<script>';
//$msg.='setTimeout(\'window.location.replace("?module=user_group")\',3000);';
$msg.='</script>';
echo '<p class="bigtitle"><br>'.$msg.'</p>';
//echo $action;
}
?>
		<?php
		//Get list of available user group
		$allow_edit=false;
		$view='select * from '.$user_group_tbl." ";
        $mylevel = get_by_id($user_tbl,$_SESSION['userID'],"groupof");//echo "ddđ".$mylevel."dddd";
        $mylevel = get_by_id($user_group_tbl,$mylevel,"level");//echo "ddđ".$mylevel."dddd";
        $view.= 'where level >= '.$mylevel;
		$view.=' order by level ASC';	
		//echo $view;
		$doview=mysql_query($view);
		if ($doview and mysql_num_rows($doview)>0)
			{
			$return_rows=mysql_num_rows($doview);
			$id_array=array($return_rows);
			$desc_array=array($return_rows);
			$icon_array=array($return_rows);
			$i=0;
			while ($result=mysql_fetch_array($doview))
				{
				$id_array[$i]=$result['id'];
				$desc_array[$i]=$result['description'];
				$icon_array[$i]=$result['icon'];
				if (isset($_POST['group']) && $id_array[$i]==$_POST['group'])
					{
					$cur_group=$desc_array[$i];
					$cur_icon=$icon_array[$i];
					}
				$i++;
				}
			}
		?>
                <div class="paneltab">
                <ul>         
            <?php
                foreach($id_array as $key => $value)
                {
                ?>
                       
                        <li> 
                            <a href="#panel<?=$value?>"> <?=$desc_array[$key]?> </a>
                        </li>
                    
                
                <?
                }
                ?>
                        <li> <a href="#paneladd"> <?=$strAdd." ".$strGroup." ".$strUser?> </a> </li>
                </ul>
                <?php
                foreach($id_array as $key => $value)
                {
                ?>
                    
                    
                    
                    <div style="display: none;" id="panel<?=$value?>" >
                    <form name="form<?=$value?>" method="post">
                    <input type="hidden" name="group" value="<?=$value?>" />
                    <input type="hidden" name="action" value="" />
                    <?php if($icon_array[$key])echo "<img class='gicon' src='".$icon_array[$key]."' />"; ?>
                    <div class="fullwidth" style="text-align: right;">
                        <a href="javascript:void(0);" class="add_button" onclick="addrec(<?=$value?>);"> <?=$strAdd." ".$strUser?> </a>
                        <a href="javascript:void(0);" class="del_button" onclick="delrec('form<?=$value?>');"> <?=$strDelete." ".$strUser?> </a>
                        <!--a href="javascript:void(0);" class="del_button" onclick="delgroup('form<?=$value?>')"> Xóa nhóm </a-->
                        
                        <br /><br />
                    </div>
                    <div class="clear"></div>
                    
                    <?php
                    $view='select * from users';
					$view.=' where groupof="'.$value.'"';
					$view.=' order by id ASC';
                    $get_user = get_all("users"," groupof = ".$value." "," id asc ");
					//echo $view;
					//show_datatbl($view,'datatbl','','dataTable',$title,$dimension,$var_array);
                    
                    ?>
                    <table width="100%" cellspacing="1" cellpadding="0" border="0" style="border: 1px solid #f1f1f1;" id="dataTable">
                    		<tbody>
                            <tr bgcolor="#efefff">
                        		<td class="tdtitle"><input type="checkbox" onchange="checkAll(this.form);" name="cbxSelectAll" /></td>
                                <td class="tdtitle">ID</td>
                                <td class="tdtitle">Tên truy cập</td>
                                <td class="tdtitle">Tên thật</td>
                                <td class="tdtitle">Ngày sinh</td>
                                <td class="tdtitle">Giới tính</td>
                                <td class="tdtitle">Địa chỉ</td>
                                <td class="tdtitle">Điện thoại</td>
                    		</tr>
                            <?php 
                            $_count = 0;
                            foreach($get_user as $iuser) { $_count++; ?> 
                    		<tr bgcolor="" style="cursor: hand" onmouseout="undo(this)" onmouseover="change(this,'#EEEEEE')" id="dataRow1">
                    			<td align="center" width="20" tf_colkey="check">
                    			<input type="checkbox" onclick="javascript:colorRow(this);" value="<?=$iuser['id']?>" name="chkbox<?=$_count?>" />
                    			</td>
                    			<td width="30" onclick="viewrec(<?=$iuser['id']?>,<?=$value?>)" class="tdtext" tf_colkey="id"><?=$iuser['id']?></td>
                                <td width="150" onclick="viewrec(<?=$iuser['id']?>,<?=$value?>)" class="tdtext" tf_colkey="username"><?=stripslashes($iuser['username'])?></td>
                                <td width="200" onclick="viewrec(<?=$iuser['id']?>,<?=$value?>)" class="tdtext" tf_colkey="realname"><?=stripslashes($iuser['realname'])?></td>
                                <td width="90" onclick="viewrec(<?=$iuser['id']?>,<?=$value?>)" class="tdtext" tf_colkey="birthday"><?=$iuser['birthday']?></td>
                                <td width="50" onclick="viewrec(<?=$iuser['id']?>,<?=$value?>)" class="tdtext" tf_colkey="genre"><?php if($iuser['genre']=='m')echo $strMale;else echo $strFemale;?></td>
                                <td width="300" onclick="viewrec(<?=$iuser['id']?>,<?=$value?>)" class="tdtext" tf_colkey="address"><?=$iuser['address']?></td>
                                <td width="120" onclick="viewrec(<?=$iuser['id']?>,<?=$value?>)" class="tdtext" tf_colkey="phone"><?=$iuser['phone']?></td>
                    		</tr>
                            <?php } ?>
                    		<input type="hidden" value="1" name="total_rows" />
                    		</tbody></table></form>
                    </div>
                
                <?
                }
            ?>
                <div id="paneladd" style="display: none;">
                        <form name="new_group" class="adminform" method="post" action="" style="display: " enctype="multipart/form-data">
                    	  <input type="hidden" name="module" value="user_group">
                      	  <input type="hidden" name="action" value="new">
                    	  <input type="hidden" name="group" value="">
                    		<span class="label"><?php echo $strName; ?></span><input type="text" class="mediuminput" name="group_name" />
                            <div class="clear"></div>
                            <span class="label">Icon</span><input type="file" class="mediuminput" name="icon" id="icon"  />
                            <div class="clear"></div>
                    		<br /><br />
                            <div class="fullwidth" style="text-align: center;">
                                <input type="submit" style="display: none;"/>
                    			<a href="javascript:void(0);" class="submit_button" onclick="document.new_group.submit();"> <?=$strAdd?> </a>
                                <a href="javascript:void(0);" class="reset_button"> <?=$strReset?> </a>
                            </div>
                    			
                    	</form>
                    </div>
            </div>
	  
		
	  <br/>
	  
	  </td></tr>
	</table>