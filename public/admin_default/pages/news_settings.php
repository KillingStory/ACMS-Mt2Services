<?php if(Permission::Verify('articles')) { ?>
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>
<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-12 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h3 class="card-title"><?= l(154); ?></h3><br>
				<h6 style="float:right;"></h6>
				</div>
				<div class="card-body px-0 pb-2" style="margin-left:20px;margin-right:20px;">
					<?php 
						if(isset($callback))
						{
							print $callback;
						}
					?>
					<form method="post">
						&nbsp;&bull; <?= l(155); ?>:
						<input type="number" class="form-control" onfocusout="UploadSettings('newslimits')" onfocusin="OnFocus('newslimits')" id="newslimits" name="newslimits" placeholder="<?= l(155); ?>" value="<?= Server_Details::NewsRecords();?>">
						<br>
						<input type="checkbox" id="ownerart" data-toggle="switchbutton" name="creatorname" data-onlabel="Enabled" data-offlabel="Disabled" data-onstyle="success" data-offstyle="danger" <?= ACP::ShowNewsSettings(7); ?>> &nbsp;&bull; <?= l(156); ?>
						<br><br>
						<input type="checkbox" id="articledate" data-toggle="switchbutton" name="dateshow" data-onlabel="Enabled" data-offlabel="Disabled" data-onstyle="success" data-offstyle="danger" <?= ACP::ShowNewsSettings(8); ?>> &nbsp;&bull; <?= l(157); ?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div style="display:none;" id="result_hash"></div>

<script>
	function OnFocus(variable)
	{
		document.getElementById(variable).classList.remove('is-valid');
	}
	
	function UploadSettings(quest) {
		document.getElementById(quest).classList.add('is-valid');
		var variable = '0';
		if(variable=='' || variable==null)
		{
			var variable = document.getElementById('sdesc');
		}
		else
		{
			var variable = document.getElementById(quest).value;
		}
		$('#result_hash').load('<?= Theme::URL(); ?>?v=general&' + quest + '=' + encodeURI(variable));
		alertSuccess(variable);
	}
	$("#ownerart").on('change', function() 
	{
		if ($(this).is(':checked')) 
		{
			$('#result_hash').load('<?= Theme::URL(); ?>?v=general&ownerart=1');
			alertSuccess('1');
		}
		else
		{
			$('#result_hash').load('<?= Theme::URL(); ?>?v=general&ownerart=0');
			alertSuccess('0');
		}
	});
	$("#articledate").on('change', function() 
	{
		if ($(this).is(':checked')) 
		{
			$('#result_hash').load('<?= Theme::URL(); ?>?v=general&articledate=1');
			alertSuccess('1');
		}
		else
		{
			$('#result_hash').load('<?= Theme::URL(); ?>?v=general&articledate=0');
			alertSuccess('0');
		}
	});
</script>
<?php } else print '<div class="alert alert-danger">You dont have access!</div>';?>