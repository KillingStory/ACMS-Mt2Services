<div class="container-fluid py-4">
	<div class="row mb-4">
		<div class="col-lg-12 col-md-6 mb-md-0 mb-4">
			<div class="card card-secondary">
				<div class="card-header pb-0">
					<h4 class="card-title"><?= l(115); ?></h4><br>
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
					<input type="text" class="form-control" name="hashing" id="hashing" onkeyup="PassEncrypt()" placeholder="<?= l(114); ?>">
				</div>
			</div>
			<div class="card card-secondary" id="disp" style="display:none;">
				<div class="card-header pb-0">
					<h4 class="card-title"><?= l(116); ?></h4><br>
					
					<h6 style="float:right;"></h6>
				</div>
				<div class="card-body">
				<center>
<pre class="wp-block-code language-php" style="width:50%;">
<code id="result_hash"></code>
</pre>
				</center>
				</div>
			</div>
		</div>
	</div>
</div>