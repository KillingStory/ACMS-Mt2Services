<?php
	if (isset($_POST['username'],$_POST['password']))
	{
		$username = strip_tags($_POST['username']);
		$password = strip_tags($_POST['password']);
		
		$login_result = UserLogin($username,$password);
	}