<?php
$__counter = 0;
$download_db = file_get_contents('system/database/download_links.json');
$download_db = json_decode($download_db, true);
if(isset($_POST['idiom'], $_POST['download'.$_POST['idiom']],$_POST['stdownload_link']))
{
	$download_db[$_POST['stdownload_id']]['count']=$download_db[$_POST['stdownload_id']]['count']+1;
	$json_new = json_encode($download_db);
	file_put_contents('system/database/download_links.json', $json_new);
	print '<script>location.replace("'.$_POST['stdownload_link'].'");</script>';
}
$requirements_db = file_get_contents('system/database/download_requirements.json');
$requirements_db = json_decode($requirements_db, true);