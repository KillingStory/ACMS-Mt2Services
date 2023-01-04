<?php if(Permission::Verify('genset')) { ?>
<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-6 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title"><i class="fa fa-gear"></i> <?= l(187); ?></h3>
					<div class="card-tools">
						<span class="badge badge-warning"><?= l(188); ?></span>
					</div>
				</div>
				<div class="card-body">
					<label><?= l(189); ?>:</label>
					<input type="text" class="form-control" onfocusout="UploadSettings('site_title')" onfocusin="OnFocus('site_title')" id="site_title" value="<?= Server_Details::GetSettings(1); ?>" required>
					<br>
					<label><?= l(190); ?>:</label>
					<input type="text" class="form-control" onfocusout="UploadSettings('description')" onfocusin="OnFocus('description')" id="description" value="<?= Server_Details::GetSettings(2); ?>" required>
					<br>
					<label>ItemShop Link:</label>
					<input type="text" class="form-control" onfocusout="UploadSettings('itemshop')" onfocusin="OnFocus('itemshop')" id="itemshop" value="<?= Server_Details::GetSettings(15); ?>" required>
					<br>
					<label>Forum Link:</label>
					<input type="text" class="form-control" onfocusout="UploadSettings('forum')" onfocusin="OnFocus('forum')" id="forum" value="<?= Server_Details::GetSettings(14); ?>" required>
					<br>
					<label><?= l(223)?>:</label>
					<input type="color" class="form-control" onfocusout="ColorPicker()" onfocusin="OnFocus('colorcode')" id="colorcode" value="#<?= Server_Details::GetSettings(13); ?>" required>
					<div style="display:none;" id="result_hash"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-6 mb-md-0 mb-4">
					<div class="card card-secondary" style="height:auto;">
						<div class="card-header">
							<h3 class="card-title"><i class="fa-solid fa-image"></i> <?=l(217);?></h3>
							<div class="card-tools">
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<div class="card card-secondary" style="height:400px;">
										<div class="card-header">
											<h3 class="card-title"><i class="fa fa-eye"></i> <?=l(216);?></h3>
											<div class="card-tools">
											</div>
										</div>
										<div class="card-body">
											<center><div class="logoshow" id="logoshow"><img style="max-height:250px;max-width:270px;" src="<?= Theme::Logo(); ?>"></div></center>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="card card-secondary" style="height:400px;">
										<div class="card-header">
											<h3 class="card-title"><i class="fa fa-upload"></i> <?=l(215);?></h3>
											<div class="card-tools">
												<span class="badge badge-warning">PNG & GIF</span>
											</div>
										</div>
										<div class="card-body">
											<form class="uploadfile" action="#">
												<input class="file-input" type="file" name="file" hidden/>
												<i class="fa fa-upload" aria-hidden="false"></i>
												<p><?=l(214);?></p>
											</form>
											<section class="progress-area"></section>
											<section class="uploaded-area"></section>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title"><i class="fa fa-gear"></i> SEO</h3>
					<div class="card-tools">
						<span class="badge badge-warning"><?= l(188); ?></span>
					</div>
				</div>
				<div class="card-body">
					<label><?= l(191); ?>:</label>
					<textarea type="text" class="form-control" onfocusout="UploadSettings('sdesc')" onfocusin="OnFocus('sdesc')" id="sdesc" required><?= Server_Details::GetSEO(1); ?></textarea>
					<br>
					<label><?= l(192); ?>:</label>
					<input type="text" class="form-control" id="tags" value="<?= Server_Details::GetSEO(2); ?>" data-role="tagsinput" required>
				</div>
			</div>
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title"><i class="fa fa-gear"></i> <?= l(193); ?></h3>
					<div class="card-tools">
						<span class="badge badge-warning"><?= l(188); ?></span>
					</div>
				</div>
				<div class="card-body">
					<label><i class="fa-brands fa-facebook"></i> Facebook:</label>
					<input type="text" class="form-control" onfocusout="UploadSettings('facebook')" onfocusin="OnFocus('facebook')" id="facebook" value="<?= Server_Details::GetSEO(3); ?>" required>
					<br>
					<label><i class="fa-brands fa-youtube"></i> Youtube:</label>
					<input type="text" class="form-control" onfocusout="UploadSettings('youtube')" onfocusin="OnFocus('youtube')" id="youtube" value="<?= Server_Details::GetSEO(4); ?>" required>
					<br>
					<label><i class="fa-brands fa-discord"></i> Discord:</label>
					<input type="text" class="form-control" onfocusout="UploadSettings('discord')" onfocusin="OnFocus('discord')" id="discord" value="<?= Server_Details::GetSEO(5); ?>" required>
					<br>
					<label><i class="fa-brands fa-twitch"></i> Twitch:</label>
					<input type="text" class="form-control" onfocusout="UploadSettings('twitch')" onfocusin="OnFocus('twitch')" id="twitch" value="<?= Server_Details::GetSEO(6); ?>" required>
					<br>
					<label><i class="fa-brands fa-instagram"></i> Instagram:</label>
					<input type="text" class="form-control" onfocusout="UploadSettings('instagram')" onfocusin="OnFocus('instagram')" id="instagram" value="<?= Server_Details::GetSEO(7); ?>" required>
					
				</div>
			</div>
		</div>
	</div>
</div>
<script language="javascript" type="text/javascript">
function refresh(){$("#logoshow").load(location.href+" #logoshow"),$("#favshow").load(location.href+" #favshow")}function OnFocus(e){document.getElementById(e).classList.remove("is-valid")}function UploadSettings(e){document.getElementById(e).classList.add("is-valid");var s="0";if(""==s||null==s)var s=document.getElementById("sdesc");else var s=document.getElementById(e).value;$("#result_hash").load("<?= Theme::URL(); ?>?v=general&"+e+"="+encodeURI(s)),alertSuccess(s)}function ColorPicker(){document.getElementById("colorcode").classList.add("is-valid");var e=document.getElementById("colorcode").value.replace("#","");$("#result_hash").load("<?= Theme::URL(); ?>?v=general&colorcode="+e),alertSuccess(e)}$(document).ready(function(){setInterval(function(){refresh()},1e3)}),$("input").on("itemAdded",function(e){var s=document.getElementById("tags").value;$("#result_hash").load("<?= Theme::URL(); ?>?v=general&tags="+encodeURI(s)),alertSuccess(s)}),$("input").on("itemRemoved",function(e){var s=document.getElementById("tags").value;$("#result_hash").load("<?= Theme::URL(); ?>?v=general&tags="+encodeURI(s)),alertSuccess(s)});const form=document.querySelector("form"),fileInput=document.querySelector(".file-input"),progressArea=document.querySelector(".progress-area"),uploadedArea=document.querySelector(".uploaded-area");function uploadFile(e){let s=new XMLHttpRequest;s.open("POST","<?= Theme::URL(); ?>?v=general&logo=da"),s.upload.addEventListener("progress",({loaded:s,total:l})=>{let a=Math.floor(s/l*100),r=Math.floor(l/1e3),o;o=r<1024?r+" KB":(s/1048576).toFixed(2)+" MB";let n=`<center><li class="row">
                          <i class="fa fa-file"></i>
                          <div class="content">
                            <div class="details">
                              <span class="name">${e} • Uploading</span>
                              <span class="percent">${a}%</span>
                            </div>
                            <div class="progress-bar">
                              <div class="progress" style="width: ${a}%"></div>
                            </div>
                          </div>
                        </li><br></center>`;if(uploadedArea.classList.add("onprogress"),progressArea.innerHTML=n,s==l){progressArea.innerHTML="";let t=`<center><li class="row">
                            <div class="content upload">
                              <i class="fa fa-file"></i>
                              <div class="details">
                                <span class="name">${e} • <a style="color:green;">Uploaded</a> <i style="color:green;" class="fas fa-check"></i></span>
                                <span class="size">${o}</span>
                              </div>
                            </div>
                          </li><br></center>`;uploadedArea.classList.remove("onprogress"),uploadedArea.insertAdjacentHTML("afterbegin",t),GeneralSuccess("<?=l(218);?>")}});let l=new FormData(form);s.send(l)}form.addEventListener("click",()=>{fileInput.click()}),fileInput.onchange=({target:e})=>{let s=e.files[0];if(s){let l=s.name;if(l.length>=12){let a=l.split(".");l=a[0].substring(0,13)+"... ."+a[1]}uploadFile(l)}};
</script>
<?php } else print '<div class="alert alert-danger">You dont have access!</div>';?>