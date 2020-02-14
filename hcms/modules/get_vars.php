<?php
	$image_num=0;
	@$open_file=fopen($db_dir.$tblname.'.'.$db_fileex,'r',1);
	if (!$open_file)
		{
		echo '<p>';
		echo 'Khong the lay thong tin ve ban ghi !';
		echo '</p>';
		$allow_update=false;
		}
	else
		{
		//Khoi tao
		$start=0;
		$line=0;
		//Doc noi dung tung dong
		while($cur_line=fgets($open_file))
			{
			$line+=1;
			if ($line==1)
				$tbldetail=chop($cur_line);
			//echo $line;
			//Neu gap dong trong
			if (strlen($cur_line)==2)
				{
				$start=1;
				$start_line=$line+1;
				//echo $start_line;
				$index=0;
				$field_array=array();
				}
			//Bat dau lay DL
			if ($start==1 && $line>=$start_line)
				{
				$line_array=explode('-',$cur_line);
				//Tieu de cot
				$field_array[$index]=$line_array[1];
				$type_array[$index]=$line_array[2];
				$var=$field_array[$index];
				$type=$type_array[$index];
				//echo '<strong>'.$var.' - '.$type.'</strong><br>';
				switch ($type)
					{
					case 'image':
						$$var=$_FILES[$var];
						$vname=$var.'_name'; $$vname=$_FILES[$var]['name'];
						$vsize=$var.'_size'; $$vsize=$_FILES[$var]['size'];
						$vtype=$var.'_type'; $$vtype=$_FILES[$var]['type'];
						$vtemp=$var.'_temp'; $$vtemp=$_FILES[$var]['tmp_name'];
						if ($$vname!='')
							{
							$have_image=true;
							$image_num+=1;
							}
						else
							$check_img='No change image or No image selected<br>';
						break;
						case 'checkbox':
						$_var = implode(',',$_POST[$var]);
						$$var = $_var;
						break;
					default:
						$$var=$_POST[$var];
						break;
					}
				/*
				echo $$var.'<br>';
				if ($have_image==true)
					echo $$vname.' - '.$$vsize;
				*/
				$index+=1;
				}
			$load_var=' Done !<br>';
			$allow_update=true;
			}
		}
?>