<?php 
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);
	
	$lpx = $_POST['lpx'];
	$lang_prefix = ($lpx ? $lpx."_" : ""); // empty = iw
	$now = date("Y-m-d H:i:s", time());
	$caption = $_POST['section_caption'];
	
	$cardUpd = array(
						'section_caption'			=> $caption,
						'section_sub_caption'		=> $_POST['section_sub_caption'],
						//'section_content'			=> $_POST['section_content'],
						'created'					=> $now,
						'modified'					=> $now
					);
					

	// File upload filename
	
	$file_path = "../../../../split/files/home_slides/";
	$im_1_filename = "filename";
	$im_1 		= false;
	$im_1_name 	= 5;
	$im_1_pre 	= "si_";
	
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

	$query = "INSERT INTO `osc_page_home_1` ";
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
		$data['message'] = "Слайд успешно создан. ID: ".$item_id;
		$data['item_id'] = $item_id;
		$data['status'] = "success";
	}
	