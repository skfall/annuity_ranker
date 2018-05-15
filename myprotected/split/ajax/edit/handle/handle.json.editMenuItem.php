<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = $_POST['item_id'];

	$now = date("Y-m-d H:i:s", time());

	$lpx = $_POST['lpx'];
	$lang_prefix = ($lpx ? $lpx."_" : ""); // empty = iw
	$q = "SELECT * FROM [pre]nav WHERE `id`='$item_id' LIMIT 1";
	$nav_item = $ah->rs($q, 1);
	$cardUpd = array(
		'name'		=> $_POST['name'],
		'block'			=> $_POST['block'][0],
		'modified'	=> $now,
		'pos'		=> (int)$_POST['pos'],
		'display_in_header'			=> $_POST['display_in_header'][0],
		'display_in_footer'			=> $_POST['display_in_footer'][0],

	);

	if ($nav_item['type'] != 1) {
		$cardUpd['alias'] = $_POST['alias']; 
		$cardUpd['parent'] = (int)$_POST['parent']; 
		$cardUpd['content'] = $_POST['content'];
	}

	$meta_title = $_POST['meta_title'];		
	$meta_keys = $_POST['meta_keys'];		
	$meta_desc = $_POST['meta_desc'];		
	
	$query = "SELECT id FROM [pre]nav WHERE `alias`='".$cardUpd['alias']."' AND `id`!=$item_id LIMIT 1";
	$test_alias = $ah->rs($query);
				
	if(strlen($cardUpd[$lang_prefix.'name'])>1)
	{
		if(!$test_alias)
		{
				// Update main table
				
				$query = "UPDATE [pre]$appTable SET ";
				
				$cntUpd = 0;
				foreach($cardUpd as $field => $itemUpd)
				{
					$cntUpd++;
					$query .= ($cntUpd==1 ? "`$field`='$itemUpd'" : ", `$field`='$itemUpd'");
				}
				
				$query .= " WHERE `id`=$item_id LIMIT 1";
				$ah->rs($query);

				$_alias = $cardUpd['alias'];
				$q = "UPDATE `osc_meta` SET `meta_title` = '$meta_title', `meta_keys` = '$meta_keys', `meta_desc` = '$meta_desc' WHERE alias = '$_alias' LIMIT 1";
				$res_meta = $ah->rs($q);
				
				// Upload files
				/*
				$filename = "docs";
				
				if(isset($_FILES[$filename]) && count($_FILES[$filename]) > 0)
				{
					$file_path = "../../../../split/files/documents/";
					
					$files_upload = $ah->mtvc_add_files_file_miltiple(array(
							'path'			=>$file_path,
							'name'			=>5,
							'pre'			=>"doc_",
							'size'			=>20,
							'rule'			=>0,
							'max_w'			=>2500,
							'max_h'			=>2500,
							'files'			=>$filename
						  ));
					if($files_upload)
					{
						foreach($files_upload as $file_upload)
						{
							$query = "INSERT INTO [pre]docs_ref (`ref_table`, `ref_id`, `file`, `crop`, `path`) VALUES ('menu', '$item_id', '$file_upload', '0', 'split/files/documents/')";
							
							$ah->rs($query);
						}
					}
				}
				*/
				$data['message'] = "Nav item was successfully saved.";
				
			}else{
			$data['status'] = "failed";
			$data['message'] = "Failed to save. Nav item with this alias is already exists";
			}
	}else{
		$data['status'] = "failed";
		$data['message'] = "Failed to save. Name is too short.";
		}
	
	