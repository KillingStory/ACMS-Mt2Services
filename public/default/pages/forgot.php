<div class="content-bg">
	<div class="content inner-content">
		<div class="inner-title flex-cc" style="text-transform:uppercase;">
			<?= $title; ?> 
		</div>
		<center>
			<br><br>
			<?php 
				if(isset($mail_response))
					print $mail_response;
			?>
			<center>
				<form class="inner-form" method="POST">
					<input type="text" name="username" class="input" placeholder="<?= l(79); ?>" autocomplete="off">
					<br>
					<br>
					<input type="mail" name="mail" class="input" placeholder="<?= l(78); ?>" autocomplete="off">
					<br>
					<br>
					<center>
						<br>
						<button type="submit" class="blue-button" style="height:48px;width:auto;vertical-align:middle;margin-top:-1px;" name="resetpwsubmit"><?= l(89); ?></button>
					</center>
				</form>
			</center>
	</div>
</div>