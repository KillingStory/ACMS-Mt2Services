<?php
	if(isset($return_message))
		print $return_message;
	if(isset($error_auth) && $error_auth==0)
	{
		?>
		<div class="content-bg">
			<div class="content inner-content">
				<div class="inner-title flex-cc" style="text-transform:uppercase;">
					<?= $title; ?> 
				</div><br><br>
				<center>
					<form class="inner-form" method="POST">
						<input type="password" name="passwordReg" class="input" placeholder="<?= l(36);?>" autocomplete="off">
						<br>
						<br>
						<input type="password" name="passwordRegs" class="input" placeholder="<?= l(37);?>" autocomplete="off">
						<br>
						<br>
						<center>
							<br>
							<button type="submit" class="blue-button" style="width:auto;" name="resetpwsubmit"><?= l(39);?></button>
						</center>
					</form>
				</center>
			</div>
		</div>
		<?php 
	} else print '<div class="alert alert-danger">'.l(90).'</div>';
	?>