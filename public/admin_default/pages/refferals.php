<?php if(Permission::Verify('refferal')) { ?>
<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-8 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?= l(181); ?></h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<form action="" method="post">
						<div class="form-group">
							<label for="status">Status</label>
							<select class="form-control" id="status" name="status">
								<option value="0"<?php if(!$jsondataFunctions['active-referrals']) print ' selected="selected"';?>>Dezactivat</option>
								<option value="1"<?php if($jsondataFunctions['active-referrals']) print ' selected="selected"';?>>Activat</option>
							</select>
						</div>
						<hr>
						<br>
						<div class="row">
							<div class="form-group col-md-6">
								<label for="inputHours"><?= l(184); ?></label>
								<input type="number" class="form-control" min="0" id="inputHours" name="hours" value="<?php print $jsondataReferrals['hours']; ?>" required>
							</div>
							<div class="form-group col-md-6">
								<label for="inputLevel"><?= l(185); ?></label>
								<input type="number" class="form-control" min="0" id="inputLevel" name="level" value="<?php print $jsondataReferrals['level']; ?>" required>
							</div>
						</div>

						<hr>
						<label><?= l(186); ?></label>

						<div class="form-group row">
							<div class="col-sm-6">
								<select class="form-control" name="type">
									<option value="1"<?php if($jsondataReferrals['type']==1) print ' selected="selected"';?>>MD</option>
									<option value="2"<?php if($jsondataReferrals['type']==2) print ' selected="selected"';?>>JD</option>
								</select>
							</div>
							<div class="col-sm-6">
								<input class="form-control" name="coins" value="<?php print $jsondataReferrals['coins']; ?>" type="number" required>
							</div>
						</div>
						<br>
						<center><button type="submit" name="submit" class="btn btn-dark"><?= l(158); ?></button></center>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?= l(182); ?></h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<div class="alert alert-warning">
						<p><?= l(183); ?></p>
						</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } else print '<div class="alert alert-danger">You dont have access!</div>';?>