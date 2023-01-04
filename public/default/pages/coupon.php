<?php 
	if(signed()) 
	{
		?>
		<div class="content-bg">
			<div class="content inner-content">
				<div class="inner-title flex-cc" style="text-transform:uppercase;">
					<?= $title; ?> 
				</div>
				<center>
					<br><br>
					<?php if($received>=0) { ?>
					<div class="alert alert-<?php if(!$received || $received==4) print 'danger'; else print 'success'; ?>" role="alert">
						<?php
							if(!$received)
								print l(196);
							else if($received==1 || $received==2)
							{
								print l(197).' '.$coins.' '; 
								if($received==1)
									print l(164).' (MD)';
								else print l(165).' (JD)';
								print '.';
							} else if($received==3)
								print l(198);
							else
								print 'error';
						?>
					</div>
					<?php } ?>
					<form action="" method="POST">
						<div class="input-group" style="vertical-align:middle;">
							<input type="text" class="form-control form-control-lg" placeholder="<?= l(194); ?>" name="code" style="width:500px;vertical-align:middle;" required>
							<span class="input-group-btn">
								<button class="blue-button" type="submit" data-placement="button" style="height:48px;width:auto;vertical-align:middle;margin-top:-1px;">
									<i class="fa fa-check" aria-hidden="true"></i> 
								</button>
							</span>
						</div>
					</form>
				</center><br><br>
			</div>
		</div>
		<?php 
	} 
	else 
		print '<div class="alert alert-warning">'.l(70).'</div>'; ?>