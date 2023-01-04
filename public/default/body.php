<div class="wrapper">
	<div class="navigation-bg">
		<nav class="flex-sbc">
			<div class="links flex-sc" style="text-transform:uppercase;">
				<a href="<?= Theme::URL(); ?>" class="link <?=Theme::MenuActive2('home'); ?>"><?= l(2); ?></a>
				<?php if(!signed()) { ?>
				<a href="<?= Theme::URL(); ?>register" class="link <?=Theme::MenuActive2('register'); ?>"><?= l(3); ?></a>
				<?php } else { ?>
				<div class="link">
					<div class="open-drop-box flex-cc" onclick="openuserpanel()">
						<?=l(10);?> <i class="fa fa-caret-down" aria-hidden="true"></i>
					</div>
					<div id="openuserpanel" class="drop-box active" style="display:none;">
						<?php if(areadmin()) { ?>
						<a href="<?= Theme::URL(); ?>admin_panel"><i class="fa fa-user"></i> <?php print l(201); ?></a>
						<?php } ?>
						<a href="<?= Theme::URL(); ?>myaccount"><i class="fa fa-user"></i> <?php print l(65); ?></a>
						<a href="<?= Theme::URL(); ?>coupon"><i class="fa-solid fa-gift"></i> <?php print l(66); ?></a>
						<a href="<?= Theme::URL(); ?>refferal"><i class="fa-solid fa-users"></i> <?php print l(68); ?></a>
						<a href="<?= Theme::URL(); ?>vote"><i class="fa-solid fa-check-to-slot"></i> <?php print l(67); ?></a>
						<?php if(Theme::URLVerificator(15)) { ?>
						<a target="_blank" href="<?= Server_Details::GetSettings(15); ?>"><i class="fa-solid fa-shop"></i> ItemShop</a>
						<?php } ?>
						<a style="color:red;" href="<?= Theme::URL(); ?>logout"><i class="fa-solid fa-right-from-bracket"></i> <?php print l(69); ?></a>
					</div>
				</div>
				<?php } ?>
				<a href="<?= Theme::URL(); ?>download" class="link <?=Theme::MenuActive2('download'); ?>"><?= l(4); ?></a>
				<div class="link">
					<div class="open-drop-box flex-cc" onclick="rankingpanel()">
						<?= l(5); ?> <i class="fa fa-caret-down" aria-hidden="true"></i>
					</div>
						<div id="showmenurnk" class="drop-box active" style="display:none;">
							<a href="<?= Theme::URL(); ?>class/players/"><i class="fa-solid fa-users"></i> <?= l(21);?></a>
							<a href="<?= Theme::URL(); ?>class/guilds/"><i class="fa-solid fa-users"></i> <?= l(26);?></a>
						</div>
				</div>
				<?php if(Theme::URLVerificator(14)) { ?>
				<a target="_blank" href="<?= Server_Details::GetSettings(14); ?>" class="link">FORUM</a>
				<?php } ?>
				<a href="<?php if(!signed()) print Theme::URL().'login'; else print Theme::URL().'logout'; ?>" class="cp-btn flex-cc">
					<img src="<?=Theme::Path();?>images/icon/login_icon.png" class="icon">
					<div class="info">
						<div class="name"><?php if(!signed()) print l(9); else print l(69); ?></div>
					</div>
				</a>
			</div>
			<a class="logo flex-cc"></a>
			<div class="open-navigation"><i></i></div>
		</nav>
	</div>
	<div class="header-bg">
		<header>
			<div class="header-content">
				<a href="<?= Theme::URL(); ?>" class="logo"><img src="<?=Theme::Logo();?>" alt=""></a>
				<div class="status-server flex-cc">
					<div class="server flex-cc">
						<div class="name"><b>ONLINE</b></div>
						<div class="icon flex-cc" style="font-size: 20px;"><?= ShowStats(1); ?></div>
						<div class="online"><b>PLAYERS</b></div>
					</div>
					<a href="<?= Theme::URL(); ?>download" class="realmist flex-cc"><?= l(4); ?></a>
				</div>
			</div>
		</header>
	</div>
	<?php
		include Theme::Page_Path($page);
	?>
	<div class="footer-bg">
		<footer class="flex-sbs">
			<div class="f_cpr flex-ss">
				<img src="https://web-license.mt2-services.eu/itemshop/dist/img/AdminLTELogo.png"class="logo">
				<div class="info">
					<div class="title">© <?=date('Y').' - '.Server_Details::GetSettings(1);?> </div>
					<div class="text">
						CREATED BY <a href="https://mt2-services.eu">MT2SERVICES</a><br> FOR
						<?=Server_Details::GetSettings(1);?>.<br> All rights are reserved!
					</div>
					<div class="links flex-ss">
						<a href="<?= Theme::URL(); ?>privacy">PRIVACY POLICY</a>
						<a href="<?= Theme::URL(); ?>terms">TERMS OF SERVICE</a>
					</div>
				</div>
			</div>
			<div class="f_links">
				<a href="<?= Theme::URL(); ?>"><?= l(2); ?></a><br>
				<a href="<?= Theme::URL(); ?>register"><?php print l(3); ?></a><br>
				<a href="<?= Theme::URL(); ?>download"><?php print l(4); ?></a>
			</div>
			<div class="f_links">
				<a href="<?= Theme::URL(); ?>class/players/"><?php print l(5); ?></a><br>
				<a href="<?= Theme::URL(); ?>guide"><?php print l(6); ?></a><br>
				<a href="<?= Theme::URL(); ?>about_us"><?php print l(8); ?></a>
			</div>
			<div class="f_links">
				<?php if(Social::Verify(3)) { ?>
					<a href="<?php print Social::Show(3); ?>">FACEBOOK</a><br>
				<?php } if(Social::Verify(4)) { ?>
					<a href="<?php print Social::Show(4); ?>">YOUTUBE</a><br>
				<?php } if(Social::Verify(5)) { ?>
					<a href="<?php print Social::Show(5); ?>">DISCORD</a><br>
				<?php } ?>
			</div>
			<div class="f_links">
				<?php
					if(Social::Verify(6)) { ?>
					<a href="<?php print Social::Show(6); ?>">TWITCH</a><br>
				<?php } if(Social::Verify(7)) { ?>
					<a href="<?php print Social::Show(7); ?>">INSTAGRAM</a>
				<?php } ?>
			</div>
		</footer>
	</div>
</div>
<script>
let countpress = 1;
let rann=1;
function openuserpanel()
{
	countpress++;
	if(countpress%2==0)
		document.getElementById('openuserpanel').style.cssText = 'display:relative;';
	else
		document.getElementById('openuserpanel').style.cssText = 'display:none;';
}
function rankingpanel()
{
	rann++;
	if(rann%2==0)
		document.getElementById('showmenurnk').style.cssText = 'display:relative;';
	else
		document.getElementById('showmenurnk').style.cssText = 'display:none;';
}
</script>
<script src="<?=Theme::Path();?>js/navigation.js"></script>
<script src="<?=Theme::Path();?>js/toggle.js"></script>