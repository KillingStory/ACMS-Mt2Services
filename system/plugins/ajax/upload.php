<?php 

	$file_name =  $_FILES['file']['name'];
	$tmp_name = $_FILES['file']['tmp_name'];
	$file_up_name = 'logo.png';
	if(move_uploaded_file($tmp_name, "..style/upload/".$file_up_name))
	{
		print 'da';
	}