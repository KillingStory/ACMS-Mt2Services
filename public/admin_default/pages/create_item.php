<?php if(Permission::Verify('createitem')) { ?>
<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-6 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?= l(101); ?></h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
				<?php 	
					if(isset($callback))
					{
						print $callback;
					}
				?>
				<form action="" method="post" class="form-horizontal">
					<div class="form-group">
						<label class="control-label" for="name">
							<?= l(102); ?>
						</label>
						<input class="form-control" name="name" id="name" type="text">
					</div>
					<div class="form-group">
						<label class="control-label" for="vnum">vNum</label>
						<input class="form-control" name="vnum" id="vnum" type="number">
					</div>
					<div class="form-group">
						<label class="control-label" for="count">
							<?= l(103); ?>
						</label>
						<input class="form-control" name="count" id="count" type="number" value="1">
					</div>
						
					<label class="control-label"></label>
					<?php for($i=0;$i<=6;$i++) { ?>
					<div class="form-group">
						<div class="row">
							<div class="col-md-10">
								<select class="form-control" name="attrtype<?php print $i; ?>">
									<option value="0"><?= l(105); ?></option>
									<?php print $form_bonuses; ?>
								</select>
							</div>
							<div class="col-md-2">
								<input class="form-control" name="attrvalue<?php print $i; ?>" type="number" value="0">
							</div>
						</div>
					</div>
					<?php } ?>
					<div class="form-group">
						<a class="btn btn-dark" role="button" data-toggle="collapse" href="#sockets" aria-expanded="false" aria-controls="sockets">
							<?= l(106); ?>
						</a>
						
					</div>
					<div class="form-group">
						<a class="btn btn-dark" role="button" data-toggle="collapse" href="#time" aria-expanded="false" aria-controls="time">
							<?= l(108); ?> (Min.)
						</a>
					</div>
					<div class="form-group">
						<a class="btn btn-dark" role="button" data-toggle="collapse" href="#time2" aria-expanded="false" aria-controls="time2">
								<?= l(109); ?> (Min.)
						</a>
					</div>
					<hr>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4"></div>
							<div class="col-sm-2">
								<input class="btn btn-dark" name="add" value="<?= l(110); ?>" type="submit">
							</div>
							<div class="col-sm-2">
								<input class="btn btn-warning" value="<?= l(111); ?>" type="reset">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?= l(101); ?></h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<div class="collapse" id="sockets" style="width:50%;">
						<div class="form-group">
							<label class="control-label" for="socket0">
								<?= l(107); ?> (1)</label>
							<input class="form-control" name="socket0" id="socket0" type="number" value="">
						</div>
						<div class="form-group">
							<label class="control-label" for="socket1">
							   <?= l(107); ?> (2)</label>
							<input class="form-control" name="socket1" id="socket1" type="number" value="">
						</div>
						<div class="form-group">
							<hr>
							<label class="control-label" for="socket2">
								<?= l(107); ?> (3)</label>
							<input class="form-control" name="socket2" id="socket2" type="number" value="">
						</div>
					</div>
					<div class="collapse" id="time" style="width:50%;">
						<div class="form-group">
						<hr>
							<label class="control-label" for="time">
									<?= l(108); ?>
							</label>
							<input class="form-control" name="time" id="time" type="number" value="0">
						</div>
					</div>
					<div class="collapse" id="time2" style="width:50%;">
						<div class="form-group">
						<hr>
							<label class="control-label" for="time2">
							   <?= l(109); ?></label>
							<input class="form-control" name="time2" id="time2" type="number" value="0">
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } else print '<div class="alert alert-danger">You dont have access!</div>';?>