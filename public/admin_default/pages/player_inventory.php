<?php if(Permission::Verify('banplay')) {
	if(isset($_GET['playerids']))
	{
		include 'system/items_images.php';
		$playerownid = $_GET['playerids'];
?>
<br><a href="<?= Theme::URL(); ?>admin_panel/players_management"><button class="btn btn-dark"><i class="fa-solid fa-backward"></i> &nbsp;Go back </button></a>
<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-2 col-md-2 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title">Select category</h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<center>
						<?php if(ACP::CountItemsPlayer($playerownid, 'SAFEBOX')) { ?>
						<button class="btn btn-dark" onclick="inventory();">&bull; Safebox </button><br><br>
						<?php } if(ACP::CountItemsPlayer($playerownid, 'INVENTORY')) { ?>
						<button class="btn btn-dark" onclick="safebox();">&bull; Inventory </button><br><br>
						<?php } if(ACP::CountItemsPlayer($playerownid, 'EQUIPMENT')) { ?>
						<button class="btn btn-dark" onclick="equipment();">&bull; Equipment </button>
						<?PHP } ?>
					</center>
				</div>
			</div>
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title">Player details - <?=ACP::GetCharsDetails($playerownid, 'name');?></h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<center>
						<img style="width:180px;" src="<?php print Theme::URL().'style/races/'.ACP::GetCharsDetails($playerownid, 'job').'_big.png'; ?>">
						<br><br>
						<ul class="list-group">
						  <li class="list-group-item d-flex justify-content-between align-items-center">
							Player Level
							<span class="badge badge-light badge-pill"><?=ACP::GetCharsDetails($playerownid, 'level');?></span>
						  </li>
						  <li class="list-group-item d-flex justify-content-between align-items-center">
							Playtime
							<span class="badge badge-light badge-pill"><?=round(ACP::GetCharsDetails($playerownid, 'playtime')/60);?>h</span>
						  </li>
						  <li class="list-group-item d-flex justify-content-between align-items-center">
							Yang
							<span class="badge badge-light badge-pill"><?=YangFIX(ACP::GetCharsDetails($playerownid, 'gold'));?></span>
						  </li>
						  <?php if(CheckPlayer('gaya')) { ?>
						  <li class="list-group-item d-flex justify-content-between align-items-center">
							Gaya
							<span class="badge badge-light badge-pill"><?=ACP::GetCharsDetails($playerownid, 'gaya');?></span>
						  </li>
						  <?php } ?>
						  <li class="list-group-item d-flex justify-content-between align-items-center">
							IP Adress
							<span class="badge badge-light badge-pill"><?=ACP::GetCharsDetails($playerownid, 'ip');?></span>
						  </li>
						  <li class="list-group-item d-flex justify-content-between align-items-center">
							Last Play
							<span class="badge badge-light badge-pill"><?=ACP::GetCharsDetails($playerownid, 'last_play');?></span>
						  </li>
						  <li class="list-group-item d-flex justify-content-between align-items-center">
							Status
							<span class="badge badge-light badge-pill"><?=ACP::CharStatus(ACP::GetCharsDetails($playerownid, 'alignment'));?></span>
						  </li>
						  
						</ul>
					</center>
				</div>
			</div>
		</div>
		<div class="col-lg-10 col-md-10 mb-md-0 mb-4">
			<div class="card card-secondary" id="safebox" style="display:none;">
				<div class="card-header pb-0">
					<h4 class="card-title">Inventory Items</h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<div class="row">
					<?php
						if(ACP::CountItemsPlayer($playerownid, 'INVENTORY'))
						{
							$item_owner = array();
							$item_owner = ACP::GetItemsPlayer($playerownid, 'INVENTORY');
							foreach($item_owner as $item)
							{
								print '
								<div class="col">
									<div class="card" style="width: 18rem;height:371.11px;">
										<center>
											<br>
											<img class="card-img-top" alt="'.$item['vnum'].'" title="'.$item['vnum'].'" style="width:42px;" src="'.Theme::URL().'style/partials/items/'.get_item_image($item['vnum']).'.png" alt="Card image cap">
										</center>
										<div class="card-body">
											<h5 alt="'.$item['vnum'].'" title="'.$item['vnum'].'">
												<b>
													<center>
														'.ACP::GetItemName($item['vnum']).'
													</center>
												</b>
											</h5>
											<p class="card-text"><br>
												'.ACP::GetBonus($item['attrtype0'], $item['attrvalue0']).'<br>
												'.ACP::GetBonus($item['attrtype1'], $item['attrvalue1']).'<br>
												'.ACP::GetBonus($item['attrtype2'], $item['attrvalue2']).'<br>
												'.ACP::GetBonus($item['attrtype3'], $item['attrvalue3']).'<br>
												'.ACP::GetBonus($item['attrtype4'], $item['attrvalue4']).'<br>
												'.ACP::GetBonus($item['attrtype5'], $item['attrvalue5']).'<br>
												'.ACP::GetBonus($item['attrtype6'], $item['attrvalue6']).'<br>
											</p>
										</div>
									</div>
								</div>';
							}
						}
					?>
					
					</div>
				</div>
			</div>
			<div class="card card-secondary" id="inventory" style="display:none;">
				<div class="card-header pb-0">
					<h4 class="card-title">Safebox Items</h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<div class="row">
						<?php
						if(ACP::CountItemsPlayer($playerownid, 'SAFEBOX'))
						{
							$item_owner = array();
							$item_owner = ACP::GetItemsPlayer($playerownid, 'SAFEBOX');
							foreach($item_owner as $item)
							{
								print '
								<div class="col">
									<div class="card" style="width: 18rem;height:371.11px;">
										<center>
											<br>
											<img class="card-img-top" alt="'.$item['vnum'].'" title="'.$item['vnum'].'" style="width:42px;" src="'.Theme::URL().'style/partials/items/'.get_item_image($item['vnum']).'.png" alt="Card image cap">
										</center>
										<div class="card-body">
											<h5 alt="'.$item['vnum'].'" title="'.$item['vnum'].'">
												<b>
													<center>
														'.ACP::GetItemName($item['vnum']).'
													</center>
												</b>
											</h5>
											<p class="card-text"><br>
												'.ACP::GetBonus($item['attrtype0'], $item['attrvalue0']).'<br>
												'.ACP::GetBonus($item['attrtype1'], $item['attrvalue1']).'<br>
												'.ACP::GetBonus($item['attrtype2'], $item['attrvalue2']).'<br>
												'.ACP::GetBonus($item['attrtype3'], $item['attrvalue3']).'<br>
												'.ACP::GetBonus($item['attrtype4'], $item['attrvalue4']).'<br>
												'.ACP::GetBonus($item['attrtype5'], $item['attrvalue5']).'<br>
												'.ACP::GetBonus($item['attrtype6'], $item['attrvalue6']).'<br>
											</p>
										</div>
									</div>
								</div>';
							}
						}
					?>
					</div>
				</div>
			</div>
			<div class="card card-secondary" id="equipment" style="display:none;">
				<div class="card-header pb-0">
					<h4 class="card-title">Equipment Items</h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<div class="row">
						<?php
						if(ACP::CountItemsPlayer($playerownid, 'EQUIPMENT'))
						{
							$item_owner = array();
							$item_owner = ACP::GetItemsPlayer($playerownid, 'EQUIPMENT');
							foreach($item_owner as $item)
							{
								print '
								<div class="col">
									<div class="card" style="width: 18rem;height:371.11px;">
										<center>
											<br>
											<img class="card-img-top" alt="'.$item['vnum'].'" title="'.$item['vnum'].'" style="width:42px;" src="'.Theme::URL().'style/partials/items/'.get_item_image($item['vnum']).'.png" alt="Card image cap">
										</center>
										<div class="card-body">
											<h5 alt="'.$item['vnum'].'" title="'.$item['vnum'].'">
												<b>
													<center>
														'.ACP::GetItemName($item['vnum']).'
													</center>
												</b>
											</h5>
											<p class="card-text"><br>
												'.ACP::GetBonus($item['attrtype0'], $item['attrvalue0']).'<br>
												'.ACP::GetBonus($item['attrtype1'], $item['attrvalue1']).'<br>
												'.ACP::GetBonus($item['attrtype2'], $item['attrvalue2']).'<br>
												'.ACP::GetBonus($item['attrtype3'], $item['attrvalue3']).'<br>
												'.ACP::GetBonus($item['attrtype4'], $item['attrvalue4']).'<br>
												'.ACP::GetBonus($item['attrtype5'], $item['attrvalue5']).'<br>
												'.ACP::GetBonus($item['attrtype6'], $item['attrvalue6']).'<br>
											</p>
										</div>
									</div>
								</div>';
							}
						}
					?>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>

<script>
var safeboxcount = 1;
var inventocount = 1;
var equipmentcnt = 1;
function safebox()
{
	safeboxcount++;
	if(safeboxcount%2==0)
		document.getElementById("safebox").style.display="block";
	else
		document.getElementById("safebox").style.display="none";
}
function inventory()
{
	inventocount++;
	if(inventocount%2==0)
	document.getElementById("inventory").style.display="block";
	else
	document.getElementById("inventory").style.display="none";
}
function equipment()
{
	equipmentcnt++;
	if(equipmentcnt%2==0)
	document.getElementById("equipment").style.display="block";
	else
	document.getElementById("equipment").style.display="none";
}
</script>

	<?php } 
	} else print '<div class="alert alert-danger">You dont have access!</div>';?>