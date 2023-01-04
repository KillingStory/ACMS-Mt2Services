<?php if(Permission::Full()) { ?>
<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-12 col-md-12 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title">Give access</h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
				<?php
					if(isset($_POST['usercontrol'], $_POST['allowaccess']))
					{
						$username = $_POST['usercontrol'];
						
						if(!isset($_POST['articles']))
							$articles = 0;
						else 
							$articles = 1;
						
						if(!isset($_POST['downloads']))
							$downloads = 0;
						else 
							$downloads = 1;
						
						if(!isset($_POST['logs']))
							$logs = 0;
						else 
							$logs = 1;
						
						if(!isset($_POST['createitem']))
							$createitem = 0;
						else 
							$createitem = 1;
						
						if(!isset($_POST['banplay']))
							$banplay = 0;
						else 
							$banplay = 1;
						
						if(!isset($_POST['promotional']))
							$promotional = 0;
						else 
							$promotional = 1;
						
						if(!isset($_POST['vote4coins']))
							$vote4coins = 0;
						else 
							$vote4coins = 1;
						
						if(!isset($_POST['refferal']))
							$refferal = 0;
						else 
							$refferal = 1;
						
						if(!isset($_POST['genset']))
							$genset = 0;
						else 
							$genset = 1;
						
						if(!isset($_POST['custpag']))
							$custpag = 0;
						else 
							$custpag = 1;
						
						if(!isset($_POST['adlang']))
							$adlang = 0;
						else 
							$adlang = 1;
						
						if(!isset($_POST['editlang']))
							$editlang = 0;
						else 
							$editlang = 1;
						
						if(!isset($_POST['manateme']))
							$manateme = 0;
						else 
							$manateme = 1;
						
						if(!isset($_POST['marketplace']))
							$marketplace = 0;
						else 
							$marketplace = 1;
						
						if(!isset($_POST['plugsett']))
							$plugsett = 0;
						else 
							$plugsett = 1;
						
						Permission::AddAdminAllowance($username, $articles, $downloads, $logs, $createitem, $banplay, $promotional, $vote4coins, $refferal, $genset, $custpag, $adlang, $editlang, $manateme, $marketplace, $plugsett);
					}
					if(isset($_POST['idval']))
					{
						Permission::Del($_POST['idval']);
					}
				
				?>
				
				
						<form method="POST">
							<center><input type="text" name="usercontrol" class="form-control" placeholder="Account username" required></center><br>
							<div class="row">
								<div class="col">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="articles"/>
										<label class="form-check-label" for="flexCheckDefault">
											Access on articles
										</label>
									</div>
								</div>
								<div class="col">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="downloads"/>
										<label class="form-check-label" for="flexCheckDefault">
											Access on downloads
										</label>
									</div>
								</div>
								<div class="col">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="logs"/>
										<label class="form-check-label" for="flexCheckDefault">
											Access on logs
										</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="createitem"/>
										<label class="form-check-label" for="flexCheckDefault">
											Access on create item
										</label>
									</div>
								</div>
							
								<div class="col">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="banplay"/>
										<label class="form-check-label" for="flexCheckDefault">
											Access ban players
										</label>
									</div>
								</div>
								<div class="col">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="promotional"/>
										<label class="form-check-label" for="flexCheckDefault">
											Access on promotional codes
										</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="vote4coins"/>
										<label class="form-check-label" for="flexCheckDefault">
											Access on vote for coins
										</label>
									</div>
								</div>
								<div class="col">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="refferal"/>
										<label class="form-check-label" for="flexCheckDefault">
											Access on refferal system
										</label>
									</div>
								</div>
								<div class="col">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="genset"/>
										<label class="form-check-label" for="flexCheckDefault">
											Access to edit general settings
										</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="custpag"/>
										<label class="form-check-label" for="flexCheckDefault">
											Access to edit custom pages
										</label>
									</div>
								</div>
								<div class="col">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="adlang"/>
										<label class="form-check-label" for="flexCheckDefault">
											Access to add languages
										</label>
									</div>
								</div>
								<div class="col">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="editlang"/>
										<label class="form-check-label" for="flexCheckDefault">
											Access to edit languages translations
										</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="manateme"/>
										<label class="form-check-label" for="flexCheckDefault">
											Access to manage theme
										</label>
									</div>
								</div>
								<div class="col">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="marketplace"/>
										<label class="form-check-label" for="flexCheckDefault">
											Access to marketplace
										</label>
									</div>
								</div>
								<div class="col">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="plugsett"/>
										<label class="form-check-label" for="flexCheckDefault">
											Access to edit plugins settings
										</label>
									</div>
								</div>
							</div>
							<br><br>
							<center><input type="submit" name="allowaccess" class="btn btn-dark" value="Allow"></center>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12 col-md-12 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title">Access List</h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<table class="table table-bordered">
						<thead class="thead-dark">
							<tr>
							  <th scope="col"><center>Username</th>
							  <th scope="col"><center>Articles</th>
							  <th scope="col"><center>Downloads</th>
							  <th scope="col"><center>Logs</th>
							  <th scope="col"><center>Create item</th>
							  <th scope="col"><center>Ban players</th>
							  <th scope="col"><center>Promotional codes</th>
							  <th scope="col"><center>Vote4coins</th>
							  <th scope="col"><center>Refferal</th>
							  <th scope="col"><center>General Settings</th>
							  <th scope="col"><center>Custom Pages</th>
							  <th scope="col"><center>Add Language</th>
							  <th scope="col"><center>Edit Language</th>
							  <th scope="col"><center>Manage Templates</th>
							  <th scope="col"><center>Marketplace</th>
							  <th scope="col"><center>Plugin Manager</th>
							  <th scope="col"><center>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$acclist = array();
								$acclist = Permission::ShowAllowed();
								foreach ($acclist as $al)
								{
									print '<tr>';
										print '<td><center>'.$al['username'].'</td>';
										print '<td><center>'.$al['articles'].'</td>';
										print '<td><center>'.$al['downloads'].'</td>';
										print '<td><center>'.$al['logs'].'</td>';
										print '<td><center>'.$al['createitem'].'</td>';
										print '<td><center>'.$al['banplay'].'</td>';
										print '<td><center>'.$al['promotional'].'</td>';
										print '<td><center>'.$al['vote4coins'].'</td>';
										print '<td><center>'.$al['refferal'].'</td>';
										print '<td><center>'.$al['genset'].'</td>';
										print '<td><center>'.$al['custpag'].'</td>';
										print '<td><center>'.$al['adlang'].'</td>';
										print '<td><center>'.$al['editlang'].'</td>';
										print '<td><center>'.$al['manateme'].'</td>';
										print '<td><center>'.$al['marketplace'].'</td>';
										print '<td><center>'.$al['plugsett'].'</td>';
										print '<td><center><form method="POST"><input type="hidden" name="idval" value="'.$al['id'].'"><button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></center></td>';
									print '</tr>';
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php } else print '<div class="alert alert-danger">You dont have access!</div>';?>