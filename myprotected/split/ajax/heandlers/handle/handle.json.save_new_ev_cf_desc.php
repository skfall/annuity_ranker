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
	$text	= $_POST['text'];
	
	$val	= strip_tags(str_replace("'","",$_POST['val']));

	
	$query = "UPDATE `osc_sys_event_items` AS M SET M.text='$text' WHERE M.id=$id";



	
	$ah->rs($query);

	$data['status'] = "success";
	
	$data['message'] = "Элемент успешно отредактирован";