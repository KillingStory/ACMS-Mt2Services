<div class="msg flex-cc">
	<div class="avatar flex-cc"><img src="<?=Theme::Path();?>images/default.jpg" alt=""></div>
	<div class="info">
		<div class="title"><a target="_blank" href="<?php print Theme::URL(); ?>read/<?php print $row['id']; ?>"><?php print $row['title']; ?></a></div>
		<div class="desc flex-sc">
			<span class="date flex-cc"><i class="fa fa-calendar" aria-hidden="true"></i><?php if(ACP::VerifyNewsSettings(8)) print $row['time']; ?></span>
			<span class="user"><?=l(229);?> <a href=""><?php if(ACP::VerifyNewsSettings(7)) print $row['owner']; ?></a></span>
		</div>
	</div>
</div>