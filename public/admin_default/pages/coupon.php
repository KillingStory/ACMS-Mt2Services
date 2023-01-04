<?php if(Permission::Verify('promotional')) { ?>
<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-6 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?= l(162); ?></h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<?php 
						if(isset($_POST['delete']) && isset($_POST['id']) && ACP::DeleteVoucher($_POST['id']))
						{
							print '<script>alertError("<b>'.l(167).'</b> '.$_POST['codeval'].'");</script>';
						}
						if(isset($_POST['add']))
						{ 
							print '<script>alertSuccess("'.ACP::CreateVoucher($_POST['type'], $_POST['value']).'");</script>';
						} 
					?>
					<form action="" method="post">
						<label>Alege rasplata:</label>
						<select class="form-control" name="type" id="inputType">
							<option value="1"><?= l(164); ?> (MD)</option>
							<option value="2"><?= l(165); ?> (JD)</option>
							<option value="3"><?= l(166); ?> (vNum)</option>
						</select>
						<br>
						<label>Valoare:</label>
						<input type="number" class="form-control" min="0" id="inputValue" name="value" value="0" required>
						<br>
						<center><button type="submit" name="add" class="btn btn-dark"><?= l(128); ?></button></center>
						
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?= l(163); ?></h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<table class="table table-bordered">
						<thead class="thead-dark" style="text-align: center;">
							<tr>
								<th>#</th>
								<th>Code</th>
								<th>type</th>
								<th>value</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$records_per_page=10;
								$query = "SELECT * FROM redeem ORDER BY id DESC";
								$newquery = $paginate->paging($query,$records_per_page);
								$paginate->dataview($newquery);
							?>
						</tbody>
					</table>
					<?php
						$paginate->paginglink($query, $records_per_page, Theme::URL());
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } else print '<div class="alert alert-danger">You dont have access!</div>';?>