<?php if(Permission::Verify('logs')) { ?>
<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-12 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?= l(147); ?></h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<select class="form-control form-control-lg" onchange="if (this.value) window.location.href=this.value">
						<option value=""<?php if(!$current_log) print ' selected'; ?>><?= l(148); ?></option>
						<?php
							foreach($tables as $table)
							{
								print '<option value="'.Theme::URL().'admin_panel/log/'. $table.'/"';
								if($current_log && $table==$current_log)
									print ' selected';
								print '>'.$table.'</option>';
							}
						?>
					</select>
				</div>
			</div>
		</div>
		<?php if($current_log) { ?>
		<div class="container-fluid py-4">
			<div class="row mb-4">
				<div class="col-lg-12 col-md-6 mb-md-0 mb-4">
					<div class="card card-secondary">
						<div class="card-header pb-0">
							<h4 class="card-title"><?php print $current_log; ?></h4><br>
							<h6 style="float:right;"></h6>
						</div>
						<div class="card-body">
							<table class="table table-bordered">
								<thead class="thead-inverse">
									<tr>
										<?php 
											foreach($columns as $column)
												print '<th>'. $column .'</th>';
										?>
									</tr>
								</thead>
								<tbody>
									<?php 
										$banned_ids = BannedAccounts();
										
										$order_by = '';
										if(in_array('id', $columns))
											$order_by = ' ORDER BY id DESC';
										else if(in_array('date', $columns))
											$order_by = ' ORDER BY date DESC';
										else if(in_array('time', $columns))
											$order_by = ' ORDER BY time DESC';
										
										$query = "SELECT * FROM ". $current_log . $order_by;
										$records_per_page=20;
										$newquery = $paginate->paging($query,$records_per_page);
										$paginate->dataview($newquery, $columns);	
									?>
								</tbody>
							</table>
							<?php $paginate->paginglink($query, $records_per_page, Theme::URL(), $current_log);	?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } 
} else print '<div class="alert alert-danger">You dont have access!</div>';?>
