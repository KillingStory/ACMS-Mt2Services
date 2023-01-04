<?php
	if(areadmin() && isset($_SERVER['HTTP_REFERER']))
	{
		if(isset($_GET['site_title']))
		{
			$title = $_GET['site_title'];
			Server_Details::UpdateSettings(1, $title);
		}
		
		if(isset($_GET['description']))
		{
			$description = $_GET['description'];
			Server_Details::UpdateSettings(2, $description);
		}
		
		if(isset($_GET['forum']))
		{
			$forum = $_GET['forum'];
			Server_Details::UpdateSettings(14, $forum);
		}
		
		if(isset($_GET['itemshop']))
		{
			$itemshop = $_GET['itemshop'];
			Server_Details::UpdateSettings(15, $itemshop);
		}
		
		if(isset($_GET['grp']))
		{
			$grp = $_GET['grp'];
			Server_Details::UpdateSettings(9, $grp);
		}
		
		if(isset($_GET['grs']))
		{
			$grs = $_GET['grs'];
			Server_Details::UpdateSettings(10, $grs);
		}
		
		if(isset($_GET['colorcode']))
		{
			$colorcode = $_GET['colorcode'];
			Server_Details::UpdateSettings(13, $colorcode);
			print $colorcode;
		}
		
		if(isset($_GET['sdesc']))
		{
			$sdesc = $_GET['sdesc'];
			Server_Details::UpdateSEO(1, $sdesc);
		}
		
		if(isset($_GET['tags']))
		{
			$tags = $_GET['tags'];
			Server_Details::UpdateSEO(2, $tags);
		}
		
		if(isset($_GET['facebook']))
		{
			$facebook = $_GET['facebook'];
			Server_Details::UpdateSEO(3, $facebook);
		}
		
		if(isset($_GET['youtube']))
		{
			$youtube = $_GET['youtube'];
			Server_Details::UpdateSEO(4, $youtube);
		}
		
		if(isset($_GET['discord']))
		{
			$discord = $_GET['discord'];
			Server_Details::UpdateSEO(5, $discord);
		}
		
		if(isset($_GET['twitch']))
		{
			$twitch = $_GET['twitch'];
			Server_Details::UpdateSEO(6, $twitch);
		}
		
		if(isset($_GET['instagram']))
		{
			$instagram = $_GET['instagram'];
			Server_Details::UpdateSEO(7, $instagram);
		}
		if(isset($_GET['logo']))
		{
			$file_type = $_FILES['file']['type'];
			$allowed = array("image/gif", "image/png");
			if(in_array($file_type, $allowed))
			{
				$file_name =  $_FILES['file']['name'];
				$tmp_name = $_FILES['file']['tmp_name'];
				$file_up_name = time().$file_name;
				move_uploaded_file($tmp_name, "style/upload/".$file_up_name);
				Theme::AddLogo(Theme::URL().'style/upload/'.$file_up_name);
			}
		}
		if(isset($_GET['newslimits']))
		{
			$newslimits = $_GET['newslimits'];
			ACP::UpdateNewsSettings(5, $newslimits);
		}
		if(isset($_GET['ownerart']))
		{
			print $ownerart = $_GET['ownerart'];
			ACP::UpdateNewsSettings(7, $ownerart);
		}
		if(isset($_GET['articledate']))
		{
			print $articledate = $_GET['articledate'];
			ACP::UpdateNewsSettings(8, $articledate);
		}
		if(isset($_GET['download']))
		{
			$file_type = $_FILES['file']['type'];
			$allowed = array('zip','application/octet-stream','application/rar','application/zip','application/x-zip','application/x-zip-compressed');
			if(in_array($file_type, $allowed))
			{
				$file_name =  $_FILES['file']['name'];
				$tmp_name = $_FILES['file']['tmp_name'];
				$file_up_name = time().$file_name;
				move_uploaded_file($tmp_name, "public/client/".$file_up_name);
				
				$download_db = file_get_contents('system/database/download_links.json');
				$download_db = json_decode($download_db, true);
				$insert = array();
				$insert['name'] = 'Direct';
				$insert['link'] = Theme::URL().'public/client/'.$file_up_name;
				$insert['count'] = '0';
				
				array_push($download_db, $insert);
				
				$download_new = json_encode($download_db);
				file_put_contents('system/database/download_links.json', $download_new);
				
				
			}
		}
		if(isset($_GET['chart']) && $_GET['chart']=='online_players')
		{
			$var1 = Charts::OnlinePlayers();
			$var2 = Charts::Characters();
			$var3 = Charts::Accounts();
			echo json_encode(["online"=>$var1, "chars"=>$var2, "accounts"=>$var3]);
		}
		if(isset($_GET['chart']) && $_GET['chart']=='empire')
		{
			$ema = Charts::Empire(1);
			$emb = Charts::Empire(41);
			$emc = Charts::Empire(21);
			$emd = Charts::Empire(100);
			echo json_encode(["emp1"=>$ema, "emp2"=>$emb, "emp3"=>$emc, "all"=>$emd]);
		}
	}
	else print 'Denyed access!';
?>