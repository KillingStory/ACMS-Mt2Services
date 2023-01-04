<link rel="stylesheet" href="<?= Theme::URL();?>/style/partials/modal_btn.css">
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
<style>
#empire
{
	background-image: url('<?php print URL;?>/style/maps/2.jpg');
	height:500px;
	position: relative;
	background-repeat: no-repeat, no-repeat;
	background-size: auto 500px;
}

.item
{
	position:fixed;
	height:7px;
}
</style>
<div id="empire">
<?php 
	$map = array();
	$map = ACP::map3();
	foreach ($map as $pl)
	{
		$x_axe_a=$pl['y']-204800;
		$y_axe_a=$pl['x']-921600; 
		$x_axe=$x_axe_a/100/2.57;
		$y_axe=$y_axe_a/100/2.57; 
		print '<img class="item" data-toggle="modal" data-target="#player'.$pl['id'].'" src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/07/Button_Icon_Red.svg/1200px-Button_Icon_Red.svg.png" style="margin-top:'.$x_axe.'px;margin-left:'.$y_axe.'px;">';
	?>
	<div class="modal fade" style="width:80%" id="player<?=$pl['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					&#9673; <b>Player Name:</b> <?php print $pl['name'];?><br>
					&#9673; <b>Level:</b> <?php print $pl['level'];?><br>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>