<!-- JQUERY-->
	<script src="<?php print Theme::URL(); ?>style/partials/jquery.js"></script>
<!-- ALERTS -->
	<link rel="stylesheet" href="<?php print Theme::URL(); ?>style/partials/toastr/toastr.min.css">
	<script src="<?php print Theme::URL(); ?>style/partials/toastr/toastr.min.js"></script>
	<?php if($site_page=='admin') {?>
<!-- CKEDITOR -->
	<script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
	<?php } ?>
<!-- ALERTS JS -->
	<script src="<?php print Theme::URL(); ?>style/partials/sweetalert"></script>
<!-- FONT AWESOME -->
	<link rel="stylesheet" href="<?php print Theme::URL(); ?>style/partials/fontawesome/css/all.min.css"/>
<!-- LANGUAGES --->
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<link rel="stylesheet" href="<?php print Theme::URL(); ?>style/partials/languages.css" />
	<script src="<?php print Theme::URL(); ?>style/partials/languages.js"></script>
	<style>
	#mini-icons a{ display:block;color:#<?= Server_Details::GetSettings(13); ?>;font-size:24px;background-color:#<?= Server_Details::GetSettings(13); ?>;transition:all .2s ease-in-out 0s;}#mini-icons .languagewrapper a:hover{ background-color:#<?= Server_Details::GetSettings(13); ?>;}
	</style>
	<div id="mini-icons" style="left: 0px;">
		<div class="languagewrapper">
			<a class="current-language flag-icon flag-icon-<?= $language_code;?>" onmouseover="if (!window.__cfRLUnblockHandlers) return false; enlarge()" onmouseout="if (!window.__cfRLUnblockHandlers) return false; dlarge()" type="button" btattached="true"></a>
			<?php if(count($json_languages['languages'])>1) { ?>
			<div class="languages" id="languages" style="width: 0vw; left: -56px;">
				<?php
					foreach($json_languages['languages'] as $key => $value)
					{
						if($language_code!=$key)
							print '<a href="'.Lang::Change($key).'" onmouseover="if (!window.__cfRLUnblockHandlers) return false; enlarge()" onmouseout="if (!window.__cfRLUnblockHandlers) return false; dlarge()" style="width: 56px;" class="current-language flag-icon flag-icon-'.$key.'"></a>';
					}
				?>
			</div>
			<?php } ?>
		</div>
	</div>
<!---  LANGUAGES END -->
	<script>
	var Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 15000
	});
	function alertSuccess(text)
	{
		Toast.fire({
			icon: 'success',
			html: '<strong>Success:</strong> ' + text
		})
	}
	function UpdateTRUE(text)
	{
		Toast.fire({
			icon: 'success',
			html: '<strong>Success:</strong> ' + text
		})
	}
	function GeneralSuccess(text)
	{
		Toast.fire({
			icon: 'success',
			html: text
		})
	}
	function alertError(text)
	{
		Toast.fire({
			icon: 'error',
			html: text
		})
	}
	function alertWarning(text)
	{
		Toast.fire({
			icon: 'warning',
			html: text
		})
	}
	function CopyContent(input) {
	  var copyText = document.getElementById(input);
	  copyText.select();
	  copyText.setSelectionRange(0, 99999);
	  navigator.clipboard.writeText(copyText.value);
	}
	function ValidatePW() 
	{
		var password = document.getElementById("password").value;
		var confirmPassword = document.getElementById("rpassword").value;
		if (password != confirmPassword) 
		{
			document.getElementById('pass').innerHTML = '<div style="color:red;"> <i class="fa-solid fa-circle-exclamation"></i> <?= l(41); ?></div>';
			document.getElementById('registerbtn').innerHTML = '';
			return false;
		}
		document.getElementById('pass').innerHTML ='';
		return true;
	}
	function ValidateDeleteChar() 
	{
		var delchr = document.getElementById("deletec").value;
		if (isNaN(delchr)) {
			document.getElementById('delc').innerHTML = '<div style="color:red;"> <i class="fa-solid fa-circle-exclamation"></i> <?= l(40); ?></div>';
			document.getElementById('registerbtn').innerHTML = '';
			return false;
		}
		document.getElementById('delc').innerHTML ='';
		return true;
	}
	</script>