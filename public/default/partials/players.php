<tr>
	<th><?php print $number; ?></th>
	<td><?php print $row['name']; ?></td>
	<td><img style="height:15px;" src="<?= Theme::URL().'style/empires/'.PlayerEmpire($row['account_id']).'.jpg'; ?>"></td>
	<td><?php print $row['level']; ?></td>
	<td><?php print $row['exp']; ?></td>
</tr>