<?php
$post_id = isset($_GET['id']) ? $_GET['id'] : null;
if($post_id!=null || $post_id!='')
	$post_edit = true;
else
	$post_edit = false;
if(isset($_POST['updatenewsbtn'])) News::Update($_POST['title'],$_POST['content'], $_POST['idpost']);
if(isset($_POST['addnewsbtn'])) News::Add($_POST['title'],$_POST['content']);
if(isset($_POST['delete'])) News::NDelete($_POST['deleteid']);
?>