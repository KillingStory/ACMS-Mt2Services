<?php
	if(isset($_POST['add']))
	{
		$account_id = GetAccountByName($_POST['name']);
		if($account_id)
		{
			$item_position = NewPos($account_id, $_POST['vnum']);

			if($item_position != -1)
			{
				if($_POST['count']<=0)
					$_POST['count']=1;
				
				for($i=0;$i<=6;$i++) 
					if($_POST['attrtype'.$i]==0)
						$_POST['attrvalue'.$i]=0;
					
				if(ItemDescribe("applytype0"))
					for($i=0;$i<=7;$i++) 
						if($_POST['applytype'.$i]==0)
							$_POST['applyvalue'.$i]=0;
						
				if($_POST['socket0']!="")
					$socket0 = $_POST['socket0'];
				else
					$socket0 = 0;
				if($_POST['socket1']!="")
					$socket1 = $_POST['socket1'];
				else
					$socket1 = 0;
				if($_POST['socket2']!="")
					$socket2 = $_POST['socket2'];
				else
					$socket2 = 0;

				if(ItemDescribe("applytype0") && IfSash($_POST['vnum']) && $_POST['time2']==0)
				{//owner_id window pos
					$stmt = $database->Player('INSERT item (owner_id, window, pos, count, vnum, socket1, socket2, attrtype0, attrvalue0, attrtype1 , attrvalue1, attrtype2, attrvalue2, attrtype3, attrvalue3, attrtype4, attrvalue4, attrtype5, attrvalue5, attrtype6, attrvalue6, applytype0, applyvalue0, applytype1, applyvalue1, applytype2, applyvalue2, applytype3, applyvalue3, applytype4, applyvalue4, applytype5, applyvalue5, applytype6, applyvalue6, applytype7, applyvalue7) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
					$stmt->execute(array($account_id, 'MALL', $item_position, $_POST['count'], $_POST['vnum'], $_POST['absorption'], $_POST['time'],
										$_POST['attrtype0'], $_POST['attrvalue0'], $_POST['attrtype1'], $_POST['attrvalue1'], $_POST['attrtype2'], $_POST['attrvalue2'], 
										$_POST['attrtype3'], $_POST['attrvalue3'], $_POST['attrtype4'], $_POST['attrvalue4'], $_POST['attrtype5'], $_POST['attrvalue5'], 
										$_POST['attrtype6'], $_POST['attrvalue6'], 
										$_POST['applytype0'], $_POST['applyvalue0'], $_POST['applytype1'], $_POST['applyvalue1'], $_POST['applytype2'], $_POST['applyvalue2'], 
										$_POST['applytype3'], $_POST['applyvalue3'], $_POST['applytype4'], $_POST['applyvalue4'], $_POST['applytype5'], $_POST['applyvalue5'], 
										$_POST['applytype6'], $_POST['applyvalue6'], $_POST['applytype7'], $_POST['applyvalue7']));
				}
				else if(ItemDescribe("applytype0") && IfSash($_POST['vnum']) && $_POST['time2'])
				{
					$stmt = $database->Player('INSERT item (owner_id, window, pos, count, vnum, socket1, socket2, attrtype0, attrvalue0, attrtype1 , attrvalue1, attrtype2, attrvalue2, attrtype3, attrvalue3, attrtype4, attrvalue4, attrtype5, attrvalue5, attrtype6, attrvalue6, applytype0, applyvalue0, applytype1, applyvalue1, applytype2, applyvalue2, applytype3, applyvalue3, applytype4, applyvalue4, applytype5, applyvalue5, applytype6, applyvalue6, applytype7, applyvalue7) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
					$stmt->execute(array($account_id, 'MALL', $item_position, $_POST['count'], $_POST['vnum'], $_POST['absorption'], $_POST['time2'],
										$_POST['attrtype0'], $_POST['attrvalue0'], $_POST['attrtype1'], $_POST['attrvalue1'], $_POST['attrtype2'], $_POST['attrvalue2'], 
										$_POST['attrtype3'], $_POST['attrvalue3'], $_POST['attrtype4'], $_POST['attrvalue4'], $_POST['attrtype5'], $_POST['attrvalue5'], 
										$_POST['attrtype6'], $_POST['attrvalue6'], 
										$_POST['applytype0'], $_POST['applyvalue0'], $_POST['applytype1'], $_POST['applyvalue1'], $_POST['applytype2'], $_POST['applyvalue2'], 
										$_POST['applytype3'], $_POST['applyvalue3'], $_POST['applytype4'], $_POST['applyvalue4'], $_POST['applytype5'], $_POST['applyvalue5'], 
										$_POST['applytype6'], $_POST['applyvalue6'], $_POST['applytype7'], $_POST['applyvalue7']));
				}
				else if(ItemDescribe("applytype0") && IfSash($_POST['vnum']))
				{
					$stmt = $database->Player('INSERT item (owner_id, window, pos, count, vnum, socket1, socket2, attrtype0, attrvalue0, attrtype1 , attrvalue1, attrtype2, attrvalue2, attrtype3, attrvalue3, attrtype4, attrvalue4, attrtype5, attrvalue5, attrtype6, attrvalue6, applytype0, applyvalue0, applytype1, applyvalue1, applytype2, applyvalue2, applytype3, applyvalue3, applytype4, applyvalue4, applytype5, applyvalue5, applytype6, applyvalue6, applytype7, applyvalue7) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
					$stmt->execute(array($account_id, 'MALL', $item_position, $_POST['count'], $_POST['vnum'], $_POST['absorption'], $_POST['time'],
										$_POST['attrtype0'], $_POST['attrvalue0'], $_POST['attrtype1'], $_POST['attrvalue1'], $_POST['attrtype2'], $_POST['attrvalue2'], 
										$_POST['attrtype3'], $_POST['attrvalue3'], $_POST['attrtype4'], $_POST['attrvalue4'], $_POST['attrtype5'], $_POST['attrvalue5'], 
										$_POST['attrtype6'], $_POST['attrvalue6'], 
										$_POST['applytype0'], $_POST['applyvalue0'], $_POST['applytype1'], $_POST['applyvalue1'], $_POST['applytype2'], $_POST['applyvalue2'], 
										$_POST['applytype3'], $_POST['applyvalue3'], $_POST['applytype4'], $_POST['applyvalue4'], $_POST['applytype5'], $_POST['applyvalue5'], 
										$_POST['applytype6'], $_POST['applyvalue6'], $_POST['applytype7'], $_POST['applyvalue7']));
				}
				else if(ItemDescribe("applytype0") && ($socket0 || $socket1 || $socket2))
				{
					$stmt = $database->Player('INSERT item (owner_id, window, pos, count, vnum, socket0, socket1, socket2, attrtype0, attrvalue0, attrtype1 , attrvalue1, attrtype2, attrvalue2, attrtype3, attrvalue3, attrtype4, attrvalue4, attrtype5, attrvalue5, attrtype6, attrvalue6, applytype0, applyvalue0, applytype1, applyvalue1, applytype2, applyvalue2, applytype3, applyvalue3, applytype4, applyvalue4, applytype5, applyvalue5, applytype6, applyvalue6, applytype7, applyvalue7) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
					$stmt->execute(array($account_id, 'MALL', $item_position, $_POST['count'], $_POST['vnum'], $socket0, $socket1, $socket2,
										$_POST['attrtype0'], $_POST['attrvalue0'], $_POST['attrtype1'], $_POST['attrvalue1'], $_POST['attrtype2'], $_POST['attrvalue2'], 
										$_POST['attrtype3'], $_POST['attrvalue3'], $_POST['attrtype4'], $_POST['attrvalue4'], $_POST['attrtype5'], $_POST['attrvalue5'], 
										$_POST['attrtype6'], $_POST['attrvalue6'], 
										$_POST['applytype0'], $_POST['applyvalue0'], $_POST['applytype1'], $_POST['applyvalue1'], $_POST['applytype2'], $_POST['applyvalue2'], 
										$_POST['applytype3'], $_POST['applyvalue3'], $_POST['applytype4'], $_POST['applyvalue4'], $_POST['applytype5'], $_POST['applyvalue5'], 
										$_POST['applytype6'], $_POST['applyvalue6'], $_POST['applytype7'], $_POST['applyvalue7']));
				}
				else if($socket0 || $socket1 || $socket2)
				{
					$stmt = $database->Player('INSERT item (owner_id, window, pos, count, vnum, socket0, socket1, socket2, attrtype0, attrvalue0, attrtype1 , attrvalue1, attrtype2, attrvalue2, attrtype3, attrvalue3, attrtype4, attrvalue4, attrtype5, attrvalue5, attrtype6, attrvalue6) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
					$stmt->execute(array($account_id, 'MALL', $item_position, $_POST['count'], $_POST['vnum'], $socket0, $socket1, $socket2,
										$_POST['attrtype0'], $_POST['attrvalue0'], $_POST['attrtype1'], $_POST['attrvalue1'], $_POST['attrtype2'], $_POST['attrvalue2'], 
										$_POST['attrtype3'], $_POST['attrvalue3'], $_POST['attrtype4'], $_POST['attrvalue4'], $_POST['attrtype5'], $_POST['attrvalue5'], 
										$_POST['attrtype6'], $_POST['attrvalue6']));
				}
				else if($_POST['time2']==0)
				{
					$stmt = $database->Player('INSERT item (owner_id, window, pos, count, vnum, socket2, attrtype0, attrvalue0, attrtype1 , attrvalue1, attrtype2, attrvalue2, attrtype3, attrvalue3, attrtype4, attrvalue4, attrtype5, attrvalue5, attrtype6, attrvalue6) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
					$stmt->execute(array($account_id, 'MALL', $item_position, $_POST['count'], $_POST['vnum'], $_POST['time'],
										$_POST['attrtype0'], $_POST['attrvalue0'], $_POST['attrtype1'], $_POST['attrvalue1'], $_POST['attrtype2'], $_POST['attrvalue2'], 
										$_POST['attrtype3'], $_POST['attrvalue3'], $_POST['attrtype4'], $_POST['attrvalue4'], $_POST['attrtype5'], $_POST['attrvalue5'], 
										$_POST['attrtype6'], $_POST['attrvalue6']));
				} else {
					$stmt = $database->Player('INSERT item (owner_id, window, pos, count, vnum, socket0, attrtype0, attrvalue0, attrtype1 , attrvalue1, attrtype2, attrvalue2, attrtype3, attrvalue3, attrtype4, attrvalue4, attrtype5, attrvalue5, attrtype6, attrvalue6) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
					$stmt->execute(array($account_id, 'MALL', $item_position, $_POST['count'], $_POST['vnum'], $_POST['time2'],
										$_POST['attrtype0'], $_POST['attrvalue0'], $_POST['attrtype1'], $_POST['attrvalue1'], $_POST['attrtype2'], $_POST['attrvalue2'], 
										$_POST['attrtype3'], $_POST['attrvalue3'], $_POST['attrtype4'], $_POST['attrvalue4'], $_POST['attrtype5'], $_POST['attrvalue5'], 
										$_POST['attrtype6'], $_POST['attrvalue6']));
				}
				$callback = '<div class="alert alert-success">'.l(122).'</div>';
			} else $callback = '<div class="alert alert-danger">'.l(123).'</div>';
			} else $callback = '<div class="alert alert-danger">'.l(124).'</div>';
	}
	$jsonBonuses = file_get_contents('system/database/bonuses.json');
	$jsonBonuses = json_decode($jsonBonuses,true);
	
	$form_bonuses = '';
	foreach($jsonBonuses as $bonus)
		$form_bonuses .= '<option value='.$bonus['id'].'>'.str_replace("[n]", 'XXX', $bonus[$language_code]).'</option>';
?>