<?php
	$jsondataFunctions = file_get_contents('system/database/refferal_status.json');
	$jsondataFunctions = json_decode($jsondataFunctions, true);
	if(!$jsondataFunctions['active-referrals'])
	{
		print '<script>window.location.replace("'.Theme::URL().'");</script>';
		die();
	}
	
	$jsondataReferrals = file_get_contents('system/database/referrals.json');
	$jsondataReferrals = json_decode($jsondataReferrals, true);
				
	$received = false;
	
	if(isset($_POST['id']))
	{
		$getCharsINFO = Refferals::Check(intval($_POST['id']));
		
		if(count($getCharsINFO))
		{
			$getCharsINFO = Refferals::Info($_POST['id']);
			$hours = floor($getCharsINFO['playtime'] / 60);
			if($jsondataReferrals['hours']<=$hours && $jsondataReferrals['level']<=$getCharsINFO['level'])
			{
				if($jsondataReferrals['type']==1)
					ACP::ADDC(intval($_SESSION['id']), $jsondataReferrals['coins']);
				else
					ACP::ADDJC(intval($_SESSION['id']), $jsondataReferrals['coins']);
				Refferals::Update(intval($_POST['id']));
				$received = true;
			}
		}
	}

	$referrals_list = Refferals::Get();
?>