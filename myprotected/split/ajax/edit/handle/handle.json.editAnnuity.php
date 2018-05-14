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
		'alias'			=> $_POST['alias'],
		'block'			=> $_POST['block'][0],
		'is_video_bg'	=> $_POST['is_video_bg'][0],
		'pos'	=> (int)$_POST['pos'],
		'min_amount'	=> (int)$_POST['min_amount'],
		'max_amount'	=> (int)$_POST['max_amount'],
		'col_1'			=> $_POST['col_1'],
		'col_2'			=> $_POST['col_2'],
		'col_3'			=> $_POST['col_3'],
		'col_4'			=> $_POST['col_4'],
		'col_5'			=> $_POST['col_5'],
		'col_6'			=> $_POST['col_6'],
		'col_6'			=> $_POST['col_7'],
		'modified'	=> $now
	);

	
					

	$file_path = "../../../../split/files/annuities/";
	$im_1_filename = "preview";
	$im_1 		= false;
	$im_1_name 	= 5;
	$im_1_pre 	= "an_prev";
	
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
				'files'			=>$im_1_filename,
				'resize_path'	=>$file_path."crop/",
				'resize_w'		=>500,
				'resize_h'		=>400,
				'resize_path_2'	=>"0",
				'resize_w_2'	=>0,
				'resize_h_2'	=>0
			  ));
		
		if($file_update){
			$cardUpd[$im_1_filename] = $file_update;
		}
	}

	$im_1_filename = "background";
	$im_1 		= false;
	$im_1_name 	= 5;
	$im_1_pre 	= "an_bg";
	
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

	$alias = $_POST['alias'];

	$q = "SELECT M.id FROM `osc_annuities` AS M WHERE M.alias = '$alias' AND M.id != $item_id LIMIT 1";
	$check_alias = $ah->rs($q);
	if(!$check_alias){
		$name_len = mb_strlen($_POST['name']);

		if ($name_len > 0) {
			$query = "UPDATE `osc_annuities` SET ";
				
			$cntUpd = 0;
			foreach($cardUpd as $field => $itemUpd) {
				$cntUpd++;
				$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
			}
			
			$query .= " WHERE `id`=$item_id LIMIT 1";
			$ah->rs($query);
			$data['message'] = "Annuity was successfully saved.";
		}else{
			$data['message'] = "Failed to save. Name is too short.";	
		}
		
		
	}else{
		$data['message'] = "Failed to save. Annuity with this alias is already exists.";		
	}
	
	
	
	
	