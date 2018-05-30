<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************

	require_once "../../../require.base.php";
	require_once "../../library/AjaxHelp.php";

	$ah = new ajaxHelp($dbh);
	
	$id	= (isset($_POST['id']) ? (int)$_POST['id'] : 0);
	$val	= (isset($_POST['val']) ? (int)$_POST['val'] : 0);


	$query = "UPDATE `osc_sys_event_items` SET `order_id` = '$val' WHERE `id` = '$id'";
	$ah->rs($query);
	
	$data['status'] = "success";
	$data['message'] = "Элемент отредактирован";
