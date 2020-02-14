<script language="javascript">
	function docheckone()
		   {
		   		var alen=document.frmList.elements.length;
				var isChecked=true;
				alen=(alen>5)?document.frmList.chkid.length:0;
				if (alen>0)
				{
			   		for(var i=0;i<alen;i++)
						if(document.frmList.chkid[i].checked==false)
							isChecked=false;
				}else
				{
					if(document.frmList.chkid.checked==false)
						isChecked=false;
				}				
				document.frmList.chkall.checked=isChecked;
		   }
function docheck(status,from_)
		   {
		   		var alen=document.frmList.elements.length;
				alen=(alen>5)?document.frmList.chkid.length:0;
				if (alen>0)
				{
			   		for(var i=0;i<alen;i++)
						document.frmList.chkid[i].checked=status;
				}else
				{
						document.frmList.chkid.checked=status;
				}
				if(from_>0)
					document.frmList.chkall.checked=status;
		   }
 function checkInput()
		   {
				var alen=document.frmList.elements.length;
				var isChecked=false;
				var isNum=true;
				alen=(alen>5)?document.frmList.chkid.length:0;
				if (alen>0)
				{
			   		for(var i=0;i<alen;i++)
					{
						if(document.frmList.chkid[i].checked==true)
						{
							isChecked=true;							
							break;
						}
					}
					if (!isChecked)											
						alert("Please select at least one of them");
					
				}else
				{
					if(document.frmList.chkid.checked==true)
						isChecked=true;
					if (!isChecked)											
						alert("Please select at least one of them");
				}
												
			if (isChecked)											
					calculatechon();
				
												
			return isChecked;
		  } 
function calculatechon()
			{			
				var strchon="";
				var alen=document.frmList.elements.length;				
				alen=(alen>5)?document.frmList.chkid.length:0;
				if (alen>0)
				{
			   		for(var i=0;i<alen;i++)
						if(document.frmList.chkid[i].checked==true)
							strchon+=document.frmList.chkid[i].value+",";
				}else
				{
					if(document.frmList.chkid.checked==true)
						strchon=document.frmList.chkid[i].value;
				}
				document.frmList.chkids.value=strchon;	
				
			}
</script>
<table width="100%" height="100%">
<tr>
<td align="center">
<form action="" method="post" name="frmList" onSubmit="return checkInput();">
<div class="tabber" id="mytabber1">
     <div class="tabbertab">
	  <h2>Thue</h2>
	  <p>
	  	<table width="96%" border="0" cellspacing="0" cellpadding="0" align="center">
			<?php tab_deactive('articles','02'); ?>
		</table>
	  </p>
     </div>


     <div class="tabbertab">
	  <h2>Cho thue</h2>
	  <p><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center">
			<?php tab_deactive('articles','01'); ?>
		</table></p>
     </div>


     <div class="tabbertab">
	  <h2>Mua</h2>
	  <p><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center">
			<?php tab_deactive('articles','03'); ?>
		</table></p>
     </div>
	 
	 <div class="tabbertab">
	  <h2>Ban</h2>
	  <p><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center">
			<?php tab_deactive('articles','04'); ?>
		</table></p>
     </div>
</div>
<br />
<input type="hidden" name="chkids" /><input type="submit" value="Ative" class="button" name="submit" />&nbsp;&nbsp;<input type="submit" onclick="javascript: return confirm('Ban co chac chan  muon xoa no ?');" value="Delete" class="button" name="delete" />
</form>
<?php
$cid=str_replace (",", "','", $_POST['chkids']);
	if (isset($_POST['submit']))
	{
		$sql="UPDATE articles SET active='Active' WHERE id in ('".$cid."')";
		mysql_query($sql, $link);
		//echo $sql;
	}
	elseif (isset($_POST['delete']))
	{
		$sql="DELETE FROM articles WHERE id in ('".$cid."')";
		mysql_query($sql, $link);
		
	}
	
?>
</td>
</tr>
</table>