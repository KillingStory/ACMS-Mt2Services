<div class="content-bg">
	<div class="content inner-content">
		<div class="inner-title flex-cc" style="text-transform:uppercase;">
			<?= $title; ?> 
		</div>
		<?php
		if(!signed())
		{
			if(isset($_POST['username']) && isset($_POST['password']))
			{
				switch ($login_result[0]) {
					case 1:
						print '<script>alertSuccess("'.l(20).'");</script>';
						break;
					case 0:
						print '<script>alertSuccess("'.l(20).'");</script>';
						break;
					case 2:
						print '<script>alertError("'.l(18).'");</script>';
						break;
					case 3:
						print '<script>alertError("'.l(16).'");</script>';
						break;
					case 4:
						print '<script>alertError("'.l(19).'");</script>';
						break;
					case 5:
						print '<script>alertError("'.l(18).' ('.$login_result[2].')");</div>';
						break;
					default:
						print 'ERROR';
				}
				if($login_result[0]==2 || $login_result[0]==5)
					print '<div class="alert alert-info" role="alert">Reason: '.$login_result[1].'</div>';
				}
		}
		else 
		{
			print '<meta http-equiv="Refresh" content="3; url='.Theme::URL().'" />'; 
			print '<script>alertSuccess("'.l(20).'");</script>';
		}
		?>
		<form class="inner-form" method="POST">
			<div class="line">
				<input type="text" class="user" name="username" placeholder="<?php print l(12); ?>" required />
			</div>
			<div class="line">
				<input type="password" class="pass" name="password" placeholder="<?php print l(13); ?>" required />
			</div>
			<div class="line">
				<button class="blue-button flex-cc" type="submit"><?php print l(15); ?></button>
				<br><a href="<?= Theme::URL(); ?>forgot_password" class="forgot"><?php print l(14); ?></a>
			</div>
		</form>
		
	</div>
</div>