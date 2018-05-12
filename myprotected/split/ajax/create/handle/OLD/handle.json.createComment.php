<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	$now = date("Y-m-d H:i:s", time());
	
	$cardUpd = array(
				'user_id'			=> $_POST['user_id'],
				'stage_id'			=> $_POST['stage_id'],
				'content'	=> $_POST['content'],
				'author_name'			=> $_POST['author_name'],
				'block'			=> $_POST['block'][0],
				'is_fake'			=> $_POST['is_fake'][0],
				'modified'	=> $now,
				'created'		=> $now
	);

	$file_path = "../../../../split/files/projects/";
	$im_1_filename = "author_avatar";
	$im_1 		= false;
	$im_1_name 	= 5;
	$im_1_pre 	= "fkc_ava_";
	
	if(isset($_FILES[$im_1_filename]) && $_FILES[$im_1_filename]['size'] > 0){
		$im_1 		= true;
	}
	if($im_1){
		$file_update = false;
		$file_update = $ah->mtvc_add_files_file(array(
				'path'			=>$file_path,
				'name'			=>$im_1_name,
				'pre'			=>$im_1_pre,
				'size'			=>10,
				'rule'			=>0,
				'max_w'			=>2500,
				'max_h'			=>2500,
				'files'			=>$im_1_filename
			  ));
		
		if($file_update){
			$cardUpd[$im_1_filename] = $file_update;
		}
	}

	$query = "INSERT INTO `osc_comments` ";
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
		$data['message'] = "Комментарий успешно создан. ID: ".$item_id;
		$data['item_id'] = $item_id;
		$data['status'] = "success";
	}