<?php if(Permission::Verify('custpag')) { ?>
<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-12 col-md-12 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title">Custom Pages 
					<?php
					if($_GET['variablepage']!='') 
						print ' - '.ucfirst(Custom_Pages::Show($_GET['variablepage'], 'title')); 
					?>
					</h4><br>
					<h6 style="float:right;">
					</h6>
				</div>
				<div class="card-body">
					<?php
						if(!isset($_GET['variablepage']) || $_GET['variablepage']=='')
						{
					?>
					<table class="table table-bordered">
						<tbody>
							<tr>
								<th scope="col" style="text-transform:uppercase;">
									<center>Page Name</center>
								</th>
								<th scope="col" style="text-transform:uppercase;">
									<center>Last Updated</center>
								</th>
								<th scope="col" style="text-transform:uppercase;">
									<center>Actions</center>
								</th>
							</tr>
							<?php
							$list = array();
							$list = Custom_Pages::AllList();
							foreach($list as $show)
							{
								?>
								<tr>
									<td><?php print ucfirst($show['title']); ?></td>
									<td><center><?php print $show['last_update']; ?></center></td>
									<td><center><a href="<?php print Theme::URL().'admin_panel/custom-page/'.$show['id']; ?>"><button class="btn btn-warning"><i class="fa fa-pencil"></button></center></td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
					<?php 
						} 
						else  
						{
							if(isset($_POST['content']))
							{
								$datanew = date('Y-m-d H:i:s');
								Custom_Pages::Update($_POST['content'], $datanew, $_GET['variablepage']);
							}
						?>
					<form method="POST">
						<textarea name="content" id="addnews" rows="10" cols="80"><?= Custom_Pages::Show($_GET['variablepage'], 'contain'); ?></textarea>
						<br><br><center><button type="submit" class="btn btn-secondary">Update</button>
					</form>
					
					<script>
						CKEDITOR.replace('addnews');
					</script>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } else print '<div class="alert alert-danger">You dont have access!</div>';?>