<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	$now = date("Y-m-d H:i:s", time());

	$cardUpd = array(
		'answer'			=> $_POST['answer'],
		'question_id'			=> (int)$_POST['question_id'],
		'block'			=> $_POST['block'][0],
		'pos'	=> (int)$_POST['pos'],
		'modified'	=> $now,
		'created' 	=> $now
	);


	$answer_len = mb_strlen($_POST['answer']);
	if ($answer_len > 1) {
		$query = "INSERT INTO `osc_answers` ";
		$fieldsStr = " ( ";
		$valuesStr = " ( ";
		$cntUpd = 0;
		foreach($cardUpd as $field => $itemUpd) {
			$cntUpd++;
			$fieldsStr .= ($cntUpd==1 ? "`$field`" : ", `$field`");
			$valuesStr .= ($cntUpd==1 ? "'$itemUpd'" : ", '$itemUpd'");
		}
		$fieldsStr .= " ) ";
		$valuesStr .= " ) ";
		$query .= $fieldsStr." VALUES ".$valuesStr;
		$item_id = $ah->rs($query, 0, 1, 1);
		
		if($item_id){
			$data['message'] = "Answer was successfully saved. ID: ".$item_id;
			$data['item_id'] = $item_id;
			$data['status'] = "success";
		}
	}else{
		$data['message'] = "Failed to save. Answer is too short.";	
	}

	