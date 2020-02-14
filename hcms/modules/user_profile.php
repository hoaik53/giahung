<?php
    if(!defined('bcms')) die("can not access directly :)");
    
    $mylevel = get_by_id("user_groups",$_SESSION['usergroup'],"level");;
    $postid = isset($_POST['userID']) ? $_POST['userID'] : $_SESSION['userID'];
    $postlevel = get_by_id("users",$postid,"groupof");
    $postlevel = get_by_id("user_groups",$postlevel,"level");
    //echo $mylevel."vs".$postlevel;
    if($postlevel < $mylevel)
    {
        echo "Bạn không đủ quyền để xem thông tin của tài khoản đã chọn";
    }
    else 
    {
        $data = get_by_id("users",intval($postid));
        $blockheader = $strViewUserTitle;
        ?>
<div class="ui-widget-content">
    <h3 class="ui-widget-header"> <?=$blockheader?> </h3>
    <div class="ui-widget-body">
        <form class="adminform" name="adduser" method="post" enctype="multipart/form-data" action="?module=creat_user">
            <input type="hidden" name="userID" value="<?=$data['id']?>" />
            <span class="label"> Tên truy cập </span><?=$data['username']?>
            <div class="clear"></div>
            <span class="label"> Nhóm người dùng </span><?=get_by_id("user_groups",$data['groupof'],'description')?>
            <div class="clear"></div>
            <span class="label"> Tên thật </span><?=$data['realname']?>
            <div class="clear"></div>
            <span class="label"> Ngày sinh </span><?=$data['birthday']?>
            <div class="clear"></div>
            <span class="label"> Giới tính </span><?php if($data['genre'] == 'm')echo $strMale;else echo $strFemale; ?>
            <div class="clear"></div>
            <span class="label"> Địa chỉ </span><?=$data['address']?> 
            <div class="clear"></div>
            <!--span class="label"> Nghề nghiệp </span><?=$data['job']?>
            <div class="clear"></div>
            <span class="label"> Nơi công tác </span><?=$data['jobadd']?>
            <div class="clear"></div>
            <span class="label"> Điện thoại </span><?=$data['phone']?>
            <div class="clear"></div-->
            <span class="label"> Email </span><?=$data['email']?>
            <div class="clear"></div>
            <!--span class="label"> Yahoo ID </span><?=$data['ymid']?>
            <div class="clear"></div>
            <span class="label"> Website </span><?=$data['website']?>
            <div class="clear"></div>
            <span class="label"> Mô tả bản thân </span><?=$data['description']?> 
            <div class="clear"></div>
            <span class="label"> Chữ ký </span><?=$data['sign']?> 
            <div class="clear"></div>
            <span class="label"> Hình đại diện </span><img src="<?=$data['avatar']?>" />
            <div class="clear"></div-->
            <span class="label"> Trạng thái </span><?php if($data['active'] == 'y')echo "Active";else echo "Inactive"; ?>
            <div class="clear"></div>
            <br /><br />
            <div class="" style="text-align: center;">
                <input type="submit" class='button' value="Sửa" />
            </div>
                
        </form>
    </div>
</div>
<br /><br />
        <?php
    }
    
?>