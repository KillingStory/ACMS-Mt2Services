<div class="content-bg">
	<div class="content inner-content">
		<div class="inner-title flex-cc" style="text-transform:uppercase;">
			<?= $title; ?> 
		</div>
		<center>
			<br><br>
			<form action="" method="POST" class="formGroup-button button-bottom">
				<input type="text" style="width:200px;vertical-align:middle;" name="search" placeholder="<?= l(62); ?>" value="<?php if(isset($search)) print $search; ?>">
				<button type="submit" class="blue-button" style="height:48px;width:auto;vertical-align:middle;margin-top:-1px;"><i class="fa fa-search fa-1" aria-hidden="true"></i> <?= l(61); ?></button>
			</form>
			<br>
			<table class="table table-striped" style="width: 95%;">
				<thead>
					<tr>
						<th style="text-transform:uppercase;">#</th>
						<th style="text-transform:uppercase;"><?php print l(57); ?></th>
						<th style="text-transform:uppercase;"><?php print l(58); ?></th>
						<th style="text-transform:uppercase;"><?php print l(59); ?></th>
						<th style="text-transform:uppercase;"><?php print l(60); ?></th>
						<th style="text-transform:uppercase;"><?php print l(64); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php		
						$records_per_page=20;

						if(isset($search))
						{
							$query = "SELECT id, name, master, level, ladder_point FROM guild WHERE name NOT LIKE '[%]%' AND name LIKE :search ORDER BY level DESC, ladder_point DESC, exp DESC, name ASC";
							$newquery = $paginate->paging($query,$records_per_page);
							$paginate->dataview($newquery, $search);
						} else {
							$query = "SELECT id, name, master, level, ladder_point FROM guild WHERE name NOT LIKE '[%]%' ORDER BY level DESC, ladder_point DESC, exp DESC, name ASC";
							$newquery = $paginate->paging($query,$records_per_page);
							$paginate->dataview($newquery);
						}
						
					?>
				</tbody>
			</table>
			<?php
				if(isset($search))
					$paginate->paginglink($query,$records_per_page,l(55),l(56),Theme::URL(),$search);
				else
					$paginate->paginglink($query,$records_per_page,l(55),l(56),Theme::URL());
			?>
		</center>
	</div>
</div>
			