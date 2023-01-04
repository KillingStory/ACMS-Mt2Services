<?php
	if($_GET['password'])
	{
		print $post_data = strtoupper("*".sha1(sha1($_GET['password'], true)));
	}
?>