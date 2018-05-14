<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];

	$lpx = $_POST['lpx'];
	$lang_prefix = ($lpx ? $lpx."_" : ""); // empty = iw
	$now = date("Y-m-d H:i:s", time());

	
	$cardUpd = array(
		'value'			=> $_POST['value'],
		'link'			=> $_POST['link'],
		'modified'	=> $now
	);

	$query = "UPDATE `osc_static_texts` SET ";
			
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd) {
		$cntUpd++;
		$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
	}
	
	$query .= " WHERE `id`=$item_id LIMIT 1";
	$ah->rs($query);
	$data['message'] = "Text was successfully saved.";

	
	
	
	
	