<div class="products">
	<?php
		$discount_items = array();
		$discount_items = getDiscounts();
		foreach ($discount_items as $dit)
		{
			?>
			<div class="single-product-m">
				<div class="p-inner">
					<div class="promotion"><b>-<?php print $dit['discount']; ?>%</b></div>
					<div class="hotdeal"></div>
					<div class="p-data">
						<div class="p-img">
							<img class="item_icon467" src="<?php print $url.'assets/img/items/'.get_item_image($dit['vnum']).'.png'; ?>" alt="Voucher Costum Valentine's Day">
						</div>
						<div class="data-area">
							<a class="strong item_name"><?= get_item_name($dit['vnum']); ?></a>
							<span>
							<?php
							if($dit['description'])
								print custom_echo($dit['description'], 150); 
							else print custom_echo(GetItemDesc($dit['vnum']), 150); 
							?>
							</span>
						</div>
					</div>
				</div>
				<br>
				<a style="text-decoration: inherit;color: inherit;" href="<?php print $url.'?p=item&id='.$dit['id']; ?>">
					<div class="buttons-section-m">
						<div class="buy-small">
							<div class="ins-bs"><b class="pricetag467"><?php print $dit['coins']-$dit['discount']*$dit['coins']/100; ?></b></div>
						</div>
					</div>
				</a>
			</div>
			<?php 
		}
		?>
</div>