<?php if(Permission::Verify('marketplace')) { ?>
<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-12 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h3 class="card-title">Plugins</h3><br>
				<h6 style="float:right;">
				</h6>
				</div>
				<div class="card-body px-0 pb-2" style="margin-left:20px;margin-right:20px;">
				<?php 
					$json_arr = file_get_contents('system/database/plugins.json');
					$json_arr = json_decode($json_arr, true);
					if(isset($_POST['product']))
					{
						$download_url = "https://m2s-shop.com/cms/store/plugins/?downloadproduct=".$_POST['product']."&sitekey=".$siteownkey;
						$delete = "no";
						$file = "file.zip";
						$script = basename($_SERVER['PHP_SELF']);
						file_put_contents($file, fopen($download_url, 'r'));
						$path = pathinfo(realpath($file), PATHINFO_DIRNAME);
						$zip = new ZipArchive;
						$res = $zip->open($file);

						if ($res === TRUE) {
							$zip->extractTo($path);
							$zip->close();
							unlink($file);
							include 'install.php';
							print 'Installed!';
						} else {
						  echo "Couldn't open $file";
						}
					}
					if(isset($_POST['delete']))
					{
						$json_arr[$_POST['delete']]['active']='false';
						file_put_contents('system/database/plugins.json', json_encode($json_arr));
					}
					if(isset($_POST['activate']))
					{
						$json_arr[$_POST['activate']]['active']='true';
						file_put_contents('system/database/plugins.json', json_encode($json_arr));
					}
				?>
					<div class="row">
					<?php
						$plugins_read = file_get_contents('https://m2s-shop.com/cms/store/mt2services-plugins-acms.json');
						$plugins_read = json_decode($plugins_read, true);
						foreach($plugins_read as $plugins)
						{
							?>
							<div class="col-md-3">
								<div class="card" style="width: 18rem;">
									<img class="card-img-top" src="<?php print $plugins['image']; ?>" alt="Card image cap">
									<div class="card-body">
										<h5 class="card-title"><?php print $plugins['name']; ?></h5>
										<p class="card-text"><br><?php print $plugins['content']; ?><br><br></p>
										<?php
										$active_plugins = file_get_contents('system/database/plugins.json');
										$active_plugins = json_decode($active_plugins, true);
										
										
										
										if(isset($active_plugins[$plugins['identificator']]) && $active_plugins[$plugins['identificator']]['installed']=='true' && $active_plugins[$plugins['identificator']]['active']=='true')
										{
											print '<form method="POST"><input type="hidden" name="delete" value="'.$plugins['identificator'].'"><button type="submit" class="btn btn-warning">Disable</button></form> &nbsp;&nbsp;&nbsp;';
										}
										elseif(isset($active_plugins[$plugins['identificator']]) && $active_plugins[$plugins['identificator']]['active']=='false')
											print '<form method="POST"><input type="hidden" name="activate" value="'.$plugins['identificator'].'"><button type="submit" class="btn btn-success">Enable</button></form> &nbsp;&nbsp;&nbsp;';
										else
										{
											print '<form method="POST"><input type="hidden" name="product" value="'.$plugins['identificator'].'"><button type="submit" class="btn btn-dark">Download & Install</button></form> &nbsp;&nbsp;&nbsp;';
											print '<a><b>Price:</b> <font color="red">'.$plugins['price'].'</font>';
										}
										?>
										
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row mb-4">
		<div class="col-lg-12 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h3 class="card-title">Templates</h3><br>
				<h6 style="float:right;">
				</h6>
				</div>
				<div class="card-body px-0 pb-2" style="margin-left:20px;margin-right:20px;">
				<?php 
					
				?>
					<div class="row">
					<?php
						$templates_read = file_get_contents('https://m2s-shop.com/cms/store/mt2services-templates-acms.json');
						$templates_read = json_decode($templates_read, true);
						foreach($templates_read as $templates)
						{
							?>
							<div class="col-md-3">
								<div class="card" style="width: 18rem;">
									<img class="card-img-top" src="<?php print $templates['image']; ?>" alt="Card image cap">
									<div class="card-body">
										<h5 class="card-title"><?php print $templates['name']; ?></h5>
										<p class="card-text"><br><?php print $templates['content']; ?></p>
										<p class="card-text"><br><b>Price:</b>&nbsp;<?php print $templates['price']; ?><br><br></p>
										<a target="_blank" href="https://discord.gg/AwhKh3Hbtp"><button type="submit" class="btn btn-success">Contact to buy</button></a>
										
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } else print '<div class="alert alert-danger">You dont have access!</div>';?>