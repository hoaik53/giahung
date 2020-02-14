<?php

$test='select * from '.$tblname.' where id="'.$ID.'" order by id ASC';
$dotest=mysql_query($test,$link);
if (!$dotest)
	{
	$check_row='Can not connect to Database to check you exist data';
	$allow_update=false;
	}
else
	{
	$rows=mysql_num_rows($dotest);
	if ($rows>1)
		{
		$check_row=' Sorry, duplicate in exist data<br>';
		$allow_update=false;
		}
	else
		{
		$test_result=mysql_fetch_array($dotest);
		$check_row=' Done !<br>';
		$allow_update=true;
		}
	}

?>
