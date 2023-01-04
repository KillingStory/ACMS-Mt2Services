<?php
	$download_db = file_get_contents('system/database/download_links.json');
	$download_db = json_decode($download_db, true);
	
	if(!$download_db)
		$download_db = array();
	
	if(isset($_POST['adddownload']))
	{
		$insert = array();
		$insert['name'] = $_POST['addname'];
		$insert['link'] = $_POST['addlink'];
		$insert['count'] = '0';
		
		array_push($download_db, $insert);
		
		$download_new = json_encode($download_db);
		file_put_contents('system/database/download_links.json', $download_new);
		
	} 
	else if(isset($_POST['del_downlink']))
	{
		unset($download_db[$_POST['download_del_id']]);
		
		$delete_new = json_encode($download_db);
		file_put_contents('system/database/download_links.json', $delete_new);
	}
	$requirements_db = file_get_contents('system/database/download_requirements.json');
	$requirements_db = json_decode($requirements_db, true);
	
	if(!$requirements_db)
		$requirements_db = array();
	
	if(isset($_POST['add_requirement']))
	{
		$insert = array();
		$insert['request'] = $_POST['name_req'];
		$insert['minimum'] = $_POST['name_min'];
		$insert['recoman'] = $_POST['name_max'];
		
		array_push($requirements_db, $insert);
		
		$req_new = json_encode($requirements_db);
		file_put_contents('system/database/download_requirements.json', $req_new);
		
	} 
	else if(isset($_POST['del_req']))
	{
		unset($requirements_db[$_POST['req_del_id']]);
		
		$req_new = json_encode($requirements_db);
		file_put_contents('system/database/download_requirements.json', $req_new);
	}
	
?>