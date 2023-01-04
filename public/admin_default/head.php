<!DOCTYPE html>
		<html>
			<head>
				<meta charset="UTF-8">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<title><?= Server_Details::GetSettings(1).' &bull; '.$atitle; ?></title>
				<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
				<!-- Ionicons -->
				<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
				<!-- Tempusdominus Bootstrap 4 -->
				<link rel="stylesheet" href="<?php print Theme::Admin_PathStyle(); ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
				<!-- iCheck -->
				<link rel="stylesheet" href="<?php print Theme::Admin_PathStyle(); ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
				<!-- Theme style -->
				<link rel="stylesheet" href="<?php print Theme::Admin_PathStyle(); ?>dist/css/adminlte.min.css">
				<!-- overlayScrollbars -->
				<link rel="stylesheet" href="<?php print Theme::Admin_PathStyle(); ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
				<!-- Daterange picker -->
				<link rel="stylesheet" href="<?php print Theme::Admin_PathStyle(); ?>plugins/daterangepicker/daterangepicker.css">
				<!-- summernote -->
				<link rel="stylesheet" href="<?php print Theme::Admin_PathStyle(); ?>plugins/summernote/summernote-bs4.min.css">
				
				<?php include 'system/general_header.php'; ?>
			</head>