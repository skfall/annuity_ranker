<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$field	= (isset($_POST['field']) ? $_POST['field'] : 'images');

	if($field == 'docs'){
		$appTable = "docs_ref";
	}else{
		$appTable = "files_ref";
		}

	
	$id	= (int)$_POST['id'];
	
	$val	= strip_tags(str_replace("'","",$_POST['val']));

	
	
	$query = "UPDATE `osc_page_building_items` SET `bp_desc`='$val' WHERE `id`=$id LIMIT 1";


	
	$ah->rs($query);
	
	$data['status'] = "success";
	
	$data['message'] = "Описание изображения успешно сохранено.";