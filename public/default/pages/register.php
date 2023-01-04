<div class="content-bg">
	<div class="content inner-content">
		<div class="inner-title flex-cc" style="text-transform:uppercase;">
			<?= $title; ?>
		</div>
			<?php 
				if(isset($show_error))
					print $show_error;
				if(!signed()) 
				{ 
					if(Server_Details::GetSettings(4)==1) 
					{ 
				
						?>
						<form class="inner-form" method="POST">
							<div class="line">
								<div class="icon flex-cc"><i class="fa fa-user" aria-hidden="true"></i></div>
								<div class="form-group field-signupform-username required has-error">
									<input type="text" name="username" id="username" pattern=".{5,16}" maxlength="16" pattern="[A-Za-z0-9]" placeholder="<?= l(35); ?>">
								</div>
							</div>
							<div class="line">
								<div class="icon flex-cc"><i class="fa fa-lock" aria-hidden="true"></i></div>
								<div class="form-group field-signupform-password required">
									<input type="password" name="password" id="password" pattern=".{5,16}" maxlength="16" placeholder="<?= l(36); ?>">
								</div>
							</div>
							<div class="line">
								<div class="icon flex-cc"><i class="fa fa-lock" aria-hidden="true"></i></div>
								<div class="form-group field-signupform-password_repeat required">
									<input type="password" name="rpassword" id="rpassword" pattern=".{5,16}" onkeyup="ValidatePW()" maxlength="16" placeholder="<?= l(37); ?>">
									<center><br><div id="pass"></div></center>
								</div>
							</div>
							<div class="line">
								<div class="icon flex-cc"><i class="fa fa-envelope" aria-hidden="true"></i></div>
								<div class="form-group field-signupform-email required">
									<input type="email" name="email" id="email" pattern=".{7,64}" maxlength="64" placeholder="ex@test.com" required="" placeholder="Input placeholder">
								</div>
							</div>
							<div class="line">
								<div class="icon flex-cc"><i class="fa fa-users" aria-hidden="true"></i></div>
								<div class="form-group field-signupform-recruiter">
									<input type="text" name="deletec" id="deletec" maxlength="7" onkeyup="ValidateDeleteChar()" placeholder="<?= l(38); ?>">
									<center><br><div id="delc"></div></center>
								</div>
							</div>
							<!----RECAPTCHAINSERT---->
							<button type="submit" class="blue-button flex-cc"><?= l(39); ?></button>
						</form>
						<?php 
					} 
					else 
						print '<div class="alert alert-info">'.l(42).'</div>'; 
				}
				else print '<div class="alert alert-warning">'.l(195).'</div>'; 
					
				?>
	</div>
</div>