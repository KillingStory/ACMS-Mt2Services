<?php if(Permission::Verify('manateme')) { 
	if(isset($_POST['makeprimary']))
	{
		Server_Details::UpdateSettings(3,$_POST['makeprimary']);
		print '<script>alertSuccess("Now use '.$_POST['makeprimary'].' template");</script>';
	}
?>
<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-12 col-md-12 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?=l(241);?></h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<table class="table table-bordered">
						<thead class="thead-dark">
							<tr>
								<th><?=l(242);?></th>
								<th><?=l(243);?></th>
								<th style="width:20%;"><?=l(145);?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$dir    = 'public/';
							if ($handle = opendir($dir)) 
							{
								$blacklist = array('.', '..', '.htaccess', 'loading.php','admin_');
								while (false !== ($file = readdir($handle))) 
								{
									if (!in_array($file, $blacklist) && !strstr($file, 'admin_')) 
									{
										if(file_exists($dir.$file.'/body.php') && file_exists($dir.$file.'/head.php') && file_exists($dir.$file.'/partials/owner.php'))
										{
											include $dir.$file.'/partials/owner.php';
											if($file=='default') $file_name = "default_template"; else $file_name = $file;
										?>
										<tr>
											<td style="vertical-align:middle;"><?= $file_name; ?><br><small>&copy;&nbsp;<?=$creator;?></small></td>
											<td style="vertical-align:middle;">
												<div class="row">
													<div class="col-md-6 my-auto align-self-center">
														<a target="blank" href="<?= $preview; ?>" style=" position: relative;text-align: center;color: white;">
															<img style="width:130.55px;height:150px;opacity:0.3" src="<?= $preview; ?>"/>
															<div style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"><b style="color:black"><?=l(244);?></b></div>
														</a>
													</div>
													<div class="col-md-6 my-auto align-self-center">
														<div style="vertical-align:middle;">
														<b><?=l(245);?>:</b> <?=$version;?> <br>
														<b><?=l(246);?>:</b> <?=$price;?> <br>
														<b><?=l(247);?>:</b> <?=$dir.$file.'/';?> <br>
														<b><?=l(248);?>:</b> <?=GetDirectorySize($dir.$file);?> KB <br><?=$message;?>
														</div>
													</div>
												</div>
											</td>
											<td style="vertical-align:middle;">
												<center>
													<form method="POST">
														<input type="hidden" value="<?= $file;?>" name="makeprimary">
														<button type="submit" alt="<?=l(235);?> " title="<?=l(235);?> " class="btn btn-secondary btn-sm" <?php if(Server_Details::GetSettings(3)==$file) print 'disabled'; ?>>
															<i class="fa-solid fa-key"></i>
														</button>
													</form>
												</center>
											</td>
										</tr>
										<?php
										}
									}
								}
								closedir($handle);
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } else print '<div class="alert alert-danger">You dont have access!</div>';?>