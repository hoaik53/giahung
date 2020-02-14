<?php if (substr_count($_SERVER['PHP_SELF'],'/cpanel.php')>0) die ("You can't access this file directly..."); ?>
<!-- for all admin user -->
<?php
$_count = 0;
foreach($menu_array as $kmenu => $gmenu)
{
    $_count++;    
      ?>
<div class="paneltab">
    <ul>
        <li><a href="#panel<?=$_count?>"><?=$kmenu?></a></li>
    </ul>
    <div id="panel<?=$_count?>">    
            <?php foreach($gmenu as $imenu) { ?>
            <div class="panel_item" onclick="<?=$imenu['onclick']?>">
                <img src="<?=$imenu['icon']?>" />
                <h3><?=$imenu['title']?></h3>
            </div>
            <?php } ?>
        <div class="clear"></div>
    </div>
</div>
<?php }
?>