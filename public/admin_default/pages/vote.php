<?php if(Permission::Verify('vote4coins')) { 
	if(isset($_POST['submit']))
	{
		$new_link = array();
		$new_link['name'] = $_POST['site_name'];
		$new_link['link'] = $_POST['site_link'];
		$new_link['type'] = $_POST['type'];
		$new_link['value'] = $_POST['coins'];
		$new_link['time'] = $_POST['time'];
		array_push($jsondataVote4Coins, $new_link);
		$json_new = json_encode($jsondataVote4Coins);
		file_put_contents('system/database/vote.json', $json_new);
		print '<script>alertSuccess("'.$_POST['site_name'].'");</script>';
		
	} else if(isset($_GET['del']))
	{
		unset($jsondataVote4Coins[$_GET['del']]);
		$json_new = json_encode($jsondataVote4Coins);
		file_put_contents('system/database/vote.json', $json_new);
		if(ACP::DelV4C($_GET['del']))
			print '<script>alertError("<b>'.l(167).'</b> '.$_GET['del'].'");</script>';
	}
?>
<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-6 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?= l(179); ?></h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					 <form action="" method="post">
						<label><?= l(174);?>:</label>
						<input type="text" class="form-control" name="site_name" placeholder="Site">
						<br>
						<label><?= l(175);?>:</label>
						<input type="url" class="form-control" name="site_link" placeholder="Link" value="http://">
						<br>
						<div class="row">
							<div class="col-md-4">
								<label><?= l(177);?>:</label>
								<select class="form-control" name="type">
									<option value="1">MD</option>
									<option value="2">JD</option>
								</select>
							</div>
							<div class="col-md-4">
								<label><?= l(176);?>:</label>
								<input type="number" class="form-control" name="coins" placeholder="0" value="0">
							</div>
							<div class="col-md-4">
								<label><?= l(178);?>:</label>
								<input class="form-control" name="time" min="1" required="" type="number">
							</div>
						</div>
						<br>
						<center><button type="submit" name="submit" class="btn btn-dark"><?= l(128); ?></button></center>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?= l(180); ?></h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<?php if(count($jsondataVote4Coins)) { ?>
					<table class="table table-bordered">
						<thead class="thead-dark" style="text-align: center;">
							<tr>
								<th>#</th>
								<th>Site</th>
								<th><?php print l(169); ?></th>
								<th><?php print l(170); ?></th>
								<th><?php print l(171); ?></th>
								<th><?php print l(172); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php $i=1; foreach($jsondataVote4Coins as $key => $vote4coins) { ?>
							<tr style="text-align: center;">
								<th><?php print $i++; ?></th>
								<td><?php print $vote4coins['name']; ?></td>
								<td><?php if($vote4coins['type']==1) print l(164).' [MD]'; else print print l(165).' [JD]'; ?></td>
								<td><?php print $vote4coins['value']; ?></td>
								<td><?php if($vote4coins['time']>1) print $vote4coins['time'].' '.l(168); else print l(173); ?></td>
								<td><a href="<?php print Theme::URL().'admin_panel/vote/'.$key; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } else print '<div class="alert alert-danger">You dont have access!</div>';?>