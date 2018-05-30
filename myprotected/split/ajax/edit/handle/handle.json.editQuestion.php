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
		'question'			=> $_POST['question'],
		'annuity_id'			=> (int)$_POST['annuity_id'],
		'block'			=> $_POST['block'][0],
		'pos'	=> (int)$_POST['pos'],
		'modified'	=> $now
	);

	$question_len = mb_strlen($_POST['question']);
	if ($question_len > 0) {
		$query = "UPDATE `osc_questions` SET ";
			
		$cntUpd = 0;
		foreach($cardUpd as $field => $itemUpd) {
			$cntUpd++;
			$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
		}
		
		$query .= " WHERE `id`=$item_id LIMIT 1";
		$ah->rs($query);
		$data['message'] = "Question was successfully saved.";
	}else{
		$data['message'] = "Failed to save. Question is too short.";	
	}

	
	
	
	
	