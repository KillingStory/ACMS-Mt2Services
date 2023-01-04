<?php

	function clean($str)
	{       
		$str = utf8_decode($str);
		$str = str_replace("&nbsp;", "", $str);
		$str = preg_replace('/\s+/', ' ',$str);
		$str = trim($str);
		return $str;
	}
	function l($var)
	{
		global $language_code;
		global $database;
		
		$stmtasasas = $database->Sqlite("SELECT $language_code FROM website_languages WHERE const = '$var'");
		$stmtasasas->execute();
		$result = $stmtasasas->fetch(PDO::FETCH_ASSOC)[$language_code];
		return $result;
	}
	function HashPW($password)
	{
		$hash = "*".sha1(sha1($password, true));
		return strtoupper($hash);
	}
	
	function IfEmail($email) {
		if(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email)<=64)
			return true;
		else return false;
	}
	
	function CheckBAN($name)
	{
		global $database;
		
		$sth = $database->Account("DESCRIBE account");
		$sth->execute();
		$columns = $sth->fetchAll(PDO::FETCH_COLUMN);
		
		if(in_array($name, $columns))
			return true;
		else return false;
	}
	
	function availDt($id)
	{
		global $database;
		
		$stmt = $database->Account("SELECT availDt FROM account WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		if($result['availDt'] != "0000-00-00 00:00:00")
		{	
			$date1 = new DateTime("now");
			$date2 = new DateTime($result['availDt']);
			if($date1 < $date2)
				return 1;//banned
		} else return 0;
		
		return 0;
	}
	
	function BanReason($id)
	{
		global $database;
		
		$stmt = $database->Sqlite('SELECT reason FROM ban_log WHERE account_id = ? ORDER BY id DESC LIMIT 1');
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		if($result)
			return $result['reason'];
		else return '';
	}
	
	function TempBAN($id, $reason, $time_availDt)
	{
		global $database;
		
		$now_time = date('Y-m-d H:i:s');
		
		$stmt = $database->Sqlite("INSERT INTO ban_log (account_id, date, reason) VALUES (:id, :date, :reason)");
		$stmt->execute(array(':date'=>$now_time, ':id'=>$id, ':reason'=>$reason));
		
		$date = date('Y-m-d H:i:s', $time_availDt);

		$stmt = $database->Account("UPDATE account SET availDt = ? WHERE id = ?");
		$stmt->bindParam(1, $date, PDO::PARAM_STR);
		$stmt->bindParam(2, $id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	function unBAN($id)
	{
		global $database;
		
		$status = 'OK';
		
		$stmt = $database->Account("UPDATE account SET status = ? WHERE id = ?");
		$stmt->bindParam(1, $status, PDO::PARAM_STR);
		$stmt->bindParam(2, $id, PDO::PARAM_INT);
		$stmt->execute();
		
		if(CheckColumns('availDt'))
		{
			$reset_availDt = "0000-00-00 00:00:00";
			
			$stmt = $database->Account("UPDATE account SET availDt = ? WHERE id = ?");
			$stmt->bindParam(1, $reset_availDt, PDO::PARAM_STR);
			$stmt->bindParam(2, $id, PDO::PARAM_INT);
			$stmt->execute();
		}
	}
	
	function PermanentBAN($id, $reason)
	{
		global $database;
		
		$now_time = date('Y-m-d H:i:s');
		$status = 'BLOCK';
		
		$stmt = $database->Sqlite("INSERT INTO ban_log (account_id, date, reason) VALUES (:id, :date, :reason)");
		$stmt->execute(array(':date'=>$now_time, ':id'=>$id, ':reason'=>$reason));
		
		$stmt = $database->Account("UPDATE account SET status = ? WHERE id = ?");
		$stmt->bindParam(1, $status, PDO::PARAM_STR);
		$stmt->bindParam(2, $id, PDO::PARAM_INT);
		$stmt->execute();
	}
	
	function EncryptionKey($password)
	{
		return md5($password[10].$password[7].$password[3].$password[12].$password[24].$password[17].$password[26].$password[29].$password[18].$password[6]);
	}
	
	function BannedAccounts()
	{
		global $database;
		
		$status = 'BLOCK';
		
		$stmt = $database->Account("SELECT id FROM account WHERE status=?");
		$stmt->bindParam(1, $status, PDO::PARAM_STR);
		$stmt->execute();
		$banned = $stmt->fetchAll();
		
		$banned_array = array();
		foreach($banned as $id)
			$banned_array[] = $id['id'].' ';
		
		$ids = join(',',$banned_array);
		
		return $ids;
	}
	
	function PlayerEmpire($id)
	{
		global $database;
		
		$stmt = $database->Player("SELECT empire FROM player_index WHERE id = :id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['empire'];
	}
	
	function players10()
	{
		global $database;
		
		$bid = BannedAccounts();
		if($bid)
			$stmt = $database->Player("SELECT id, name, account_id, level FROM player WHERE name NOT LIKE '[%]%' AND account_id NOT IN (".$bid.") ORDER BY level DESC, exp DESC, playtime DESC, name ASC limit 10");
		else
			$stmt = $database->Player("SELECT id, name, account_id, level FROM player WHERE name NOT LIKE '[%]%' ORDER BY level DESC, exp DESC, playtime DESC, name ASC limit 10");
		$stmt->execute();
		$top = $stmt->fetchAll();
		
		return $top;
		
	}
	
	function GuildOwner($id)
	{
		global $database;
		
		$stmt = $database->Player("SELECT name FROM player WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['name'];
	}
	
	function AccountID($id)
	{
		global $database;
		
		$stmt = $database->Player("SELECT account_id FROM player WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['account_id'];
	}
	
	function guilds10()
	{
		global $database;
		
		$stmt = $database->Player("SELECT name, master, level FROM guild WHERE name NOT LIKE '[%]%' ORDER BY level DESC, ladder_point DESC, exp DESC, name ASC limit 10");
		$stmt->execute();
		$top = $stmt->fetchAll();
		
		return $top;
	}
	
	function TableExist($table)
	{
		global $database;
		
		$stmt = $database->Player("SHOW TABLES LIKE ?");
		$stmt->bindParam(1, $table, PDO::PARAM_STR);
		$stmt->execute(); 
		$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
		
		if(count($result))
			return true;
		else return false;
	}
	
	function OnlinePlayers($m)
	{
		global $database;
		
		$stmt = $database->Player("SELECT count(*) FROM player WHERE DATE_SUB(NOW(), INTERVAL ? MINUTE) < last_play");
		$stmt->bindParam(1, $m, PDO::PARAM_INT);
		$stmt->execute(); 
		$count = $stmt->fetchColumn(); 

		return $count;
	}
	
	function OnlinePlayers24($d)
	{
		global $database;
		
		$stmt = $database->Player("SELECT count(*) FROM player WHERE DATE_SUB(NOW(), INTERVAL ? DAY) < last_play");
		$stmt->bindParam(1, $d, PDO::PARAM_INT);
		$stmt->execute(); 
		$count = $stmt->fetchColumn(); 

		return $count;
	}
	
	function TotalCharacters()
	{
		global $database;
		
		$stmt = $database->Player("SELECT count(*) FROM player"); 
		$stmt->execute(); 
		$count = $stmt->fetchColumn(); 

		return $count;
	}
	
	function TotalAccounts()
	{
		global $database;
		
		$stmt = $database->Account("SELECT count(*) FROM account"); 
		$stmt->execute(); 
		$count = $stmt->fetchColumn(); 

		return $count;
	}
	
	function TotalGuilds()
	{
		global $database;
		
		$stmt = $database->Player("SELECT count(*) FROM guild"); 
		$stmt->execute(); 
		$count = $stmt->fetchColumn(); 

		return $count;
	}
	
	function TotalShops()
	{
		global $database;
		
		if(!TableExist('offline_shop_npc'))
			return 0;
		else
		{
			$stmt = $database->Player("SELECT count(*) FROM offline_shop_npc"); 
			$stmt->execute(); 
			$count = $stmt->fetchColumn(); 

			return $count;
		}
		return 5;
	}
	
	function LoginUsername($account)
	{
		global $database;
		
		$stmt = $database->Account('SELECT login FROM account WHERE id = ?');
		$stmt->bindParam(1, $account, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		return $result;
	}
	
	function ShowStats($key)
	{
		switch ($key) {
			case '1':
				return OnlinePlayers(10);
				break;
			case '2':
				return TotalAccounts();
				break;
			case '3':
				return TotalCharacters();
				break;
			case '4':
				return TotalGuilds();
				break;
			case '5':
				return TotalShops();
				break;
			case '6':
				return OnlinePlayers24(1);
				break;
			default:
				return "ERROR";
		}
	}
	
	function VerifyEmail($email) {
		if(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email)<=64)
			return true;
		else return false;
	}

	function VerifyUsername($name) {
		if(preg_match('/^[0-9a-zA-Z]*$/', $name, $matches) && strlen($name)>=5 && strlen($name)<=16)
			return true;
		else return false;
	}

	function VerifyPassword($password) {
		if(preg_match('/^[a-zA-Z0-9 @!#$%&(){}*+,\-.\/:;<>=?[\\]\^_|~]*$/', $password) && strlen($password)>=5 && strlen($password)<=16)
			return true;
		else return false;
	}
	
	function RefferalCreate($my_id, $ref)
	{
		global $database;
		
		$stmt = $database->Sqlite("INSERT INTO referrals (invited_by, registered) VALUES (:invited_by, :registered)");
		$stmt->execute(array(':invited_by'=>$ref, ':registered'=>$my_id));
	}
	
	function VerifyExistUsername($username)
	{
		global $database;
		
		$stmt = $database->Account("SELECT login FROM account WHERE login LIKE :username LIMIT 1");
		$stmt->bindparam(":username", $username);
		$stmt->execute();
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() == 1)
			return 1;
		else return 0;
	}
	
	function VerifyExistEmail($email)
	{
		global $database;
		
		$stmt = $database->Account("SELECT email FROM account WHERE email LIKE :email LIMIT 1");
		$stmt->bindparam(":email", $email);
		$stmt->execute();
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() == 1)
			return 1;
		else return 0;
	}
	
	function GetEmpire($id)
	{
		global $database;
		
		$stmt = $database->Player("SELECT empire FROM player_index WHERE id = :id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['empire'];
	}
	
	function CheckColumns($name)
	{
		global $database;
		
		$sth = $database->Account("DESCRIBE account");
		$sth->execute();
		$columns = $sth->fetchAll(PDO::FETCH_COLUMN);
		
		if(in_array($name, $columns))
			return true;
		else return false;
	}
	
	function CheckProto($name)
	{
		global $database;
		
		$sth = $database->Player("DESCRIBE item_proto");
		$sth->execute();
		$columns = $sth->fetchAll(PDO::FETCH_COLUMN);
		
		if(in_array($name, $columns))
			return true;
		else return false;
	}
	
	function CheckPlayer($name)
	{
		global $database;
		
		$sth = $database->Player("DESCRIBE player");
		$sth->execute();
		$columns = $sth->fetchAll(PDO::FETCH_COLUMN);
		
		if(in_array($name, $columns))
			return true;
		else return false;
	}
	
	function CheckBanned($id)
	{
		global $database;
		
		$stmt = $database->Account("SELECT availDt FROM account WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		if($result['availDt'] != "0000-00-00 00:00:00")
		{	
			$date1 = new DateTime("now");
			$date2 = new DateTime($result['availDt']);
			if($date1 < $date2)
				return 1;//banned
		} else return 0;
		
		return 0;
	}
	
	function checkStatus($id)
	{
		global $database;
		
		$stmt = $database->Account("SELECT status FROM account WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		if($result['status']=="OK")
			return 1;
		else return 0;
	}
	
	function FixAccount()
	{
		global $database;
		global $lang;
		
		$sth = $database->Account("DESCRIBE account");
		$sth->execute();
		$columns = $sth->fetchAll(PDO::FETCH_COLUMN);
		
		$fix = array(	"coins" => "ALTER TABLE account ADD coins int(20) NOT NULL DEFAULT 0",
						"jcoins" => "ALTER TABLE account ADD jcoins int(20) NOT NULL DEFAULT 0", 
						"passlost" => "ALTER TABLE account ADD passlost int(21) NOT NULL DEFAULT 0",
						"maillost" => "ALTER TABLE account ADD maillost int(21) NOT NULL DEFAULT 0");
		
		foreach($fix as $column => $query)
		if(!in_array($column, $columns))
		{
			$sth = $database->Account($fix[$column]);
			$sth->execute();

			print '<div class="alert alert-success" role="alert">Success - '.$column.'</center></div>';
		}
	}
	
	function YangFIX($n, $precision = 3)
	{
		if ($n < 1000000) 
		{
			$n_format = round($n/1000) . 'k';
		} 
		else if ($n < 1000000000) 
		{
			$n_format = round($n / 1000000) . 'kk';
		} 
		else 
		{
			$n_format = round($n / 1000000000) . 'kkk';
		}
		return $n_format;
	}
	
	function CharacterReset($id, $mapindex, $x, $y)
	{
		global $database;
		
		$stmt = $database->Player('SELECT map_index, x, y, exit_map_index FROM player WHERE id = ?');
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		if($result['map_index']!= $mapindex || $result['x']!= $x || $result['y']!= $y || $result['exit_map_index']!= $mapindex)
		{
			$stmt = $database->Player("UPDATE player SET map_index=".$mapindex.", x=".$x.", y=".$y.", exit_x=0, exit_y=0, exit_map_index=".$mapindex.", horse_riding=0 WHERE id=".$id);
			if($stmt->execute()) 
				return true;
			else
				return false;
		}
		return false;
	}
	
	function UpdatePassLost($session)
	{
		global $database;
		
		$passlost=rand(10000000,99999999);
		$stmt = $database->Account("UPDATE account SET passlost='$passlost' WHERE id=:id");
		$stmt->bindParam(':id', $session, PDO::PARAM_INT);
		if($stmt->execute()) return true;
	}
	
	function UpdateMailLost($session)
	{
		global $database;
		
		$passlost=rand(10000000,99999999);
		$stmt = $database->Account("UPDATE account SET maillost='$passlost' WHERE id=:id");
		$stmt->bindParam(':id', $session, PDO::PARAM_INT);
		if($stmt->execute()) return true;
	}
	
	function ResetPWCreditentials($user, $passlost, $accid)
	{
		global $database;
		
		$stmt = $database->Account("SELECT * FROM account WHERE id=:id");
		$stmt->bindParam(':id', $accid, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		if(md5($result['login'])==$user && md5($result['passlost'])==$passlost)
			return true;
		else return false;
	}
	
	function ResetMLCreditentials($user, $maillost, $accid)
	{
		global $database;
		
		$stmt = $database->Account("SELECT * FROM account WHERE id=:id");
		$stmt->bindParam(':id', $accid, PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		if(md5($result['login'])==$user && md5($result['maillost'])==$maillost)
			return true;
		else return false;
	}
	
	function SelectCharacterOwner()
	{
		global $database;
		global $_SESSION;
		
		$stmt = $database->Player("SELECT * FROM player WHERE account_id=:id");
		$stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
		$stmt->execute();
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		
		return $result['name'];
	}
	
	function GetAccountByName($name)
	{
		global $database;

		$sth = $database->Player("SELECT account_id FROM player WHERE name LIKE ?");
		$sth->bindParam(1, $name, PDO::PARAM_STR);
		$sth->execute();
		$account_id = $sth->fetchAll(PDO::FETCH_COLUMN);
		if($account_id)
			return $account_id[0];
		else return false;
	}
	
	function ItemDescribe($name)
	{
		global $database;
		
		$sth = $database->Player("DESCRIBE item");
		$sth->execute();
		$columns = $sth->fetchAll(PDO::FETCH_COLUMN);
		
		if(in_array($name, $columns))
			return true;
		else return false;
	}
	
	function IfSash($id)
	{
		if($id > 85000 && $id < 90000)
			return true;
		else return false;
	}
	
	function getItemSize($code)
	{
		return 3;
	}
	
	function NewPos($id_account, $new_item)
	{
		global $database;
			
		$sth = $database->Player('SELECT pos, vnum FROM item WHERE owner_id=? AND window="MALL" ORDER by pos ASC');
		$sth->bindParam(1, $id_account, PDO::PARAM_INT);
		$sth->execute();
		$result = $sth->fetchAll();
		
		$used = $items_used = $used_check = array();
		
		foreach( $result as $row ) {
			$used_check[] = $row['pos'];
			$used[$row['pos']] = 1;
			$items_used[$row['pos']] = $row['vnum'];
		}
		$used_check = array_unique($used_check);

		$free = -1;
		
		for($i=0; $i<45; $i++){
			if(!in_array($i,$used_check)){
				$ok = true;
				
				if($i>4 && $i<10)
				{
					if(array_key_exists($i-5, $used) && getItemSize($items_used[$i-5])>1)
						$ok = false;
				}
				else if($i>9 && $i<40)
				{
					if(array_key_exists($i-5, $used) && getItemSize($items_used[$i-5])>1)
						$ok = false;
					
					if(array_key_exists($i-10, $used) && getItemSize($items_used[$i-10])>2)
						$ok = false;
				}
				else if($i>39 && $i<45 && getItemSize($new_item)>1)
						$ok = false;
				
				if($ok)
					return $i;
			}
		}
		
		return $free;
	}
	
	function GetIP() {
		$ipaddress = getenv('HTTP_CLIENT_IP')?:
			getenv('HTTP_X_FORWARDED_FOR')?:
			getenv('HTTP_X_FORWARDED')?:
			getenv('HTTP_FORWARDED_FOR')?:
			getenv('HTTP_FORWARDED')?:
			getenv('REMOTE_ADDR');
		return $ipaddress;
	}
	
	function RPWMSG($link, $lang, $click_here)
	{
		global $_var;
		return '
		<style>
		* {
			box-sizing: border-box;
		}

		body {
			margin: 0;
			padding: 0;
		}

		a[x-apple-data-detectors] {
			color: inherit !important;
			text-decoration: inherit !important;
		}

		#MessageViewBody a {
			color: inherit;
			text-decoration: none;
		}

		p {
			line-height: inherit
		}

		@media (max-width:500px) {
			.icons-inner {
				text-align: center;
			}

			.icons-inner td {
				margin: 0 auto;
			}

			.row-content {
				width: 100% !important;
			}

			.column .border {
				display: none;
			}

			table {
				table-layout: fixed !important;
			}

			.stack .column {
				width: 100%;
				display: block;
			}
		}
		</style>
		<body style="background-color: #ffffff; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
		   <table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff;" width="100%">
		   <tbody>
			  <tr>
				 <td>
					<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
					   <tbody>
						  <tr>
							 <td>
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #595959; color: #000000; width: 480px;" width="480">
								   <tbody>
									  <tr>
										 <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
											<table border="0" cellpadding="0" cellspacing="0" class="heading_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
											   <tr>
												  <td style="width:100%;text-align:center;">
													 <h1 style="margin: 0; color: #555555; font-size: 23px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; line-height: 120%; text-align: center; direction: ltr; font-weight: 700; letter-spacing: normal; margin-top: 0; margin-bottom: 0;"><span class="tinyMce-placeholder" style="color: #ffffff;">'.Server_Details::GetSettings(1).'</span></h1>
												  </td>
											   </tr>
											</table>
										 </td>
									  </tr>
								   </tbody>
								</table>
							 </td>
						  </tr>
					   </tbody>
					</table>
					<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
					   <tbody>
						  <tr>
							 <td>
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #595959; color: #000000; width: 480px;" width="480">
								   <tbody>
									  <tr>
										 <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
											<table border="0" cellpadding="10" cellspacing="0" class="paragraph_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
											   <tr>
												  <td>
													 <div style="color:#000000;font-size:14px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-weight:400;line-height:120%;text-align:left;direction:ltr;letter-spacing:0px;">
														<p style="margin: 0;"><span style="color: #ffffff;">'.$lang.'</span></p>
													 </div>
												  </td>
											   </tr>
											</table>
											<table border="0" cellpadding="10" cellspacing="0" class="button_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
											   <tr>
												  <td>
													 <div align="center">
														<!--[if mso]>
														<v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" style="height:42px;width:86px;v-text-anchor:middle;" arcsize="10%" stroke="false" fillcolor="#3AAEE0">
														   <w:anchorlock/>
														   <v:textbox inset="0px,0px,0px,0px">
															  <center style="color:#ffffff; font-family:Arial, sans-serif; font-size:16px">
																 <![endif]-->
																 <div style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#3AAEE0;border-radius:4px;width:auto;border-top:1px solid #3AAEE0;font-weight:400;border-right:1px solid #3AAEE0;border-bottom:1px solid #3AAEE0;border-left:1px solid #3AAEE0;padding-top:5px;padding-bottom:5px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;text-align:center;mso-border-alt:none;word-break:keep-all;"><span style="padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;letter-spacing:normal;"><a href="'.$link.'"><span style="font-size: 16px; line-height: 2; mso-line-height-alt: 32px;">'.$click_here.'</span></a></span></div>
																 <!--[if mso]>
															  </center>
														   </v:textbox>
														</v:roundrect>
														<![endif]-->
													 </div>
												  </td>
											   </tr>
											</table>
										 </td>
									  </tr>
								   </tbody>
								</table>
							 </td>
						  </tr>
					   </tbody>
					</table>
					<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
					   <tbody>
						  <tr>
							 <td>
								<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #595959; color: #000000; width: 480px;" width="480">
								   <tbody>
									  <tr>
										 <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
											<table border="0" cellpadding="0" cellspacing="0" class="icons_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
											   <tr>
												  <td style="vertical-align: middle; color: #9d9d9d; font-family: inherit; font-size: 15px; padding-bottom: 5px; padding-top: 5px; text-align: center;">
													 <table cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
														<tr>
														   <td style="vertical-align: middle; text-align: center;">
															  <!--[if vml]>
															  <table align="left" cellpadding="0" cellspacing="0" role="presentation" style="display:inline-block;padding-left:0px;padding-right:0px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;">
																 <![endif]-->
																 <!--[if !vml]><!-->
																 <table cellpadding="0" cellspacing="0" class="icons-inner" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block; margin-right: -4px; padding-left: 0px; padding-right: 0px;">
																	<!--<![endif]-->
																 </table>
																 </td>
																 </tr>
															  </table>
														   </td>
														</tr>
													 </table>
												  </td>
											   </tr>
											   </tbody>
											</table>
										 </td>
									  </tr>
								   </tbody>
								</table>
							 </td>
						  </tr>
					   </tbody>
					</table>';
	}
?>