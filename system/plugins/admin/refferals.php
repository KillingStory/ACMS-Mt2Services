<?php
	$jsondataFunctions = file_get_contents('system/database/refferal_status.json');
		$jsondataFunctions = json_decode($jsondataFunctions, true);
	$jsondataReferrals = file_get_contents('system/database/referrals.json');
	$jsondataReferrals = json_decode($jsondataReferrals, true);
	
	if(isset($_POST['submit']))
	{
		$edited = false;
		if(isset($_POST['status']) && $jsondataFunctions['active-referrals']!=$_POST['status'])
		{
			$jsondataFunctions['active-referrals']=$_POST['status'];
			$json_new = json_encode($jsondataFunctions);
			file_put_contents('system/database/refferal_status.json', $json_new);
		}
		foreach($_POST as $key=>$value)
			if(isset($jsondataReferrals[$key]))
				if($jsondataReferrals[$key]!=$value)
				{
					$jsondataReferrals[$key]=$value;
					$edited = true;
				}
		if($edited)
		{
			$json_new = json_encode($jsondataReferrals);
			file_put_contents('system/database/referrals.json', $json_new);
		}
	}
?>