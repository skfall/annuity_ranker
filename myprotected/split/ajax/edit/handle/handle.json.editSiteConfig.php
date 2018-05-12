<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];

	$lpx = $_POST['lpx'];

	$lang_prefix = ($lpx ? $lpx."_" : ""); // empty = en

	$query = "SELECT `filename` FROM [pre]settings WHERE `id`='$item_id' LIMIT 1";
	$alias = $ah->rs($query);

	$old_filename = $alias[0]['filename'];
	
	$cardUpd = array(
					'sitename'		=> $_POST['sitename'],
					'site_index'	=> $_POST['site_index'][0],
					'email'		=> $_POST['email'],
					'phone'		=> $_POST['phone'],
					'address'		=> $_POST['address'],
					'lat'		=> (float)str_replace(',', '.', $_POST['lat']),
					'lng'		=> (float)str_replace(',', '.', $_POST['lng']),
					
					'copyright'		=> $_POST['copyright'],
					

					'top_script'		=> $_POST['top_script'],
					'bot_script'		=> $_POST['bot_script'],
					
					'modified'	=> date("Y-m-d H:i:s", time())
					);
					

	


	// Update main table
	
	$query = "UPDATE [pre]$appTable SET ";
	
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd)
	{
		$cntUpd++;
		$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
	}
	
	$query .= " WHERE `id`=$item_id LIMIT 1";
		
	$data['query'] = $query;
		
	$ah->rs($query);
	
	
	
	$data['message'] = "Настройки успешно вступили в силу";
	