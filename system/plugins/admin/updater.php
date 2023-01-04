<?php
	if(isset($_POST['update_now']))
	{
		$download_url = "https://cms.mt2-services.eu/updater-acms/?sitekey=".$siteownkey."&site=".Theme::URL().'&actualv='.$_version;
		$file = "update.zip";
		$script = basename($_SERVER['PHP_SELF']);
		file_put_contents($file, fopen($download_url, 'r'));
		$path = pathinfo(realpath($file), PATHINFO_DIRNAME);
		$zip = new ZipArchive;
		$res = $zip->open($file);

		if ($res === TRUE) {
			$zip->extractTo($path);
			$zip->close();
			unlink($file);
		} else {
		  echo "Couldn't open $file";
		}
	}
	$update_version = file_get_contents('https://cms.mt2-services.eu/updater-acms/');
?>