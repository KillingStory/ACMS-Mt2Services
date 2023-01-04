<?php if(Permission::Verify('articles')) { ?>
<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-5 col-md-6 mb-md-0 mb-4">
			<?php if($post_edit) { ?>
			
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<?= l(138); ?>
				<h6 style="float:right;"><a href="<?php print Theme::URL(); ?>admin_panel/news"><button class="btn btn-dark btn-small"><?= l(139); ?></button></a></h6>
				</div>
				<form method="POST">
					<div class="card-body px-0 pb-2" style="margin-left:20px;margin-right:20px;">
						<input type="text" class="form-control" name="title" value="<?= News::Get($post_id, 'title'); ?>">
						<br>
						<textarea name="content" id="addnews" rows="10" cols="80"><?= News::Get($post_id, 'content'); ?></textarea>
						<br>
						<input type="hidden" class="form-control" name="idpost" value="<?= $post_id; ?>">
						<center><input type="submit" class="btn btn-success btn-sm" name="updatenewsbtn" value="<?= l(140); ?>"></center>
					</div>
				</form>
			</div>
			
			<?php } else { ?>
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<?= l(139); ?><br>
				<h6 style="float:right;"></h6>
				</div>
				<form method="POST">
					<div class="card-body px-0 pb-2" style="margin-left:20px;margin-right:20px;">
						<input type="text" class="form-control" name="title" placeholder="<?= l(141); ?>">
						<br>
						<textarea name="content" id="addnews" rows="10" cols="80"></textarea>
						<br>
						<center><input type="submit" class="btn btn-success btn-sm" name="addnewsbtn" value="<?= l(128); ?>"></center>
					</div>
				</form>
			</div>
			<?php } ?>
		</div>
		<div class="col-lg-7 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<?= l(161); ?><br>
				<h6 style="float:right;"></h6>
				</div>
				<div class="card-body px-0 pb-2" style="margin-left:20px;margin-right:20px;">
					
					<table class="table table-bordered">
						<thead class="thead-dark">
							<tr>
								<th scope="col"><center><?= l(141); ?></center></th>
								<th scope="col"><center><?= l(142); ?></center></th>
								<th scope="col"><center><?= l(143); ?></center></th>
								<th scope="col"><center><?= l(144); ?></center></th>
								<th scope="col"><center><?= l(145); ?></center></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$news_list = array();
								$news_list = News::Show();
								foreach ($news_list as $nl)
								{
									print '<tr>';
									print '<td><center>'.$nl['title'].'</center></th>';
									print '<td><center><a target="_blank" href="'.Theme::URL().'read/'.$nl['id'].'"><button class="btn btn-dark">'.l(146).'</button></a></center></td>';
									print '<td><center>'.$nl['time'].'</center></td>';
									print '<td><center>'.$nl['owner'].'</center></td>';
									print '<td><center>
									<form method="POST">
									<a class="btn btn-dark btn-sm" href="'.Theme::URL().'admin_panel/news/'.$nl['id'].'"><i class="fa fa-pencil"></i></a> &nbsp;
									<input type="hidden" name="deleteid" value="'.$nl['id'].'">
									<button name="delete" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></form></center></td>';
									print '</tr>';
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	CKEDITOR.replace('addnews');
</script>
<?php } else print '<div class="alert alert-danger">You dont have access!</div>';?>