<?php
	if(isset($_POST['resetpwsubmit']))
	{
		$username=$_POST['username'];
		$email=$_POST['mail'];
		$findaccount = $database->Account("SELECT * FROM account WHERE login=:username AND email=:email");
		$findaccount->bindParam(':username', $username, PDO::PARAM_STR);
		$findaccount->bindParam(':email', $email, PDO::PARAM_STR);
		$findaccount->execute();
		$data = $findaccount->fetch(PDO::FETCH_ASSOC);
		if($findaccount->rowCount()>0)
		{
			$servername = Server_Details::GetSettings(1);
			$receiver_mail = $data['email'];
			$title_add = l(73);
			if(UpdatePassLost($data['id']))
			{
				$link_to_rpw = Theme::URL().'reset_password/'.$data['id'].'/'.md5(Player::Username($data['id'])).'/'.md5(Player::PassLost($data['id']));
				$mail_message = RPWMSG($link_to_rpw, l(75), l(77));
				include 'system/plugins/mailer/send_mail.php';
			}
		}
		else $mail_response = '<div class="alert alert-danger">'.l(97).'</div>';
	}
?>