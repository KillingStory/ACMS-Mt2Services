<?php 
	if(signed()) 
	{
		?>
		<div class="content-bg">
			<div class="content inner-content">
				<div class="inner-title flex-cc" style="text-transform:uppercase;">
					<?= $title; ?> 
				</div><br><br>
				<center>
					<?php
						if(isset($mail_response))
							print $mail_response;
						if(isset($rsch_response))
							print $rsch_response;
					?>
						<table class="table table-striped" style="width: 95%;">
							<tbody>
								<tr>
									<th style="width:50%;text-transform:uppercase;padding:25px;"><center><?= l(78);?></center></th>
									<th style=""><center><?= Player::Email($i_player); ?></center></th>
								</tr>
								<tr>
									<th style="width:50%;text-transform:uppercase;padding:25px;"><center><?= l(79);?></center></th>
									<th style=""><center><?= Player::Username($i_player); ?></center></th>
								</tr>
								<tr>
									<th style="width:50%;text-transform:uppercase;padding:25px;"><center><?= l(80);?></center></th>
									<th style=""><center><?= Player::TotalChars($i_player); ?></center></th>
								</tr>
							</tbody>
						</table>
						<br>
						<table class="table table-striped" style="width: 95%;">
							<tbody>
								<tr>
									<th style="width:50%;text-transform:uppercase;padding:25px;"><center><?= l(81);?></center></th>
									<th style="text-transform:uppercase;"><center><?= Player::Coins($i_player); ?> MD</th>
								</tr>
								<tr>
									<th style="width:50%;text-transform:uppercase;padding:25px;"><center><?= l(82);?></center></th>
									<th style="text-transform:uppercase;"><center><?= Player::JCoins($i_player); ?> JD</th>
								</tr>
								<tr>
									<th style="width:50%;text-transform:uppercase;padding:25px;"><center><?= l(83);?></center></th>
									<th style="text-transform:uppercase;"><center><?= Player::TGold($i_player); ?> Yang</th>
								</tr>
							</tbody>
						</table>
						<br>
						<table class="table table-striped" style="width: 95%;">
							<tbody>
								<tr>
									<th style="width:50%;vertical-align:middle;text-transform:uppercase;padding:25px;"><center><?= l(84);?></center></th>
									<th style="text-transform:uppercase;">
										<center>
											<form method="POST">
												<button type="submit" name="reset_mail" class="blue-button" style="width:auto;"><?= l(86);?></button>
											</form>
										</center>
									</th>
								</tr>
								<tr>
									<th style="width:50%;vertical-align:middle;text-transform:uppercase;padding:25px;"><center><?= l(85);?></center></th>
									<th style="text-transform:uppercase;">
										<center>
											<form method="POST">
												<button type="submit" name="reset_pw" class="blue-button" style="width:auto;"><?= l(86);?></button>
											</form>
										</center>
									</th>
								</tr>
							</tbody>
						</table>
					<br><br>
					<div class="inner-title flex-cc" style="text-transform:uppercase;"><?=l(87)?></div>
					<br>
					<table class="table table-striped" style="width: 95%;">
						<tbody>
							<tr style="text-transform:uppercase;">
								<th style="padding:25px;"><center><?= l(98)?></center></th>
								<th style="padding:25px;"><center><?= l(22)?></center></th>
								<th style="padding:25px;"><center><?= l(24)?></center></th>
								<th style="padding:25px;"><center>DEBUG</center></th>
							</tr>
							<?php
								$characters_list = array();
								$characters_list = Player::CharList();
								if(!empty($characters_list)) {
								foreach($characters_list as $chars)
								{
							?>
							<tr>
								<th style="vertical-align:middle;"><center><img style="height:30px;" src="<?= Theme::URL(); ?>style/races/<?= $chars['job'];?>.png"></center></th>
								<th style="vertical-align:middle;"><center><?= $chars['name'];?></center></th>
								<th style="vertical-align:middle;"><center><?= $chars['level'];?></center></th>
								<th style="">
									<center>
										<form method="POST">
											<input type="hidden" name="debug_char" value="<?= $i_player; ?>">
											<button type="submit" name="debug_btn" class="blue-button" style="width:auto;">DEBUG</button>
										</form>
									</center>
								</th>
							</tr>
							<?php 
								}
							} else print '<tr style=""><th>Nu exista caractere</th><th></th><th></th><th></th></tr>'; ?>
						</tbody>
					</table>
				</center><br><br><br>
			</div>
		</div>
		<?php 
	} 
	else 
		print '<div class="alert alert-warning">'.l(70).'</div>'; ?>
