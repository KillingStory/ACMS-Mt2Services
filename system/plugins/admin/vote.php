<?php
	$jsondataVote4Coins = file_get_contents('system/database/vote.json');
	$jsondataVote4Coins = json_decode($jsondataVote4Coins, true);
	
	if(!$jsondataVote4Coins)
		$jsondataVote4Coins = array();
?>