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
							<th style="text-transform:uppercase;"><?= l(50); ?></th>
							<th style="text-transform:uppercase;"><?= l(59); ?></th>
							<th style="text-transform:uppercase;"><?= l(60); ?></th>
							<th style="text-transform:uppercase;">EXP</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$banned_accounts = BannedAccounts();
							$page_limit=20;
							
							if(isset($search))
							{
								if($banned_accounts)
									$query = "SELECT id, name, account_id, level, exp FROM player WHERE name NOT LIKE '[%]%' AND account_id NOT IN (".$banned_accounts.") AND name LIKE :search ORDER BY level DESC, exp DESC, playtime DESC, name ASC";
								else
									$query = "SELECT id, name, account_id, level, exp FROM player WHERE name NOT LIKE '[%]%' AND name LIKE :search ORDER BY level DESC, exp DESC, playtime DESC, name ASC";
								$newquery = $paginate->paging($query,$page_limit);
								$paginate->dataview($newquery, $search);
							} else {
								if($banned_accounts)
									$query = "SELECT id, name, account_id, level, exp FROM player WHERE name NOT LIKE '[%]%' AND account_id NOT IN (".$banned_accounts.") ORDER BY level DESC, exp DESC, playtime DESC, name ASC";
								else
									$query = "SELECT id, name, account_id, level, exp FROM player WHERE name NOT LIKE '[%]%' ORDER BY level DESC, exp DESC, playtime DESC, name ASC";
								$newquery = $paginate->paging($query,$page_limit);
								$paginate->dataview($newquery);
							}
						?>
					</tbody>
				</table>
			</center>
			<?php
				if(isset($search))
					$paginate->pagelist($query,$page_limit,l(55),l(56),Theme::URL(),$search);
				else
					$paginate->pagelist($query,$page_limit,l(55),l(56),Theme::URL());
			?>
	</div>
</div>