<?php if (substr_count($_SERVER['PHP_SELF'],'/cpanel.php')>0) die ("You can't access this file directly..."); ?>
<table cellpadding="0" cellspacing="0" width="90%" border="0">
	<tr>
		<td class="bottomborder"><p class="grouptitle"><?php echo $strManagement.' '.$strInformation; ?></p></td>
	</tr>
	<tr>
		<td align="center" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr align="center">
					<?php if ($_SESSION['usergroup']<3)
					{
					?>
					<td width="10">&nbsp;</td>
					<td width="100" onClick="window.location='?module=categories&tblname=articles'"><p class="item">
					<img src="images/queue.gif" width="48" height="48"><br>
					<?php echo $strArticle; ?></p></td>
					<td width="10">&nbsp;</td>
					<td width="100" onClick="window.location='?module=categories&tblname=news'"><p class="item">
					<img src="images/kwallet.gif" width="48" height="48"><br>
					<?php echo $strNews; ?></p></td>
					<td width="10">&nbsp;</td>
					<td width="100" onClick="window.location='?module=viewtbl&tblname=weblinks'"><p class="item">
					<img src="images/browser.gif" width="48" height="48"><br>
					<?php echo $strWeblink; ?></p></td>					<td width="10">&nbsp;</td>
					<td width="100" onClick="window.location='?module=viewtbl&tblname=pools_cat'"><p class="item">
					<img src="images/pool_manager.gif" width="48" height="48"><br>
					<?php echo $strPool; ?></p></td>
					<td width="10">&nbsp;</td>
					<td width="100" onClick="window.location='?module=viewtbl&tblname=contact'"><p class="item">
					<img src="images/mailinglist.gif" width="48" height="48"><br>
					<?php echo $strContact; ?></p></td>
					<td width="10">&nbsp;</td>
					<td width="100" onClick="window.location='?module=viewtbl&tblname=support_online'"><p class="item">
					<img src="images/message.gif" width="48" height="48"><br>
					<?php echo $strSupport; ?></p></td>
					<td>&nbsp;</td>
					<?php
					}
				?>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height="30" align="center" valign="top">&nbsp;</td></tr>
	<tr>
	<?php if ($_SESSION['usergroup']<2)
		{
		?>
		<tr>
			<td class="bottomborder"><p class="grouptitle"><?php echo $strManagement.' '.$strUser; ?></p></td>
		</tr>
		<tr>
			<td align="center" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr align="center">
						<td width="10">&nbsp;</td>
						<td width="100" onClick="window.location='<?php echo $phpself; ?>?module=creat_user'"><p class="item">
							<img src="images/users.gif" width="48" height="48"><br>
						<?php echo $strCreatNew; ?></p></td>
						<td width="10">&nbsp;</td>
						<td width="100" onClick="window.location='<?php echo $phpself; ?>?module=user_group'"><p class="item">
							<img src="images/usergroup.gif" width="48" height="48"><br>
						<?php echo $strManagement.' '.$strGroup; ?></p></td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><td height="30" align="center" valign="top">&nbsp;</td></tr>
		<?php
		}
	?>
	<?php if ($_SESSION['usergroup']<3)
		{
		?>
	<tr><td class="bottomborder"><p class="grouptitle"><?php echo $strManagement.' '.$strSystem; ?></p></td></tr>
	<tr>
		<td align="center" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td width="10">&nbsp;</td>
					<td width="100"><p class="item" onClick="window.location='?module=explorer&file_type=files';">
						<img src="images/fileman.gif" width="48" height="48"><br>
					<?php echo $strFile; ?></p></td>
					<td width="10">&nbsp;</td>
					<td width="100"><p class="item" onClick="window.location='?module=explorer&file_type=images';">
						<img src="images/imgman.gif" width="48" height="48"><br>
					<?php echo $strImage; ?></p></td>
					<td width="10">&nbsp;</td>
					<td width="100" onClick="window.location='?module=langsys'"><p class="item">
						<img src="images/artlist.gif" width="48" height="48"><br>
					<?php echo $strLanguage; ?></p></td>
					<td width="10">&nbsp;</td>
					<td width="100"><p class="item" onClick="window.location='?module=viewtbl&tblname=site';">
						<img src="images/config.gif" width="48" height="48"><br>
					<?php echo $strConfig; ?></p></td>
					<td width="10">&nbsp;</td>
					<td width="100" onClick="window.location='?module=viewtbl&tblname=linkex'"><p class="item">
						<img src="images/eye.gif" width="48" height="48"><br>
					Từ khóa</p></td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height="30" align="center" valign="top">&nbsp;</td></tr>
		<?php
		}
	?>
</table>