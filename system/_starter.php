<?php 
	if($page!='admin' && $plugin==NULL) 
	{ 
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title><?= Server_Details::GetSettings(1).' &bull; '.Server_Details::GetSettings(2); ?></title>
			<meta name="og:title" property="og:title" content="<?= Server_Details::GetSettings(1); ?>">
			<meta name="description" content="<?= Server_Details::GetSEO(1); ?>">
			<meta name="news_keywords" content="<?= Server_Details::GetSEO(2); ?>" />
			<link rel="canonical" href="https://<?= $_SERVER['SERVER_NAME']; ?>/" />
			<meta name="robots" content="index,follow" />
			<meta name="googlebot-news" content="index,follow" />
			<meta name="googlebot" content="index,follow" />
			<link rel="stylesheet" href="<?= Theme::URL().'style/partials/alerts.css'; ?>"/>
			<?php include 'public/'.Server_Details::GetSettings(3).'/head.php'; ?>
		</head>
		<?php include $start_homepage; print '</html>';
	}
	elseif($page=='admin' && areadmin())
	{
		include Theme::Admin_Style().'head.php';
		include Theme::Admin_Style().'body.php';
	}
	elseif($plugin!=null && areadmin())
	{
		if($plugin=='red' || $plugin=='yellow' || $plugin=='blue') {
			include 'system/plugins/maps/'.$plugin.'.php'; die();
		}
		if($plugin=='general' || $plugin=='social' || $plugin=='translations') {
			include 'system/plugins/ajax/'.$plugin.'.php'; die();exit();
		}
	}
	else
	{
		echo "<h1>404 Not Found</h1>";echo "<p>The requested address <strong>{$_SERVER['REQUEST_URI']}</strong> was not found.</p>";exit();
	}
?>