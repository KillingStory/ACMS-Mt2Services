<div class="content-bg">
	<div class="content inner-content">
		<div class="inner-title flex-cc" style="text-transform:uppercase;">
			<?= $title; ?> 
		</div>
		<br>
		<center>
			<table class="table table-striped" style="width: 95%;">
				<tbody>
					<tr>
						<th scope="col" style="text-transform:uppercase;padding:25px;"><center><?= l(50); ?></center></th>
						<th scope="col" style="text-transform:uppercase;padding:25px;"><center><?= l(49); ?></center></th>
						<th scope="col" style="text-transform:uppercase;padding:25px;"><center><?= l(51); ?></center></th>
					</tr>
					<?php
						foreach($download_db as $key => $download) { $__counter++; ?>
							<form method="POST">
								<tr>
									<input type="hidden" value="<?= $__counter; ?>" name="idiom">
									<input type="hidden" value="<?= $key; ?>" name="stdownload_id">
									<input type="hidden" value="<?= $download['link']; ?>" name="stdownload_link">
									<td><center><?= $download['name']; ?></center></td>
									<td><center><?= $download['count']; ?></center></td>
									<td><center><button type="submit" style="width:auto;" class="blue-button" name="download<?= $__counter; ?>">Download</button></center></td>
								</tr>
							</form>
						<?php } ?>
				</tbody>
			</table>
			<br><br>
			<div class="inner-title flex-cc" style="text-transform:uppercase;">
			<?= l(52); ?>
			</div>
			<br>
			<table class="table table-striped" style="width: 95%;">
				<tbody>
					<tr>
						<th scope="col" style="text-transform:uppercase;padding:17px;"><center>#</center></th>
						<th scope="col" style="text-transform:uppercase;padding:17px;"><center><?= l(54); ?></center></th>
						<th scope="col" style="text-transform:uppercase;padding:17px;"><center><?= l(53); ?></center></th>
					</tr>
					<?php
						foreach($requirements_db as $key => $req) { ?>
							<tr>
								<th scope="col" style="padding:17px;"><center><?= $req['request']; ?></center></th>
								<th scope="col" style="padding:17px;"><center><?= $req['minimum']; ?></center></th>
								<th scope="col" style="padding:17px;"><center><?= $req['recoman']; ?></center></th>
							</tr>
						<?php } ?>
				</tbody>
			</table>
			<br><br><br>
		</center>
	</div>
</div>