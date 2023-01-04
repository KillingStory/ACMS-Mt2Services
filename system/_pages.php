<?php
	switch ($site_page) {
		//START USERS PAGES
		case 'myaccount':
			$page = 'myaccount';
			$title = l(65);
			include 'system/plugins/pages/myaccount.php';
		break;
	
		case 'coupon':
			$page = 'coupon';
			$title = l(66);
			include 'system/plugins/pages/coupon.php';
		break;
	
		case 'vote':
			$page = 'vote';
			$title = l(67);
			include 'system/plugins/pages/vote.php';
		break;
	
		case 'refferal':
			$page = 'refferal';
			$title = l(68);
			include 'system/plugins/pages/refferal.php';
		break;
		//END USERS PAGES
		
		//START NORMAL PAGES
		case 'login':
			$page = 'login';
			$title = l(15);
			include 'system/plugins/pages/login.php';
		break;
			
		case 'register':
			$page = 'register';
			$title = l(3);
			include 'system/plugins/pages/register.php';
		break;
			
		case 'download':
			$page = 'download';
			$title = l(4);
			include 'system/plugins/pages/download.php';
		break;
			
		case 'players':
			$page = 'players';
			$title = l(21);
			include 'system/plugins/pages/players.php';
		break;
			
		case 'guilds':
			$page = 'guilds';
			$title = l(26);
			include 'system/plugins/pages/guilds.php';
		break;
			
		case 'guide':
			$page = 'guide';
			$title = l(6);
		break;
		
		case 'aboutus':
			$page = 'aboutus';
			$title = l(8);
		break;
		
		case 'privacy':
			$page = 'privacy';
			$title = 'Privacy';
		break;
		
		case 'terms':
			$page = 'terms';
			$title = 'Terms';
		break;
		
		case 'forgot':
			$page = 'forgot';
			$title = l(96);
			include 'system/plugins/pages/forgot.php';
		break;
		
		case 'rmail':
			$page = 'rmail';
			$title = l(88);
			include 'system/plugins/pages/rmail.php';
		break;

		case 'rpassword':
			$page = 'rpassword';
			$title = l(89);
			include 'system/plugins/pages/rpassword.php';
		break;
			
		case 'read':
			$page = 'read';
			$title = l(89);
		break;
			
		case 'admin':
			$page = 'admin';
		break;
			
		case 'logout':
			session_destroy();
			print "<script>window.location.replace('".Theme::URL()."');</script>";
			$page ='login';
		break;
		//END NORMAL PAGES
		default:
			$page = 'home';
			$title = l(2);
			include 'system/plugins/pages/home.php';
	}
?>