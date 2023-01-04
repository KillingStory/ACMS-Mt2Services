<?php
	/*   ____    ____   _________    _____     ______    ________   _______      ____   ____   _____     ______   ________    ______
		|_   \  /   _| |  _   _  |  / ___ `. .' ____ \  |_   __  | |_   __ \    |_  _| |_  _| |_   _|  .' ___  | |_   __  | .' ____ \
		  |   \/   |   |_/ | | \_| |_/___) | | (___ \_|   | |_ \_|   | |__) |     \ \   / /     | |   / .'   \_|   | |_ \_| | (___ \_|
		  | |\  /| |       | |      .'____.'  _.____`.    |  _| _    |  __ /       \ \ / /      | |   | |          |  _| _   _.____`.
		 _| |_\/_| |_     _| |_    / /_____  | \____) |  _| |__/ |  _| |  \ \_      \ ' /      _| |_  \ `.___.'\  _| |__/ | | \____) |
		|_____||_____|   |_____|   |_______|  \______.' |________| |____| |___|      \_/      |_____|  `.____ .' |________|  \______.'

												   ______   ____    ____    ______
												 .' ___  | |_   \  /   _| .' ____ \
												/ .'   \_|   |   \/   |   | (___ \_|
												| |          | |\  /| |    _.____`.
												\ `.___.'\  _| |_\/_| |_  | \____) |
												 `.____ .' |_____||_____|  \______.'*/
	session_start();
	ob_start("minifier");
	function minifier($code) 
	{
		$search = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s','/<!--(.|\s)*?-->/');
		$replace = array('>', '<', '\\1');
		$code = preg_replace($search, $replace, $code);
		return $code;
	}
	header('Cache-control: private');
	include 'config.php';
	$server_status = 0;
	include 'language.php';
	require_once("database.php");
	$database = new Connection(SERVER_IP, SERVER_ID, SERVER_PW, array(PDO::ATTR_TIMEOUT => 5, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	include '_functions.php';
	$site_page = isset($_GET['p']) ? $_GET['p'] : null;
	include '_pages.php';
	$administrator_page = isset($_GET['a']) ? $_GET['a'] : null;
	include '_apages.php';
	$plugin = isset($_GET['v']) ? $_GET['v'] : null;
	$siteownkey = strtoupper(sha1(sha1(md5(Theme::URL()) ,true)));
	include 'system/current_version.php';
	if($server_status!=1) 
	{ 
		$start_homepage = 'public/'.Server_Details::GetSettings(3).'/body.php'; 
	} 
	else 
	{ 
		$start_homepage = 'public/loading.php';
	}
	