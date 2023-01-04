<?php
	if(isset($return_message))
		print $return_message;
	if(isset($error_ml) && $error_ml==0)
	{
		?>
		<div class="content-bg">
			<div class="content inner-content">
				<div class="inner-title flex-cc" style="text-transform:uppercase;">
					<?= $title; ?> 
				</div><br><br>
				<center>
					<form class="inner-form" method="POST">
						<input type="mail" name="newmail" class="input" placeholder="<?= l(93);?>" autocomplete="off">
						<br>
						<br>
						<center>
							<br>
							<button type="submit" class="blue-button" style="width:auto;" name="mailsubmit"><?= l(39);?></button>
						</center>
					</form>
				</center>
			</div>
		</div>
		<?php 
	} else print '<div class="alert alert-danger">'.l(90).'</div>';
	?>