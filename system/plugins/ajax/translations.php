<?php 
if(isset($_GET['langcode'],$_GET['search']))
	{
	$language_code_received = $_GET['langcode'];
	$search_value = $_GET['search'];
?>
	<table class="table table-bordered">
		<thead class="thead-dark">
			<tr>
				<th><?=l(236);?></th>
				<th><?=l(237);?></th>
				<th><?=l(238);?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$countdro=0;
				if(isset($_GET['search']))
					$stmtasasas = $database->Sqlite("SELECT * FROM website_languages WHERE $language_code_received LIKE '%$search_value%' OR const LIKE '%$search_value%'");
				else
					$stmtasasas = $database->Sqlite("SELECT * FROM website_languages");
				$stmtasasas->execute();
				$fetch = $stmtasasas->fetchAll();
				foreach ($fetch as $sh)
				{
					$countdro++;
					if($sh[$language_code_received]=='')
						$languagetranslate = $sh['en'];
					else
						$languagetranslate = $sh[$language_code_received];
					
					
					?>
					<tr>
						<td style="width:3%;"><?= $sh['const'];?></td>
						<td style="width:50%;"><?= $languagetranslate;?></td>
						<td style="width:50%;"><textarea id="newv<?=$countdro;?>" class="form-control" onfocusout="UploadLang('newv<?=$countdro;?>','<?=$sh['const'];?>','<?=$language_code_received;?>')" onfocusin="OnFocus('newv<?=$countdro;?>')"  style="width:100%;overflow-y: auto;height: auto;"><?= $sh[$language_code_received];?></textarea></td>
					</tr>
					<?php
				} ?>
		</tbody>
	</table>
	<?php
}
?>