<?php
	if(areadmin() && isset($_SERVER['HTTP_REFERER']))
	{
		if(isset($_GET['language'],$_GET['newv'],$_GET['rkey']))
		{
			Lang::Update($_GET['language'],$_GET['newv'],$_GET['rkey']);
			print $_GET['newv'];
		}
	}
?>