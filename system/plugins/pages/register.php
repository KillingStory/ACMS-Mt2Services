<?php
	if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['rpassword']) && isset($_POST['email']) && isset($_POST['deletec']))
	{
		$errors = array();
		if(!VerifyUsername($_POST['username']))
			$errors[]=l(45);
		if(!VerifyPassword($_POST['password']))
			$errors[]=l(44);
		if($_POST['password'] != $_POST['rpassword'])
			$errors[]=l(41);
		if(!VerifyEmail($_POST['email']))
			$errors[]=l(43);
		if(VerifyExistUsername($_POST['username']))
			$errors[]=l(46);
		if(VerifyExistEmail($_POST['email']))
			$errors[]=l(47);
		
		
		foreach($errors as $error)
			$show_error = '<div class="alert alert-danger" role="alert">'.$error.'</div>';
		if(!count($errors))
		{
			$referral = isset($_GET['ref']) ? $_GET['ref'] : null;
			
			if(UserRegister($_POST['username'], $_POST['password'], $_POST['email'], $_POST['deletec'], $referral)){	
				$show_error = '<div class="alert alert-success"><p>'.l(48).'</p></div>';
			}
			else $show_error = '<div class="alert alert-danger">Unknown error</div>';
		}
	}
?>