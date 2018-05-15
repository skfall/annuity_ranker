<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	$now = date("Y-m-d H:i:s", time());

	
	$cardUpd = array(
		'name'			=> $_POST['name'],
		'alias'			=> $_POST['alias'],
		'parent'			=> $_POST['parent'],
		'pos'		=> (int)$_POST['pos'],
		'block'			=> $_POST['block'][0],
		'created'	=> $now,
		'modified'	=> $now
	);

	$meta_title = $_POST['meta_title'];		
	$meta_keys = $_POST['meta_keys'];		
	$meta_desc = $_POST['meta_desc'];

	
	$query = "SELECT id FROM `osc_nav` WHERE `alias`='".$cardUpd['alias']."' LIMIT 1";
	$test_alias = $ah->rs($query);
				
	if(strlen($cardUpd['name'])>1){
		if(!$test_alias){
	
				
				$query = "INSERT INTO `osc_nav` ";
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
				
				if($item_id) {
					$data['item_id'] = $item_id;
					$data['message'] = "New nav item was successfully created. ID: ". $item_id;

					$alias = $cardUpd['alias'];
					$q = "INSERT INTO `osc_meta` (`alias`, `meta_title`, `meta_keys`, `meta_desc`) VALUES ('$alias', '$meta_title', '$meta_keys', '$meta_desc')";
					$meta_res = $ah->rs($q, 0, 1, 1);
				}else
				{
					$data['item_id'] = 0;
				}
			
			}else{
				$data['status'] = "failed";
				$data['message'] = "Failed to save. Nav item with this alias is already exists.";
			}
	}else{
		$data['status'] = "failed";
		$data['message'] = "Failed to save. Name is too short.";
	}
	
	