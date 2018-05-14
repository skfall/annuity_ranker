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
		'answer'			=> $_POST['answer'],
		'question_id'			=> (int)$_POST['question_id'],
		'block'			=> $_POST['block'][0],
		'pos'	=> (int)$_POST['pos'],
		'modified'	=> $now,
	);

	$answer_len = mb_strlen($_POST['answer']);
	if ($answer_len > 1) {
		$query = "UPDATE `osc_answers` SET ";
			
		$cntUpd = 0;
		foreach($cardUpd as $field => $itemUpd) {
			$cntUpd++;
			$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
		}
		
		$query .= " WHERE `id`=$item_id LIMIT 1";
		$ah->rs($query);
		$data['message'] = "Answer was successfully saved.";
	}else{
		$data['message'] = "Failed to save. Answer is too short.";	
	}

	
	
	
	
	