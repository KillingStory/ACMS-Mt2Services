<?php
	if(signed()) 
	{
		$i_player = $_SESSION['id'];
		if(isset($_POST['debug_btn']))
		{
			$empire_stats = PlayerEmpire($i_player);
			if($empire_stats==1) 
			{ 
				$mapindex = "0";
				$x = "459770";
				$y = "953980";
			}
			elseif($empire_stats==2) 
			{
				$mapindex = "21";
				$x = "52043";
				$y = "166304";
			}
			elseif($empire_stats==3)
			{
				$mapindex = "41";
				$x = "957291";
				$y = "255221";
			}
			if(CharacterReset($i_player, $mapindex, $x, $y))
			{
				$rsch_response = '<div class="alert alert-success" role="alert">';
				$rsch_response.= l(71);
				$rsch_response.= '</div>';
			}
			else
			{
				$rsch_response = '<div class="alert alert-danger" role="alert">';
				$rsch_response.= l(72);
				$rsch_response.= '</div>';
			}
		}
		if(isset($_POST['reset_pw']))
		{
			if(!CheckColumns('passlost'))
				FixAccount();
			$servername = Server_Details::GetSettings(1);
			$receiver_mail = Player::Email($i_player);
			$title_add = l(73);
			if(UpdatePassLost($i_player))
			{
				$link_to_rps = Theme::URL().'reset_password/'.$i_player.'/'.md5(Player::Username($i_player)).'/'.md5(Player::PassLost($i_player));
				$mail_message = RPWMSG($link_to_rps, l(75), l(77));
				include 'system/plugins/mailer/send_mail.php';
			}
		}
		
		if(isset($_POST['reset_mail']))
		{
			if(!CheckColumns('maillost'))
				FixAccount();
			$servername = Server_Details::GetSettings(1);
			$receiver_mail = Player::Email($i_player);
			$title_add = l(74);
			if(UpdateMailLost($i_player))
			{
				$link_to_rps = Theme::URL().'reset_mail/'.$i_player.'/'.md5(Player::Username($i_player)).'/'.md5(Player::MailLost($i_player));
				$mail_message = RPWMSG($link_to_rps, l(76), l(77));
				include 'system/plugins/mailer/send_mail.php';
			}
		}
		
	}
?>