<?php
	class online_connection
	{
		public $verificator;
		
		public function __Connect($ip, $db, $user, $pass, $sqlite=null)
		{
			$this->verificator = null;
			try
			{
				if($sqlite==NULL)
					$this->verificator = new PDO("mysql:host=".$ip.";dbname=".$db, $user, $pass);
				else
				{
					$this->verificator = new PDO("sqlite:system/database/storage.db");
					$this->verificator->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				}
			}
			catch(PDOException $exception)
			{
				global $server_status;
				$server_status = 1;
			}
			return $this->verificator;
		}
	}
	if($server_status!=1)
	{
		class Connection
		{
			private $account;
			private $player;
			private $sqlite;
			private $verificator;
			
			public function __construct($ip, $user, $pass)
			{
				$online_connection = new online_connection();
				
				$account = $online_connection->__Connect($ip, "account", $user, $pass);
				$this->account = $account;
				
				$player = $online_connection->__Connect($ip, "player", $user, $pass);
				$this->player = $player;
				
				$common = $online_connection->__Connect($ip, "common", $user, $pass);
				$this->common = $common;
				
				$sqlite = $online_connection->__Connect("", "", "", "", "yes");
				$this->sqlite = $sqlite;
				
				$logs = $online_connection->__Connect($ip, "log", $user, $pass);
				$this->logs = $logs;
			}
			
			public function Account($sql)
			{
				$stmt = $this->account->prepare($sql);
				return $stmt;
			}
			
			public function Player($sql)
			{
				$stmt = $this->player->prepare($sql);
				return $stmt;
			}
			
			public function Common($sql)
			{
				$stmt = $this->common->prepare($sql);
				return $stmt;
			}
			
			public function Sqlite($sql)
			{
				$stmt = $this->sqlite->prepare($sql);
				return $stmt;
			}
			
			public function execSqlite($sql)
			{
				$stmt = $this->sqlite->exec($sql);
				return $stmt;
			}
			
			public function Logs($sql)
			{
				$stmt = $this->logs->prepare($sql);
				return $stmt;
			}
		}
	}
	
	function UserLogin($login,$password)
	{
		global $database;

		$password = HashPW($password);
	
			if(IfEmail($login))
				$stmt = $database->Account("SELECT id, status, password,login FROM account WHERE email=:login AND password=:password");
			else
				$stmt = $database->Account("SELECT id, status, password,login FROM account WHERE login=:login AND password=:password");
			$stmt->execute(array(':login'=>$login, ':password'=>$password));
			
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if($userRow['status']=='OK')
				{
					if(CheckBAN('availDt') && availDt($userRow['id']))
						return array(5, BanReason($userRow['id']), availDt($userRow['id']));
					$_SESSION['id'] = $userRow['id'];
					$_SESSION['usern'] = $userRow['login'];
					$_SESSION['password'] = EncryptionKey($userRow['password']);
					$_SESSION['fingerprint'] = md5($_SERVER['HTTP_USER_AGENT'] . 'x' . $_SERVER['REMOTE_ADDR']);
					return array(1);
				}
				else
					return array(2, BanReason($userRow['id']));
			} else {
				if(IfEmail($login))
					return array(4);
				else
					return array(3);
			}
		
	}

	function UserRegister($username, $password, $email, $delc, $ref)
	{
		global $database;
		$safebox_size = 1;
		
		$password = HashPW($password);
		$status = "OK";
		
		$stmt = $database->Account("INSERT INTO account (login, password, social_id, email, create_time, status) VALUES(:login, :password, :social_id, :email, NOW(), :status)");
		$stmt->bindparam(":login", $username);
		$stmt->bindparam(":password", $password);
		$stmt->bindparam(":social_id", $delc);
		$stmt->bindparam(":email", $email);
		$stmt->bindparam(":status", $status);
			
		if($stmt->execute())
		{
			$stmta = $database->Account("SELECT max(id) as max FROM account");
			$stmta-> execute();
			$lastId = $stmta->fetch(PDO::FETCH_ASSOC)['max'];
			$safebox_password = "000000";
			
			$stmt = $database->Player("INSERT INTO safebox(account_id, size, password) VALUES(:account_id, :size, :password)");
			$stmt->bindparam(":account_id", $lastId);
			$stmt->bindparam(":size", $safebox_size);
			$stmt->bindparam(":password", $safebox_password);
				
			if($stmt->execute())
			{
				if($ref && count(LoginUsername($ref)))
					RefferalCreate($lastId, $ref);
				return true;
			}
			else return false;
		}
		else return false;
	}

	function signed()
	{
		if(isset($_SESSION['id']))
			return true;
		else 
			return false;
	}
	
	function __SESSION()
	{
		if(isset($_SESSION['id']))
			return $_SESSION['id'];
		else 
			return false;
	}
	
	function areadmin()
	{
		if(signed())
		{
			global $database;
			
			$stmt = $database->Account("SELECT web_admin FROM account WHERE id=:id");
			$stmt->execute(array(':id'=>__SESSION()));
			$type = $stmt->fetch(PDO::FETCH_ASSOC)['web_admin'];
			if($type > 0)
				return true;
			else
				return false;
		}
	}

	function GetDirectorySize($path)
	{
		$bytestotal = 0;
		$path = realpath($path);
		if($path!==false && $path!='' && file_exists($path)){
			foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
				$bytestotal += $object->getSize()/1024;
			}
		}
		return round($bytestotal);
	}

	class Server_Details
	{
		public static function GetSettings($var)
		{
			global $database;
			
			$stmt = $database->Sqlite("SELECT * FROM settings WHERE id=:id");
			$stmt->execute(array(':id'=>$var));
			
			return $stmt->fetch(PDO::FETCH_ASSOC)['value'];
		}
		
		public static function NewsRecords()
		{
			global $database;
			
			$var = 5;
			$stmt = $database->Sqlite("SELECT * FROM settings WHERE id=:id");
			$stmt->execute(array(':id'=>$var));
			
			return $stmt->fetch(PDO::FETCH_ASSOC)['value'];
		}
		
		public static function GetSEO($var)
		{
			global $database;
			
			$stmt = $database->Sqlite("SELECT * FROM seo WHERE id=:id");
			$stmt->execute(array(':id'=>$var));
			
			return $stmt->fetch(PDO::FETCH_ASSOC)['value'];
		}
		
		public static function UpdateSettings($var, $value)
		{
			global $database;
			
			$stmt = $database->Sqlite("UPDATE settings SET value=:value WHERE id=:id");
			$stmt->execute(array(':id'=>$var, ':value'=>$value));
		}
		
		public static function UpdateSEO($var, $value)
		{
			global $database;
			
			$stmt = $database->Sqlite("UPDATE seo SET value=:value WHERE id=:id");
			$stmt->execute(array(':id'=>$var, ':value'=>$value));
		}
		
	}
	
	class News
	{
		public static function read($var,$get)
		{
			global $database;
			
			$stmt = $database->Sqlite("SELECT * FROM articles WHERE id=:id");
			$stmt->execute(array(':id'=>$var));
			
			return $stmt->fetch(PDO::FETCH_ASSOC)[$get];
		}
		
		public static function Show()
		{
			global $database;
			
			$stmt = $database->Sqlite("SELECT * FROM articles");
			$stmt->execute();
			return $stmt->fetchAll();
		}
		
		public static function Get($var, $show)
		{
			global $database;
			
			$stmt = $database->Sqlite("SELECT * FROM articles WHERE id=:id");
			$stmt->execute(array(':id'=>$var));
			
			return $stmt->fetch(PDO::FETCH_ASSOC)[$show];
		}
		
		public static function Update($title, $content, $var)
		{
			global $database;
			
			$stmt = $database->Sqlite("UPDATE articles SET title=:title,content=:content WHERE id=:id");
			$stmt->execute(array(':id'=>$var, ':title'=>$title, ':content'=>$content));
		}
		
		public static function Add($title, $content)
		{
			global $database;
			
			$owner= SelectCharacterOwner();
			$time = date('Y-m-d H:i:s');
			$stmt = $database->Sqlite("INSERT INTO articles (title, content, time, owner) VALUES (:title, :content, :time, :owner)");
			$stmt->execute(array(':title'=>$title, ':content'=>$content, ':time'=>$time, ':owner'=>$owner));
		}
		
		public static function NDelete($id)
		{
			global $database;
			
			$stmt = $database->Sqlite("DELETE FROM articles WHERE id=:id");
			$stmt->execute(array(':id'=>$id));
		}
	}

	class Theme
	{
		public static function Path()
		{
			$get_url = URL;

			if (substr($get_url , -1)!='/')
				$get_url.='/';
			
			$get_url.= 'style/';
			$get_url.= Server_Details::GetSettings(3);
			$get_url.= '/';
			return $get_url;
		}
		
		public static function URL()
		{
			$get_url = URL;

			if (substr($get_url , -1)!='/')
				$get_url.='/';

			return $get_url;
		}
		
		public static function Page_Path($page)
		{
			if($page!='admin')
			{
				$get_url='public/';
				$get_url.= Server_Details::GetSettings(3);
				$get_url.='/pages/';
				$get_url.=$page;
				$get_url.='.php';
				return $get_url;
			}
		}
		
		public static function Admin_Path($page)
		{
			$get_url='public/admin_';
			$get_url.= Server_Details::GetSettings(6);
			$get_url.='/pages/'.$page.'.php';
			return $get_url;
		}
		
		public static function Admin_Style()
		{
			$get_url='public/admin_';
			$get_url.= Server_Details::GetSettings(6);
			$get_url.='/';
			return $get_url;
		}
		
		public static function Admin_PathStyle()
		{
			$get_url = URL;

			if (substr($get_url , -1)!='/')
				$get_url.='/';
			
			$get_url.= 'style/admin_';
			$get_url.= Server_Details::GetSettings(6);
			$get_url.= '/';
			return $get_url;
		}
		
		public static function MenuActive($pagesss)
		{
			global $_GET;
			
			if(!isset($_GET['p'])) 
				$crtpage = 'home';
			else
				$crtpage = $_GET['p'];
			
			
			if($crtpage == $pagesss)
				return 'class="active"';
		}
		
		public static function MenuActive2($pagesss)
		{
			global $_GET;
			
			if(!isset($_GET['p'])) 
				$crtpage = 'home';
			else
				$crtpage = $_GET['p'];
			
			
			if($crtpage == $pagesss)
				return 'active';
		}
		
		public static function Logo()
		{
			global $database;
			
			$stmt = $database->Sqlite("SELECT * FROM settings WHERE id='11'");
			$stmt -> execute();
			return $stmt->fetch(PDO::FETCH_ASSOC)['value'];
		}
		
		public static function AddLogo($link)
		{
			global $database;
			
			$stmt = $database->Sqlite("UPDATE settings SET value=:logo WHERE id='11'");
			$stmt->execute(array(':logo'=>$link));
		}
		
		public static function Fav()
		{
			global $database;
			
			$stmt = $database->Sqlite("SELECT * FROM settings WHERE id='12'");
			$stmt -> execute();
			return $stmt->fetch(PDO::FETCH_ASSOC)['value'];
		}
		
		public static function Used()
		{
			global $database;
			
			$stmt = $database->Sqlite("SELECT * FROM settings WHERE id='3'");
			$stmt -> execute();
			return $stmt->fetch(PDO::FETCH_ASSOC)['value'];
		}
		
		public static function URLVerificator($id)
		{
			global $database;
			
			$stmt = $database->Sqlite('SELECT * FROM settings WHERE id = ?');
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if($result['value']=='0' || $result['value']==null)
				return false;
			else
				return true;
		}
	}
	
	class Player
	{
		public static function Username($var)
		{
			global $database;
			
			$stmt = $database->Account("SELECT login FROM account WHERE id=:id");
			$stmt->execute(array(':id'=>$var));
			
			return $stmt->fetch(PDO::FETCH_ASSOC)['login'];
		}
		
		public static function Email($var)
		{
			global $database;
			
			$stmt = $database->Account("SELECT email FROM account WHERE id=:id");
			$stmt->execute(array(':id'=>$var));
			
			return $stmt->fetch(PDO::FETCH_ASSOC)['email'];
		}
		
		public static function Coins($var)
		{
			global $database;
			
			$stmt = $database->Account("SELECT coins FROM account WHERE id=:id");
			$stmt->execute(array(':id'=>$var));
			
			return $stmt->fetch(PDO::FETCH_ASSOC)['coins'];
		}
		
		public static function JCoins($var)
		{
			global $database;
			
			$stmt = $database->Account("SELECT jcoins FROM account WHERE id=:id");
			$stmt->execute(array(':id'=>$var));
			
			return $stmt->fetch(PDO::FETCH_ASSOC)['jcoins'];
		}
		
		public static function PassLost($var)
		{
			global $database;
			
			$stmt = $database->Account("SELECT passlost FROM account WHERE id=:id");
			$stmt->execute(array(':id'=>$var));
			
			return $stmt->fetch(PDO::FETCH_ASSOC)['passlost'];
		}
		
		public static function MailLost($var)
		{
			global $database;
			
			$stmt = $database->Account("SELECT maillost FROM account WHERE id=:id");
			$stmt->execute(array(':id'=>$var));
			
			return $stmt->fetch(PDO::FETCH_ASSOC)['maillost'];
		}
		
		public static function TotalChars($var)
		{
			global $database;
			
			$stmt = $database->Player("SELECT COUNT(*) as total FROM player WHERE account_id=:id");
			$stmt->execute(array(':id'=>$var));
			
			return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
		}
		
		public static function TGold($var)
		{
			global $database;
			
			$stmt = $database->Player("SELECT account_id,SUM(gold) as total FROM player WHERE account_id=:id GROUP BY account_id");
			$stmt->execute(array(':id'=>$var));
			$count = $stmt-> rowCount();
			if($count>0)
			{
				$yang = $stmt->fetch(PDO::FETCH_ASSOC);
				
				if($yang['total']>0)
					return YangFIX($yang['total']);
				else return 0;
			}
			else return 0;
		}
		
		public static function CharList()
		{
			global $database;
			
			$stmt = $database->Player("SELECT * FROM player WHERE account_id = :id");
			$stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
			$stmt->execute();
			
			return $result=$stmt->fetchAll();
		}
	}
	
	class ACP
	{
		public static function map1()
		{
			global $database;
			
			$stmt = $database->Player("SELECT * FROM player WHERE map_index='1' AND DATE_SUB(NOW(), INTERVAL 5 MINUTE) < last_play");
			$stmt->execute();
			
			return $result=$stmt->fetchAll();
		}
		
		public static function map2()
		{
			global $database;
			
			$stmt = $database->Player("SELECT * FROM player WHERE map_index='21' AND DATE_SUB(NOW(), INTERVAL 5 MINUTE) < last_play");
			$stmt->execute();
			
			return $result=$stmt->fetchAll();
		}
		
		public static function map3()
		{
			global $database;
			
			$stmt = $database->Player("SELECT * FROM player WHERE map_index='41' AND DATE_SUB(NOW(), INTERVAL 5 MINUTE) < last_play");
			$stmt->execute();
			
			return $result=$stmt->fetchAll();
		}
		
		public static function OnlineMap($var)
		{
			global $database;
			
			$stmt = $database->Player("SELECT COUNT(id) as result FROM player WHERE map_index='$var' AND DATE_SUB(NOW(), INTERVAL 5 MINUTE) < last_play");
			$stmt->execute();
			
			return $stmt->fetch(PDO::FETCH_ASSOC)['result'];
		}
		
		public static function UpdateNewsSettings($id, $val)
		{
			global $database;
			
			$stmt = $database->Sqlite("UPDATE settings SET value=:value WHERE id=:id");
			if($stmt->execute(array(':value'=>$val, ':id'=>$id)))
				return true;
		}
		
		public static function ShowNewsSettings($var)
		{
			global $database;
			
			$stmt = $database->Sqlite("SELECT * FROM settings WHERE id=:idvalue");
			$stmt->execute(array(':idvalue'=>$var));
			$res = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if($res['value']==1)
				print 'checked';
		}
		
		public static function VerifyNewsSettings($var)
		{
			global $database;
			
			$stmt = $database->Sqlite("SELECT * FROM settings WHERE id=:idvalue");
			$stmt->execute(array(':idvalue'=>$var));
			$res = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if($res['value']==1)
				return true;
		}
		
		public static function ServerLogs()
		{
			global $database;
			
			$stmt = $database->Logs("SHOW TABLES");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
			
			return $result;
		}
		
		public static function ServerLogsColumns($table)
		{
			global $database;
			
			$stmt = $database->Logs("DESCRIBE ".$table);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
			
			return $result;
		}

		public static function DeleteVoucher($id)
		{
			global $database;
			
			$stmt = $database->Sqlite('DELETE FROM redeem WHERE id = ?');
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			if($stmt->execute())
				return true;
		}

		public static function CodeGenerator($length = 7) 
		{
			$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}

		public static function CheckVoucher($code)
		{
			global $database;

			$stmt = $database->Sqlite("SELECT id FROM redeem WHERE code = ?");
			$stmt->bindParam(1, $code, PDO::PARAM_STR);
			$stmt->execute();
			$check = $stmt->fetchAll();

			if(count($check))
				return true;
			else return false;
		}

		public static function CreateVoucher($type, $value)
		{
			global $database;

			$ok = false;
			
			while(!$ok)
			{
				$code = ACP::CodeGenerator(16);
				
				if(!ACP::CheckVoucher($code))
					$ok = true;
			}
			
			$stmt = $database->Sqlite("INSERT INTO redeem (code, type, value) VALUES (:code, :type, :value)");
			$stmt->execute(array(':code'=>$code, ':type'=>$type, ':value'=>$value));
			
			return $code;
		}
		
		public static function RedeemVoucher($code)
		{
			global $database;

			$stmt = $database->Sqlite("SELECT * FROM redeem WHERE code = ? LIMIT 1");
			$stmt->bindParam(1, $code, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			return $result;
		}
		
		public static function ADDC($account_id, $coins)
		{
			global $database;

			$stmt = $database->Account("UPDATE account SET coins = coins + ? WHERE id = ?");
			$stmt->bindParam(1, $coins, PDO::PARAM_INT);
			$stmt->bindParam(2, $account_id, PDO::PARAM_INT);
			$stmt->execute();
		}
	
		public static function ADDJC($account_id, $coins)
		{
			global $database;

			$stmt = $database->Account("UPDATE account SET jcoins = jcoins + ? WHERE id = ?");
			$stmt->bindParam(1, $coins, PDO::PARAM_INT);
			$stmt->bindParam(2, $account_id, PDO::PARAM_INT);
			$stmt->execute();
		}
		
		public static function DelV4C($id)
		{
			global $database;
			
			$stmt = $database->Sqlite('DELETE FROM vote4coins WHERE site = ?');
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			if($stmt->execute())
				return true;
		}
		
		public static function CharsCount($id)
		{
			global $database;
			
			$stmt = $database->Player('SELECT id FROM player WHERE account_id=?');
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			$count = $stmt->rowCount(); 
			if($count>0)
				return true;
			else return false;
		}
		
		public static function CharsLists($id)
		{
			global $database;
			
			$stmt = $database->Player('SELECT * FROM player WHERE account_id=?');
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			$count = $stmt->rowCount();
			if($count>0)
			{
				return $result = $stmt->fetchAll();
			}
		}
		
		public static function GetItemName($id)
		{
			global $database;
			global $language_code;
			
			$stmt = $database->Sqlite('SELECT * FROM game_items WHERE id=?');
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if(isset($result[$language_code]))
				return $result[$language_code];
			elseif(CheckProto('locale_name_'.$language_code))
			{
				$stmta = $database->Player('SELECT * FROM item_proto WHERE vnum=?');
				$stmta->bindParam(1, $id, PDO::PARAM_INT);
				$stmta->execute();
				$resulta = $stmta->fetch(PDO::FETCH_ASSOC);
				if(isset($resulta['locale_name_'.$language_code]))
					return $resulta['locale_name_'.$language_code];
				elseif(isset($resulta['locale_name']))
				{
					if(isset($resulta['locale_name']))
					return $resulta['locale_name'];
				}
				else
					return $id;
			}
			else
				return $id;
		}
		
		public static function CountItemsPlayer($id, $window)
		{
			global $database;
			
			$stmt = $database->Player('SELECT * FROM item WHERE owner_id=? AND window=? ORDER BY vnum ASC');
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->bindParam(2, $window, PDO::PARAM_STR);
			$stmt->execute();
			$count = $stmt -> rowCount();
			if($count>0)
				return true;
			else return false;
		}
		
		public static function GetItemsPlayer($id, $window)
		{
			global $database;
			
			$stmt = $database->Player('SELECT * FROM item WHERE owner_id=? AND window=? ORDER BY vnum ASC');
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->bindParam(2, $window, PDO::PARAM_STR);
			$stmt->execute();
			$count = $stmt -> rowCount();
			if($count>0)
				return $result = $stmt->fetchAll();
		}
		
		public static function GetBonus($id, $replace)
		{
			global $database;
			global $language_code;
			
			$stmt = $database->Sqlite('SELECT * FROM bonus_names WHERE id=?');
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if(isset($result[$language_code]))
			{
			
				return $preg = str_replace("[n]", $replace, $result[$language_code]);
			}
			
		}
		
		public static function GetCharsDetails($id, $show)
		{
			global $database;
			
			$stmt = $database->Player('SELECT * FROM player WHERE id=?');
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			
			return $result = $stmt->fetch(PDO::FETCH_ASSOC)[$show];
		}
		
		public static function CharStatus($value)
		{
			if($value >= 12000)
				return '<span style="color:#3399FF;">Cavaler</span>';
			elseif($value >= 8000 &&  $value <= 11999)
				return '<span style="color:#0066CC;">Nobil</span>';
			elseif($value >= 4000 &&  $value <= 7999)
				return '<span style="color:#003366;">Good</span>';
			elseif($value >= 1000 &&  $value <= 3999)
				return '<span style="color:#336699;">Friendly</span>';
			elseif($value >= 0 &&  $value <= 999)
				return '<span style="">Neutral</span>';
			elseif($value >= -3999 &&  $value <= -1)
				return '<span style="color:#660000;">Agresiv</span>';
			elseif($value >= -7999 &&  $value <= -4000)
				return '<span style="color:#990000;">Dezonorat</span>';
			elseif($value >= -11999 &&  $value <= -8000)
				return '<span style="color:#CC0000;">Răutăcios</span>';
			elseif($value <= 12000)
				return '<span style="color:#FF0000;">Crud</span>';
				
		}
		
	}
	
	class Vote
	{
		public static function Check($key, $id)
		{
			global $database;

			$stmt = $database->Sqlite("SELECT site FROM vote4coins WHERE site = ? AND account_ip = ?");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->bindParam(2, $key, PDO::PARAM_STR);
			$stmt->execute();
			$check = $stmt->fetchAll();

			if(count($check))
				return true;
			else return false;
		}
		
		public static function CheckAccount($id)
		{
			global $database;

			$stmt = $database->Sqlite("SELECT site FROM vote4coins WHERE site = ? AND account_id= ?");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->bindParam(2,  $_SESSION['id'], PDO::PARAM_INT);
			$stmt->execute();
			$check = $stmt->fetchAll();

			if(count($check))
				return true;
			else return false;
		}
		
		public static function Insert($id, $ip)
		{
			global $database;
			
			$date = date('Y-m-d G:i');
			$account = $_SESSION['id'];
			
			$stmt = $database->Sqlite("INSERT INTO vote4coins (site, account_id, account_ip, date) VALUES (:site, :account_id, :account_ip, :date)");
			$stmt->execute(array(':date'=>$date, ':account_id'=>$account, ':account_ip'=>$ip, ':site'=>$id));
		}
	
		public static function ChecksDate($id, $ip)
		{
			global $database;
			
			$stmt = $database->Sqlite("SELECT date FROM vote4coins WHERE site = ? AND account_ip = ? ORDER BY date DESC LIMIT 1");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->bindParam(2, $ip, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
			
			if($result)
				return $result[0];
			else return "0000-00-00 00:00";
		}
	
		public static function ChecksDateAccount($id)
		{
			global $database;
			
			$stmt = $database->Sqlite("SELECT date FROM vote4coins WHERE site = ? AND account_id = ?");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->bindParam(2, $_SESSION['id'], PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_COLUMN);

			if($result)
				return $result[0];
			else return "0000-00-00 00:00";
		}
		
		public static function Update($site, $ip)
		{
			global $database;
			
			$date = date('Y-m-d G:i');

			$stmt = $database->Sqlite("UPDATE vote4coins SET account_ip = ?, date = ? WHERE site = ? AND account_id = ?");
			$stmt->bindParam(1, $ip, PDO::PARAM_STR);
			$stmt->bindParam(2, $date, PDO::PARAM_STR);
			$stmt->bindParam(3, $site, PDO::PARAM_INT);
			$stmt->bindParam(4, $_SESSION['id'], PDO::PARAM_INT);
			$stmt->execute();
		}
	}
	
	class Social
	{
		public static function Verify($id)
		{
			global $database;
			
			$stmt = $database->Sqlite('SELECT * FROM seo WHERE id = ?');
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if($result['value']=='0' || $result['value']==null)
				return false;
			else
				return true;
		}
		
		
		public static function Show($id)
		{
			global $database;
			
			$stmt = $database->Sqlite('SELECT * FROM seo WHERE id = ?');
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC)['value'];
			if($result!='' || $result!=null)
				return $result;
		}
	}
	
	class Refferals
	{
		public static function Check($id)
		{
			global $database;
			
			$stmt = $database->Sqlite('SELECT * FROM referrals WHERE invited_by = ? AND registered = ? AND claimed = 0');
			$stmt->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
			$stmt->bindParam(2, $id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetchAll();
			
			return $result;
		}
		
		public static function Info($account)
		{
			global $database;
			
			$stmt = $database->Player('SELECT *
				FROM player
				WHERE account_id = ? ORDER BY level DESC LIMIT 1');
			$stmt->bindParam(1, $account, PDO::PARAM_INT);
			$stmt->execute();
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
			
			return $result;
		}
		
		public static function Update($id)
		{
			global $database;
			
			$stmt = $database->Sqlite("UPDATE referrals SET claimed = 1 WHERE registered=:id");
			$stmt->execute(array(':id'=>$id));
		}
		
		public static function Get()
		{
			global $database;
			
			$stmt = $database->Sqlite('SELECT * FROM referrals WHERE invited_by = ?');
			$stmt->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetchAll();
			
			return $result;
		}
		
		public static function _Info($account)
		{
			global $database;
			
			$stmt = $database->Player('SELECT * FROM player WHERE account_id = ? ORDER BY level DESC LIMIT 1');
			$stmt->bindParam(1, $account, PDO::PARAM_INT);
			$stmt->execute();
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
			
			return $result;
		}
		
	}
	
	class Charts
	{
		public static function OnlinePlayers()
		{
			global $database;
			
			$stmt = $database->Player("SELECT count(*) FROM player WHERE DATE_SUB(NOW(), INTERVAL 5 MINUTE) < last_play");
			$stmt->execute(); 
			$count = $stmt->fetchColumn(); 

			return $count;
		}
		
		public static function Characters()
		{
			global $database;
			
			$stmt = $database->Player("SELECT count(*) FROM player");
			$stmt->execute(); 
			$count = $stmt->fetchColumn(); 

			return $count;
		}
		
		public static function Accounts()
		{
			global $database;
			
			$stmt = $database->Account("SELECT count(*) FROM account");
			$stmt->execute(); 
			$count = $stmt->fetchColumn(); 

			return $count;
		}
		
		public static function Empire($var)
		{
			global $database;
			
			if($var==100)
				$stmt = $database->Player("SELECT count(*) FROM player WHERE DATE_SUB(NOW(), INTERVAL 5 MINUTE) < last_play AND map_index!='1' AND map_index!='21' AND map_index!='41'");
			else
				$stmt = $database->Player("SELECT count(*) FROM player WHERE DATE_SUB(NOW(), INTERVAL 5 MINUTE) < last_play AND map_index='$var'");
			$stmt->execute(); 
			$count = $stmt->fetchColumn(); 

			return $count;
		}
	}
	
	class Lang
	{
		public static function Change($var)
		{
			$redir = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
			$redir.= '?lang='.$var;
			
			return $redir;
		}
		
		public static function Update($langcode, $upload, $id)
		{
			global $database;
			
			$stmt = $database->Sqlite("UPDATE website_languages SET $langcode=:value WHERE const=:id");
			$stmt->execute(array(':id'=>$id, ':value'=>$upload));
		}
		
		public static function Add($langcode)
		{
			global $database;
			
				$stmt = $database->Sqlite("ALTER TABLE website_languages ADD $langcode VARCHAR;");
				if($stmt->execute())
					return true;
				else return false;
		}
	}
	
	class Custom_Pages
	{
		public static function Update($contain, $lup, $id)
		{
			global $database;
			
			$stmt = $database->Sqlite("UPDATE custom_pages SET contain=:contain, last_update=:lastup WHERE id=:id");
			$stmt->execute(array(':contain'=>$contain, 'lastup'=>$lup, 'id'=>$id));
		}
		
		public static function Show($id, $what)
		{
			global $database;
			
			$stmt = $database->Sqlite("SELECT * FROM custom_pages WHERE id=:id");
			$stmt->execute(array('id'=>$id));
			
			return $result=$stmt->fetch(PDO::FETCH_ASSOC)[$what];
		}
		
		public static function AllList()
		{
			global $database;
			
			$stmt = $database->Sqlite("SELECT * FROM custom_pages");
			$stmt->execute();
			
			return $result=$stmt->fetchAll();
		}
	}
	
	class Permission
	{
		public static function WebAdmin($accountuser)
		{
			global $database;
			$given = 1;
			
			$stmt = $database->Account("UPDATE account SET web_admin=? WHERE login=? AND web_admin!='99'");
			$stmt->bindParam(1, $given, PDO::PARAM_INT);
			$stmt->bindParam(2, $accountuser, PDO::PARAM_STR);
			if($stmt->execute())
				print '<script>GeneralSuccess("Permission added");</script>';
		}
		public static function AddAdminAllowance($username, $articles, $downloads, $logs, $createitem, $banplay, $promotional, $vote4coins, $refferal, $genset, $custpag, $adlang, $editlang, $manateme, $marketplace, $plugsett)
		{
			global $database;
			
			$stmt = $database->Sqlite("SELECT username FROM permission");
			$stmt->execute();
			$result= $stmt->fetch(PDO::FETCH_ASSOC);
			
			if(!isset($result['username']))
			{
				$stmt = $database->Sqlite("INSERT INTO permission (username, articles, downloads, logs, createitem, banplay, promotional, vote4coins, refferal, genset, custpag, adlang, editlang, manateme, marketplace, plugsett) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
				$stmt->bindParam(1, $username, PDO::PARAM_STR);
				$stmt->bindParam(2, $articles, PDO::PARAM_INT);
				$stmt->bindParam(3, $downloads, PDO::PARAM_INT);
				$stmt->bindParam(4, $logs, PDO::PARAM_INT);
				$stmt->bindParam(5, $createitem, PDO::PARAM_INT);
				$stmt->bindParam(6, $banplay, PDO::PARAM_INT);
				$stmt->bindParam(7, $promotional, PDO::PARAM_INT);
				$stmt->bindParam(8, $vote4coins, PDO::PARAM_INT);
				$stmt->bindParam(9, $refferal, PDO::PARAM_INT);
				$stmt->bindParam(10, $genset, PDO::PARAM_INT);
				$stmt->bindParam(11, $custpag, PDO::PARAM_INT);
				$stmt->bindParam(12, $adlang, PDO::PARAM_INT);
				$stmt->bindParam(13, $editlang, PDO::PARAM_INT);
				$stmt->bindParam(14, $manateme, PDO::PARAM_INT);
				$stmt->bindParam(15, $marketplace, PDO::PARAM_INT);
				$stmt->bindParam(16, $plugsett, PDO::PARAM_INT);
				if($stmt->execute())
					Permission::WebAdmin($username);
			} 
			elseif($result['username']!=$username)
			{
				$stmt = $database->Sqlite("INSERT INTO permission (username, articles, downloads, logs, createitem, banplay, promotional, vote4coins, refferal, genset, custpag, adlang, editlang, manateme, marketplace, plugsett) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
				$stmt->bindParam(1, $username, PDO::PARAM_STR);
				$stmt->bindParam(2, $articles, PDO::PARAM_INT);
				$stmt->bindParam(3, $downloads, PDO::PARAM_INT);
				$stmt->bindParam(4, $logs, PDO::PARAM_INT);
				$stmt->bindParam(5, $createitem, PDO::PARAM_INT);
				$stmt->bindParam(6, $banplay, PDO::PARAM_INT);
				$stmt->bindParam(7, $promotional, PDO::PARAM_INT);
				$stmt->bindParam(8, $vote4coins, PDO::PARAM_INT);
				$stmt->bindParam(9, $refferal, PDO::PARAM_INT);
				$stmt->bindParam(10, $genset, PDO::PARAM_INT);
				$stmt->bindParam(11, $custpag, PDO::PARAM_INT);
				$stmt->bindParam(12, $adlang, PDO::PARAM_INT);
				$stmt->bindParam(13, $editlang, PDO::PARAM_INT);
				$stmt->bindParam(14, $manateme, PDO::PARAM_INT);
				$stmt->bindParam(15, $marketplace, PDO::PARAM_INT);
				$stmt->bindParam(16, $plugsett, PDO::PARAM_INT);
				if($stmt->execute())
					Permission::WebAdmin($username);
			}
			else
			{
				$stmt = $database->Sqlite("UPDATE permission SET articles=?, downloads=?, logs=?, createitem=?, banplay=?, promotional=?, vote4coins=?, refferal=?, genset=?, custpag=?, adlang=?, editlang=?, manateme=?, marketplace=?, plugsett=? WHERE username=?");
				$stmt->bindParam(1, $articles, PDO::PARAM_INT);
				$stmt->bindParam(2, $downloads, PDO::PARAM_INT);
				$stmt->bindParam(3, $logs, PDO::PARAM_INT);
				$stmt->bindParam(4, $createitem, PDO::PARAM_INT);
				$stmt->bindParam(5, $banplay, PDO::PARAM_INT);
				$stmt->bindParam(6, $promotional, PDO::PARAM_INT);
				$stmt->bindParam(7, $vote4coins, PDO::PARAM_INT);
				$stmt->bindParam(8, $refferal, PDO::PARAM_INT);
				$stmt->bindParam(9, $genset, PDO::PARAM_INT);
				$stmt->bindParam(10, $custpag, PDO::PARAM_INT);
				$stmt->bindParam(11, $adlang, PDO::PARAM_INT);
				$stmt->bindParam(12, $editlang, PDO::PARAM_INT);
				$stmt->bindParam(13, $manateme, PDO::PARAM_INT);
				$stmt->bindParam(14, $marketplace, PDO::PARAM_INT);
				$stmt->bindParam(15, $plugsett, PDO::PARAM_INT);
				$stmt->bindParam(16, $username, PDO::PARAM_STR);
				$stmt->execute();
				
			}
			
		}
		
		public static function ShowAllowed()
		{
			global $database;
			
			$stmt = $database->Sqlite("SELECT * FROM permission");
			$stmt->execute();
			
			return $result=$stmt->fetchAll();
		}
		
		public static function Del($id)
		{
			global $database;
			
			$stmt = $database->Sqlite("DELETE FROM permission WHERE id=?");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->execute();
		}
		
		public static function Verify($vars)
		{
			global $database;
			global $_SESSION;
			
			$stmt = $database->Sqlite("SELECT * FROM permission WHERE username=?");
			$stmt->bindParam(1, $_SESSION['usern'], PDO::PARAM_STR);
			$stmt->execute();
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
			if(isset($result[$vars]) && $result[$vars]==1)
				return true;
			else return false;
		}
		
		public static function Full()
		{
			global $database;
			global $_SESSION;
			
			$stmt = $database->Account("SELECT web_admin FROM account WHERE login=?");
			$stmt->bindParam(1, $_SESSION['usern'], PDO::PARAM_STR);
			$stmt->execute();
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
			if(isset($result['web_admin']) && $result['web_admin']==99)
				return true;
			else return false;
		}
		
	}