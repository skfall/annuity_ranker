<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post

	require_once "../../../../require.base.php";
	
	require_once "../../../library/AjaxHelp.php";
	
	$ah = new ajaxHelp($dbh);
	
	$id	= (isset($_POST['ct_id']) ? (int)$_POST['ct_id'] : 0);
	$status	= (isset($_POST['ct_status']) ? $_POST['ct_status'] : 0);
	$text	= (isset($_POST['ct_text']) ? $_POST['ct_text'] : '');
	
	

	
	$query = "UPDATE `osc_ct_genplan` SET `status` = '$status', `ct_desc` = '$text' WHERE `id` = '$id'";
	
	$ah->rs($query);
	
	$data['status'] = "success";
	$data['sel_ct_status'] = $status;
	$data['sel_ct_id'] = $id;

	echo json_encode($data);