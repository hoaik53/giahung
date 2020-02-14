<?php if (substr_count($_SERVER['PHP_SELF'],'/creat_user.php')>0) die ("You can't access this file directly..."); ?>
<?php
$allow_edit=false;
$mylevel = get_by_id("users",$_SESSION['userID'],"groupof");
$mylevel = get_by_id("user_groups",$mylevel,"level");
if ($mylevel<2 )
  	{
//----------------------------------------- Actions -------------------------------------------
	
//------------------------------------- End Actions ----------------------------------------

//----------------------------------------- Form -------------------------------------------
$data = array();
$error = 0;
$msg = array();
//print_r($_POST);
if($_SESSION['username'] != "admin" && $_SESSION['userID'] != $_POST['userID'])
{
?>
<p class="bigtitle"><?php echo $strErr['201']; ?></p>
<?php
die("");
}
$blockheader = $strCreatNew." ".$strUser;
if(isset($_POST['userID']) && !isset($_POST['username']) && $_POST['userID'] != "")
{//if edit 
    $blockheader = $strEdit." ".$strUser." : ".$_POST['userID'];
    if($_SESSION['username'] == "admin" || $_SESSION['userID'] == $_POST['userID'])
    $data = get_by_id("users",intval($_POST['userID']));
    else {
    ?>
	<p class="bigtitle"><?php echo $strErr['201']; ?></p>
	<?php
    die("");
    }
}
else if(!isset($_POST['userID']) && isset($_POST['groupof']))
{//if insert or post after edit
    
    $data = $_POST;
    //check valid information
    if(isset($data['id']))
    {//check cac truong khi sua
        
        if(count(get_all("users"," username != '".$data['username']."' and email = '".$data['email']."' ","",0,1)))
        {
            $msg[] = "Email đã được sử dụng";
            $error++;
        }
        if($data['password'] != $data['confirmpass'])
        {
            $msg[] = "Mật khẩu xác nhận không trùng khớp";
            $error++;
        }
        if($data['password'] == "")unset($data['password']);
        if( isset($_FILES['avatar']['error']) && $_FILES['avatar']['error']==0 )
        {
            $oldimage = get_by_id("users",$data['id'],'avatar');
            if(@GetImageSize($_SERVER['DOCUMENT_ROOT']."/admin/".$oldimage))
            {
                if(unlink($_SERVER['DOCUMENT_ROOT'].'/admin/'.$oldimage))
                $msg[] = "Deleted old image !";
                else $msg[] = "Can not deleted old image !";
            }
            include('classes/image_tool.php');
            // upload image
            $myImage = new _image;
            $myImage->uploadTo = 'avatar/'; // SET UPLOAD FOLDER HERE
            $myImage->returnType = 'array'; // RETURN ARRAY OF IMAGE DETAILS
            $img = $myImage->upload($_FILES['avatar']);
            if($img) {
            $myImage->source_file = 'avatar/'.$img['image']; // THIS IS AUTOMATICALLY SET BY UPLOAD - just here for reference
            //echo $myImage->source_file;
            $myImage->newPath = 'avatar/';
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
        $data['avatar'] = $iname;
    }
    else 
    {//check cac truong khi them
        if($data['username'] == "")
        {
            $msg[] = "Bạn chưa nhập tên người dùng";
            $error++;
        }
        else if(count(get_all("users"," username = '".$data['username']."' ","",0,1)))
        {
            $msg[] = "Tên đăng nhập đã được sử dụng";
            $error++;
        }
        if(count(get_all("users"," email = '".$data['email']."' ","",0,1)))
            {
                $msg[] = "Email đã được sử dụng";
                $error++;
            }
        if($data['password'] == "")
        {
            $msg[] = "Bạn chưa nhập mật khẩu";
            $error++;
        }
        else if($data['password'] != $data['confirmpass'])
        {
            $msg[] = "Mật khẩu xác nhận không trùng khớp";
            $error++;
        }
        if((isset($_FILES['avatar']['error']))&&($_FILES['avatar']['error']==0))
        {
            include('classes/image_tool.php');
            // upload image
            $myImage = new _image;
            $myImage->uploadTo = 'avatar/'; // SET UPLOAD FOLDER HERE
            $myImage->returnType = 'array'; // RETURN ARRAY OF IMAGE DETAILS
            $img = $myImage->upload($_FILES['avatar']);
            if($img) {
            $myImage->source_file = 'avatar/'.$img['image']; // THIS IS AUTOMATICALLY SET BY UPLOAD - just here for reference
            //echo $myImage->source_file;
            $myImage->newPath = 'avatar/';
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
        $data['avatar'] = $iname;
    }
    //check cac truong kho phan biet luc them hay sua
    if($data['groupof'] == "")
    {
        $msg[] = "Bạn chưa chọn nhóm người dùng";
        $error++;
    }
    if($data['realname'] == "")
    {
        $msg[] = "Bạn chưa nhập tên thật";
        $error++;
    }
    if($data['birthday'] == "")
    {
        $msg[] = "Bạn chưa nhập ngày sinh";
        $error++;
    }
    if($data['genre'] == "")
    {
        $msg[] = "Bạn chưa chọn giới tính";
        $error++;
    }
    if($data['active'] == "")
    {
        $msg[] = "Bạn chưa chọn trạng thái";
        $error++;
    }
    
    ////////////////////thuc hien luu 
    if($error == 0)
    {
        $data['password'] = md5($data['password']); 
        
        if(isset($data['id']))
        $dosql = do_sql("users",$data,"update");
        else $dosql = do_sql("users",$data,"insert");
        if($dosql)
        {
            $msg[] = "Lưu thông tin thành công";
            $msg[] = "Đang về trang danh sách sau 2 giây!<script typr='text/javascript'>setTimeout('window.location = \"?module=user_group\"',2000);</script>";
        }
        else {
            $msg[] = "Lưu thông tin không thành công";
            $msg[] = "Đang về trang danh sách sau 2 giây!<script typr='text/javascript'>setTimeout('window.location = \"?module=user_group\"',2000);</script>";
        }
    }
}
    
?>
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
<script type="text/javascript">
$(document).ready(function(){
    $("form[name=adduser]").validationEngine();
    
});
    


</script>
<style>
    .adminform span.label
    {
        vertical-align: top;
    }
    .adminform .w250,.adminform select,.adminform textarea
    {
        width:250px;
        margin: 3px 0;
    }
</style>
<?php $ftitle=array(); ?>
<div class="ui-widget-content">
    <h3 class="ui-widget-header"> <?=$blockheader?> </h3>
    <div class="ui-widget-body">
        <form class="adminform" name="adduser" method="post"  enctype="multipart/form-data">
            <?php if(isset($data['id']))echo "<input name='id' type='hidden' value='".$data['id']."'/>"; ?>
            <span class="label"> Tên truy cập(*) </span><?php if(isset($data['id'])) echo $data['username']."<input type='hidden' name='username' value='".$data['username']."' />"; 
            else { 
                ?><input id="username" class="validate[required] w250" type="text" name="username" value="<?=$data['username']?>" /> 
            <?php } ?>
            <div class="clear"></div>
            <span class="label"> <?=$strPassWord?>(*) </span><input id="password" type="password" name="password" class="<?php if(!isset($data['id'])) echo "validate[required]";?> w250" />
            <div class="clear"></div>
            <span class="label"> <?=$strConfirm." ".$strPassWord?>(*) </span><input id="confirmpass" type="password" name="confirmpass" class="validate[<?php if(!isset($data['id'])) echo "required,";?>equals[password]] w250" />
            <div class="clear"></div>
            <span class="label"> <?=$strGroup?>(*) </span><select name="groupof" class="validate[required]" id="groupof" >
                <option value=""> -- Chọn nhóm -- </option>
                <?php
                    $groups = get_all("user_groups",""," level asc ");
                    $selectG = $_POST['group'];
                    foreach($groups as $igroup)
                    {
                        if($data['groupof'] == $igroup['id'] || $selectG == $igroup['id'] )$selected = "selected='selected'";else $selected = "";
                        echo "<option value='{$igroup['id']}' {$selected}>".$igroup['description']."</option>";
                    }
                ?>
                </select>
            <div class="clear"></div>
            <span class="label"> <?=$strName?>(*) </span><input class="validate[required] w250" id="realname" type="text" name="realname" value="<?=$data['realname']?>" />
            <div class="clear"></div>
            <span class="label"> <?=$strBirthDay?>(*) </span><input id="birthday" type="text" class="select_date validate[required]" name="birthday" value="<?=$data['birthday']?>" />
            <div class="clear"></div>
            <span class="label"> <?=$strGender?>(*) </span><select name="genre" id="genre" class="validate[required]" >
                    <option value="">-- Chọn --</option>
                    <option value="m" <?php if($data['genre'] == 'm')echo "selected='selected'"; ?> > Nam </option>
                    <option value="fm" <?php if($data['genre'] == 'fm')echo "selected='selected'"; ?> > Nữ </option>
                </select>
            <div class="clear"></div>
            <span class="label"> <?=$strAddress?>(*) </span><textarea name="address" id="address" class="validate[required] w250"><?=$data['address']?></textarea> 
            <div class="clear"></div>
            <!--span class="label"> Nghề nghiệp </span><input id="job" type="text" name="job" class="w250" value="<?=$data['job']?>" />
            <div class="clear"></div>
            <span class="label"> Nơi công tác </span><input id="jobadd" type="text" name="jobadd" class="w250" value="<?=$data['jobadd']?>" />
            <div class="clear"></div>
            <span class="label"> Điện thoại </span><input id="phone" type="text" name="phone"  class="validate[custom[integer],maxSize[11],minSize[7] w250" value="<?=$data['phone']?>" />
            <div class="clear"></div-->
            <span class="label"> Email(*) </span><input id="email" type="text" class="validate[required,custom[email]] w250" name="email" value="<?=$data['email']?>" />
            <div class="clear"></div>
            <!--span class="label"> Yahoo ID </span><input id="ymid" type="text" name="ymid" class="w250" value="<?=$data['ymid']?>" />
            <div class="clear"></div>
            <span class="label"> Website </span><input id="website" type="text" class="validate[custom[url]] w250" name="website" value="<?=$data['website']?>" />
            <div class="clear"></div>
            <span class="label"> Mô tả bản thân </span><textarea id="description" name="description" class="w250"><?=$data['description']?></textarea> 
            <div class="clear"></div>
            <span class="label"> Chữ ký </span><textarea id="sign" name="sign" class="w250"><?=$data['sign']?></textarea> 
            <div class="clear"></div>
            <span class="label"> Hình đại diện </span><input id="avatar" type="file" name="avatar" class="w250" />
            <div class="clear"></div>
            <span class="label">  </span><img src="<?=$data['avatar']?>" />
            <div class="clear"></div-->
            <span class="label"> Trạng thái(*) </span>
                                <select name="active" id="active" class="validate[required]">
                                    <option value="">  -- Chọn --  </option>
                                    <option value="y" <?php if($data['active'] == 'y')echo "selected='selected'"; ?> > Active </option>
                                    <option value="n" <?php if($data['active'] == 'n')echo "selected='selected'"; ?> > Inactive </option>
                                </select>
            <div class="clear"></div>
            <br /><br />
            <div class="" style="text-align: center;">
                <input type="submit" class='button' value="<?=$strSave?>" />
                <input type="reset" class="button" value="<?=$strReset?>" />
            </div>
                
        </form>
    </div>
</div>
<br /><br />		

<?php
	}
else
	{
	?>
	<p class="bigtitle"><?php echo $strErr['201']; ?></p>
	<?php
	}
?>