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
		'name'			=> $_POST['name'],
		'company_id'			=> (int)$_POST['company_id'],
		'content'			=> $_POST['content'],
		'block'			=> $_POST['block'][0],
		'pos'	=> (int)$_POST['pos'],
		'modified'	=> $now
	);

	$company_id = (int)$_POST['company_id'];

	if($company_id > 0){
		$name_len = mb_strlen($_POST['name']);
		if ($name_len > 0) {
			$query = "UPDATE `osc_tabs` SET ";
				
			$cntUpd = 0;
			foreach($cardUpd as $field => $itemUpd) {
				$cntUpd++;
				$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
			}
			
			$query .= " WHERE `id`=$item_id LIMIT 1";
			$ah->rs($query);
			$data['message'] = "Tab was successfully saved.";
		}else{
			$data['message'] = "Failed to save. Name is too short.";	
		}
	}else{
		$data['message'] = "Failed to save. Select company from list.";
	}

	
	
	
	
	