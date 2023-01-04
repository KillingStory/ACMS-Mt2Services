<?php 
	if(signed()) 
	{
		if(isset($voted_now) && isset($already_voted) && !$voted_now) { 
			print '<script>alertWarning("'.l(200).'");</script>';
		} 
		if(count($vote4coins)) 
		{ 	
			?>
			<div class="content-bg">
				<div class="content inner-content">
					<div class="inner-title flex-cc" style="text-transform:uppercase;">
						<?= $title; ?> 
					</div><br><br>
					<center>
						<table class="table" style="width:95%;">
							<thead>
								<tr>
									<th style="text-transform:uppercase;">#</th>
									<th style="text-transform:uppercase;">Site</th>
									<th style="text-transform:uppercase;"><?= l(177); ?></th>
									<th style="text-transform:uppercase;"><?= l(178); ?></th>
									<th style="text-transform:uppercase;"><?= l(199); ?></th>
								</tr>
							</thead>
							<tbody>
							<?php $i=1; foreach($vote4coins as $key => $vote) { ?>
								<tr>
									<th style="text-transform:uppercase;"><?php print $i++; ?></th>
									<td style="text-transform:uppercase;"><?php print $vote['name']; ?></td>
									<td style="text-transform:uppercase;"><?php print $vote['value']; if($vote['type']==1) print 'MD'; else print 'JD'; ?></td>
									<td style="text-transform:uppercase;"><?php print $vote['time'].' '.l(168); ?></td>
									<td style="text-transform:uppercase;"><a href="<?php print Theme::URL().'vote/'.$key; ?>"><button class="blue-button" style="width:auto;"><?= l(199); ?></button></a></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</center>
					<br><br><br>
				</div>
			</div>
			<?php 
		} 
		else 
		{ 
			print 'no link';
		} 
	} 
	else 
		print '<div class="alert alert-warning">'.l(70).'</div>'; ?>