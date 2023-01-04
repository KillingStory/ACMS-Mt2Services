<?php 
	if(signed()) 
	{ 
		$link = Theme::URL().'register/'.$_SESSION['id'];
		?>
		<div class="content-bg">
			<div class="content inner-content">
				<div class="inner-title flex-cc" style="text-transform:uppercase;">
					<?= $title; ?> 
				</div><br><br>
				<center>
					<form class="formGroup-button button-bottom">
						<input type="text" style="width:400px;vertical-align:middle;" class="form-control" value="<?php print $link; ?>" id="share" readonly="readonly">
						<button class="blue-button" style="width:auto;height:48px;vertical-align:middle;margin-top:-1px;" type="button" onclick="CopyContent('share')" data-placement="button" style="height:47;">
							<i class="fa fa-clipboard" aria-hidden="true"></i>
						</button>
					</form>
					<?php if(is_array($referrals_list) && count($referrals_list)) { ?>
					<br><br><br><br>
					<?php if($received) 
					{
						if($jsondataReferrals['type']==1)
							$cointype = ' (MD)';
						else 
							$cointype = ' (JD)';
						print '<script>GeneralSuccess("'.l(208).' '.$jsondataReferrals['coins'].' '.$cointype.'.");</script>';
					}
					?>
					<table class="table table-striped" style="width: 95%;">
						<thead>
							<tr>
								<th style="text-transform:uppercase;">#</th>
								<th style="text-transform:uppercase;"><?= l(209); ?></th>
								<th style="text-transform:uppercase;"><?= l(210); ?></th>
								<th style="text-transform:uppercase;"><?= l(211); ?></th>
								<th style="text-transform:uppercase;"><?= l(212); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$x=0;
								$i=1;
								foreach($referrals_list as $getChars) {
									
									$getCharsINFO = Refferals::_Info($getChars['registered']);

									if(count($getCharsINFO))
									{
										$hours = floor($getCharsINFO['playtime'] / 60);
										$minutes = $getCharsINFO['playtime'] % 60;
										
										echo'<tr>
											  <td style="text-transform:uppercase;">'.$i++.'</td>
											  <td style="text-transform:uppercase;">'.$getCharsINFO['name'].'</td>
											  <td style="text-transform:uppercase;">'.$getCharsINFO['level'].'</td>
											  <td style="text-transform:uppercase;">'.$hours.' ore & '.$minutes.' minute</td>';
										if($getChars['claimed']==1) echo '<td style="text-transform:uppercase;"><button class="blue-button" style="width:auto;">'.l(206).'</button></td>';
										else {
										if($jsondataReferrals['hours']<=$hours && $jsondataReferrals['level']<=$getCharsINFO['level'])
											echo '<td style="text-transform:uppercase;"><form action="" method="post"><input type="hidden" name="id" value="'.$getChars['registered'].'"><button id="submitBtn" type="submit" name="login" class="blue-button" style="width:auto;">'.l(207).'</button></td></form>';
										else echo '<td style="text-transform:uppercase;">'.l(205).'</td>';}
										echo'</tr>';
										  $x++;
									
									}		
								}
							?>
						</tbody>
					</table>
					<br><br>
					<div class="alert alert-warning" role="alert" style="color:black;width: 95%;">
						<h3 style="color:black;"><?= l(204); ?>:</h3><br>
						<span style="color:black;"><?php print l(202).': '.$jsondataReferrals['hours']; ?></span><br>
						<span style="color:black;"><?php print l(203).': '.$jsondataReferrals['level']; ?></span>
					</div>
				</center>
			</div>
		</div>
		<?php 
		} 
	} 
	else 
		print '<div class="alert alert-warning">'.l(70).'</div>'; ?>
