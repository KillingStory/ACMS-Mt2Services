<?php if(Permission::Verify('downloads')) { ?>
<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-6 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?= l(125); ?></h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<form method="POST">
						<input type="text" class="form-control" name="addlink" placeholder="<?= l(126); ?>">
						<br>
						<input type="text" class="form-control" name="addname" placeholder="<?= l(127); ?>">
						<br>
						<center><button type="submit" name="adddownload" class="btn btn-dark"><?= l(128); ?></button></center>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?= l(137); ?></h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<?php if(count($download_db)) { ?>
					<table class="table table-bordered">
						<tbody>
							<tr>
								<th scope="col" style="text-transform:uppercase;"><center><?= l(50); ?></center></th>
								<th scope="col" style="text-transform:uppercase;"><center><?= l(129); ?></center></th>
								<th scope="col" style="text-transform:uppercase;"><center><?= l(130); ?></center></th>
								<th scope="col" style="text-transform:uppercase;"><center><?= l(131); ?></center></th>
							</tr>
							<?php 
							
								$i=1; foreach($download_db as $key => $download)
								{
									print 
									'<tr>
										<td><center>'.$download['name'].'</center></td>
										<td><center>'.$download['count'].'</center></td>
										<td><center>'.$download['link'].'</center></td>
										<td><center><form method="POST"><input type="hidden" value="'.$key.'" name="download_del_id"><button type="submit" style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;" name="del_downlink"><i style="color:red;" class="fa fa-trash"></i></button></form></center></td>
									</tr>';
								}
							?>
						</tbody>
					</table>
					<?php } else print l(132); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row mb-4">
		<div class="col-lg-6 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?= l(133); ?></h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
						<form method="POST">
							<input type="text" class="form-control" name="name_req" placeholder="<?= l(50); ?> (Ex. RAM,CPU)">
							<br>
							<input type="text" class="form-control" name="name_min" placeholder="<?= l(134); ?>">
							<br>
							<input type="text" class="form-control" name="name_max" placeholder="<?= l(135); ?>">
							<br>
							<center><input type="submit" name="add_requirement" value="<?= l(128); ?>" class="btn btn-dark"></center>
						</form>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?= l(136); ?></h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<center>
						<table class="table table-bordered">
							<tbody>
								<tr>
									<th scope="col"><center>#</center></th>
									<th scope="col"><center><?= l(134); ?></center></th>
									<th scope="col"><center><?= l(135); ?></center></th>
									<th scope="col"><center><?= l(131); ?></center></th>
								</tr>
								<?php
									$i=1; foreach($requirements_db as $key => $req)
									{
								?>
								<tr>
									<th scope="col"><center><?= $req['request']; ?></center></th>
									<th scope="col"><center><?= $req['minimum']; ?></center></th>
									<th scope="col"><center><?= $req['recoman']; ?></center></th>
									<th><center><form method="POST"><input type="hidden" value="<?= $key; ?>" name="req_del_id"><button type="submit" style="background: none;color: inherit;border: none;padding: 0;font: inherit;cursor: pointer;outline: inherit;" name="del_req"><i style="color:red;" class="fa fa-trash"></i></button></form></center></th>
								</tr>
								<?php }?>
							</tbody>
						</table>
					</center>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } else print '<div class="alert alert-danger">You dont have access!</div>';?>