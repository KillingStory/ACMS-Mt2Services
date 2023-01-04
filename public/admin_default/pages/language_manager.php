<?php if(Permission::Verify('editlang')) { 

	if(isset($_GET['edit']))
		$language_code_received = $_GET['edit'];
	else
		$language_code_received = 'en';
	if(isset($_GET['search']))
		$search_value = $_GET['search'];
	else
		$search_value = null;
?>

<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-12 col-md-12 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?=l(239);?></h4>
					
					<h6 style="float:right;">
						<form class="form-inline">
							<input type="text" placeholder="<?=l(240);?>" style="width:300px;" id="searchkey" onkeyup="loadtable()" class="form-control form-control-sm">&nbsp;&nbsp;&nbsp;
							<?php if(count($json_languages['languages'])>1) { ?>
								<select class="form-control form-control-sm" style="width:200px;" onchange="if (this.value) window.location.href=this.value">
								<?php
									foreach($json_languages['languages'] as $key => $value)
									{
											print '<option value="'.Theme::URL().'admin_panel/languages_edit/'. $key.'/"';
											if($key==$language_code_received)
												print ' selected';
											print '>'.$value.'</option>';
									}
								?>
								</select>
						</form>
						<?php } ?>
					</h6>
				</div>
				<div class="card-body">
				<div id="callback_response" style="display:none;"></div>
					<div id="callback_responsetable"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
loadtable();
function loadtable() {
	var default_value = '';
	default_value = document.getElementById("searchkey").value;
		$("#callback_responsetable").load("<?= Theme::URL(); ?>?v=translations&langcode=<?=$language_code_received;?>&search=" + default_value);
}
function OnFocus(varvd) {
	document.getElementById(varvd).classList.remove("is-valid")
}
function UploadLang(newcontent, key, lang) {
	document.getElementById(newcontent).classList.add("is-valid");
	var newcontent = document.getElementById(newcontent).value;
	var delnbsp = newcontent.replace(/&.*;/g,' ');
	$("#callback_response").load("<?= Theme::URL(); ?>?v=social&rkey=" + key + "&language=" + encodeURI(lang) + "&newv=" + encodeURI(delnbsp)), alertSuccess(delnbsp)
}
</script>
<?php } else print '<div class="alert alert-danger">You dont have access!</div>';?>