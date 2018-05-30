<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post

	require_once "../../../../require.base.php";
	
	require_once "../../../library/AjaxHelp.php";
	
	$ah = new ajaxHelp($dbh);
	
	$id	= (isset($_POST['id']) ? (int)$_POST['id'] : 0);
	
	

	
	$query = "SELECT M.ct_desc FROM `osc_ct_genplan` AS M WHERE M.id = $id LIMIT 1";
	
	$result = $ah->rs($query);
	
	$data['status'] = "success";
	
	$data['text'] = $result[0]['ct_desc'];


	echo json_encode($data);