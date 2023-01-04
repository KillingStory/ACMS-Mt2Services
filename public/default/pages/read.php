<?php
	if(isset($_GET['no']))
	{ 
		$ids_n = $_GET['no']; ?>
		<div class="content-bg">
			<div class="content inner-content">
				<div class="inner-title flex-cc" style="text-transform:uppercase;">
					<?= News::read($ids_n,'title'); ?>
				</div>
				<br><br>
				<center>
					<div class="news">
						<div class="news-content" style="margin-left:20px;margin-right:20px;">
							<div class="news-text" style="width:100%;text-align:justify;">
							<?= News::read($ids_n,'content'); ?>
							</div>
						</div>
					</div>
				</center>
				<br><br><br>
			</div>
		</div>
		<?php 
	}
	else
		print '<div class="alert alert-warning">'.l(100).'</div>';
?>
