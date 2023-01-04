<?php 
	$received = -1;
	if(isset($_POST['code']))
	{
		$received = 0;
		
		if(strlen($_POST['code'])==16 && ACP::CheckVoucher($_POST['code']))
		{
			$redeem_info = ACP::RedeemVoucher($_POST['code']);
			$coins = $redeem_info['value'];
			if($redeem_info['type']==1 || $redeem_info['type']==2)
			{
				$received = $redeem_info['type'];
				if($received==1)
					ACP::ADDC(intval($_SESSION['id']), $coins);
				else
					ACP::ADDJC(intval($_SESSION['id']), $coins);
				
				ACP::DeleteVoucher($redeem_info['id']);
			} else {
				$received = 3;
				
				$account_id = intval($_SESSION['id']);
				$item_position = NewPos($account_id, $coins);

				if($item_position != -1)
				{

					$stmt = $database->Player('INSERT item (owner_id, window, pos, count, vnum) VALUES (?,?,?,?,?)');
					$stmt->execute(array($account_id, 'MALL', $item_position, 1, $coins));
					
					ACP::DeleteVoucher($redeem_info['id']);
				} else $received = 4;
			}
		}
	}
?>