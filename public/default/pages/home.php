<div class="content-bg">
		<div class="content flex-sbs">
			<div class="home-description">
					<?=l('home-announce'); ?>
			</div>
			<div class="home-news flex-sbs">
				<article style="height:320px;">
					<div class="img flex-es"><img src="<?=Theme::Path();?>images/logo/bg.png" alt="CROSS-FACTION INSTANCES"></div>
					
					<div class="info">
						<div class="title">
							<a href="<?=Server_Details::GetSettings(15); ?>"><?=l(224)?></a>                        
						</div>
						<div class="text">
							<?=l(225)?>
						</div>                   
					</div>
				</article>
				<div class="forum-msg" style="text-transform:uppercase;">
					<div class="title"><?= l(228);?></div>
					<a class="show-more-btn"><?= l(160);?> &bull; <?= ShowStats(1); ?></a>
					<a class="show-more-btn"><?= l(30);?> &bull; <?= ShowStats(2); ?></a>
					<a class="show-more-btn"><?= l(31);?> &bull; <?= ShowStats(3); ?></a>
					<a class="show-more-btn"><?= l(32);?> &bull; <?= ShowStats(4); ?></a>
					<a class="show-more-btn"><?= l(33);?> &bull; <?= ShowStats(5); ?></a>
				</div>
			</div>
			<aside class="flex-sbs">
				<div class="rankings">
					<div class="switch flex-sbc">
						<div class="button flex-cc rank-switch-btn active" data-view-table="ranking"><span><?=l(226); ?></span></div>
						<div class="button flex-cc rank-switch-btn" data-view-table="voters"><span><?=l(227); ?></span></div>
					</div>
					<div class="tables">
						<div class="table flex-sbs rank-switch-table active" data-id-table="ranking">
							<?php
								$top_players = array();
								$top_players = players10();
								$top_players_count = 0;
								foreach ($top_players as $show)
								{
									$top_players_count ++;
									$player_empire = PlayerEmpire($show['account_id']);
									print '<div class="line flex-sc">';
									print '<div class="num flex-cc">'.$top_players_count.'</div>';
									print '<div class="name">'.$show['name'].'</div>';
									print '<div class="val">Lv. <span>'.$show['level'].'</span></div>';
									print '</div>';
								}
							?>
						</div>
						<div class="table flex-sbs rank-switch-table" data-id-table="voters">
						<?php
								$top_guilds = array();
								$top_guilds = guilds10();
								$top_guilds_count = 0;
								foreach ($top_guilds as $g_show)
								{
									$top_guilds_count ++;
									$guild_empire = PlayerEmpire(AccountID($g_show['master']));
									print '<div class="line flex-sc">';
									print '<div class="num flex-cc">'.$top_guilds_count.'</div>';
									print '<div class="name">'.$g_show['name'].'</div>';
									print '<div class="val"><span>'.$g_show['level'].'</span></div>';
									print '</div>';
								}
							?>
						</div>
					</div>
				</div>
				<div class="forum-msg">
					<div class="title"><?=l(161);?></div>
					<div class="messages flex-sbs">
						
						<?php 
							$selector = "SELECT * FROM articles ORDER BY id DESC";
							$vectoriz = $news_starter->limits($selector, Server_Details::NewsRecords());
							$news_starter->news_show($vectoriz, Theme::URL(), l(99));
						
						?>
					</div>
				</div>
			</aside>
		</div>
		<br />		
	</div>

