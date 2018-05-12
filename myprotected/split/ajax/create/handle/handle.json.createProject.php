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
		'details'			=> $_POST['details'],
		'content'			=> $_POST['content'],
		'pos'			=> (int)$_POST['pos'],
		'block'			=> $_POST['block'][0],
		'meta_title'			=> $_POST['meta_title'],
		'meta_keys'			=> $_POST['meta_keys'],
		'meta_desc'			=> $_POST['meta_desc'],
		'capacity'			=> $_POST['capacity'],
		'location'			=> $_POST['location'],
		'area'			=> $_POST['area'],
		'type'			=> $_POST['type'],		
		'created'	=> $now,
		'modified'	=> $now
	);


	$docs_path = "../../../../split/files/documents/";
	$file_path = "../../../../split/files/projects/";
	$im_1_filename = "preview";
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
				'files'			=>$im_1_filename,
				'resize_path'	=>$file_path."crop/",
				'resize_w'		=>600,
				'resize_h'		=>308,
				'resize_path_2'	=>"0",
				'resize_w_2'	=>0,
				'resize_h_2'	=>0
			  ));
		
		if($file_update){
			$cardUpd[$im_1_filename] = $file_update;
		}
	}

	$im_1_filename = "card_image";
	$im_1 		= false;
	$im_1_name 	= 5;
	$im_1_pre 	= "pci_";
	
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
				'resize_w'		=>600,
				'resize_h'		=>308,
				'resize_path_2'	=>"0",
				'resize_w_2'	=>0,
				'resize_h_2'	=>0
			  ));
		
		if($file_update){
			$cardUpd[$im_1_filename] = $file_update;
		}
	}

	$alias = $_POST['alias'];
	$q = "SELECT id FROM osc_projects WHERE alias = '$alias' LIMIT 1";

	$check_alias = $ah->rs($q);
				
	if(!$check_alias) {
			$query = "INSERT INTO `osc_projects` ";
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
				// STAGE 1
				$stage_1 = [
					'caption' => $_POST['s1_caption'],
					'details' => $_POST['s1_details'],
					'pos' 	=> (int)$_POST['s1_pos'],
					'block'	=> $_POST['s1_block'][0],
					'lat'	=> (float)str_replace(',', '.', $_POST['s1_lat']),
					'lng'	=> (float)str_replace(',', '.', $_POST['s1_lng']),
					'video' 	=> $_POST['s1_video'],
					'panorama' => $_POST['s1_panorama'],
					'docs_caption' => $_POST['s1_docs_caption'],
					'docs_details' => $_POST['s1_docs_details'],
					'project_id' => $item_id,
					'created' => $now,
					'modified' => $now					
				];
				$im_1_filename = "s1_protocol"; $im_1 = false; $im_1_name = 5; 
				$im_1_pre = "s1_proto";
				if(isset($_FILES[$im_1_filename]) && $_FILES[$im_1_filename]['size'] > 0) $im_1 = true;
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
						));
					
					if($file_update){
						$stage_1['protocol_link'] = $file_update;
					}
				}
				$query = "INSERT INTO `osc_stages` ";
				$fieldsStr = " ( ";
				$valuesStr = " ( ";
				$s1Upd = 0;
				foreach($stage_1 as $field => $itemUpd) {
					$s1Upd++;
					$fieldsStr .= ($s1Upd==1 ? "`$field`" : ", `$field`");
					$valuesStr .= ($s1Upd==1 ? "'$itemUpd'" : ", '$itemUpd'");
				}
				$fieldsStr .= " ) ";
				$valuesStr .= " ) ";
				$query .= $fieldsStr." VALUES ".$valuesStr;
				$stage_1_id = $ah->rs($query, 0, 1, 1);
				if($stage_1_id){
					/*IMG GALLERY SET*/
					$filename = "s1_photos";
					if(isset($_FILES[$filename]) && count($_FILES[$filename]) > 0 && $item_id) {		
						$files_upload = $ah->mtvc_add_files_file_miltiple(array(
								'path'			=>$file_path,
								'name'			=>5,
								'pre'			=>"s1_photo",
								'size'			=>10,
								'rule'			=>0,
								'max_w'			=>2500,
								'max_h'			=>2500,
								'files'			=>$filename,
							));
						if($files_upload) {
							foreach($files_upload as $file_upload){
								$now = date("Y-m-d H:i:s", time());
								$query = "INSERT INTO osc_stage_photos (`stage_id`, `filename`, `created`, `modified`) VALUES ('$stage_1_id', '$file_upload', '$now', '$now')";
								$ah->rs($query,0,1);
								chmod($file_path.$file_upload,0777);
							}
						}
					}

					/*DOCS*/
					$filename = "s1_docs";
					if(isset($_FILES[$filename]) && count($_FILES[$filename]) > 0 && $item_id) {		
						$files_upload = $ah->mtvc_add_files_file_miltiple(array(
								'path'			=>$docs_path,
								'name'			=>5,
								'pre'			=>"s1_doc",
								'size'			=>10,
								'rule'			=>0,
								'max_w'			=>2500,
								'max_h'			=>2500,
								'files'			=>$filename,
								'resize_path'	=>$docs_path."crop/",
								'resize_w'		=>170,
								'resize_h'		=>240,
								'resize_path_2'	=>"0",
								'resize_w_2'	=>0,
								'resize_h_2'	=>0
							));
						if($files_upload) {
							foreach($files_upload as $file_upload){
								$now = date("Y-m-d H:i:s", time());
								$query = "INSERT INTO osc_stage_docs (`stage_id`, `filename`, `created`, `modified`) VALUES ('$stage_1_id', '$file_upload', '$now', '$now')";
								$ah->rs($query,0,1);
								chmod($docs_path.$file_upload,0777);
							}
						}
					}
				}
				//echo "<pre>"; print_r($query); echo "</pre>"; exit();
				



				// STAGE 2
				$stage_2 = [
					'caption' => $_POST['s2_caption'],
					'details' => $_POST['s2_details'],
					'pos' 	=> (int)$_POST['s2_pos'],
					'block'	=> $_POST['s2_block'][0],
					'lat'	=> (float)str_replace(',', '.', $_POST['s2_lat']),
					'lng'	=> (float)str_replace(',', '.', $_POST['s2_lng']),
					'video' 	=> $_POST['s2_video'],
					'panorama' => $_POST['s2_panorama'],
					'docs_caption' => $_POST['s2_docs_caption'],
					'docs_details' => $_POST['s2_docs_details'],
					'project_id' => $item_id,
					'created' => $now,
					'modified' => $now					
				];
				$im_1_filename = "s2_protocol"; $im_1 = false; $im_1_name = 5; 
				$im_1_pre = "s2_proto";
				if(isset($_FILES[$im_1_filename]) && $_FILES[$im_1_filename]['size'] > 0) $im_1 = true;
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
						));
					
					if($file_update){
						$stage_2['protocol_link'] = $file_update;
					}
				}
				$query = "INSERT INTO `osc_stages` ";
				$fieldsStr = " ( ";
				$valuesStr = " ( ";
				$s1Upd = 0;
				foreach($stage_2 as $field => $itemUpd) {
					$s1Upd++;
					$fieldsStr .= ($s1Upd==1 ? "`$field`" : ", `$field`");
					$valuesStr .= ($s1Upd==1 ? "'$itemUpd'" : ", '$itemUpd'");
				}
				$fieldsStr .= " ) ";
				$valuesStr .= " ) ";
				$query .= $fieldsStr." VALUES ".$valuesStr;
				$stage_2_id = $ah->rs($query, 0, 1, 1);
				if($stage_2_id){
					/*IMG GALLERY SET*/
					$filename = "s2_photos";
					if(isset($_FILES[$filename]) && count($_FILES[$filename]) > 0 && $item_id) {		
						$files_upload = $ah->mtvc_add_files_file_miltiple(array(
								'path'			=>$file_path,
								'name'			=>5,
								'pre'			=>"s2_photo",
								'size'			=>10,
								'rule'			=>0,
								'max_w'			=>2500,
								'max_h'			=>2500,
								'files'			=>$filename,
							));
						if($files_upload) {
							foreach($files_upload as $file_upload){
								$now = date("Y-m-d H:i:s", time());
								$query = "INSERT INTO osc_stage_photos (`stage_id`, `filename`, `created`, `modified`) VALUES ('$stage_2_id', '$file_upload', '$now', '$now')";
								$ah->rs($query,0,1);
								chmod($file_path.$file_upload,0777);
							}
						}
					}

					/*DOCS*/
					$filename = "s2_docs";
					if(isset($_FILES[$filename]) && count($_FILES[$filename]) > 0 && $item_id) {		
						$files_upload = $ah->mtvc_add_files_file_miltiple(array(
								'path'			=>$docs_path,
								'name'			=>5,
								'pre'			=>"s2_doc",
								'size'			=>10,
								'rule'			=>0,
								'max_w'			=>2500,
								'max_h'			=>2500,
								'files'			=>$filename,
								'resize_path'	=>$docs_path."crop/",
								'resize_w'		=>170,
								'resize_h'		=>240,
								'resize_path_2'	=>"0",
								'resize_w_2'	=>0,
								'resize_h_2'	=>0
							));
						if($files_upload) {
							foreach($files_upload as $file_upload){
								$now = date("Y-m-d H:i:s", time());
								$query = "INSERT INTO osc_stage_docs (`stage_id`, `filename`, `created`, `modified`) VALUES ('$stage_2_id', '$file_upload', '$now', '$now')";
								$ah->rs($query,0,1);
								chmod($docs_path.$file_upload,0777);
							}
						}
					}
				}




				// STAGE 3
				$stage_3 = [
					'caption' => $_POST['s3_caption'],
					'details' => $_POST['s3_details'],
					'pos' 	=> (int)$_POST['s3_pos'],
					'block'	=> $_POST['s3_block'][0],
					'lat'	=> (float)str_replace(',', '.', $_POST['s3_lat']),
					'lng'	=> (float)str_replace(',', '.', $_POST['s3_lng']),
					'video' 	=> $_POST['s3_video'],
					'panorama' => $_POST['s3_panorama'],
					'docs_caption' => $_POST['s3_docs_caption'],
					'docs_details' => $_POST['s3_docs_details'],
					'project_id' => $item_id,
					'created' => $now,
					'modified' => $now					
				];
				$im_1_filename = "s3_protocol"; $im_1 = false; $im_1_name = 5; 
				$im_1_pre = "s3_proto";
				if(isset($_FILES[$im_1_filename]) && $_FILES[$im_1_filename]['size'] > 0) $im_1 = true;
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
						));
					
					if($file_update){
						$stage_3['protocol_link'] = $file_update;
					}
				}
				$query = "INSERT INTO `osc_stages` ";
				$fieldsStr = " ( ";
				$valuesStr = " ( ";
				$s1Upd = 0;
				foreach($stage_3 as $field => $itemUpd) {
					$s1Upd++;
					$fieldsStr .= ($s1Upd==1 ? "`$field`" : ", `$field`");
					$valuesStr .= ($s1Upd==1 ? "'$itemUpd'" : ", '$itemUpd'");
				}
				$fieldsStr .= " ) ";
				$valuesStr .= " ) ";
				$query .= $fieldsStr." VALUES ".$valuesStr;
				$stage_3_id = $ah->rs($query, 0, 1, 1);
				if($stage_3_id){
					/*IMG GALLERY SET*/
					$filename = "s3_photos";
					if(isset($_FILES[$filename]) && count($_FILES[$filename]) > 0 && $item_id) {		
						$files_upload = $ah->mtvc_add_files_file_miltiple(array(
								'path'			=>$file_path,
								'name'			=>5,
								'pre'			=>"s3_photo",
								'size'			=>10,
								'rule'			=>0,
								'max_w'			=>2500,
								'max_h'			=>2500,
								'files'			=>$filename,
							));
						if($files_upload) {
							foreach($files_upload as $file_upload){
								$now = date("Y-m-d H:i:s", time());
								$query = "INSERT INTO osc_stage_photos (`stage_id`, `filename`, `created`, `modified`) VALUES ('$stage_3_id', '$file_upload', '$now', '$now')";
								$ah->rs($query,0,1);
								chmod($file_path.$file_upload,0777);
							}
						}
					}

					/*DOCS*/
					$filename = "s3_docs";
					if(isset($_FILES[$filename]) && count($_FILES[$filename]) > 0 && $item_id) {		
						$files_upload = $ah->mtvc_add_files_file_miltiple(array(
								'path'			=>$docs_path,
								'name'			=>5,
								'pre'			=>"s3_doc",
								'size'			=>10,
								'rule'			=>0,
								'max_w'			=>2500,
								'max_h'			=>2500,
								'files'			=>$filename,
								'resize_path'	=>$docs_path."crop/",
								'resize_w'		=>170,
								'resize_h'		=>240,
								'resize_path_2'	=>"0",
								'resize_w_2'	=>0,
								'resize_h_2'	=>0
							));
						if($files_upload) {
							foreach($files_upload as $file_upload){
								$now = date("Y-m-d H:i:s", time());
								$query = "INSERT INTO osc_stage_docs (`stage_id`, `filename`, `created`, `modified`) VALUES ('$stage_3_id', '$file_upload', '$now', '$now')";
								$ah->rs($query,0,1);
								chmod($docs_path.$file_upload,0777);
							}
						}
					}
				}

				

				$data['message'] = "Проект успешно создан. ID: ".$item_id;
				$data['item_id'] = $item_id;
				$data['status'] = "success";
			}
	}else{
		$data['message'] = "Проект с таким алиасом уже существует.";
	}
	