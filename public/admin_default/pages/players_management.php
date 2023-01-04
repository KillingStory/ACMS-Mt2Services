<?php if(Permission::Verify('banplay')) { ?>
<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-12 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?= l(149); ?></h4>
					<h6 style="float:right;">
					<form action="" method="POST">
						<div class="row">
							<div class="col-lg-8">
								<input type="text" name="search" class="form-control" placeholder="<?= l(50); ?> / IP" value="<?php if(isset($search)) print $search; ?>">
							</div>
							<div class="col-lg-4">
								<button type="submit" class="btn btn-dark"><i class="fa fa-search fa-1" aria-hidden="true"></i> <?= l(150); ?></button>
							</div>
						</div>
					</form>
					</h6>
				</div>
				<div class="card-body">
					<table class="table table-bordered">
						<thead class="thead-dark">
							<tr>
								<th><?= l(151); ?></th>
								<th><?= l(50); ?></th>
								<th>IP</th>
								<th><?= l(152); ?></th>
								<th><?= l(153); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$records_per_page=20;
								
								if(isset($search))
								{
									if(!filter_var($search, FILTER_VALIDATE_IP) === false)
										$query = "SELECT id, name, account_id, level, ip FROM player WHERE ip = :ip ORDER BY account_id ASC";
									else
										$query = "SELECT id, name, account_id, level, ip FROM player WHERE name LIKE :search ORDER BY account_id ASC";
									$newquery = $paginate->paging($query,$records_per_page);
									$paginate->dataview($newquery, $search);
								} else {
									$query = "SELECT id, name, account_id, level, ip FROM player ORDER BY account_id ASC";
									$newquery = $paginate->paging($query,$records_per_page);
									$paginate->dataview($newquery, null);
								}
							?>
						</tbody>
					</table>
					<?php
						if(isset($search))
							$paginate->paginglink($query, $records_per_page, Theme::URL(), $search);
						else
							$paginate->paginglink($query, $records_per_page, Theme::URL());
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } else print '<div class="alert alert-danger">You dont have access!</div>';?>