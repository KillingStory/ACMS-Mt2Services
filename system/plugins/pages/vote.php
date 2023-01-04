<?php
	$vote4coins = file_get_contents('system/database/vote.json');
	$vote4coins = json_decode($vote4coins, true);
	if(isset($_GET['site']) && isset($vote4coins[$_GET['site']]) && isset($vote4coins[$_GET['site']]['link']) && isset($vote4coins[$_GET['site']]['value']) && isset($vote4coins[$_GET['site']]['type']) && isset($vote4coins[$_GET['site']]['time']))
	{
		$voted_now  = false;
		$account_ip = GetIP();
		if(filter_var($account_ip, FILTER_VALIDATE_IP) !== false) {
			if(!Vote::Check($account_ip, $_GET['site']) && !Vote::CheckAccount($_GET['site'])) {
				Vote::Insert($_GET['site'], $account_ip);
				if($vote4coins[$_GET['site']]['type'] == 1)
					ACP::ADDC($_SESSION['id'], $vote4coins[$_GET['site']]['value']);
				else
					ACP::ADDJC($_SESSION['id'], $vote4coins[$_GET['site']]['value']);
				
				$voted_now = true;
			} else {
				$can_vote = false;
				$date_voted = $date_voted_ip = Vote::ChecksDate($_GET['site'], $account_ip);
				$date_voted_account = Vote::ChecksDateAccount($_GET['site']);
				
				if(strtotime($date_voted_ip) > strtotime($date_voted_account))
					$date_voted = $date_voted_ip;
				else
					$date_voted = $date_voted_account;
				
				$time_needed = strtotime('-' . $vote4coins[$_GET['site']]['time'] . ' hours');
				
				if($time_needed > strtotime($date_voted))
					$can_vote = true;
				else
					$date_diff = date_diff(date_create($date_voted), date_create(date('Y-m-d G:i', $time_needed)));
				if(!$can_vote) 
				{
					$time_vote            = array();
					$time_vote['days']    = $date_diff->d;
					$time_vote['hours']   = $date_diff->h;
					$time_vote['minutes'] = $date_diff->i;
					$already_voted        = '';
					foreach ($time_vote as $key => $time)
						if($time)
							$already_voted .= $time.' '.l(168).' ';
					$already_voted = substr($already_voted, 0, -1);
					$already_voted .= '.';
				} 
				else 
				{
					Vote::Update($_GET['site'], $account_ip);
					if($vote4coins[$_GET['site']]['type'] == 1)
						ACP::ADDC($_SESSION['id'], $vote4coins[$_GET['site']]['value']);
					else
						ACP::ADDJC($_SESSION['id'], $vote4coins[$_GET['site']]['value']);
					$voted_now = true;
				}
			}
		}
		if($voted_now) {
			print '<script>window.location.replace("'.$vote4coins[$_GET['site']]['link'].'");</script>';
		}
	}
?>