<tr>
	<th><?php print $number; ?></th>
	<td><?php print $row['name']; ?></td>
	<td><?php print GuildOwner($row['master']); ?></td>
	<td><img src="<?= Theme::URL().'style/empires/'.PlayerEmpire(AccountID($row['master'])).'.jpg'; ?>"></td>
	<td><?php print $row['level']; ?></td>
	<td><?php print $row['ladder_point']; ?></td>
</tr>